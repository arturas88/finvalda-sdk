# sParametras Knowledge Base & Helper Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Build a documented, machine-readable knowledge base of Finvalda `sParametras` profiles plus a generic guide, so an AI assistant can match needs to profiles, explain them, and draft `FvsNETParamKonfig` instructions — without exposing HTL data in the public repo.

**Architecture:** Two layers. A *published* layer (`docs/parameters/`: generic guide, fake example YAML, redacted screenshots) committed to git. A *local* layer (`docs/parameters/parameters.local.yaml`) gitignored, holding the real HTL profiles transcribed from a hand-made `.xlsx` options catalog (not a tool export — `FvsNETParamKonfig` has none). The old `docs/ParametersOptions/` folder is removed; its raw `.xlsx`/originals move outside the git tree as local reference.

**Tech Stack:** Markdown, YAML, Python 3 + Pillow (one-off screenshot redaction), git.

**Security rule (applies to every task):** Nothing committed may contain real deployment-specific values — the profile names, the employee/division codes, the desktop `.fvs` filename, or the journal/series/account codes. Those live only in the git-ignored `parameters.local.yaml`. A leak-check grep — built from your real markers (kept out of this public plan) — gates the final commit.

---

## Field → Lithuanian-label mapping (reference for guide + Task 4)

This mapping is generic (no values) and safe to commit. It defines the YAML keys.

**Header (`header:`)**
| YAML key | LT UI label |
|---|---|
| `division` | Padalinys |
| `employee` | Darbuotojas |
| `series` | Serija |
| `prices_include_vat` | Kainos su PVM |
| `export_to_ivaz` | Eksportuoti į iVAZ |
| `assign_first_free_number` | Priskirti pirmą laisvą PUI pardavime/vid. perk. |
| `marked` | Pažymėta operacija |
| `suggest_gross_from_product` | Pasiūlomas bruto iš prekės kortelės |
| `suggest_net_from_product` | Pasiūlomas neto iš prekės kortelės |
| `suggest_volume_from_product` | Pasiūlomas tūris iš prekės kortelės |

**Descriptions (`descriptions:`)** — `products`/`services`/`clients`
| YAML key | LT UI label |
|---|---|
| `account_link` | Ryšys su sąskaitomis |
| `vat_code` | PVM mokestis |
| `unit` | Mato vienetas (products only) |
| `debit_account` | Debetinė sąskaita (clients) |
| `credit_account` | Kreditinė sąskaita (clients) |

**Sales (`sales:`)** groups: `sales`=Pardavimai, `reservations`=Rezervavimai, `returns`=Grąžinimai, `uvm_reservations`=UVM rezervavimai.
**Purchases (`purchases:`)** groups: `purchases`=Pirkimai, `orders`=Užsakymai, `returns`=Grąžinimai, `uvm_orders`=UVM užsakymai.
Per group: `journal`=Žurnalas, `type`=Tipas, `series`=Serija, `document_type`=Dokumento tipas, `suggest_price`=Kaina pasiūloma.

**Production (`production:`)**: `receipts`=Pajamavimai, `writeoffs`=Nurašymai, `other`=Kitos Op. — each `journal`+`type`.
**Inflows (`inflows:`)**: `inflows`=Įplaukos, `disbursements`=Išmokos — `journal`=Žurnalas, `series`=Serija, `series2`=Serija 2, `type`=Op. tipas, `currency`=Valiuta.
**Other (`other:`)**: `capitalization`=Pajamavimo, `uvm_cancellation`=UVM anuliavimo, `internal_transfer`=Vidinio perkėlimo (+`series`), `inventory_count`=Prekių inventorizacija (`journal`+`warehouse`=Sandėlis), `writeoff`=Nurašymo, `non_analytical`=Kitų neanalitinių, `clearing`=Užskaitų (+`account`=Sąskaita). Each `journal`+`type` unless noted.
**Intrastat (`intrastat:`)**: `sales`/`purchases`; header `transaction`=Sandoris, `delivery_terms`=Pristatymo sąl., `transport`=Transp. rūšis, `dispatch_country`=Šalis siuntėja; line `county`=Apskritis.

---

## Task 1: Scaffold published folder + gitignore

**Files:**
- Create: `docs/parameters/` (directory)
- Modify: `.gitignore`

- [ ] **Step 1: Create the folder**

```bash
mkdir -p docs/parameters
```

- [ ] **Step 2: Add the gitignore entry for the local YAML**

Append to `.gitignore`:

```
docs/parameters/parameters.local.yaml
```

- [ ] **Step 3: Verify the ignore rule works (file need not exist yet)**

Run: `git check-ignore -v docs/parameters/parameters.local.yaml`
Expected: prints a line referencing `.gitignore` and the pattern (exit 0).

- [ ] **Step 4: Commit**

```bash
git add .gitignore
git commit -m "chore: scaffold docs/parameters and gitignore local parameter YAML"
```

---

## Task 2: Write the fake example YAML

**Files:**
- Create: `docs/parameters/parameters.example.yaml`

- [ ] **Step 1: Write the file with invented values only**

```yaml
# Finvalda sParametras knowledge base — EXAMPLE (fake values).
# One entry per server-side profile (managed in FvsNETParamKonfig).
# Copy this shape into your gitignored parameters.local.yaml with your real values.
# Only include the sections a profile actually uses.

profiles:
  STANDARD_SALE:
    purpose: Standard goods sale invoice          # human-readable; drives matching
    matches: [sale, invoice, sell goods]          # keywords to help the assistant pick it
    operations: [sale, salesReturn]               # SDK builders / OperationClasses fed
    notes: |
      Example profile. 21% VAT goods sales only.
    header:
      division: MAIN            # Padalinys
      employee: WEBUSER         # Darbuotojas
      series: INV               # Serija
      prices_include_vat: false # Kainos su PVM
    descriptions:
      clients:
        debit_account: "2410"   # Debetinė sąskaita
        credit_account: "4430"  # Kreditinė sąskaita
        vat_code: STDVAT        # PVM Mokestis
    sales:
      sales:   { journal: SALES,     type: GOODS, series: INV, document_type: SF }
      returns: { journal: SALES_RET, type: GOODS, series: CRN, document_type: KS }
    sdk_example: |
      $finvalda->sale()->client('CLIENT_CODE')
          ->product(ProductLine::make('PRODUCT', 1))
          ->save('STANDARD_SALE');

  CASH_PAYMENT:
    purpose: Customer cash inflow
    matches: [payment, cash receipt, inflow]
    operations: [inflow]
    header:
      division: MAIN
      employee: WEBUSER
    inflows:
      inflows: { journal: CASH_IN, series: CSH, type: CASH_EUR, currency: EUR }
    sdk_example: |
      $finvalda->inflow()->client('CLIENT_CODE')->amount(100.00)
          ->save('CASH_PAYMENT');
```

- [ ] **Step 2: Verify it parses as YAML**

Run: `python3 -c "import yaml; d=yaml.safe_load(open('docs/parameters/parameters.example.yaml')); print(sorted(d['profiles']))"`
Expected: `['CASH_PAYMENT', 'STANDARD_SALE']`

- [ ] **Step 3: Verify no real HTL value leaked into the example**

Run: `grep -Ei '<PROFILE_NAMES>|<EMPLOYEE_CODE>|<JOURNAL_AND_SERIES_PREFIXES>|<FVS_FILENAME>' docs/parameters/parameters.example.yaml; echo "exit=$?"`
(substitute your real markers from `parameters.local.yaml`; do not write them into this plan)
Expected: no matches, `exit=1`.

- [ ] **Step 4: Commit**

```bash
git add docs/parameters/parameters.example.yaml
git commit -m "docs: add example sParametras knowledge-base YAML"
```

---

## Task 3: Write the generic guide

**Files:**
- Create: `docs/parameters/README.md`
- Source material: `docs/ParametersOptions/README.md` (HTL-specific draft — reuse only the generic explanatory prose; drop all HTL tables/values)

- [ ] **Step 1: Write `docs/parameters/README.md` with these sections, generic only:**

1. **What `sParametras` is** — the mental model: a server-side preset that injects journal/type/series/document-type/accounts/VAT/division/employee into every write op; every SDK write requires it (`->save('NAME')`, `Operations::create(..., 'NAME')`).
2. **Managing profiles in `FvsNETParamKonfig`** — exe location (`C:\Program Files (x86)\FVS.fin\FvsNETParamKonfig.exe`), login modes (DSN / `.fvs` desktop file / connection string), Naujas/Išsaugoti/Pašalinti.
3. **The 7 tabs and their fields** — Aprašymai / Pirkimai / Pardavimai / Gamyba / Įplaukos / Kita / Intrastat, using the Field → LT-label mapping table from this plan (copy it in).
4. **YAML format spec** — the structure from `parameters.example.yaml`; explain that only used sections appear; English keys with LT label comments; `parameters.local.yaml` is gitignored and per-deployment.
5. **How the helper works** — three workflows with example prompt → example output:
   - *Match:* "I need to invoice a late fee" → assistant finds the best-fit profile via `purpose`/`matches`/`operations`, shows resolved defaults + the `->save('NAME')` snippet.
   - *Explain:* "What does profile X do?" → assistant prints resolved defaults in plain terms.
   - *Draft new/updated profile:* describe a need with no match → assistant clones the closest profile, emits step-by-step `FvsNETParamKonfig` instructions (tab → LT-labeled field → suggested value → why), flags accountant-owned values (accounts/VAT/series), and warns referenced journals/types/series/accounts must already exist.
6. **Keeping it current** — `FvsNETParamKonfig` has no export; the catalog is maintained by hand from the tool's profile settings (the hand-made `.xlsx` only seeds it). Update `parameters.local.yaml` when the server config changes; treat the YAML as last-known-good.
7. **UI reference** — embed the redacted screenshots (added in Task 5) with one-line captions per tab.

- [ ] **Step 2: Verify no HTL value leaked into the guide**

Run: `grep -Eni '<PROFILE_NAMES>|<EMPLOYEE_CODE>|<JOURNAL_AND_SERIES_PREFIXES>|<FVS_FILENAME>|<REAL_ACCOUNT_NUMBERS>' docs/parameters/README.md; echo "exit=$?"` (substitute your real markers)
Expected: no matches, `exit=1`. (If a generic mention of an account is needed, use the fake `2410`/`4430` from the example.)

- [ ] **Step 3: Commit (screenshots embedded later in Task 5)**

```bash
git add docs/parameters/README.md
git commit -m "docs: add generic sParametras guide"
```

---

## Task 4: Transcribe the real profiles into the gitignored local YAML

**Files:**
- Create (gitignored): `docs/parameters/parameters.local.yaml`
- Read: `docs/ParametersOptions/Finvalda Web Service Parameter.xlsx`

> The real HTL values are intentionally NOT reproduced in this plan (public repo). Transcribe them from the `.xlsx` into the local file using the format from `parameters.example.yaml` and the Field → LT-label mapping above. The `.xlsx` lays profiles out as columns; each row is a `Parametras.Tab.Group.Field` path.

- [ ] **Step 1: Re-read the export to confirm the current profile set**

Run:
```bash
python3 -c "
import openpyxl
wb=openpyxl.load_workbook('docs/ParametersOptions/Finvalda Web Service Parameter.xlsx', data_only=True)
ws=wb.active
print([c.value for c in ws[1][1:] if c.value])
"
```
Expected: the list of profile names (the column headers after `Parametras`).

- [ ] **Step 2: Write `docs/parameters/parameters.local.yaml`**

For each profile column, create one `profiles.<NAME>:` entry. Map each non-empty row to its YAML key via the mapping table. Add `purpose` and `matches` per profile from your knowledge of each flow, and `operations` from which tabs are populated (e.g. sales rows → `sale`; sales `returns` rows → `salesReturn`; inflow rows → `inflow`; UVM reservation rows → `uvmSalesReservation`). Strip Excel's numeric `.0` suffix from code-like values (write `"4431"`, not `4431.0`). For values that look like account numbers used as a `type`, transcribe verbatim and add a `notes:` caveat to confirm against the live server. All profiles share `header.division` and `header.employee` from the export.

- [ ] **Step 3: Verify it parses and the profile count matches the export**

Run:
```bash
python3 -c "
import yaml
d=yaml.safe_load(open('docs/parameters/parameters.local.yaml'))
print('profiles:', len(d['profiles']), sorted(d['profiles']))
"
```
Expected: count equals the number of columns from Step 1, names match.

- [ ] **Step 4: Verify the file is gitignored (must NOT be committable)**

Run: `git check-ignore docs/parameters/parameters.local.yaml && git status --porcelain docs/parameters/parameters.local.yaml`
Expected: `git check-ignore` prints the path (exit 0); `git status --porcelain` prints nothing (file is ignored, not staged).

- [ ] **Step 5: No commit**

This file is intentionally not committed. Do not force-add it.

---

## Task 5: Redact and commit the screenshots

**Files:**
- Read: `docs/ParametersOptions/[1-9]_*.png`
- Create: `docs/parameters/screenshots/<tab>.png` (redacted copies)
- Create (temporary, do not commit): `redact_screenshots.py`

> Redaction is security-sensitive and per-image (different resolutions). Approach: cover data-bearing regions with solid boxes; keep tab/field labels visible. Coordinates are determined by viewing each image, not known in advance — iterate.

- [ ] **Step 1: Confirm Pillow is available**

Run: `python3 -c "import PIL; print(PIL.__version__)"`
Expected: a version string. If it errors: `python3 -m pip install Pillow`.

- [ ] **Step 2: Write the redaction script skeleton**

Create `redact_screenshots.py`:

```python
from PIL import Image, ImageDraw
from pathlib import Path

SRC = Path("docs/ParametersOptions")
OUT = Path("docs/parameters/screenshots")
OUT.mkdir(parents=True, exist_ok=True)

# Map source filename -> (output name, [boxes]) where each box is (x0, y0, x1, y1).
# Boxes cover: left profile list, Parametras field value, Padalinys/Darbuotojas values,
# all filled tab input fields, and (login shot) the .fvs path + username.
# Fill coordinates per image after viewing each one.
JOBS = {
    "3_Description_options.png": ("descriptions.png", []),
    "4_Purchases_options.png":   ("purchases.png", []),
    "5_Sales_options.png":       ("sales.png", []),
    "6_Production_options.png":  ("production.png", []),
    "7_Inflows_options.png":     ("inflows.png", []),
    "8_Other_options.png":       ("other.png", []),
    "9_Intrastat_options.png":   ("intrastat.png", []),
    "2_Login.png":               ("login.png", []),
    "1_Open_FvsNETParamKonfig_for_managing_Webservice_parameters.png": ("locate-exe.png", []),
}

for src_name, (out_name, boxes) in JOBS.items():
    img = Image.open(SRC / src_name).convert("RGB")
    draw = ImageDraw.Draw(img)
    for box in boxes:
        draw.rectangle(box, fill=(0, 0, 0))
    img.save(OUT / out_name)
    print("wrote", out_name, img.size)
```

- [ ] **Step 3: Determine boxes per image, iterate until clean**

For each source image: open it with the Read tool to see content and estimate pixel regions (Pillow reports each image's size in Step 2's output to scale estimates). Fill the `boxes` list in `JOBS`. Re-run `python3 redact_screenshots.py`. Re-open each output with the Read tool. Repeat until every HTL value (profile names, Parametras, Padalinys, Darbuotojas, journals, types, series, accounts, VAT, and the login path/username) is covered while tab and field labels remain visible.

Run (each iteration): `python3 redact_screenshots.py`
Expected: prints `wrote <name> <size>` for all 9.

- [ ] **Step 4: USER VERIFICATION GATE — do not proceed without explicit approval**

Present all redacted images in `docs/parameters/screenshots/` to the user. Ask them to confirm no readable HTL data remains in any image. If anything is missed, return to Step 3. Only continue after explicit user approval.

- [ ] **Step 5: Embed screenshots in the guide**

In `docs/parameters/README.md` (section 7), add `![<tab> tab](screenshots/<tab>.png)` references with one-line captions.

- [ ] **Step 6: Remove the temporary script and commit redacted images + guide update**

```bash
rm redact_screenshots.py
git add docs/parameters/screenshots docs/parameters/README.md
git commit -m "docs: add redacted FvsNETParamKonfig screenshots to parameter guide"
```

---

## Task 6: Remove old folder and relocate raw artifacts

**Files:**
- Delete from repo: `docs/ParametersOptions/`
- Move outside git tree: `Finvalda Web Service Parameter.xlsx` + original screenshots

- [ ] **Step 1: Ask the user for the local destination path (outside the repo)**

Prompt for an absolute path, e.g. `~/finvalda-local/`. This becomes the local reference location; record it in the guide's "Keeping it current" section if the user wants it noted (or keep it out of the public repo and only in the local YAML's top comment).

- [ ] **Step 2: Move the raw artifacts out of the repo**

```bash
DEST="<user-provided-absolute-path>"
mkdir -p "$DEST"
mv "docs/ParametersOptions/Finvalda Web Service Parameter.xlsx" "$DEST"/
mv docs/ParametersOptions/*.png "$DEST"/
```

- [ ] **Step 3: Remove the now-stripped folder (it was never committed — untracked)**

```bash
rm -f docs/ParametersOptions/.DS_Store
rm -f docs/ParametersOptions/README.md      # HTL-specific draft, content already migrated
rmdir docs/ParametersOptions 2>/dev/null || ls -la docs/ParametersOptions
```
Expected: folder gone. If `rmdir` fails, list remaining files and move/remove them deliberately (verify none are needed).

- [ ] **Step 4: Confirm the folder is no longer present and nothing references it**

Run: `test ! -e docs/ParametersOptions && echo "removed"; grep -rn "ParametersOptions" docs/parameters README.md 2>/dev/null; echo "refs-exit=$?"`
Expected: prints `removed`; no references found (`refs-exit=1`).

- [ ] **Step 5: No commit needed**

`docs/ParametersOptions/` was untracked, so its removal needs no commit. (The migration commits happened in Tasks 1–5.)

---

## Task 7: Final leak audit

**Files:** (read-only audit across the whole committed tree)

- [ ] **Step 1: Grep all tracked files for HTL markers**

Run:
```bash
git grep -Eni '<PROFILE_NAMES>|<EMPLOYEE_CODE>|<JOURNAL_AND_SERIES_PREFIXES>|<FVS_FILENAME>' -- . ':!docs/superpowers/'; echo "exit=$?"   # substitute your real markers
```
Expected: no matches in committed files, `exit=1`. (The `docs/superpowers/` specs/plans are excluded only because they legitimately reference profile *names* as security markers, not values — confirm by inspection that no spec/plan contains real account numbers, journals, or series.)

- [ ] **Step 2: Confirm the local YAML is present locally but ignored**

Run: `git check-ignore docs/parameters/parameters.local.yaml && echo "ignored-ok"; git ls-files docs/parameters/parameters.local.yaml; echo "tracked-exit=$?"`
Expected: prints `ignored-ok`; `git ls-files` prints nothing (file is not tracked).

- [ ] **Step 3: Confirm OCR'd screenshots carry no readable HTL text (manual)**

Re-open each `docs/parameters/screenshots/*.png` with the Read tool and confirm no profile names, accounts, journals, series, or the login path/username are legible. This repeats the Task 5 gate as a final backstop before the branch is shared.

- [ ] **Step 4: Final commit if any audit fixes were made**

```bash
git add -A
git commit -m "docs: final leak audit for sParametras knowledge base" || echo "nothing to commit"
```

---

## Self-review notes

- **Spec coverage:** Layer 1 (Tasks 2,3,5) ✓; Layer 2 / local YAML (Task 4) ✓; YAML format (Tasks 2,3) ✓; helper workflows (Task 3 §5) ✓; cleanup + relocate `.xlsx` (Task 6) ✓; redaction + user gate (Task 5) ✓; gitignore (Task 1) ✓; out-of-scope items (no PHP/CLI/generator) ✓ none added. Risk mitigations: drift (Task 3 §6, Task 4 caveats), redaction completeness (Task 5 Step 4 + Task 7 Step 3), genericity leakage (leak-check greps in Tasks 2,3,7).
- **No real HTL values appear anywhere in this committed plan** — only the fake example, the generic mapping, and profile *names* used as grep markers.
