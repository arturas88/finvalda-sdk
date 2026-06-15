# `sParametras` — Operation Parameter Profiles & Helper

This folder is the knowledge base for Finvalda `sParametras` parameter profiles. It explains
what the parameter is, how it is configured on the server, how to describe your own profiles
in a YAML file, and how an AI assistant can use that file to help you pick, explain, or create
profiles.

- **`parameters.example.yaml`** — the YAML format, with fake placeholder values.
- **`parameters.local.yaml`** — your real profiles (git-ignored; never committed).

---

## 1. What `sParametras` is

Every **write** operation in the SDK requires a `sParametras` value:

```php
$finvalda->sale()
    ->client('CL001')
    ->product(ProductLine::make('PRD1', 2))
    ->save('STANDARD_SALE');          // <-- 'STANDARD_SALE' is the sParametras value
```

`sParametras` is **not** a free-form string. It is the **name of a server-side configuration
profile**. Each profile bundles defaults — journal, operation type, document series, document
type, GL accounts, VAT codes, division, employee, currency, Intrastat data, and behavioral
flags. When you send an operation with a given `sParametras`, the Finvalda server looks up
that profile and **fills in those defaults for you**. That is why an API payload can be
minimal (a client plus product lines): the journal, type, series, accounts and VAT come from
the profile, not from your request.

> **Mental model:** `sParametras` is a server-side preset. The SDK builders construct the
> *content* of an operation (who, what, how much); the profile supplies the *accounting
> context* (where it lands in the books). One profile per business flow.

Because every SDK write path requires it (`OperationBuilder::save()` throws without one, and
`Operations::create()` mandates it), choosing the right `sParametras` is load-bearing for
correct postings.

---

## 2. Managing profiles: `FvsNETParamKonfig`

Profiles **cannot** be created or read through the web service API. They are managed with a
desktop admin tool that ships with Finvalda:

1. **Location:** `C:\Program Files (x86)\FVS.fin\FvsNETParamKonfig.exe` (usually pinned in
   the Finvalda `help` folder).
2. **Login:** connect to the same database the web service uses.
   - `DSN`, *or* `Darbalaukis` (a `.fvs` desktop file), *or* `Prisijungimo eil.`
     (connection string)
   - `Vardas` / `Slaptažodis` — an admin user.
3. The left-hand list shows all configured profiles. Use **Naujas** (new), **Išsaugoti**
   (save), **Pašalinti** (delete) to manage them.

Each profile name in that list is exactly the string you pass as `sParametras`.

---

## 3. The configuration tabs and their fields

A profile has a **header** (always applied) plus **seven tabs**. Most fields are optional —
an empty field means "no default; rely on the request payload or Finvalda's own defaults."

The YAML keys used in `parameters.example.yaml` map to the Lithuanian UI labels as follows.

### Header

| YAML key | LT UI label | Meaning |
|---|---|---|
| `division` | Padalinys | Division / branch |
| `employee` | Darbuotojas | Employee (often the web-service user) |
| `series` | Serija | Header-level default document series |
| `prices_include_vat` | Kainos su PVM | Line prices include VAT |
| `export_to_ivaz` | Eksportuoti į iVAZ | Export to i.VAZ (e-waybill) |
| `assign_first_free_number` | Priskirti pirmą laisvą PUI pardavime/vid. perk. | Auto-assign first free document number in sales / internal transfer |
| `marked` | Pažymėta operacija | Flag the operation |
| `suggest_gross_from_product` | Pasiūlomas bruto iš prekės kortelės | Suggest gross weight from the product card |
| `suggest_net_from_product` | Pasiūlomas neto iš prekės kortelės | Suggest net weight from the product card |
| `suggest_volume_from_product` | Pasiūlomas tūris iš prekės kortelės | Suggest volume from the product card |

### Tab `Aprašymai` (Descriptions) — `descriptions:`

Defaults used when auto-creating reference data (products / services / clients).

| YAML path | LT UI label |
|---|---|
| `products.account_link` | Prekių parametrai → Ryšys su sąskaitomis |
| `products.vat_code` | Prekių parametrai → PVM mokestis |
| `products.unit` | Prekių parametrai → Mato vienetas |
| `services.account_link` | Paslaugų parametrai → Ryšys su sąskaitomis |
| `services.vat_code` | Paslaugų parametrai → PVM mokestis |
| `clients.debit_account` | Klientų parametrai → Debetinė sąskaita |
| `clients.credit_account` | Klientų parametrai → Kreditinė sąskaita |
| `clients.vat_code` | Klientų parametrai → PVM Mokestis |

### Tab `Pirkimai` (Purchases) — `purchases:` · Tab `Pardavimai` (Sales) — `sales:`

Each tab has several operation groups, and every group shares the same five fields.

Purchase groups: `purchases` (Pirkimai), `orders` (Užsakymai), `returns` (Grąžinimai),
`uvm_orders` (UVM užsakymai).
Sales groups: `sales` (Pardavimai), `reservations` (Rezervavimai), `returns` (Grąžinimai),
`uvm_reservations` (UVM rezervavimai).

| YAML key (per group) | LT UI label |
|---|---|
| `journal` | Žurnalas |
| `type` | Tipas |
| `series` | Serija |
| `document_type` | Dokumento tipas |
| `suggest_price` | Kaina pasiūloma |

Both tabs also carry these tab-level fields (siblings of the groups, not inside them):

| YAML key | LT UI label |
|---|---|
| `cost_account` | Sąskaitos → Savikainos |
| `additional_expenses_account` | Sąskaitos → Pap. išlaidų |
| `vat_code` | PVM mokestis |
| `recalc_eur_from_currency` | Perskaičiuoti sumas EUR iš sumos valiuta (kai EUR 0/nenurodyta) |

### Tab `Gamyba` (Production) — `production:`

Tab-level `journal` (Žurnalas) + `type` (Operacijos tipas), plus three groups, each with
`journal` + `type`: `receipts` (Pajamavimai), `writeoffs` (Nurašymai), `other` (Kitos Op.).

### Tab `Įplaukos` (Inflows) — `inflows:`

Groups `inflows` (Įplaukos) and `disbursements` (Išmokos). Each group has a single journal and
series, plus a **list** (`types`) of operation-type/currency rows — the UI lets you add one
operation type per currency, so a group can hold several:

| YAML key | LT UI label |
|---|---|
| `journal` | Žurnalas |
| `series` | Serija |
| `series2` | Serija 2 |
| `types` | repeatable list (one row per currency) |
| `types[].type` | Op. tipas |
| `types[].currency` | Valiuta |

### Tab `Kita` (Other) — `other:`

Each group has `journal` + `type` unless noted:

| YAML key | LT UI label | Extra fields |
|---|---|---|
| `capitalization` | Pajamavimo operacijų parametrai | |
| `uvm_cancellation` | UVM anuliavimo operacijų parametrai | |
| `internal_transfer` | Vidinio perkėlimo operacijų parametrai | `series` |
| `inventory_count` | Prekių inventorizacija | `warehouse` (Sandėlis), no `type` |
| `writeoff` | Nurašymo operacijų parametrai | |
| `non_analytical` | Kitų neanalitinių operacijų parametrai | |
| `clearing` | Užskaitų operacijų parametrai | `account` (Sąskaita) |

### Tab `Intrastat` — `intrastat:`

Separate `sales` (Pardavimai) and `purchases` (Pirkimai) sections:

| YAML key | LT UI label |
|---|---|
| `transaction` | Antraštė → Sandoris |
| `delivery_terms` | Antraštė → Pristatymo sąl. |
| `transport` | Antraštė → Transp. rūšis |
| `dispatch_country` | Antraštė → Šalis siuntėja |
| `suggest_from_client_card` | Antraštė → Siūlyti iš kliento kortelės |
| `county` | Eilutės → Apskritis |
| `suggest_code_from_product` | Eilutės → Siūlyti intrastat kodą iš prekės lentelės |
| `suggest_dispatch_country_from_product` | Eilutės → Siūlyti šalį siuntėją iš prekės kortelės |

---

## 4. The YAML format

`parameters.example.yaml` is the canonical format reference. One top-level `profiles` map,
keyed by the exact `sParametras` value. **Only include the sections a profile actually
uses** — a sales-only profile has no `purchases:` block. English keys, with the Lithuanian
UI label in a comment for traceability.

Each profile may carry helper metadata in addition to the configuration fields:

| Key | Purpose |
|---|---|
| `purpose` | One-line human-readable description (drives matching) |
| `matches` | Keywords that help the assistant pick this profile |
| `operations` | SDK builders / operation classes this profile feeds (e.g. `sale`, `inflow`) |
| `notes` | Free text — caveats, "do not use for X", things to confirm |
| `sdk_example` | A ready-to-use SDK snippet |

Your real profiles live in `parameters.local.yaml`, which is **git-ignored** — it is
deployment-specific and must never be committed to this public repository.

---

## 5. How the helper works

With a populated `parameters.local.yaml`, an AI assistant (e.g. in Claude Code) can act as a
helper in three ways:

**1. Match** — you describe a transaction, the assistant finds the best-fit profile.
> *You:* "I need to invoice a late payment fee."
> *Assistant:* searches `purpose` / `matches` / `operations`, replies with the profile name,
> the journal/series/accounts it will post to, and the snippet:
> `$finvalda->sale()->client('…')->service(…)->save('LATE_FEE');`
> If several profiles plausibly fit, it lists them with the distinguishing fields.

**2. Explain** — you name a profile, the assistant prints its resolved defaults in plain
terms (which journal, type, series, document type, accounts, VAT, flags), so you can confirm
it posts where you expect before using it.

**3. Draft a new / updated profile** — you describe a need with no good match.
> *Assistant:* picks the closest existing profile as a template, then emits step-by-step
> `FvsNETParamKonfig` instructions: which tab, which Lithuanian-labeled field, a suggested
> value, and *why*. It flags the values you must decide with your accountant (accounts, VAT
> codes, series), and warns that any journal / type / series / account it references must
> already exist in Finvalda before the profile will work.

The assistant cannot read the live server — it reasons only over `parameters.local.yaml`. Keep
that file accurate (see below) for the help to be reliable.

---

## 6. Keeping it current

There is no API to read profiles, and `FvsNETParamKonfig` has no export — so
`parameters.local.yaml` is **hand-curated** and treated as "last known good," not gospel. You
maintain it by reading each profile's settings in `FvsNETParamKonfig` and writing them into
the YAML using the tables in Section 3. When the server configuration changes:

1. Open the changed profile(s) in `FvsNETParamKonfig` and note the affected fields.
2. Update `parameters.local.yaml` accordingly (or ask the assistant to, describing the
   change). Keep it outside version control — it is git-ignored.
3. Spot-check a profile against the live server if a posting looks wrong.

> **`prices_include_vat` is the field most likely to cause wrong totals.** If a profile has
> it set and your code sends net amounts (or vice-versa), line totals will be off. Confirm it
> matches how your `ProductLine` / `ServiceLine` amounts are expressed.
