# Design: `sParametras` Knowledge Base & Helper

**Date:** 2026-06-15
**Status:** Approved (design); pending spec review
**Repo:** `arturas88/finvalda-sdk` (public, MIT)

## Goal

Give the finvalda-sdk a documented, machine-readable knowledge base of `sParametras`
parameter profiles so that an AI assistant (Claude Code, in-session) can act as a helper:

1. **Match** a user's stated need to an existing profile ("I need to invoice a late fee" →
   the matching late-fee profile) and show the SDK snippet to use it.
2. **Explain** what a profile does (journals, series, accounts, VAT, flags).
3. **Draft instructions** for creating/updating a profile in `FvsNETParamKonfig` when none
   fits — with suggested field values cloned from the closest existing profile.

No SDK runtime code, no CLI, no generator is built. The helper *is* the assistant reasoning
over a well-structured data file plus a guide.

## Background & constraints

- `sParametras` is the name of a **server-side configuration profile** managed only in the
  desktop tool `FvsNETParamKonfig.exe`. Profiles bundle defaults (journal, operation type,
  series, document type, GL accounts, VAT codes, division, employee, currency, Intrastat
  data, behavioral flags) that the Finvalda server injects into every write operation.
- Profiles **cannot be read via the web service API**. The only sync mechanism is a manual
  `.xlsx` export from `FvsNETParamKonfig`. The knowledge base is therefore hand-curated and
  treated as "last known good," not gospel.
- The repo is **public**. HTL-specific data (real profile names, account numbers, journal
  codes, server paths, logins) must never be committed.
- Every SDK write path already requires a parameter (`OperationBuilder::save()` throws
  without one; `Operations::create()` mandates it), so this knowledge is load-bearing for
  correct usage.

## Architecture: two layers

### Layer 1 — Published (generic, committed to git)

Lives in a new clean folder `docs/parameters/`:

- `README.md` — the generic guide (no HTL values):
  - What `sParametras` is + the mental model.
  - The `FvsNETParamKonfig` tool: location, login, the 7 tabs and every field, with the
    English-key → Lithuanian-UI-label mapping.
  - The YAML format spec (see below).
  - **"How the helper works"** — the three assistant workflows (match / explain /
    draft-new-profile-instructions), with example prompts and example outputs.
  - Redacted screenshots inline as UI reference.
- `parameters.example.yaml` — the format with **obviously fake** placeholder values (e.g.
  `STANDARD_SALE`, journal `SALES`, accounts `2410`/`4430`, `WEBUSER`). Shows the shape
  without exposing any real config.
- Redacted screenshots (see Cleanup).

### Layer 2 — Local (HTL-specific, gitignored)

- `docs/parameters/parameters.local.yaml` — the **real** curated knowledge base: the 10
  HTL profiles transcribed from the `.xlsx`. A single gitignored file (not a folder of
  binaries → not tech debt). This is the file the assistant reads in HTL sessions.
- `.gitignore` gains: `docs/parameters/parameters.local.yaml`

## YAML format spec

One top-level `profiles` map. Each entry is keyed by the exact `sParametras` value. Only the
sections a profile actually uses are present (a sales-only profile omits `purchases:`, etc.).
English keys; the Lithuanian UI label appears as a comment for traceability.

```yaml
profiles:
  STANDARD_SALE:
    purpose: Standard goods sale invoice          # human-readable; drives matching
    matches: [sale, invoice, sell goods]          # keywords to help the assistant pick it
    operations: [sale, salesReturn]               # SDK builders / OperationClasses fed
    notes: |                                      # optional free text: caveats, "do not use for X"
      Use for standard 21% VAT goods sales only.
    header:                                       # always-applied header fields
      division: MAIN            # Padalinys
      employee: WEBUSER         # Darbuotojas
      series: INV               # Serija (header-level fallback)
      prices_include_vat: false # Kainos su PVM
      export_to_ivaz: false     # Eksportuoti į iVAZ
      assign_first_free_number: false  # Priskirti pirmą laisvą PUI ...
      marked: false             # Pažymėta operacija
    descriptions:               # Aprašymai tab (defaults for auto-created reference data)
      products: { account_link: ..., vat_code: ..., unit: ... }
      services: { account_link: ..., vat_code: ... }
      clients:  { debit_account: "2410", credit_account: "4430", vat_code: STDVAT }
    sales:                      # Pardavimai tab. Sub-keys: sales, reservations, returns, uvm_reservations
      sales:        { journal: SALES, type: GOODS, series: INV, document_type: SF }
      returns:      { journal: SALES_RET, type: GOODS, series: CRN, document_type: KS }
    purchases:                  # Pirkimai tab. Sub-keys: purchases, orders, returns, uvm_orders
      purchases:    { journal: PURCH, type: ..., series: ..., document_type: SF }
    production:                 # Gamyba tab
      receipts:     { journal: ..., type: ... }
      writeoffs:    { journal: ..., type: ... }
    inflows:                    # Įplaukos tab
      inflows:      { journal: CASH_IN, series: ..., series2: ..., type: ..., currency: EUR }
      disbursements:{ journal: ..., series: ..., type: ..., currency: EUR }
    other:                      # Kita tab
      internal_transfer: { journal: ..., type: ..., series: ... }
      writeoff:          { journal: ..., type: ... }
      capitalization:    { journal: ..., type: ... }
      inventory_count:   { journal: ..., warehouse: ... }
      non_analytical:    { journal: ..., type: ... }
      clearing:          { journal: ..., type: ..., account: ... }
      uvm_cancellation:  { journal: ..., type: ... }
    intrastat:                  # Intrastat tab
      sales:    { transaction: ..., delivery_terms: ..., transport: ..., dispatch_country: ... }
      purchases:{ transaction: ..., delivery_terms: ..., transport: ..., dispatch_country: ... }
    sdk_example: |
      $finvalda->sale()->client('CLIENT_CODE')
          ->product(ProductLine::make('PRODUCT', 1))
          ->save('STANDARD_SALE');
```

Field → Lithuanian-label mapping is documented once in the guide; the YAML stays concise.

## Helper workflows (assistant behavior, documented in the guide)

1. **Match:** user describes a transaction → assistant searches `purpose`/`matches`/
   `operations` → returns the best-fit profile name, what it posts, and the `->save('NAME')`
   snippet. If multiple plausible, lists them with the distinguishing fields.
2. **Explain:** user names a profile → assistant prints its resolved defaults in plain terms.
3. **Draft new/updated profile:** user describes a need with no good match → assistant picks
   the closest profile as a template, then emits step-by-step `FvsNETParamKonfig` instructions
   (which tab, which LT-labeled field, suggested value, and *why*), flags values the user must
   decide with their accountant (accounts/VAT/series), and notes that referenced
   journals/types/series/accounts must already exist in Finvalda.

## Cleanup plan

- Create `docs/parameters/` with the guide, example YAML, and redacted screenshots.
- Write `docs/parameters/parameters.local.yaml` (real 10 profiles) — gitignored.
- Redact the 9 screenshots and the existing draft README's HTL content; move generic guide
  content into the new guide.
- Move the raw `.xlsx` (and screenshot originals) to a local path **outside the git tree**
  (path provided by user) as the re-sync source.
- Remove `docs/ParametersOptions/` from the repo.
- Add `.gitignore` entry for the local YAML.

### Redaction detail (security-sensitive)

Each screenshot is redacted programmatically (Pillow: solid boxes over data regions). Images
are different resolutions, so coordinates are per-image. Regions to cover on every relevant
shot: the left profile-list panel, the `Parametras` field, `Padalinys`/`Darbuotojas`, all
filled tab fields (journals/types/series/accounts/VAT), and — on the login shot — the
desktop `.fvs` path and the admin username. UI labels and tab names stay visible (that is the
generic value). **Gate: user visually verifies every redacted image before it is committed.**
A single missed field on a public repo is the entire risk.

## Out of scope (explicitly deferred — YAGNI)

- PHP runtime validation / a `->parameters()` accessor that loads the YAML.
- A `bin/` CLI helper.
- An automated `.xlsx` → YAML generator.

Each remains a clean future extension built on the same YAML, if the file + assistant
workflow proves insufficient.

## Risks

- **Drift:** the YAML is hand-maintained and will diverge from the live server. Mitigation:
  treat it as last-known-good; re-transcribe from a fresh `.xlsx` export when config changes.
- **Redaction completeness:** mitigated by the mandatory per-image user verification gate.
- **Genericity leakage:** the example YAML and guide must use only invented values; reviewed
  in spec self-review and before commit.
