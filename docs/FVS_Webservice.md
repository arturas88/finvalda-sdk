---
title: "FVS Webserviso metodų naudojimo instrukcija"
revision: "110"
date: "2025 m. Balandžio 14 d."
source: "FVS Webservice.docx"
---

# FVS Webserviso metodų naudojimo instrukcija

- **Peržiūra:** 110
- **Data:** 2025 m. Balandžio 14 d.

## Patvirtinta

Šis dokumentas yra pasirašytas ir patvirtintas:
- **Vardas:** Rasa
- **Pavardė:** Kanclerienė
- **Pareigos:** IT Projektų vadovė
- **Data:** 2008-09-15
- **Parašas:**

## Peržiūrų istorija

| Peržiūra | Data | Aprašymas | Autorius |
| --- | --- | --- | --- |
| 1 | 2008-09-12 |  | S. Kvederavičius |
| 2 | 2008-12-02 | Ištaisyti netikslumai detalių eilučių mazgų pavadinimuose. | S. Kvederavičius |
| 3 | 2009-08-26 | Einamųjų likučių funkcijose pridėti papildomi parametrai | S. Kvederavičius |
| 4 | 2009-09-01 | Pašalinta GetEinamiejiLikuciaiSandelyje() funkcija, parametru (SandelioKodas) papildyta GetEinamiejiLikuciai() funkcija | S. Kvederavičius |
| 5 | 2009-09-02 | Papildytas duomenų rinkinys, kurį grąžina GetEinamiejiLikučiai() prekės savikaina. Nauja finkcija GetEinamiejiLikučiaiXml() – dubliuoja GetEinamiejiLikuciai() bet grąžina daugiau duomenų (prekės rūšį ir požymius) | S. Kvederavičius |
| 6 | 2009-09-08 | Operacijų išsaugojimo metodai papildyti, kad sėkmingai išsaugojus operaciją, būtų grąžinama informacija apie operaciją | S. Kvederavičius |
| 7 | 2009-09-21 | Įtraukta įplaukos operacija, papildyti klaidų kodai | S. Kvederavičius |
| 8 | 2009-11-24 | Įtraukta vidinio perkėlimo operacija bei operacijų šalinimo funkcija. Papildyti klaidų sąrašai | S. Kvederavičius |
| 9 | 2009-12-08 | Vidiniame perkėlime pridėta serija | S. Kvederavičius |
| 10 | 2009-12-21 | Įtrauktas operacijų koregavimas. Papildyti klaidų sąrašai | S. Kvederavičius |
| 11 | 2010-02-22 | Operacijų koregavime įtraukta galimybė nurodyti sandėlį. | S. Kvederavičius |
| 12 | 2010-03-16 | Nauja funkcija – GetPrekesSandelyjeOrder() | S. Kvederavičius |
| 13 | 2010-06-10 | Nauja funkcija – GetUzsakytasPrekes() | S.Kvederavičius |
| 14 | 2010-07-29 | Klientų, prekių ir paslaugų duomenų gavimo funkcijos papildytos kūrimo bei koregavimo datomis | S. Kvederavičius |
| 15 | 2010-08-27 | Koregavimo operacijos papildymas<br>Header tipo informacija | G. Jasvilis |
| 16 | 2010-09-27 | Pardavimo operacija pipldyta gaminio detalia eilute | S. Kvederavičius |
| 17 | 2010-11-18 | Nauja funkcija: GetEinamiejiLikuciaiExtSuKainom() | S. Kvederavičius |
| 18 | 2011-04-01 | Naujos funkcijos: Adreso kortelės išsaugojimas, UVM pardavimų rezervavimų įterpimas, šalinimas ir anuliavimas, UVM pardavimų rezeravavimų (įvykdytų, neįvykdytų, anuliuotų) paėmimas. | S. Kvederavičius |
| 19 | 2011-05-23 | UVM pardavimų rezeravavimų (įvykdytų, neįvykdytų, anuliuotų) paėmimas papildytas žurnalų grupės parametru. |  |
| 20 | 2011-11-22 | Naujas detalios eilutės tipas pirkimuose ir pardavimuose – sąskaitos det. Eil. | S. Kvederavičius |
| 21 | 2012-01-03 | Nauja funkcija – GetPrekesImage() | S. Kvederavičius |
| 22 | 2012-01-04 | Nauja funkcija – GetUVMPardRBusena() | S. Kvederavičius |
| 23 | 2012-03-14 | Naujos funkcijos: objektų (visų lygių) kūrimas ir koregavimas; UVM pirkimų užsakymų operacijos išsaugojimas ir šalinimas. | S. Kvederavičius |
| 24 | 2012-06-18 | Nurašymo operacija | S. Kvederavičius |
| 25 | 2012-10-18 | Nauja fukcija: GetAtsiskaitymaiUzDok; Pirkimo operacijoje: pridėtas avansininkas | S. Kvederavičius |
| 26 | 2013-02-06 | Pardavimo prekių ir paslaugų det. Eilutėse pridėtas PVM procentas; | S. Kvederavičius |
| 27 | 2013-04-05 | Naujos funkcijos: GetObjektai1Set,<br>GetObjektai2Set, GetObjektai3Set,<br>GetObjektai4Set, GetObjektai5Set,<br>GetObjektai6Set, GetObjektai1SetXml,<br>GetObjektai2SetXml, GetObjektai3SetXml,<br>GetObjektai4SetXml, GetObjektai5SetXml,<br>GetObjektai6SetXml, GetObjektas1,<br>GetObjektas2, GetObjektas3, GetObjektas4, GetObjektas5, GetObjektas6. Galimybė kurti ir koreguoti 5 ir 6 lygio objektus. | S. Kvederavičius |
| 28 | 2013-04-08 | Sandėlio kortelės kūruimas ir koregavimas; Papildytas aprašymas: funkcijos buvo suprogramuotos, bet nebuvo uždokumentuotos: Aprašymų kūrimas ir koregavimas: Bankai, Kliento Rūšis, Kliento požymiai, Atsiskaitymo terminai. | S. Kvederavičius |
| 29 | 2013-05-07 | Nauja funkcija GetPrekesSetExt, analogiška funkcijai GetPrekesSet, tačiau turinti išsamesnį filtrą. | S. Kvederavičius |
| 30 | 2013-10-22 | Pirkimų ir pardavimų paslaugų det. Eilutėse nauji laukai (savikaina ir pap. Išlaidos) | S. Kvederavičius |
| 31 | 2013-11-04 | Pirkimų ir pardavimų paslaugų det. Eilutėse nauji laukai (savikaina ir pap. Išlaidos) pakoreguoti į savikaina EUR, savikaina valiuta, pap. Išl. Iitais, pap. Išl. Valiuta. | S. Kvederavičius |
| 32 | 2014-03-19 | Naujas metodas: EditItemProps() | S. Kvederavičius |
| 33 | 2014-03-24 | Adreso kortelėje naujas laukas: sPapildomaInf3 | S. Kvederavičius |
| 34 | 2014-04-29 | Prekės kortelėje, Insert/Edit Item: sKilmesSalis | R. Vanagas |
| 35 | 2014-05-20 | InsertNew/Update Operation: naujas laukas dNlProc pirkimo/pardavimo operacijos det. Eilutės įraše | M. Piešina |
| 36 | 2014-05-23 | EditItemProps() papildyta galimybe nurodyti kilmės šalį (tik prekėms) | S. Kvederavičius |
| 37 | 2014-07-21 | InsertNewOperation/DeleteOperation pajamavimų operacijos | R.Vanagas |
| 38 | 2014-11-11 | InsertNewOperation/DeleteOperation gamybos operacijos | R. Vanagas |
| 39 | 2015-02-18 | Nauja funkcija GetAtsiskaitymaiUzDok | R. Vanagas |
| 40 | 2015-03-31 | GetUVMPardRBusena() papildytas nauja būsena (5 – surinktas) | S. Kvederavičius |
| 41 | 2015-04-21 | Pridėtas REST aprašymas | R. Vanagas |
| 42 | 2015-09-15 | Pridėtas papildomas laukas<br>nPirmasMat | R. Vanagas |
| 43 | 2015-10-29 | Pridėti laukai:<br>sAprasymas2, sKlientas<br>gamybos op. | R. Vanagas |
| 44 | 2016-03-18 | Pridėta užskaitos operacija | R. Vanagas |
| 45 | 2016-05-30 | JSON formato pilnas palaikymas pridėtas | R.Vanagas |
| 46 | 2016-06-29 | Pridėtos naujos funkcijos:<br>GetAtsiskaitymaiUzDokDataNuoDet<br>,<br>GetAtsiskaitymaiUzDokDataNuoDet<br>Xml | R. Vanagas |
| 47 | 2016-07-18 | Pridėtas laukai: „tRegistravimoData“, „sPvmKodas“ pirkimo/pardavimo operacijoms | R. Vanagas |
| 48 | 2016-08-24 | Pridėti važtaraščio laukai:<br>tSurasData, tPakrovimoData, tIskrovimoData<br>Pridėta<br>tMokejimoData<br>operacijos koregavime<br>Pirkimuose pridėtas laukas<br>dPVM_Procentas | R. Vanagas |
| 49 | 2016-09-14 | Pridėta dokumento data<br>tDokumentoData | R. Vanagas |
| 50 | 2016-11-02 | Pridėtas valstybės ISO kodas kliento kortelės saugojime | R. Vanagas |
| 51 | 2016-11-17 | Pridėti metodai GetEinamiejiLikuciaiGrp, GetEinamiejiLikuciaiGrpXml | R. Vanagas |
| 52 | 2016-12-15 | Kliento redagavime pridėta varna „Siusti faktūras e-paštu“ | R. Vanagas |
| 53 | 2016-12-27 | Pridėti metodai: GetPardPrekPerPerioda, GetPardPrekPerPeriodaXml | R. Vanagas |
| 54 | 2017-05-02 | Pridėta galimybė kurti ir koreguoti prekės rūšį ir požymius. | R. Vanagas |
| 55 | 2017-09-27 | Pridėtas naujas XML mazgas operacijoms, kuriuo galima klientą identifikuoti pagal įmonės kodą: <sKlientImonesKodas><br>„InsertNewOperation“ metode. | A. Junevičius |
| 56 | 2017-10-30 | Į pardavimo operacijos detaliasias eilutes pridėti laukai:<br>sIntrastatKodas, sKilmesSalis.<br>Į pirkimo op. detaliasias eilutes pridėti laukai:<br>sIntrastatKodas, sKilmesSalis, dBruto, dNeto, dTuris<br>. | R. Vanagas |
| 57 | 2018-04-05 | Į pardavimo operacijos prekės ir paslaugos detaliasias eilutes pridėtas laukas<br>sPapInf<br>(InsertNewOperation) | R. Vanagas |
| 58 | 2019-04-30 | Pridėta galimybė koreguoti pirkimo operacijas<br>UpdateOperation<br>metode.<br>Pridėta galimybė nurodyti papildomas išlaidų sumas ir kodus pirkimo operacijose<br>UpdateOperation<br>ir<br>InsertNewOperation<br>metoduose. | R. Vanagas |
| 59 | 2019-05-17 | Į operacijų headerį pridėtas finvaldos darbuotojas<br>sDarbuotojas | R. Vanagas |
| 60 | 2019-07-02 | Kliento kortelės kūrimas papildytas požymiu nPvmMokaPirkejas | R. Vanagas |
| 61 | 2019-09-10 | Pridėtas naujas metodas<br>GetKlientoSaskaitas | R. Vanagas |
| 62 | 2019-10-16 | Pridėti metodai<br>GetPrekesIstorija, AppendGroup | R. Vanagas |
| 63 | 2019-11-07 | Pridėtas aprašymas SSL sertifikatų naudojimui. | R. Vanagas |
| 64 | 2019-11-19 | Pridėtas metodas GetAtsiskaitymaiUzDokDataNuoDetParam | R. Vanagas |
| 65 | 2020-03-02 | Pridėtas metodas<br>GetVeiklaPagalObjektus | R. Vanagas |
| 66 | 2020-06-10 | PirkDokPaslaugaDetEil<br>papildytas nauju lauku<br>sPastaba | R. Vanagas |
| 67 | 2020-10-26 | Pridėtas adreso koregavimas<br>EditItem – „Fvs.Adresas“ | R. Vanagas |
| 68 | 2021-02-11 | Kliento kortelės saugojimas papildytas lauku<br>nFizinisAsmuo | R. Vanagas |
| 69 | 2021-03-08 | Pridėtas metodas<br>MakeInvoice<br>faktūrų generavimui | R. Vanagas |
| 70 | 2021-03-29 | Pridėtas metodas GetOperations | R. Vanagas |
| 71 | 2021-04-30 | Užklausos antraštė papildyta<br>Language<br>parametru | R. Vanagas |
| 72 | 2021-06-15 | GetKlientuSet<br>papildytas laukais:<br>valstybe, valstybe_pav, miestas | R. Vanagas |
| 73 | 2021-09-10 | GetOperations metodas papildytas iplaukų/išmokų/užskaitų nuskaitymas | R. Vanagas |
| 74 | 2022-05-17 | Pridėtas naujas metodas<br>GetDescriptions | R. Vanagas |
| 75 | 2022-05-18 | GetOperations metodas papildytas pardavimų rezervavimų ir pirkimų užsakymų skaitymu. | R. Vanagas |
| 76 | 2022-05-25 | GetDescriptions metodas papildytas prekių sąrašu | R. Vanagas |
| 77 | 2022-05-30 | InsertNewOperation<br>pirkimai ir pardavimai papildyti nauju lauku<br>sDokRusis | R. Vanagas |
| 78 | 2022-06-09 | GetDescriptions<br>metodas papildytas prekių partnerio kataloguose skaitymu | R. Vanagas |
| 79 | 2022-07-05 | GetDescriptions metodas papildas fakturų sąrašo nuskaitymu | R. Vanagas |
| 80 | 2022-07-25 | GetDescriptions metodas papildytas dokumentų serijų skaitymu | R. Vanagas |
| 81 | 2022-09-12 | Pridėtas naujas metodas<br>MakeReport | R. Vanagas |
| 82 | 2022-09-14 | GetDescriptions metodas papildytas klientu ir pardavimu skaiciaus skaitymu | R. Vanagas |
| 83 | 2022-09-20 | Nauji metodai: GetAutoReportsList, GetAutoReport | R. Vanagas |
| 84 | 2022-09-27 | GetDescriptions metodas papildytas kalendoriaus įvykių skaitymu CalendarEvents | R. Vanagas |
| 85 | 2022-10-10 | GetDescriptions metodas papildytas prekių likučių skaitymu CurrentStock | R. Vanagas |
| 86 | 2022-10-12 | GetDescriptions metodas papildytas ataskaitų sąrašo skaitymu ReportList | R. Vanagas |
| 87 | 2022-10-24 | GetDescriptions metodas papildytas ataskaitų sąrašo skaitymu CompanyWorkStart | R. Vanagas |
| 88 | 2022-11-22 | GetDescriptions metodas papildytas klientų ir transporto priemonių skaitymu. | R. Vanagas |
| 89 | 2022-12-22 | GetDescriptions metodas papildytas adresų skaitymu | R. Vanagas |
| 90 | 2023-05-02 | GetDescriptions metodas papildytas gaminio kortelių skaitymu. GetOperations papildytas vidinių perkėlimų skaitymu. | R. Vanagas |
| 91 | 2023-05-04 | GetOperations<br>metodas leidžia nuskaityti operaciją su jos eilutėmis vienu kreipimusi. | R. Vanagas |
| 92 | 2023-06-22 | GetDescriptions metodas papildytas paslaugų skaitymu | R. Vanagas |
| 93 | 2023-07-17 | GetDescriptions metodas papildytas kainų skaitymu (Prices, PricesByItemType, PricesByClientType, PricesByClientAndItemTypes) | R. Vanagas |
| 94 | 2023-07-18 | GetDescriptions metodas papildytas likučių skaitymu CurrentStockDet |  |
| 95 | 2024-01-29 | UpdateOperation<br>papildytas laukais serija, dokumentas, dokumento rūšis. |  |
| 96 | 2024-02-26 | UpdateOperation<br>paradavimų operacijose leidžiama keisti klientą | R. Vanagas |
| 97 | 2024-02-29 | InsertNewOperation<br>papildytas prekių inventorizacijos operacijų kūrimu. | R. Vanagas |
| 98 | 2024-03-13 | UpdateOperation<br>Metodas papildytas vidinio perkėlimo operacijų koregavimu. Pridėta galimybė keisti operacios žymę.<br>GetDescriptions<br>papildytas barkodų sąrašu. | R. Vanagas |
| 99 | 2024-05-02 | Pridėtas metodas DeleteDokumentas | R. Vanagas |
| 100 | 2024-05-29 | Pridėti metodai: LockOperation, UnLockOperation, IsOperatonLocked | R. Vanagas |
| 101 | 2024-07-01 | InsertNewOperation<br>papildytas Išmokų operacijos formavimu. | R. Vanagas |
| 102 | 2024-09-06 | Išmokų operacijų formavimas (<br>InsertNewOperation<br>) papildytas, mokėjimo reikalavimo įterpimu | R. Vanagas |
| 103 | 2024-09-12 | Kitų neanalitinių įterpimas (<br>InsertNewOperation<br>) | R. Vanagas |
| 104 | 2024-10-30 | UpdateOperation<br>papildytas pardavimų gražinimo operacija | R. Vanagas |
| 105 | 2024-11-19 | InsertNewOperation<br>pridėtas tagas leidžiantis keisti požymį „Eksportuoti į IVaz“ | R. Vanagas |
| 106 | 2024-12-12 | EditItemProps<br>papildytas prekių požymiais 7-20.<br>GetDescriptions<br>papildytas rūšių ir požymių skaitymu |  |
| 107 | 2025-02-25 | GetDescriptions<br>papildytas nauju metodu valiutų kursų skaitymui<br>CurrencyRates | R. Vanagas |
| 108 | 2025-02-27 | InsertNewOperation<br>užskaitų įterpimas praplėstas | R. Vanagas |
| 109 | 2025-03-26 | Pirkimo, Pardavimo operacijos papildytos suapvalintų centų lauku<br>dGrApvalinimoSuma | R. Vanagas |
| 110 | 2025-04-14 | Operacijų įterpimas papildytas galimybe ‚pažymėti‘ operaciją ar eilutę. | R. Vanagas |

## Turinys

- [1. Įvadas](#įvadas) — p. 12
  - [1.1. Tikslas](#tikslas) — p. 12
- [2. Protokolai](#protokolai) — p. 12
  - [2.1. Kalbos parinkimas](#kalbos-parinkimas) — p. 12
  - [2.2. Sąsajos](#sąsajos) — p. 12
- [3. Webserviso metodai](#webserviso-metodai) — p. 14
  - [3.2. GetEinamiejiLikuciai](#geteinamiejilikuciai) — p. 17
  - [3.3. GetEinamiejiLikuciaiExt](#geteinamiejilikuciaiext) — p. 18
  - [3.4. GetEinamiejiLikuciaiExtSuKainom](#geteinamiejilikuciaiextsukainom) — p. 19
  - [3.5. GetEinamiejiLikuciaiGrp](#geteinamiejilikuciaigrp) — p. 20
  - [3.6. GetKlientuRusisPozymius](#getklienturusispozymius) — p. 21
  - [3.7. GetKlientusSet](#getklientusset) — p. 21
  - [3.8. GetMatavimoVienetus](#getmatavimovienetus) — p. 22
  - [3.9. GetNeapmoketiKliDok](#getneapmoketiklidok) — p. 23
  - [3.10. GetAtsiskaitymaiUzDok](#getatsiskaitymaiuzdok) — p. 24
  - [3.1. GetAtsiskaitymaiUzDokDet, GetAtsiskaitymaiUzDokDataNuoDet, GetAtsiskaitymaiUzDokDataNuoDetParam](#getatsiskaitymaiuzdokdet-getatsiskaitymaiuzdokdatanuodet-getatsiskaitymaiuzdokdatanuodetparam) — p. 24
  - [3.2. GetPaslaugosSet](#getpaslaugosset) — p. 26
  - [3.3. GetPaslauguRusisPozymius](#getpaslaugurusispozymius) — p. 27
  - [3.4. GetPrekesSet](#getprekesset) — p. 28
  - [3.5. GetPrekesSetExt](#getprekessetext) — p. 29
  - [3.6. GetPrekiuRusisPozymius](#getprekiurusispozymius) — p. 31
  - [3.7. GetPrekiuRusiuGrupes](#getprekiurusiugrupes) — p. 31
  - [3.8. GetPrekiuRusiuGrupesSudeti](#getprekiurusiugrupessudeti) — p. 32
  - [3.9. GetSandelius](#getsandelius) — p. 32
  - [3.10. GetKliPrekPasNuolPapKain](#getkliprekpasnuolpapkain) — p. 33
  - [3.11. GetKliRusPrekPasNuolPapKain](#getklirusprekpasnuolpapkain) — p. 34
  - [3.12. GetKliPrekPasRusNuolPapKain](#getkliprekpasrusnuolpapkain) — p. 35
  - [3.13. GetKliRusPrekPasRusNuolPapKain](#getklirusprekpasrusnuolpapkain) — p. 37
  - [3.14. GetMokesciai](#getmokesciai) — p. 38
  - [3.15. GetKlientuPaslauguNuol](#getklientupaslaugunuol) — p. 38
  - [3.16. GetKlientuPaslauguPapKainas](#getklientupaslaugupapkainas) — p. 40
  - [3.17. GetKlientuPaslauguRusNuol](#getklientupaslaugurusnuol) — p. 40
  - [3.18. GetKlientuPaslauguRusPapKainas](#getklientupaslauguruspapkainas) — p. 41
  - [3.19. GetKlientuPrekiuNuol](#getklientuprekiunuol) — p. 42
  - [3.20. GetKlientuPrekiuPapKainas](#getklientuprekiupapkainas) — p. 43
  - [3.21. GetKlientuPrekiuRusNuol](#getklientuprekiurusnuol) — p. 44
  - [3.22. GetKlientuPrekiuRusPapKainas](#getklientuprekiuruspapkainas) — p. 45
  - [3.23. GetKlientuRusPaslauguNuol](#getklienturuspaslaugunuol) — p. 46
  - [3.24. GetKlientuRusPaslauguPapKainas](#getklienturuspaslaugupapkainas) — p. 47
  - [3.25. GetKlientuRusPaslauguRusNuol](#getklienturuspaslaugurusnuol) — p. 48
  - [3.26. GetKlientuRusPaslauguRusPapKainas](#getklienturuspaslauguruspapkainas) — p. 49
  - [3.27. GetKlientuRusPrekiuNuol](#getklienturusprekiunuol) — p. 49
  - [3.28. GetKlientuRusPrekiuPapKainas](#getklienturusprekiupapkainas) — p. 50
  - [3.29. GetKlientuRusPrekiuRusNuol](#getklienturusprekiurusnuol) — p. 51
  - [3.30. GetKlientuRusPrekiuRusPapKainas](#getklienturusprekiuruspapkainas) — p. 52
  - [3.31. GetFvsUser](#getfvsuser) — p. 53
  - [3.32. GetObjektas1](#getobjektas1) — p. 54
  - [3.33. GetObjektas2](#getobjektas2) — p. 55
  - [3.34. GetObjektas3](#getobjektas3) — p. 56
  - [3.35. GetObjektas4](#getobjektas4) — p. 56
  - [3.36. GetObjektas5](#getobjektas5) — p. 57
  - [3.37. GetObjektas6](#getobjektas6) — p. 58
  - [3.38. GetKlientas](#getklientas) — p. 58
  - [3.39. GetKlientasEMail](#getklientasemail) — p. 60
  - [3.40. GetKlientus](#getklientus) — p. 60
  - [3.41. GetPaslauga](#getpaslauga) — p. 61
  - [3.42. GetPaslaugos](#getpaslaugos) — p. 62
  - [3.43. GetPreke](#getpreke) — p. 63
  - [3.44. GetPrekes](#getprekes) — p. 65
  - [3.45. GetPrekesImage](#getprekesimage) — p. 66
  - [3.46. GetPrekesSandelyje](#getprekessandelyje) — p. 66
  - [3.47. GetPrekesSandelyjeOrder](#getprekessandelyjeorder) — p. 67
  - [3.48. GetPrekiuRusiesSudeti](#getprekiurusiessudeti) — p. 68
  - [3.49. GetPardPrekPerPerioda](#getpardprekperperioda) — p. 68
  - [3.50. GetPaslauguRusiesSudeti](#getpaslaugurusiessudeti) — p. 69
  - [3.51. GetKlientusRusiesSudeti](#getklientusrusiessudeti) — p. 69
  - [3.52. GetAtsiskaitymoTerm](#getatsiskaitymoterm) — p. 70
  - [3.53. GetObjektai1Set](#getobjektai1set) — p. 70
  - [3.54. GetObjektai2Set](#getobjektai2set) — p. 71
  - [3.55. GetObjektai3Set](#getobjektai3set) — p. 72
  - [3.56. GetObjektai4Set](#getobjektai4set) — p. 73
  - [3.57. GetObjektai5Set](#getobjektai5set) — p. 73
  - [3.58. GetObjektai6Set](#getobjektai6set) — p. 74
  - [3.59. GetUVMPardRBusena](#getuvmpardrbusena) — p. 75
  - [3.60. GetUVMPardRAnuliuoti](#getuvmpardranuliuoti) — p. 75
  - [3.61. GetUVMPardRIvykdyti](#getuvmpardrivykdyti) — p. 76
  - [3.62. GetUVMPardRNeivykdyti](#getuvmpardrneivykdyti) — p. 77
  - [3.63. GetKlientoSaskaitas](#getklientosaskaitas) — p. 78
  - [3.64. GetPrekesIstorija](#getprekesistorija) — p. 79
  - [3.65. GetVeiklaPagalObjektus](#getveiklapagalobjektus) — p. 80
  - [3.66. InsertNewItem](#insertnewitem) — p. 81
  - [3.67. EditItem](#edititem) — p. 93
  - [3.68. EditItemProps](#edititemprops) — p. 94
  - [3.69. AppendGroup](#appendgroup) — p. 98
  - [3.70. InsertNewOperation](#insertnewoperation) — p. 98
  - [3.71. DeleteOperation](#deleteoperation) — p. 122
  - [3.72. UpdateOperation](#updateoperation) — p. 123
  - [3.73. LockOperation, UnLockOperation](#lockoperation-unlockoperation) — p. 130
  - [3.74. IsOperationLocked](#isoperationlocked) — p. 131
  - [3.75. MakeInvoice](#makeinvoice) — p. 132
  - [3.76. MakeReport](#makereport) — p. 133
  - [3.77. GetOperations](#getoperations) — p. 137
  - [3.78. Pavyzdžiai](#pavyzdžiai-2) — p. 141
  - [3.79. GetRecommendedPrice](#getrecommendedprice) — p. 142
  - [3.80. InsertDocument](#insertdocument) — p. 145
  - [3.81. DeleteDocument](#deletedocument) — p. 148
  - [3.82. AttachDocument](#attachdocument) — p. 148
  - [3.83. GetAttachedDocuments](#getattacheddocuments) — p. 152
  - [3.84. GetUserPermissions](#getuserpermissions) — p. 158
- [4. GetDescriptions](#getdescriptions) — p. 166
  - [4.2. StockOnDate](#stockondate) — p. 168
  - [4.3. FixedAsset](#fixedasset) — p. 169
  - [4.4. Products](#products) — p. 169
  - [4.5. CurrentStock](#currentstock) — p. 170
  - [4.6. CurrentStockDet](#currentstockdet) — p. 171
  - [4.7. PartnerProducts](#partnerproducts) — p. 172
  - [4.8. InvoiceList](#invoicelist) — p. 172
  - [4.9. ReportList](#reportlist) — p. 173
  - [4.10. DocumentSeries](#documentseries) — p. 173
  - [4.11. CountSales](#countsales) — p. 173
  - [4.12. CountClients](#countclients) — p. 174
  - [4.13. ClientGroups](#clientgroups) — p. 174
  - [4.14. LogbookGroups](#logbookgroups) — p. 174
  - [4.15. OpTypeGroups](#optypegroups) — p. 174
  - [4.16. WareHouseGroups](#warehousegroups) — p. 174
  - [4.17. CalendarEvents](#calendarevents) — p. 175
  - [4.18. CompanyWorkStart](#companyworkstart) — p. 175
  - [4.19. Vehicles](#vehicles) — p. 175
  - [4.20. Clients](#clients) — p. 175
  - [4.21. Address](#address) — p. 176
  - [4.22. ProductionItem](#productionitem) — p. 177
  - [4.23. Services](#services) — p. 177
  - [4.24. Prices](#prices) — p. 178
  - [4.25. PricesByItemType](#pricesbyitemtype) — p. 178
  - [4.26. PricesByClientType](#pricesbyclienttype) — p. 179
  - [4.27. PricesByClientAndItemTypes](#pricesbyclientanditemtypes) — p. 179
  - [4.28. BarCodes](#barcodes) — p. 180
  - [4.29. TagsAndTypes](#tagsandtypes) — p. 180
  - [4.30. CurrencyRates](#currencyrates) — p. 181
  - [4.31. Pavyzdžiai](#pavyzdžiai-3) — p. 181
- [5. Metodų kvietimas JSON formatu](#metodų-kvietimas-json-formatu) — p. 181
- [6. I Priedas – Klaidos](#i-priedas-klaidos) — p. 182
  - [6.1. Aprašymų klaidos:](#aprašymų-klaidos) — p. 182
  - [6.2. Operacijų klaidos:](#operacijų-klaidos) — p. 184
  - [6.3. Importavimo klaidos](#importavimo-klaidos) — p. 187
  - [6.4. Operacijų šalinimo klaidos](#operacijų-šalinimo-klaidos) — p. 187
  - [6.5. Operacijų koregavimo klaidos](#operacijų-koregavimo-klaidos) — p. 188
- [7. II Priedas - Papildoma informacija](#ii-priedas---papildoma-informacija) — p. 189
  - [7.1. SSL sertifikato įdiegimas webservisui](#ssl-sertifikato-įdiegimas-webservisui) — p. 189

<a id="įvadas"></a>
# 1. Įvadas

<a id="tikslas"></a>
## 1.1. Tikslas

Šis dokumentas aprašo visus FVS webserviso metodus. Kiekvienam metodui yra nurodomi įėjimo parametrai (jei tokie yra), rezultatai ir galimi klaidų pranešimai.

<a id="protokolai"></a>
# 2. Protokolai

Webserviso metodai pasiekiami per SOAP arba REST protokolus. SOAP pasiekiamas per standartinį adresą „../FvsService.asmx“, o REST pasiekiamas adresu „../FvsService.asmx/rest“ (adresai gali būti ir kitokie). Visi REST metodai yra „post“ tipo ir užklausos gali būti XML arba JSON formatu (užklausos atsakymas gražinamas tokiu pačiu formatu kaip ir užklausa).

<a id="kalbos-parinkimas"></a>
## 2.1. Kalbos parinkimas

Webservisas gali gražinti atsakymus su lietuviškais arba angliškais „tagais“. Angliškus variantą galima gauti tokiais būdais:

- Užklausos antraštėje nurodant parametrą „Language“: 0 – lietuviškai, 1 – angliškai

- Kreipiantis į *FvsServiceEn* sąsają rezultatai visada gražinami angliškai

<a id="sąsajos"></a>
## 2.2. Sąsajos

- Visos sąsajos gražina tuos pačius duomenis, tik skiriasi užklausų ir atsakymų formavimas

- Vienu metu gali veikti visos sąsajos, skiriasi tik kreipimosi adresai

### FvsService

FvsService sąsaja veikia SOAP protokolu, galimas ir REST protokolas bet tik xml sintakse. Sąsajos soap atsakymo pavyzdys:

```xml
<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
<s:Body xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="...">
<GetMatavimoVienetusResponse xmlns="http://www.fvs.lt/webservices">
<GetMatavimoVienetusResult>Success</GetMatavimoVienetusResult>
<Data>
<diffgr:diffgram xmlns:diffgr="..." xmlns:msdata="...">
<Matavimo_x0020_vienetai xmlns="">
<Table1 diffgr:id="Table11" msdata:rowOrder="0" diffgr:hasChanges="inserted">
<kodas>KG</kodas>
<pavadinimas>KILOGRAMAI</pavadinimas>
<pirm_mat_pav>KG</pirm_mat_pav>
<antr_mat_pav>G</antr_mat_pav>
<pirm_antr_sant>1000</pirm_antr_sant>
</Table1>
</Matavimo_x0020_vienetai>
</diffgr:diffgram>
</Data>
<sError/>
</GetMatavimoVienetusResponse>
</s:Body>
</s:Envelope>
```

### FvsServiceEn

> FvsServiceEn sąsaja yra tokia pati kaip FvsService, tik užklausų ir atsakymų parametrai (tags) yra angliški.

### FvsServiseR

FvsServiceR sąsaja veikia SOAP ir REST protokolais., galima naudoti xml ir json. Rezultatas yra apgaubptas (wrapped) ir gražinamas kaip xml/json symbolių eilutė (string). Sąsajos rest atsakymo pavyzdys:

XML:

```xml
<GetKlientusSetResponse xmlns="http://www.fvs.lt/webservices">
<GetKlientusSetResult>Success</GetKlientusSetResult>
<Data>&lt;DataSet&gt;&#xD;
&lt;Klientai&gt;&#xD;
&lt;Table1 diffgr:id="Table11" msdata:rowOrder="0" diffgr:hasChanges="inserted"&gt;&#xD;
&lt;kodas&gt;A1&lt;/kodas&gt;&#xD;
&lt;pavadinimas&gt;A1 &amp;amp; testas&lt;/pavadinimas&gt;&#xD;
&lt;/Table1&gt;&#xD;
&lt;/Klientai&gt;&#xD;
&lt;/DataSet&gt;</Data>
<sError/>
</GetKlientusSetResponse>
```

JSON:

```json
{
"GetKlientusSetResult": 2,
"Data": "{\r\n \\Table1\\: [\r\n {\r\n \\kodas\\: \\A1\\,\r\n \\pavadinimas\\: \\A1 & testas\}\r\n ]\r\n}",
"sError": ""
}
```

### FvsServicePure

FvsServicePure sąsaja veikia REST protokolu., galima naudoti xml ir json. Rezultatas yra gražinamas kaip xml/json objektas. Sąsajos atsakymo pavyzdys:

```xml
<AccessResult>Success</AccessResult>
<error></error>
<Klientai>
<Eil>
<kodas>A1</kodas>
<pavadinimas>A1 &amp; testas</pavadinimas>
</Eil>
</Klientai>
```

JSON:

```json
{
"AccessResult":Success,
"error": "",
{
"items": [
{
"kodas": "A1",
"pavadinimas": "A1 & testas"
}]
}
}
```

<a id="webserviso-metodai"></a>
# 3. Webserviso metodai

Fvs webservisai skirstomi Į tokias grupes:

1)  Grąžina duomenys DataSet formatu:

GetEinamiejiLikuciai,

GetEinamiejiLikuciaiExt,

GetEinamiejiLikuciaiGrp,

GetKlientuRusisPozymius,

GetKlientusSet,

GetMatavimoVienetus,

GetNeapmoketiKliDok,

GetAtsiskaitymaiUzDok,

GetAtsiskaitymaiUzDokDet,

GetAtsiskaitymaiUzDokDataNuoDet,

GetPaslaugosSet,

GetPaslauguRusisPozymius,

GetPrekesSet,

GetPrekesSetExt,

GetPrekiuRusisPozymius,

GetPrekiuRusiuGrupes,

GetPrekiuRusiuGrupesSudeti,

GetSandelius,

GetKliPrekPasNuolPapKain,

GetKliRusPrekPasNuolPapKain,

GetKliPrekPasRusNuolPapKain,

GetKliRusPrekPasRusNuolPapKain,

GetMokesciai,

GetKlientuPaslauguNuol,

GetKlientuPaslauguPapKainas,

GetKlientuPaslauguRusNuol,

GetKlientuPaslauguRusPapKainas,

GetKlientuPrekiuNuol,

GetKlientuPrekiuPapKainas,

GetKlientuPrekiuRusNuol,

GetKlientuPrekiuRusPapKainas,

GetKlientuRusPaslauguNuol,

GetKlientuRusPaslauguPapKainas,

GetKlientuRusPaslauguRusNuol,

GetKlientuRusPaslauguRusPapKainas,

GetKlientuRusPrekiuNuol,

GetKlientuRusPrekiuPapKainas,

GetKlientuRusPrekiuRusNuol,

GetKlientuRusPrekiuRusPapKainas,

GetPrekiuRusiesSudeti,

GetPaslauguRusiesSudeti,

GetKlientusRusiesSudeti,

GetAtsiskaitymoTerm,

GetObjektai1Set,

GetObjektai2Set,

GetObjektai3Set,

GetObjektai4Set,

GetObjektai5Set,

GetObjektai6Set,

GetUVMPardRAnuliuoti,

GetUVMPardRIvykdyti,

GetUVMPardRNeivykdyti,

GetPardPrekPerPerioda,

GetKlientoSaskaitas,

GetPrekesIstorija.

2)  Grąžina duomenys XML formatu:

GetEinamiejiLikuciaiXml,

GetEinamiejiLikuciaiExtXml,

GetEinamiejiLikuciaiGrpXml,

GetKlientuRusisPozymiusXml,

GetKlientusSetXml,

GetNeapmoketiKliDokXml,

GetAtsiskaitymaiUzDokXml,

GetAtsiskaitymaiUzDokDetXml,

GetAtsiskaitymaiUzDokDataNuoDetXml,

GetPaslaugosSetXml,

GetPaslauguRusisPozymiusXml,

GetPrekesSetXml,

GetPrekesSetExtXml,

GetPrekiuRusisPozymiusXml,

GetPrekiuRusiuGrupesXml,

GetPrekiuRusiuGrupesSudetiXml,

GetSandeliusXml,

GetKliPrekPasNuolPapKainXml,

GetKliRusPrekPasNuolPapKainXml,

GetKliPrekPasRusNuolPapKainXml,

GetKliRusPrekPasRusNuolPapKainXml,

GetMokesciaiXml,

GetKlientuPaslauguNuolXml,

GetKlientuPaslauguPapKainasXml,

GetKlientuPaslauguRusNuolXml,

GetKlientuPaslauguRusPapKainasXml,

GetKlientuPrekiuNuolXml,

GetKlientuPrekiuPapKainasXml,

GetKlientuPrekiuRusNuolXml,

GetKlientuPrekiuRusPapKainasXml,

GetKlientuRusPaslauguNuolXml,

GetKlientuRusPaslauguPapKainasXml,

GetKlientuRusPaslauguRusNuolXml,

GetKlientuRusPaslauguRusPapKainasXml,

GetKlientuRusPrekiuNuolXml,

GetKlientuRusPrekiuPapKainasXml,

GetKlientuRusPrekiuRusNuolXml,

GetKlientuRusPrekiuRusPapKainasXml,

GetFvsUser,

GetObjektas1,

GetObjektas2,

GetObjektas3,

GetObjektas4,

GetObjektas5,

GetObjektas6,

GetKlientas,

GetKlientus,

GetPaslauga,

GetPaslaugos,

GetPreke,

GetPrekes,

GetPrekesImage,

GetPrekesSandelyje,

GetPrekiuRusiesSudetiXml,

GetPaslauguRusiesSudetiXml,

GetKlientusRusiesSudetiXml,

GetAtsiskaitymoTermXml,

GetObjektai1SetXml,

GetObjektai2SetXml,

GetObjektai3SetXml,

GetObjektai4SetXml,

GetObjektai5SetXml,

GetObjektai6SetXml,

GetUVMPardRBusena,

GetUVMPardRAnuliuotiXml,

GetUVMPardRIvykdytiXml,

GetUVMPardRNeivykdytiXml,

GetPardPrekPerPeriodaXml,

GetKlientoSaskaitasXml,

GetPrekesIstorijaXml.

3)  Finvaldos aprašymų (kliento, prekės, paslaugos) įterpimas bei koregavimas, operacijų (pardavimų bei pirkimų grupės) kūrimas bei operacijų šalinimas:

InsertNewItem,

EditItem,

EditItemsProps,

AppendGroup,

InsertNewOperation,

DeleteOperation

### Xml failų duomenų tipai:

Xml failuose slankaus kablelio duomenų tipas atvaizduojamas pagal dabartinį XSD standartą: dešimtainės dalies skirtukas – taškas (‚.‘), skaitmenų grupių skirtukai nėra naudojami.

<a id="geteinamiejilikuciai"></a>
## 3.2. GetEinamiejiLikuciai

### Aprašymas

```csharp
GetEinamiejiLikuciai(string sPrekesKodas, string sSandelioKodas, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetEinamiejiLikuciaiXml(string sPrekesKodas, string sSandelioKodas, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina visų prekių likučius visuose sandėliuose.

### Įėjimo parametrai

sPrekesKodas – jei ne NULL, bus grąžinami tik nurodytos prekės likučiai visuose sandėliuose.

sSandelioKodas – jei ne NULL, nus grąžinami likučiai iš nurodyto sandėlio.

tKoregavimoData – Paskutinio koregavimo data, jei NULL, bus pateikiami visi duomenys.

tSukurimoData – Sukūrimo data, jei NULL, bus pateikiami visi duomenys.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

DataSet:

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | sandelis              | Char (10) | Sandėlio kodas                                                              |
| 2   | sandelio_pav          | Char (50) | Sandėlio pavadinimas                                                        |
| 3   | preke                 | Char (20) | Prekės kodas                                                                |
| 4   | prekes_pav            | Char (50) | Prekės pavadinimas                                                          |
| 5   | kiekis                | Double    | Prekės likutis sandėlyje (pirmu matavimu)                                   |
| 6   | kiekis_su_rezervuotom | Double    | Prekės likutis sandėlyje, atsižvelgus į rezervuotas prekes (pirmu matavimu) |
| 7   | mato_vnt_pav          | Char (50) | Prekės mato vieneto pavadinimas                                             |
| 8   | pirm_antr_mat_sant    | Integer   | Prekės pirmo ir antro mato vienetų santykis                                 |
| 9   | savikaina             | Double    | Prekės savikaina sandėlyje (suma)                                           |

XML:

```xml
<Einamieji_likučiai>
<Eil>
<sandelis> Sandėlio kodas </sandelis>
<sandelio_pav> Sandėlio pavadinimas </sandelio_pav>
<preke> Prekės kodas </preke>
<prekes_pav> Prekės pavadinimas </prekes_pav>
<kiekis> Prekės likutis sandėlyje (pirmu matavimu) </kiekis>
<kiekis_su_rezervuotom> Prekės likutis sandėlyje, atsižvelgus į rezervuotas prekes (pirmu matavimu)</kiekis_su_rezervuotom>
<mato_vnt_pav> Prekės mato vieneto pavadinimas </mato_vnt_pav>
<pirm_antr_mat_sant> Prekės pirmo ir antro mato vienetų santykis </pirm_antr_mat_sant>
<savikaina> Prekės savikaina sandėlyje (suma </savikaina>
</Eil>
</Einamieji_likučiai>
```

Pastaba.

XML tag‘ai ir DataSet laukų pavadinimai yra vienodi, todėl toliau bus rodoma bendro pobūdžio lentelė su laukų pavadinimais.

<a id="geteinamiejilikuciaiext"></a>
## 3.3. GetEinamiejiLikuciaiExt

### Aprašymas

```csharp
GetEinamiejiLikuciaiExt(string sPrekesKodas, string sSandelioKodas, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetEinamiejiLikuciaiExtXml(string sPrekesKodas, string sSandelioKodas, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina prekių likučius sandėliuose.

### Įėjimo parametrai

sPrekesKodas – jei ne NULL, bus grąžinami tik nurodytos prekės likučiai visuose sandėliuose.

sSandelioKodas – jei ne NULL, bus grąžinami likučiai iš nurodyto sandėlio.

tKoregavimoData – Paskutinio koregavimo data, jei NULL, bus pateikiami visi duomenys.

tSukurimoData – Sukūrimo data, jei NULL, bus pateikiami visi duomenys.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

DataSet:

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | sandelis              | Char (10) | Sandėlio kodas                                                              |
| 2   | sandelio_pav          | Char (50) | Sandėlio pavadinimas                                                        |
| 3   | preke                 | Char (20) | Prekės kodas                                                                |
| 4   | prekes_pav            | Char (50) | Prekės pavadinimas                                                          |
| 5   | kiekis                | Double    | Prekės likutis sandėlyje (pirmu matavimu)                                   |
| 6   | kiekis_su_rezervuotom | Double    | Prekės likutis sandėlyje, atsižvelgus į rezervuotas prekes (pirmu matavimu) |
| 7   | mato_vnt_pav          | Char (50) | Prekės mato vieneto pavadinimas                                             |
| 8   | pirm_antr_mat_sant    | Integer   | Prekės pirmo ir antro mato vienetų santykis                                 |
| 9   | savikaina             | Double    | Prekės savikaina sandėlyje (suma)                                           |
| 10  | rusis                 | Char(13)  | Prekės rūšies kodas                                                         |
| 11  | pozymis1              | Char(13)  | Pirmo prekės požymio kodas                                                  |
| 12  | pozymis2              | Char(13)  | Antro prekės požymio kodas                                                  |
| 13  | pozymis3              | Char(13)  | Trečio prekės požymio kodas                                                 |
| 14  | pozymis4              | Char(13)  | Ketvirto prekės požymio kodas                                               |
| 15  | pozymis5              | Char(13)  | Penktos prekės požymio kodas                                                |
| 16  | pozymis6              | Char(13)  | Šešto prekės požymio kodas                                                  |
| 17  | uzsak_data            | DateTime  | Anksčiausia prekės pristatymo data                                          |

<a id="geteinamiejilikuciaiextsukainom"></a>
## 3.4. GetEinamiejiLikuciaiExtSuKainom

### Aprašymas

```csharp
GetEinamiejiLikuciaiExtSuKainom(string sPrekesKodas, string sSandelioKodas, bool bNuliniaiLikuciai, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetEinamiejiLikuciaiExtSuKainomXml(string sPrekesKodas, string sSandelioKodas, bool bNuliniaiLikuciai, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina prekių likučius sandėliuose su pardavimo kainomis.

### Įėjimo parametrai

sPrekesKodas – jei ne NULL, bus grąžinami tik nurodytos prekės likučiai visuose sandėliuose.

sSandelioKodas – jei ne NULL, bus grąžinami likučiai iš nurodyto sandėlio.

bNuliniaiLikuciai – jei TRUE, bus gražinamo prekės, kurių likutis yra 0, priešingu atveju bus grąžinamos tik tos prekės, kurių likutis yra didesnis už 0.

tKoregavimoData – Paskutinio koregavimo data, jei NULL, bus pateikiami visi duomenys.

tSukurimoData – Sukūrimo data, jei NULL, bus pateikiami visi duomenys.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

DataSet:

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | sandelis              | Char (10) | Sandėlio kodas                                                              |
| 2   | sandelio_pav          | Char (50) | Sandėlio pavadinimas                                                        |
| 3   | preke                 | Char (20) | Prekės kodas                                                                |
| 4   | prekes_pav            | Char (50) | Prekės pavadinimas                                                          |
| 5   | kiekis                | Double    | Prekės likutis sandėlyje (pirmu matavimu)                                   |
| 6   | kiekis_su_rezervuotom | Double    | Prekės likutis sandėlyje, atsižvelgus į rezervuotas prekes (pirmu matavimu) |
| 7   | kaina1_san            | Double    | Pirma prekės pardavimo kaina sandėlyje                                      |
| 8   | kaina2_san            | Double    | Antra prekės pardavimo kaina sandėlyje                                      |
| 9   | kaina3_san            | Double    | Trečia prekės pardavimo kaina sandėlyje                                     |
| 10  | kaina4_san            | Double    | Ketvirta prekės pardavimo kaina sandėlyje                                   |
| 11  | kaina5_san            | Double    | Penkta prekės pardavimo kaina sandėlyje                                     |
| 12  | kaina6_san            | Double    | Šešta prekės pardavimo kaina sandėlyje                                      |
| 13  | valiuta_san           | Char(3)   | Prekės pardavimo valiuta sandėlyje                                          |
| 14  | kaina1_kort           | Double    | Pirma prekės pardavimo kaina kortelėje                                      |
| 15  | kaina2_kort           | Double    | Antra prekės pardavimo kaina kortelėje                                      |
| 16  | kaina3_kort           | Double    | Trečia prekės pardavimo kaina kortelėje                                     |
| 17  | kaina4_kort           | Double    | Ketvirta prekės pardavimo kaina kortelėje                                   |
| 18  | kaina5_kort           | Double    | Penkta prekės pardavimo kaina kortelėje                                     |
| 19  | kaina6_kort           | Double    | Šešta prekės pardavimo kaina kortelėje                                      |
| 20  | valiuta_kort          | Char(3)   | Prekės pardavimo valiuta kortelėje                                          |
| 21  | pozymis3              | Char(13)  | Trečio prekės požymio kodas                                                 |
| 22  | pozymis4              | Char(13)  | Ketvirto prekės požymio kodas                                               |
| 23  | pozymis5              | Char(13)  | Penktos prekės požymio kodas                                                |
| 24  | pozymis6              | Char(13)  | Šešto prekės požymio kodas                                                  |
| 25  | uzsak_data            | DateTime  | Anksčiausia prekės pristatymo data                                          |

<a id="geteinamiejilikuciaigrp"></a>
## 3.5. GetEinamiejiLikuciaiGrp

### Aprašymas

GetEinamiejiLikuciaiGrp(string sPrekesKodas, string sSandelioGrupesKodas, out DataSet Data, out string sError)

GetEinamiejiLikuciaiGrpXml(string sPrekesKodas, string sSandelioGrupesKodas, bool writeSchema, out string Xml, out string sError)

Metodas gražina prekės likučius sandėlių grupėje.

### Įėjimo parametrai

sPrekesKodas – prekės kodas, jeigu nenurodytas gražinamas sąrašas su visomis prekėmis

sSandelioGrupesKodas – sandėlio grupės kodas, gražinamos prekės ir jų likučiai esanatys tik sandėlio grupėje nurodytuose sandėliuose. Jeigu nenurodyta gražinamos prekės visuose sandėliuose.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | preke                 | Char(20) | Prekės kodas                                                                                      |
| 2   | prekes_pav            | Char(50) | Prekės pavadinimas                                                                                |
| 3   | kiekis                | Double   | Prekės likutis per grupėje nurodytus sandėlius  (pirmu matavimu)                                  |
| 4   | kiekis_su_rezervuotom | Double   | Prekės likutis per grupėje nurodytus sandėlius, atsižvelgus į rezervuotas prekes (pirmu matavimu) |
| 5   | mato_vnt_pav          | Char(50) | Prekės mato vieneto pavadinimas                                                                   |
| 6   | pirm_antr_mat_sant    | Integer  | Prekės pirmo ir antro mato vienetų santykis                                                       |
| 7   | savikaina             | Double   | Prekės savikaina sandėlyje (suma)                                                                 |

<a id="getklienturusispozymius"></a>
## 3.6. GetKlientuRusisPozymius

### Aprašymas

```csharp
GetKlientuRusisPozymius(out DataSet Data, out string sError)
GetKlientuRusisPozymiusXml(bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina sąrašą, kuriame pateikiami klientų rūšys ir požymiai.

### Įėjimo parametrai

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1 | tipas | Integer | Eilutės tipas:<br>22 – klientų rūšis<br>12 – pirmas klientų požymis<br>13 – antras klientų požymis<br>14 – trečias klientų požymis |
| 2 | kodas | Char (13) | Klientų rūšies/požymio kodas |
| 3 | pavadinimas | Char (50) | Klientų rūšies/požymio pavadinimas |

<a id="getklientusset"></a>
## 3.7. GetKlientusSet

### Aprašymas

```csharp
GetKlientusSet(string sKliKod, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetKlientusSetXml(string sKliKod, DateTime tKoregavimoData, DateTime tSukurimoData , bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina klientų sąrašą.

### Įėjimo parametrai

sKliKod – Finvaldos kliento kodas, jei NULL, bus pateikiami visi klientai.

tKoregavimoData – Kliento paskutinio koregavimo data, jei NULL, bus pateikiami visi klientai.

tSukurimoData – Kliento sukūrimo data, jei NULL, bus pateikiami visi klientai.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kodas              | Char (15)  | Kliento kodas                                       |
| 2   | pavadinimas        | Char (100) | Kliento pavadinimas                                 |
| 3   | skola              | Double     | Einamoji kliento skola                              |
| 4   | ardesas            | Char (90)  | Kliento adresas                                     |
| 5   | telefonas          | Char (15)  | Kliento telefonas                                   |
| 6   | faksas             | Char (15)  | Kliento faksas                                      |
| 7   | atskaitingas_asmuo | Char (50)  | Kliento atskaitingas asmuo                          |
| 8   | atsiskaityti_per   | Integer    | Klientas turi atsiskaityti per nurodytą kiekį dienų |
| 9   | mokestis           | Double     | Mokesčio procentas                                  |
| 10  | bankas             | Char (20)  | Banko kodas                                         |
| 11  | banko_sask         | Char (35)  | Banko sąskaitos kodas                               |
| 12  | korsp_sask_bank    | Char (35)  | Korespondencinė sąskaita banke                      |
| 13  | im_kodas           | Char (13)  | Įmonės kodas                                        |
| 14  | pvm_moketojo_kodas | Char (15)  | PVM mokėtojo kodas                                  |
| 15  | pastabos           | Char (60)  | Pastabos                                            |
| 16  | rusis              | Char (10)  | Kliento rūšies kodas                                |
| 17  | el_pastas          | Char (30)  | Elektroninio pašto adresas                          |
| 18  | pasiuloma_valiuta  | Char (3)   | Sandėlio operacijose siūloma valiuta                |
| 19  | yra_padalinys      | Char (15)  | Klientas yra nurodyto kliento padalinys             |
| 20  | papildoma_inf      | Double     | Papildoma informacija                               |
| 21  | pozymis_1          | Char (13)  | Kliento pirmo požymio kodas                         |
| 22  | pozymis_2          | Char (13)  | Kliento antro požymio kodas                         |
| 23  | pozymis_3          | Char (13)  | Kliento trečio požymio kodas                        |
| 24  | kurimo_data        | DateTime   | Kliento kortelės sukūrimo data                      |
| 25  | koregavimo_data    | DateTime   | Kliento kortelės koregavimo data                    |
| 26  | pavadinimas2       | Char(150)  | Kliento pavadinimas kita kalba                      |
| 27  | adresas2           | Char(90)   | Kliento antras adresas                              |
| 28  | valstybe           | Char(3)    | Valstybės kodas                                     |
| 29  | valstybe_pav       | Char(20)   | Valstybės pavadinimas                               |
| 30  | miestas            | Char(20)   | Miestas                                             |

<a id="getmatavimovienetus"></a>
## 3.8. GetMatavimoVienetus

### Aprašymas

```csharp
GetMatavimoVienetus(out DataSet Data out string sError)
GetMatavimoVienetusXml(bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina visus neapmokėtus konkretaus kliento dokumentus.

### Įėjimo parametrai

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kodas          | Char (10) | Mato vieneto kodas                    |
| 2   | pavadinimas    | Char (50) | Mato vieneto pavadinimas              |
| 3   | pirm_mat_pav   | Char (8)  | Pirmasis mato vienetas                |
| 4   | antr_mat_pav   | Char (8)  | Antrasis mato vienetas                |
| 5   | tre_mat_pav    | Char (8)  | Trečiasis mato vienetas               |
| 6   | pirm_antr_sant | Integer   | Pirmo ir antro mato vienetų santykis  |
| 7   | pirm_trec_sant | Numeric   | Pirmo ir trečio mato vienetų santykis |

<a id="getneapmoketiklidok"></a>
## 3.9. GetNeapmoketiKliDok

### Aprašymas

```csharp
GetNeapmoketiKliDok(string sKlientoKodas, out DataSet Data, out string sError)
GetNeapmoketiKliDokXml(string sKlientoKodas, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina tik neapmokėtus pardavimų dokumentus.

### Įėjimo parametrai

sKlientoKodas – kliento kodas, jei NULL, grąžinamas visų klientų neapmokėtų dokumentų sąrašas.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | dokumentas       | Char (30) | Dokumentas (serijos kodas + dokumento numeris) |
| 2   | serija           | Char (15) | Serijos kodas                                  |
| 3   | dok_numeris      | Char (10) | Dokumento numeris                              |
| 4   | zurnalas         | Char (10) | Žurnalo kodas                                  |
| 5   | padalinys        | Char (10) | Padalinio kodas                                |
| 6   | op_numeris       | Integer   | Operacijos numeris                             |
| 7   | dokumento_data   | Date      | Dokumento išrašymo data                        |
| 8   | apmokejimo_data  | Date      | Dokumento apmokėjimo data                      |
| 9   | pradine_suma     | Numeric   | Operacijos suma                                |
| 10  | likusi_skola     | Numeric   | Likusi skola                                   |
| 11  | pradine_suma_val | Numeric   | Operacijos suma val.                           |
| 12  | likusi_skola_val | Numeric   | Likusi skola val                               |
| 13  | valiuta          | Char(3)   | Valiutos kodas                                 |

<a id="getatsiskaitymaiuzdok"></a>
## 3.10. GetAtsiskaitymaiUzDok

### Aprašymas

```csharp
GetAtsiskaitymaiUzDok(string sSerija, string sDokumentas, string sZurnalas, int nNumeris, out DataSet Data, out string sError)
GetAtsiskaitymaiUzDokXml(string sSerija, string sDokumentas, string sZurnalas, int nNumeris, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina tik neapmokėtus pardavimų dokumentus.

### Įėjimo parametrai

sSerija – operacijos serijos kodas.

sDokumentas – operacijos dokumentas.

sZurnalas – operacijos žurnalo kodas.

nNumeris – operacijos numeris.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | operacija      | Integer   | Operacijos tipas: 2 - pirkimas, 3 - pardavimas, 4 – pirkimo grąžinimas, 5 – pardavimo grąžinimas. |
| 2   | zurnalas       | Char (15) | Žurnalo kodas                                                                                     |
| 3   | numeris        | Integer   | Operacijos numeris                                                                                |
| 4   | serija         | Char (10) | Dokumento serija                                                                                  |
| 5   | dokumentas     | Char (10) | Dokumento numeris                                                                                 |
| 6   | opsuma_EUR     | Numeric   | Op. suma EUR                                                                                      |
| 7   | opsuma_valiuta | Numeric   | Op. suma valiuta                                                                                  |
| 8   | ats_EUR        | Numeric   | Atsiskaityta suma EUR                                                                             |
| 9   | ats_valiuta    | Numeric   | Atsiskaityta suma EUR                                                                             |
| 10  | valiuta        | Char (3)  | Valiuta                                                                                           |
| 11  | atsisk_dat     | Date      | Atsiskaitymo data                                                                                 |

<a id="getatsiskaitymaiuzdokdet-getatsiskaitymaiuzdokdatanuodet-getatsiskaitymaiuzdokdatanuodetparam"></a>
## 3.1. GetAtsiskaitymaiUzDokDet, GetAtsiskaitymaiUzDokDataNuoDet, GetAtsiskaitymaiUzDokDataNuoDetParam

### Aprašymas

```csharp
GetAtsiskaitymaiUzDokDet(string sSerija, string sDokumentas, string sZurnalas, int nNumeris, int nOperacijosID, int nOperacijosKlase, out DataSet Data, out string sError)
GetAtsiskaitymaiUzDokDetXml(string sSerija, string sDokumentas, string sZurnalas, int nNumeris, int nOperacijosID, int nOperacijosKlase, bool writeSchema, out string Xml, out string sError)
GetAtsiskaitymaiUzDokDataNuoDet(string sSerija, string sDokumentas, string sZurnalas, int nNumeris, int nOperacijosID, int nOperacijosKlase, out tSukurimoData, out tKoregavimoData, out DataSet Data, out string sError)
GetAtsiskaitymaiUzDokDataNuoDetXml(string sSerija, string sDokumentas, string sZurnalas, int nNumeris, int nOperacijosID, int nOperacijosKlase, out tSukurimoData, out tKoregavimoData, bool writeSchema, out string Xml, out string sError)
GetAtsiskaitymaiUzDokDataNuoDetParam(string sParam, out DataSet Data, out string sError)
GetAtsiskaitymaiUzDokDataNuoDetParam(string sParam, bool writeSchema, out string Xml, out string sError)
```

### Įėjimo parametrai

sSerija – operacijos serijos kodas.

sDokumentas – operacijos dokumentas.

sZurnalas – operacijos žurnalo kodas.

nNumeris – operacijos numeris.

nOperaijosID – unikalus operacijos ID

nOperacijosKlase – 2 pirkimai, 3 pardavimai, 4 pirkimų grąžinimai, 5 – pardavimų grąžinimai

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

tSukurimoData – operacijos sukūrimo data. Gražinami duomenys kurių sukūrimo data didesnė arba lygi nurodytai.

tSukurimoDataIki – operacijos sukūrimo data. Gražinami duomenys kurių sukūrimo data mažesnė nurodytai.

tKoregavimoData – operacijos paskutinio koregavimo data. Gražinami duomenys kurių koregavimo data didesnė arba lygi nurodytai.

tKoregavimoDataIki – operacijos paskutinio koregavimo data. Gražinami duomenys kurių koregavimo data mažesnė nurodytai.

sParam – funkcijos parametrai surašyti xml arba json formatu:

```xml
<root>
<sSerija>...</sSerija><sDokumentas>...</sDokumentas><sZurnalas>...<sZurnalas>
<nNumeris></nNumeris><nOperaijosID></nOperaijosID><nOperacijosKlase></nOperacijosKlase>
<tSukurimoData></tSukurimoData><tKoregavimoData></tKoregavimoData>
```

**\<tSukurimoDataIki\>\</tSukurimoDataIki\>**

> **\<tKoregavimoDataIki\>\</tKoregavimoDataIki\>**

```xml
</root>
```

*Arba*

```json
{
“sSerija“:““, “sDokumentas“:““, “sZurnalas“:““, “nNumeris“:0, “nOperaijosID“:0, “nOperacijosKlase“:0,
“tSukurimoData“:““, “tKoregavimoData“:““, “**tSukurimoDataIki**“:““, “**tKoregavimoDataIki**“:““
}
```

###  Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

###  Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | operacija    | Integer       | Operacijos tipas: 0 – įplauka, 1 - išmoka, 2 – užskaita, 5 – pati operacija, jei atsiskaitoma iš karto |
| 2   | zurnalas     | Char (15)     | Žurnalo kodas                                                                                          |
| 3   | numeris      | Integer       | Operacijos numeris                                                                                     |
| 4   | Data         | Date          | Operacijos data                                                                                        |
| 4   | DataIsr      | Date          | Operacijos data (valiutos kurso)                                                                       |
| 5   | serija       | Char (10)     | Dokumento serija                                                                                       |
| 6   | dokumentas   | Char (10)     | Dokumento numeris                                                                                      |
| 7   | op_valiuta   | Char(3)       | Atsiskaitymo operacijos valiuta                                                                        |
| 8   | dok_valiuta  | Char(3)       | Dokumento valiuta                                                                                      |
| 7   | ats_op       | Numeric(14,2) | Atsiskaityta suma atsiskaitymo op. valiuta                                                             |
| 8   | ats_sum      | Numeric(14,2) | Atsiskaityta suma dokumento valiuta                                                                    |
| 9   | ats_sist     | Numeric(14,2) | Atsiskaityta su                                                                                        |
| 10  | operacija2   | Integer       | Operacijos tipas už kurią atsiskaitoma: 2 – pirkimas, 3 - pardavimas                                   |
| 11  | zurnalas2    | Char (15)     | Operacijos už kurią atsiskaitoma žurnalas                                                              |
| 12  | numeris2     | Integer       | Operacijos už kurią atsiskaitoma numeris                                                               |
| 13  | operacijosid | Integer       | Operacijos už kurią atsiskaitoma unikalus raktas                                                       |
| 14  | im_kodas     | Char (30)     | Kliento įmonės kodas                                                                                   |
| 15  | kli_kodas    | Char(15)      | Kliento kodas                                                                                          |
| 16  | perkainuota  | Numeric(14,2) | Perkainavimo suma                                                                                      |

<a id="getpaslaugosset"></a>
## 3.2. GetPaslaugosSet

### Aprašymas

```csharp
GetPalsaugosSet(string sPasKod, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetPaslaugosSetXml(string sPasKod, DateTime tKoregavimoData, DateTime tSukurimoData , bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina paslaugų sąrašą.

### Įėjimo parametrai

sPasKod – Finvaldos paslaugos kodas, jei NULL, bus pateikiami visos paslaugos.

tKoregavimoData – Paslaugos paskutinio koregavimo data, jei NULL, bus pateikiamos visos paslaugos.

tSukurimoData – Paslaugos sukūrimo data, jei NULL, bus pateikiamos visos paslaugos.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kodas             | Char (13) | Paslaugos kodas                    |
| 2   | pavadinimas       | Char (20) | Paslaugos pavadinimas              |
| 3   | bar_kodas         | Char (20) | Paslaugos bar kodas                |
| 4   | matavimo_vienetas | Char (10) | Paslaugos matavimo vienetas        |
| 5   | pirkimo_kaina     | Double    | Paslaugos pirkimo kaina            |
| 6   | pardavimo_kaina   | Double    | Paslaugos pardavimo kaina          |
| 7   | pastabos_1        | Char (60) | Pastabos                           |
| 8   | pastabos_2        | Char (60) | Pastabos                           |
| 9   | pastabos_3        | Char (60) | Pastabos                           |
| 10  | pastabos_4        | Char (60) | Pastabos                           |
| 11  | pastabos_5        | Char (60) | Pastabos                           |
| 12  | pastabos_6        | Char (60) | Pastabos                           |
| 13  | pastabos_7        | Char (60) | Pastabos                           |
| 14  | pastabos_8        | Char (60) | Pastabos                           |
| 15  | pastabos_9        | Char (60) | Pastabos                           |
| 16  | pastabos_10       | Char (60) | Pastabos                           |
| 17  | pastabos_11       | Char (60) | Pastabos                           |
| 18  | pastabos_12       | Char (60) | Pastabos                           |
| 19  | pastabos_13       | Char (60) | Pastabos                           |
| 20  | rusis             | Char (13) | Paslaugos rūšies kodas             |
| 21  | pozymis_1         | Char (13) | Pirmo paslaugos požymio kodas      |
| 22  | pozymis_2         | Char (13) | Antro paslaugos požymio kodas      |
| 23  | pozymis_3         | Char (13) | Trečio paslaugos požymio kodas     |
| 24  | kurimo_data       | DateTime  | Paslaugos kortelės sukūrimo data   |
| 25  | koregavimo_data   | DateTime  | Paslaugos kortelės koregavimo data |

<a id="getpaslaugurusispozymius"></a>
## 3.3. GetPaslauguRusisPozymius

### Aprašymas

```csharp
GetPaslauguRusisPozymius(out DataSet Data, out string sError)
GetPaslauguRusisPozymiusXml(bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina sąrašą, kuriame pateikiami paslaugų rūšys ir požymiai.

### Įėjimo parametrai

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1 | tipas | Integer | Eilutės tipas:<br>18 – paslaugų rūšis<br>15 – pirmas paslaugų požymis<br>16 – antras paslaugų požymis<br>17 – trečias paslaugų požymis |
| 2 | kodas | Char (13) | Paslaugų rūšies/požymio kodas |
| 3 | pavadinimas | Char (50) | Paslaugų rūšies.požymio pavadinimas |

<a id="getprekesset"></a>
## 3.4. GetPrekesSet

### Aprašymas

```csharp
GetPrekesSet(string sPreKod, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetPrekesSetXml(string sPreKod, DateTime tKoregavimoData, DateTime tSukurimoData , bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina prekių sąrašą.

### Įėjimo parametrai

sPreKod – Finvaldos prekės kodas, jei NULL, bus pateikiami visos prekės.

tKoregavimoData – Paslaugos paskutinio koregavimo data, jei NULL, bus pateikiamos visos prekės.

tSukurimoData – Paslaugos sukūrimo data, jei NULL, bus pateikiamos visos prekės.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kodas           | Char (20)     | Prekės kodas                                            |
| 2   | pavadinimas     | Char (50)     | Prekės pavadinimas                                      |
| 3   | mat_vieneto_pav | Char (50)     | Mato vieneto pavadinimas                                |
| 4   | mat_santykis    | Integer       | Pirmo ir antro mato vienetų santykis                    |
| 5   | bar_kodas       | Char (13)     | Prekės bar kodas                                        |
| 6   | pastabos        | Char (255)    | Pastabos                                                |
| 7   | informacija     | Char (13)     | Informacija apie prekę                                  |
| 8   | rusis           | Char (13)     | Prekės rūšies kodas                                     |
| 9   | pozymis_1       | Char (13)     | Pirmo prekės požymio kodas                              |
| 10  | pozymis_2       | Char (13)     | Antro prekės požymio kodas                              |
| 11  | pozymis_3       | Char (13)     | Trečio prekės požymio kodas                             |
| 12  | pozymis_4       | Char (13)     | Ketvirto prekės požymio kodas                           |
| 13  | pozymis_5       | Char (13)     | Penkto prekės požymio kodas                             |
| 14  | pozymis_6       | Char (13)     | Šešto prekės požymio kodas                              |
| 15  | pirk_kaina      | Double        | Prekės pirkimo kaina                                    |
| 16  | pirk_valiuta    | Char (3)      | Prekės pirkimo valiuta                                  |
| 17  | pard_kaina_1    | Double        | Pirma prekės pardavimo kaina                            |
| 18  | pard_kaina_2    | Double        | Antra prekės pardavimo kaina                            |
| 19  | pard_kaina_3    | Double        | Trečia prekės pardavimo kaina                           |
| 20  | pard_kaina_4    | Double        | Ketvirta prekės pardavimo kaina                         |
| 21  | pard_kaina_5    | Double        | Penkta prekės pardavimo kaina                           |
| 22  | pard_kaina_6    | Double        | Šešta prekės pardavimo kaina                            |
| 23  | pard_val        | Char (3)      | Prekės pardavimo valiuta                                |
| 24  | neto            | Double        | NETO                                                    |
| 25  | bruto           | Double        | BRUTO                                                   |
| 26  | turis           | Double        | Tūris                                                   |
| 27  | antkainis       | Double        | Antkainis                                               |
| 28  | vietu_skaicius  | Integer       | Vietų skaičius                                          |
| 29  | pvm_proc        | Double        | Prekės PVM procentas                                    |
| 30  | kurimo_data     | DateTime      | Prekės kortelės sukūrimo data                           |
| 31  | koregavimo_data | DateTime      | Prekės kortelės koregavimo data                         |
| 32  | Info1           | NChar(100)    | Papildoma informacija (unicode)                         |
| 33  | Info2           | NChar(100)    | Papildoma informacija (unicode)                         |
| 34  | Info3           | NChar(100)    | Papildoma informacija (unicode)                         |
| 35  | Info4           | NChar(100)    | Papildoma informacija (unicode)                         |
| 36  | Info5           | NChar(100)    | Papildoma informacija (unicode)                         |
| 37  | Pak_po1         | Numeric(14,6) | Pirminė pakuotė (popierinė)                             |
| 38  | Pak_st1         | Numeric(14,6) | Pirminė pakuotė (stiklinė)                              |
| 39  | Pak_me1         | Numeric(14,6) | Pirminė pakuotė (metalinė)                              |
| 40  | Pak_pl1         | Numeric(14,6) | Pirminė pakuotė (pastikinė)                             |
| 41  | Pak_ko1         | Numeric(14,6) | Pirminė pakuotė (kombinuota)                            |
| 42  | Pak_ki1         | Numeric(14,6) | Pirminė pakuotė (kita)                                  |
| 43  | Pak_po2         | Numeric(14,6) | Atrinė pakuotė (popierinė)                              |
| 44  | Pak_st2         | Numeric(14,6) | Atrinė pakuotė (stiklinė)                               |
| 45  | Pak_me2         | Numeric(14,6) | Atrinė pakuotė (metalinė)                               |
| 46  | Pak_pl2         | Numeric(14,6) | Atrinė pakuotė (pastikinė)                              |
| 47  | Pak_ko2         | Numeric(14,6) | Atrinė pakuotė (kombinuota)                             |
| 48  | Pak_ki2         | Numeric(14,6) | Atrinė pakuotė (kita)                                   |
| 49  | Prek_grupes     | Char(255)     | Prekių grupės (skirtukas /), kurioms ta prekė priklauso |

<a id="getprekessetext"></a>
## 3.5. GetPrekesSetExt

### Aprašymas

```csharp
GetPrekesSetExt(String sPreKod, String sRusis, String sPozymis1, String sPozymis2, String sPozymis3, String sPozymis4, String sPozymis5, String sPozymis6, String sTiekejas1, String sTiekejas2, String sTiekejas3, String sRysysSuSask, String sObj1, String sObj2, String sObj3, String sObj4, String sObj5, String sObj6, object tKoregavimoData, object tSukurimoData, out DataSet Data, out string sError)
GetPrekesSetExtXml(String sPreKod, String sRusis, String sPozymis1, String sPozymis2, String sPozymis3, String sPozymis4, String sPozymis5, String sPozymis6, String sTiekejas1, String sTiekejas2, String sTiekejas3, String sRysysSuSask, String sObj1, String sObj2, String sObj3, String sObj4, String sObj5, String sObj6, object tKoregavimoData, object tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina prekių sąrašą pagal parinktą filtrą.

### Įėjimo parametrai

sPreKod – Finvaldos prekės kodas, jei NULL, bus pateikiami visos prekės.

sRusis – Finvaldos prekių rūšies kodas, jei NULL, bus grąžinamos visoms rūšims priskirtos prekės.

sPozymis1 – sPozymis6 – Finvaldos prekių požymių kodai, jei NULL, bus grąžinamos visiems požymiams priskirtos prekės.

sTiekejas1 – sTiekejas3 – Finvaldos prekių tiekėjų kodai, jei NULL, bus grąžinamos visų tiekėjų prekės.

sRysysSuSask – Prekės ryšio su sąskaita kodas, jei NULL, bus grąžinamos visos prekės.

sObj1 – sObj6 – Finvaldos objektų kodai, jei NULL, bus grąžinamos visos prekės.

tKoregavimoData – Paslaugos paskutinio koregavimo data, jei NULL, bus pateikiamos visos prekės.

tSukurimoData – Paslaugos sukūrimo data, jei NULL, bus pateikiamos visos prekės.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kodas           | Char (20)     | Prekės kodas                                            |
| 2   | pavadinimas     | Char (50)     | Prekės pavadinimas                                      |
| 3   | mat_vieneto_pav | Char (50)     | Mato vieneto pavadinimas                                |
| 4   | mat_santykis    | Integer       | Pirmo ir antro mato vienetų santykis                    |
| 5   | bar_kodas       | Char (13)     | Prekės bar kodas                                        |
| 6   | pastabos        | Char (255)    | Pastabos                                                |
| 7   | informacija     | Char (13)     | Informacija apie prekę                                  |
| 8   | rusis           | Char (13)     | Prekės rūšies kodas                                     |
| 9   | pozymis_1       | Char (13)     | Pirmo prekės požymio kodas                              |
| 10  | pozymis_2       | Char (13)     | Antro prekės požymio kodas                              |
| 11  | pozymis_3       | Char (13)     | Trečio prekės požymio kodas                             |
| 12  | pozymis_4       | Char (13)     | Ketvirto prekės požymio kodas                           |
| 13  | pozymis_5       | Char (13)     | Penkto prekės požymio kodas                             |
| 14  | pozymis_6       | Char (13)     | Šešto prekės požymio kodas                              |
| 15  | pirk_kaina      | Double        | Prekės pirkimo kaina                                    |
| 16  | pirk_valiuta    | Char (3)      | Prekės pirkimo valiuta                                  |
| 17  | pard_kaina_1    | Double        | Pirma prekės pardavimo kaina                            |
| 18  | pard_kaina_2    | Double        | Antra prekės pardavimo kaina                            |
| 19  | pard_kaina_3    | Double        | Trečia prekės pardavimo kaina                           |
| 20  | pard_kaina_4    | Double        | Ketvirta prekės pardavimo kaina                         |
| 21  | pard_kaina_5    | Double        | Penkta prekės pardavimo kaina                           |
| 22  | pard_kaina_6    | Double        | Šešta prekės pardavimo kaina                            |
| 23  | pard_val        | Char (3)      | Prekės pardavimo valiuta                                |
| 24  | neto            | Double        | NETO                                                    |
| 25  | bruto           | Double        | BRUTO                                                   |
| 26  | turis           | Double        | Tūris                                                   |
| 27  | antkainis       | Double        | Antkainis                                               |
| 28  | vietu_skaicius  | Integer       | Vietų skaičius                                          |
| 29  | pvm_proc        | Double        | Prekės PVM procentas                                    |
| 30  | kurimo_data     | DateTime      | Prekės kortelės sukūrimo data                           |
| 31  | koregavimo_data | DateTime      | Prekės kortelės koregavimo data                         |
| 32  | Info1           | NChar(100)    | Papildoma informacija (unicode)                         |
| 33  | Info2           | NChar(100)    | Papildoma informacija (unicode)                         |
| 34  | Info3           | NChar(100)    | Papildoma informacija (unicode)                         |
| 35  | Info4           | NChar(100)    | Papildoma informacija (unicode)                         |
| 36  | Info5           | NChar(100)    | Papildoma informacija (unicode)                         |
| 37  | Pak_po1         | Numeric(14,6) | Pirminė pakuotė (popierinė)                             |
| 38  | Pak_st1         | Numeric(14,6) | Pirminė pakuotė (stiklinė)                              |
| 39  | Pak_me1         | Numeric(14,6) | Pirminė pakuotė (metalinė)                              |
| 40  | Pak_pl1         | Numeric(14,6) | Pirminė pakuotė (pastikinė)                             |
| 41  | Pak_ko1         | Numeric(14,6) | Pirminė pakuotė (kombinuota)                            |
| 42  | Pak_ki1         | Numeric(14,6) | Pirminė pakuotė (kita)                                  |
| 43  | Pak_po2         | Numeric(14,6) | Atrinė pakuotė (popierinė)                              |
| 44  | Pak_st2         | Numeric(14,6) | Atrinė pakuotė (stiklinė)                               |
| 45  | Pak_me2         | Numeric(14,6) | Atrinė pakuotė (metalinė)                               |
| 46  | Pak_pl2         | Numeric(14,6) | Atrinė pakuotė (pastikinė)                              |
| 47  | Pak_ko2         | Numeric(14,6) | Atrinė pakuotė (kombinuota)                             |
| 48  | Pak_ki2         | Numeric(14,6) | Atrinė pakuotė (kita)                                   |
| 49  | Prek_grupes     | Char(255)     | Prekių grupės (skirtukas /), kurioms ta prekė priklauso |

<a id="getprekiurusispozymius"></a>
## 3.6. GetPrekiuRusisPozymius

### Aprašymas

```csharp
GetPrekiuRusisPozymius(out DataSet Data, out string sError)
GetPrekiuRusisPozymiusXml(bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina sąrašą, kuriame pateikiami prekių rūšys ir požymiai.

### Įėjimo parametrai

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1 | tipas | Integer | Eilutės tipas:<br>0 – prekių rūšis<br>1 – pirmas prekių požymis<br>2 – antra prekių požymis<br>5 – trečias prekių požymis<br>9 – ketvirtas prekių požymis<br>10 – penktas prekių požymis<br>11 – šeštas prekių požymis<br>100 – prekių grupės požymis |
| 2 | kodas | Char (13) | Prekių rūšies/požymio kodas |
| 3 | pavadinimas | Char (50) | Prekių rūšies/požymio pavadinimas |
| 4 | Info1 | NChar(100) | Papildoma info1 (unicode) |
| 5 | Info2 | NChar(100) | Papildoma info2(unicode) |

<a id="getprekiurusiugrupes"></a>
## 3.7. GetPrekiuRusiuGrupes

### Aprašymas

```csharp
GetPrekiuRusiuGrupes(out DataSet Data, out string sError)
GetPrekiuRusiuGrupesXml(bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina sąrašą, kuriame pateikiami prekų rūšių grupės.

### Įėjimo parametrai

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kodas       | Char (10) | Prekių rūšių grupės kodas       |
| 2   | pavadinimas | Char (50) | Prekių rūšių grupės pavadinimas |

<a id="getprekiurusiugrupessudeti"></a>
## 3.8. GetPrekiuRusiuGrupesSudeti

### Aprašymas

```csharp
GetPrekiuRusiuGrupesSudeti(string sPrekiuRusiuGrupe, out DataSet Data, out string sError)
GetPrekiuRusiuGrupesSudetiXml((string sPrekiuRusiuGrupe, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina sąrašą, pateikiama konkrečios prekių rūšies grupės sudėtis.

### Įėjimo parametrai

sPrekiuRusiuGrupe – prekių rūšių grupė;

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kodas       | Char (13) | Prekių rūšies kodas       |
| 2   | pavadinimas | Char (50) | Prekių rūšies pavadinimas |

<a id="getsandelius"></a>
## 3.9. GetSandelius

### Aprašymas

```csharp
GetSandelius(out DataSet Data, out string sError)
GetSandeliusXml(bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina sandėlių sąrašą.

### Įėjimo parametrai

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kodas       | Char (10) | Sandėlio kodas       |
| 2   | pavadinimas | Char (50) | Sandėlio pavadinimas |

<a id="getkliprekpasnuolpapkain"></a>
## 3.10. GetKliPrekPasNuolPapKain

### Aprašymas

```csharp
GetKliPrekPasNuolPapKain(out DataSet Data, out string sError)
```

*GetKliPrekPasNuolPapKain Xml(bool writeSchema, out string Xml, out string sError)*

Metodas grąžina visas klientų nuolaidas bei papildomas kainas prekėms ir paslaugoms..

### Įėjimo parametrai

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1 | kliento_kodas | Char (15) | Kliento kodas |
| 2 | kliento_pavadinimas | Char (100) | Kliento pavadinimas |
| 3 | tipas | Integer | Eilutės tipas:<br>1 – prekė<br>2 – paslauga |
| 4 | kodas | Char (20) | Prekės/paslaugos kodas |
| 5 | pavadinimas | Char (50) | Prekės/paslaugos pavadinimas |
| 6 | kiekis_1 | Integer | Prekės/paslaugos kiekis (antru matavimu), kurį surinkus taikoma pirma nuolaida |
| 7 | suma_1 | Numeric | Suma už prekę/paslaugą, kurią surinkus taikoma pirma nuolaida |
| 8 | nuolaida_1 | Numeric | Pirmos nuolaidos procentas |
| 9 | terminas_nuo_1 | Date | Jei ne 'null', rodo, kada prasideda pirmos nuolaidos galiojimas |
| 10 | terminas_iki_1 | Date | Jei ne 'null', rodo, kada baigiasi pirmos nuolaidos galiojimas |
| 11 | kiekis_2 | Integer | Prekės/paslaugos kiekis (antru matavimu), kurį surinkus taikoma antra nuolaida |
| 12 | suma_2 | Numeric | Suma už prekę/paslaugą, kurią surinkus taikoma antra nuolaida |
| 13 | nuolaida_2 | Numeric | Antros nuolaidos procentas |
| 14 | terminas_nuo_2 | Date | Jei ne 'null', rodo, kada prasideda antros nuolaidos galiojimas |
| 15 | terminas_iki_2 | Date | Jei ne 'null', rodo, kada baigiasi antros nuolaidos galiojimas |
| 16 | kiekis_3 | Integer | Prekės/paslaugos kiekis (antru matavimu), kurį surinkus taikoma trečia nuolaida |
| 17 | suma_3 | Numeric | Suma už prekę/paslaugą, kurią surinkus taikoma trečia nuolaida |
| 18 | nuolaida_3 | Numeric | Trečios nuolaidos procentas |
| 19 | terminas_nuo_3 | Date | Jei ne 'null', rodo, kada prasideda trečios nuolaidos galiojimas |
| 20 | terminas_iki_3 | Date | Jei ne 'null', rodo, kada baigiasi trečios nuolaidos galiojimas |
| 21 | kiekis_4 | Integer | Prekės/paslaugos kiekis (antru matavimu), kurį surinkus taikoma ketvirta nuolaida |
| 22 | suma_4 | Integer | Suma už prekę/paslaugą, kurią surinkus taikoma ketvirta nuolaida |
| 23 | nuolaida_4 | Integer | Ketvirtos nuolaidos procentas |
| 24 | terminas_nuo_4 | Integer | Jei ne 'null', rodo, kada prasideda ketvirtos nuolaidos galiojimas |
| 25 | terminas_iki_4 | Integer | Jei ne 'null', rodo, kada baigiasi ketvirtos nuolaidos galiojimas |
| 26 | kaina | Numeric | Siūloma prekės/paslaugos pardavimo kaina |
| 27 | valiuta | Char (3) | Siūloma prekės/paslaugos pardavimo valiuta |
| 28 | kaina_korteleje | Integer | Siūloma prekės/paslaugos pardavimo kaina iš kortelės |
| 29 | kaina_su_terminu | Numeric | Siūloma prekės/paslaugos pardavimo kaina, jei pardavimo data patenka į nurodytą periodą |
| 30 | valiuta_su_terminu | Char (3) | Siūloma prekės/paslaugos pardavimo valiuta, jei pardavimo data patenka į nurodytą periodą |
| 31 | kaina_koreleje_su_terminu | Integer | Siūloma prekės/paslaugos pardavimo kainą iš kortelės, jei pardavimo data patenka į nurodytą periodą |
| 32 | terminas_nuo | Date | Kainos galiojimo pradžios data |
| 33 | terminas_iki | Date | Kainos galiojimo pabaigos data |

<a id="getklirusprekpasnuolpapkain"></a>
## 3.11. GetKliRusPrekPasNuolPapKain

### Aprašymas

```csharp
GetKliRusPrekPasNuolPapKain(DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetKliRusPrekPasNuolPapKainXml(DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina visas klientų rūšims taikomas nuolaidas bei papildomas kainas prekėms ir paslaugoms.

### Įėjimo parametrai

tKoregavimoData – Papildomos kainos/nuolaidos paskutinio koregavimo data, jei NULL, bus pateikiamos visos kainos/nuolaidos.

tSukurimoData – Papildomos kainos/nuolaidos sukūrimo data, jei NULL, bus pateikiamos visos kainos/nuolaidos.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1 | kli_rusies_kodas | Char (10) | Kliento rūšies kodas |
| 2 | kli_rusies_pavadinimas | Char (50) | Kliento rūšies pavadinimas |
| 3 | tipas | Integer | Eilutės tipas:<br>1 – prekė<br>2 – paslauga |
| 4 | kodas | Char (20) | Prekės/paslaugos kodas |
| 5 | pavadinimas | Char (50) | Prekės/paslaugos pavadinimas |
| 6 | kiekis_1 | Integer | Prekės/paslaugos kiekis (antru matavimu), kurį surinkus taikoma pirma nuolaida |
| 7 | suma_1 | Numeric | Suma už prekę/paslaugą, kurią surinkus taikoma pirma nuolaida |
| 8 | nuolaida_1 | Numeric | Pirmos nuolaidos procentas |
| 9 | terminas_nuo_1 | Date | Jei ne 'null', rodo, kada prasideda pirmos nuolaidos galiojimas |
| 10 | terminas_iki_1 | Date | Jei ne 'null', rodo, kada baigiasi pirmos nuolaidos galiojimas |
| 11 | kiekis_2 | Integer | Prekės/paslaugos kiekis (antru matavimu), kurį surinkus taikoma antra nuolaida |
| 12 | suma_2 | Numeric | Suma už prekę/paslaugą, kurią surinkus taikoma antra nuolaida |
| 13 | nuolaida_2 | Numeric | Antros nuolaidos procentas |
| 14 | terminas_nuo_2 | Date | Jei ne 'null', rodo, kada prasideda antros nuolaidos galiojimas |
| 15 | terminas_iki_2 | Date | Jei ne 'null', rodo, kada baigiasi antros nuolaidos galiojimas |
| 16 | kiekis_3 | Integer | Prekės/paslaugos kiekis (antru matavimu), kurį surinkus taikoma trečia nuolaida |
| 17 | suma_3 | Numeric | Suma už prekę/paslaugą, kurią surinkus taikoma trečia nuolaida |
| 18 | nuolaida_3 | Numeric | Trečios nuolaidos procentas |
| 19 | terminas_nuo_3 | Date | Jei ne 'null', rodo, kada prasideda trečios nuolaidos galiojimas |
| 20 | terminas_iki_3 | Date | Jei ne 'null', rodo, kada baigiasi trečios nuolaidos galiojimas |
| 21 | kiekis_4 | Integer | Prekės/paslaugos kiekis (antru matavimu), kurį surinkus taikoma ketvirta nuolaida |
| 22 | suma_4 | Integer | Suma už prekę/paslaugą, kurią surinkus taikoma ketvirta nuolaida |
| 23 | nuolaida_4 | Integer | Ketvirtos nuolaidos procentas |
| 24 | terminas_nuo_4 | Integer | Jei ne 'null', rodo, kada prasideda ketvirtos nuolaidos galiojimas |
| 25 | terminas_iki_4 | Integer | Jei ne 'null', rodo, kada baigiasi ketvirtos nuolaidos galiojimas |
| 26 | kaina | Numeric | Siūloma prekės/paslaugos pardavimo kaina |
| 27 | valiuta | Char (3) | Siūloma prekės/paslaugos pardavimo valiuta |
| 28 | kaina_korteleje | Integer | Siūloma prekės/paslaugos pardavimo kaina iš kortelės |
| 29 | kaina_su_terminu | Numeric | Siūloma prekės/paslaugos pardavimo kaina, jei pardavimo data patenka į nurodytą periodą |
| 30 | valiuta_su_terminu | Char (3) | Siūloma prekės/paslaugos pardavimo valiuta, jei pardavimo data patenka į nurodytą periodą |
| 31 | kaina_koreleje_su_terminu | Integer | Siūloma prekės/paslaugos pardavimo kainą iš kortelės, jei pardavimo data patenka į nurodytą periodą |
| 32 | terminas_nuo | Date | Kainos galiojimo pradžios data |
| 33 | terminas_iki | Date | Kainos galiojimo pabaigos data |

<a id="getkliprekpasrusnuolpapkain"></a>
## 3.12. GetKliPrekPasRusNuolPapKain

### Aprašymas

```csharp
GetKliPrekPasRusNuolPapKain(DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetKliPrekPasRusNuolPapKainXml(DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina visas klientų nuolaidas bei papildomas kainas prekių ir paslaugų rūšims.

### Įėjimo parametrai

tKoregavimoData – Papildomos kainos/nuolaidos paskutinio koregavimo data, jei NULL, bus pateikiamos visos kainos/nuolaidos.

tSukurimoData – Papildomos kainos/nuolaidos sukūrimo data, jei NULL, bus pateikiamos visos kainos/nuolaidos.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1 | kliento_kodas | Char (15) | Kliento kodas |
| 2 | kliento_pavadinimas | Char (100) | Kliento pavadinimas |
| 3 | tipas | Integer | Eilutės tipas:<br>1 – prekė<br>2 – paslauga |
| 4 | kodas | Char (13) | Prekės/paslaugos rūšies kodas |
| 5 | pavadinimas | Char (50) | Prekės/paslaugos rūšies pavadinimas |
| 6 | kiekis_1 | Integer | Prekės/paslaugos kiekis (antru matavimu), kurį surinkus taikoma pirma nuolaida |
| 7 | suma_1 | Numeric | Suma už prekę/paslaugą, kurią surinkus taikoma pirma nuolaida |
| 8 | nuolaida_1 | Numeric | Pirmos nuolaidos procentas |
| 9 | terminas_nuo_1 | Date | Jei ne 'null', rodo, kada prasideda pirmos nuolaidos galiojimas |
| 10 | terminas_iki_1 | Date | Jei ne 'null', rodo, kada baigiasi pirmos nuolaidos galiojimas |
| 11 | kiekis_2 | Integer | Prekės/paslaugos kiekis (antru matavimu), kurį surinkus taikoma antra nuolaida |
| 12 | suma_2 | Numeric | Suma už prekę/paslaugą, kurią surinkus taikoma antra nuolaida |
| 13 | nuolaida_2 | Numeric | Antros nuolaidos procentas |
| 14 | terminas_nuo_2 | Date | Jei ne 'null', rodo, kada prasideda antros nuolaidos galiojimas |
| 15 | terminas_iki_2 | Date | Jei ne 'null', rodo, kada baigiasi antros nuolaidos galiojimas |
| 16 | kiekis_3 | Integer | Prekės/paslaugos kiekis (antru matavimu), kurį surinkus taikoma trečia nuolaida |
| 17 | suma_3 | Numeric | Suma už prekę/paslaugą, kurią surinkus taikoma trečia nuolaida |
| 18 | nuolaida_3 | Numeric | Trečios nuolaidos procentas |
| 19 | terminas_nuo_3 | Date | Jei ne 'null', rodo, kada prasideda trečios nuolaidos galiojimas |
| 20 | terminas_iki_3 | Date | Jei ne 'null', rodo, kada baigiasi trečios nuolaidos galiojimas |
| 21 | kiekis_4 | Integer | Prekės/paslaugos kiekis (antru matavimu), kurį surinkus taikoma ketvirta nuolaida |
| 22 | suma_4 | Integer | Suma už prekę/paslaugą, kurią surinkus taikoma ketvirta nuolaida |
| 23 | nuolaida_4 | Integer | Ketvirtos nuolaidos procentas |
| 24 | terminas_nuo_4 | Integer | Jei ne 'null', rodo, kada prasideda ketvirtos nuolaidos galiojimas |
| 25 | terminas_iki_4 | Integer | Jei ne 'null', rodo, kada baigiasi ketvirtos nuolaidos galiojimas |
| 26 | kaina_korteleje | Integer | Siūloma prekės/paslaugos pardavimo kaina iš kortelės |
| 27 | kaina_koreleje_su_terminu | Integer | Siūloma prekės/paslaugos pardavimo kainą iš kortelės, jei pardavimo data patenka į nurodytą periodą |
| 28 | terminas_nuo | Date | Kainos galiojimo pradžios data |
| 29 | terminas_iki | Date | Kainos galiojimo pabaigos data |

<a id="getklirusprekpasrusnuolpapkain"></a>
## 3.13. GetKliRusPrekPasRusNuolPapKain

### Aprašymas

```csharp
GetKliRusPrekPasRusNuolPapKain(DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetKliRusPrekPasRusNuolPapKainXml(DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina visas klientų rūšims taikomas nuolaidas bei papildomas kainas prekių ir paslaugų rūšims.

### Įėjimo parametrai

tKoregavimoData – Papildomos kainos/nuolaidos paskutinio koregavimo data, jei NULL, bus pateikiamos visos kainos/nuolaidos.

tSukurimoData – Papildomos kainos/nuolaidos sukūrimo data, jei NULL, bus pateikiamos visos kainos/nuolaidos.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1 | kli_rusies_kodas | Char (10) | Kliento rūšies kodas |
| 2 | kli_rusies_pavadinimas | Char (50) | Kliento rūšies pavadinimas |
| 3 | tipas | Integer | Eilutės tipas:<br>1 – prekė<br>2 – paslauga |
| 4 | kodas | Char (13) | Prekės/paslaugos rūšies kodas |
| 5 | pavadinimas | Char (50) | Prekės/paslaugos rūšies pavadinimas |
| 6 | kiekis_1 | Integer | Prekės/paslaugos kiekis (antru matavimu), kurį surinkus taikoma pirma nuolaida |
| 7 | suma_1 | Numeric | Suma už prekę/paslaugą, kurią surinkus taikoma pirma nuolaida |
| 8 | nuolaida_1 | Numeric | Pirmos nuolaidos procentas |
| 9 | terminas_nuo_1 | Date | Jei ne 'null', rodo, kada prasideda pirmos nuolaidos galiojimas |
| 10 | terminas_iki_1 | Date | Jei ne 'null', rodo, kada baigiasi pirmos nuolaidos galiojimas |
| 11 | kiekis_2 | Integer | Prekės/paslaugos kiekis (antru matavimu), kurį surinkus taikoma antra nuolaida |
| 12 | suma_2 | Numeric | Suma už prekę/paslaugą, kurią surinkus taikoma antra nuolaida |
| 13 | nuolaida_2 | Numeric | Antros nuolaidos procentas |
| 14 | terminas_nuo_2 | Date | Jei ne 'null', rodo, kada prasideda antros nuolaidos galiojimas |
| 15 | terminas_iki_2 | Date | Jei ne 'null', rodo, kada baigiasi antros nuolaidos galiojimas |
| 16 | kiekis_3 | Integer | Prekės/paslaugos kiekis (antru matavimu), kurį surinkus taikoma trečia nuolaida |
| 17 | suma_3 | Numeric | Suma už prekę/paslaugą, kurią surinkus taikoma trečia nuolaida |
| 18 | nuolaida_3 | Numeric | Trečios nuolaidos procentas |
| 19 | terminas_nuo_3 | Date | Jei ne 'null', rodo, kada prasideda trečios nuolaidos galiojimas |
| 20 | terminas_iki_3 | Date | Jei ne 'null', rodo, kada baigiasi trečios nuolaidos galiojimas |
| 21 | kiekis_4 | Integer | Prekės/paslaugos kiekis (antru matavimu), kurį surinkus taikoma ketvirta nuolaida |
| 22 | suma_4 | Integer | Suma už prekę/paslaugą, kurią surinkus taikoma ketvirta nuolaida |
| 23 | nuolaida_4 | Integer | Ketvirtos nuolaidos procentas |
| 24 | terminas_nuo_4 | Integer | Jei ne 'null', rodo, kada prasideda ketvirtos nuolaidos galiojimas |
| 25 | terminas_iki_4 | Integer | Jei ne 'null', rodo, kada baigiasi ketvirtos nuolaidos galiojimas |
| 26 | kaina_korteleje | Integer | Siūloma prekės/paslaugos pardavimo kaina iš kortelės |
| 27 | kaina_koreleje_su_terminu | Integer | Siūloma prekės/paslaugos pardavimo kainą iš kortelės, jei pardavimo data patenka į nurodytą periodą |
| 28 | terminas_nuo | Date | Kainos galiojimo pradžios data |
| 29 | terminas_iki | Date | Kainos galiojimo pabaigos data |

<a id="getmokesciai"></a>
## 3.14. GetMokesciai

### Aprašymas

```csharp
GetMokeciai(out DataSet Data, out string sError)
GetMokesciaiXml( bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina sąrašą su visais Finvaldos mokesčiais.

### Įėjimo parametrai

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kodas           | Char (10) | Mokesčio kodas            |
| 2   | pavadinimas     | Char (50) | Mokesčio pavadinimas      |
| 3   | procentas_1     | Double    | Pirmo mokesčio procentas  |
| 4   | procentas_2     | Double    | Antro mokesčio procentas  |
| 5   | procentas_3     | Double    | Trečio mokesčio procentas |
| 6   | klasifikatorius | Char (6)  | PVM klasifikatorius       |

<a id="getklientupaslaugunuol"></a>
## 3.15. GetKlientuPaslauguNuol

### Aprašymas

```csharp
GetKlientuPaslauguNuol(string sKlientoKodas, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetKlientuPaslauguNuolXml(string sKlientoKodas, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina klientų nuolaidas paslaugoms, kurios naudojamos pardavimų operacijose.

### Įėjimo parametrai

sKlientoKodas – Finvaldos kliento kodas, jei NULL, bus pateikiamas sąrašas su visais klientais, kuriems sukurtos nuolaidos.

tKoregavimoData – Nuolaidos paskutinio koregavimo data, jei NULL, bus pateikiamos visos nuolaidos.

tSukurimoData – Nuolaidos sukūrimo data, jei NULL, bus pateikiamos visos nuolaidos.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kliento_kodas         | Char (15)  | Kliento kodas                                                              |
| 2   | kliento_pavadinimas   | Char (100) | Kliento pavadinimas                                                        |
| 3   | paslaugos_kodas       | Char (20)  | Paslaugos kodas                                                            |
| 4   | paslaugos_pavadinimas | Char (50)  | Paslaugos pavadinimas                                                      |
| 5   | kiekis_1              | Integer    | Paslaugos kiekis (antru matavimu), kurį surinkus taikoma pirma nuolaida    |
| 6   | suma_1                | Numeric    | Suma už paslaugą, kurią surinkus taikoma pirma nuolaida                    |
| 7   | nuolaida_1            | Numeric    | Pirmos nuolaidos procentas                                                 |
| 8   | terminas_nuo_1        | Date       | Jei ne 'null', rodo, kada prasideda pirmos nuolaidos galiojimas            |
| 9   | terminas_iki_1        | Date       | Jei ne 'null', rodo, kada baigiasi pirmos nuolaidos galiojimas             |
| 10  | kiekis_2              | Integer    | Paslaugos kiekis (antru matavimu), kurį surinkus taikoma antra nuolaida    |
| 11  | suma_2                | Numeric    | Suma už paslaugą, kurią surinkus taikoma antra nuolaida                    |
| 12  | nuolaida_2            | Numeric    | Antros nuolaidos procentas                                                 |
| 13  | terminas_nuo_2        | Date       | Jei ne 'null', rodo, kada prasideda antros nuolaidos galiojimas            |
| 14  | terminas_iki_2        | Date       | Jei ne 'null', rodo, kada baigiasi antros nuolaidos galiojimas             |
| 15  | kiekis_3              | Integer    | Paslaugos kiekis (antru matavimu), kurį surinkus taikoma trečia nuolaida   |
| 16  | suma_3                | Numeric    | Suma už paslaugą, kurią surinkus taikoma trečia nuolaida                   |
| 17  | nuolaida_3            | Numeric    | Trečios nuolaidos procentas                                                |
| 18  | terminas_nuo_3        | Date       | Jei ne 'null', rodo, kada prasideda trečios nuolaidos galiojimas           |
| 19  | terminas_iki_3        | Date       | Jei ne 'null', rodo, kada baigiasi trečios nuolaidos galiojimas            |
| 20  | kiekis_4              | Integer    | Paslaugos kiekis (antru matavimu), kurį surinkus taikoma ketvirta nuolaida |
| 21  | suma_4                | Integer    | Suma už paslaugą, kurią surinkus taikoma ketvirta nuolaida                 |
| 22  | nuolaida_4            | Integer    | Ketvirtos nuolaidos procentas                                              |
| 23  | terminas_nuo_4        | Integer    | Jei ne 'null', rodo, kada prasideda ketvirtos nuolaidos galiojimas         |
| 24  | terminas_iki_4        | Integer    | Jei ne 'null', rodo, kada baigiasi ketvirtos nuolaidos galiojimas          |

<a id="getklientupaslaugupapkainas"></a>
## 3.16. GetKlientuPaslauguPapKainas

### Aprašymas

```csharp
GetKlientuPaslauguPapKainas(string sKlientoKodas, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetKlientuPaslauguPapKainasXml(string sKlientoKodas, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina klientų nuolaidas paslaugoms, kurios naudojamos pardavimų operacijose.

### Įėjimo parametrai

sKlientoKodas – Finvaldos kliento kodas, jei NULL, bus pateikiamas sąrašas su visais klientais, kuriems sukurtos papildomos kainos.

tKoregavimoData – Papildomos kainos paskutinio koregavimo data, jei NULL, bus pateikiamos visos kainos.

tSukurimoData – Papildomos kainos sukūrimo data, jei NULL, bus pateikiamos visos kainos.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kliento_kodas             | Char (15)  | Kliento kodas                                                                                |
| 2   | kliento_pavadinimas       | Char (100) | Kliento pavadinimas                                                                          |
| 3   | paslaugos_kodas           | Char (20)  | Paslaugos kodas                                                                              |
| 4   | paslaugos_pavadinimas     | Char (50)  | Paslaugos pavadinimas                                                                        |
| 5   | kaina                     | Numeric    | Siūloma paslaugos pardavimo kaina                                                            |
| 6   | valiuta                   | Char (3)   | Siūloma paslaugos pardavimo valiuta                                                          |
| 7   | kaina_korteleje           | Integer    | Siūloma paslaugos pardavimo kaina iš kortelės                                                |
| 8   | kaina_su_terminu          | Numeric    | Siūloma paslaugos pardavimo kaina, jei pardavimo data patenka į nurodytą periodą             |
| 9   | valiuta_su_terminu        | Char (3)   | Siūloma paslaugos pardavimo valiuta, jei pardavimo data patenka į nurodytą periodą           |
| 10  | kaina_koreleje_su_terminu | Integer    | Siūloma paslaugos pardavimo kainą iš kortelės, jei pardavimo data patenka į nurodytą periodą |
| 11  | terminas_nuo              | Date       | Kainos galiojimo pradžios data                                                               |
| 12  | terminas_iki              | Date       | Kainos galiojimo pabaigos data                                                               |

<a id="getklientupaslaugurusnuol"></a>
## 3.17. GetKlientuPaslauguRusNuol

### Aprašymas

```csharp
GetKlientuPaslauguRusNuol(string sKlientoKodas, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetKlientuPaslauguRusNuolXml(string sKlientoKodas, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina klientų nuolaidas paslaugų rūšims, kurios naudojamos pardavimų operacijose.

### Įėjimo parametrai

sKlientoKodas – Finvaldos kliento kodas, jei NULL, bus pateikiamas sąrašas su visais klientais, kuriems sukurtos nuolaidos.

tKoregavimoData – Nuolaidos paskutinio koregavimo data, jei NULL, bus pateikiamos visos nuolaidos.

tSukurimoData – Papildomos kainos sukūrimo data, jei NULL, bus pateikiamos visos kainos.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kliento_kodas           | Char (15)  | Kliento kodas                                                              |
| 2   | kliento_pavadinimas     | Char (100) | Kliento pavadinimas                                                        |
| 3   | pasl_rusies_kodas       | Char (13)  | Paslaugos rūšies kodas                                                     |
| 4   | pasl_rusies_pavadinimas | Char (50)  | Paslaugos rūšies pavadinimas                                               |
| 5   | kiekis_1                | Integer    | Paslaugos kiekis (antru matavimu), kurį surinkus taikoma pirma nuolaida    |
| 6   | suma_1                  | Numeric    | Suma už paslaugą, kurią surinkus taikoma pirma nuolaida                    |
| 7   | nuolaida_1              | Numeric    | Pirmos nuolaidos procentas                                                 |
| 8   | terminas_nuo_1          | Date       | Jei ne 'null', rodo, kada prasideda pirmos nuolaidos galiojimas            |
| 9   | terminas_iki_1          | Date       | Jei ne 'null', rodo, kada baigiasi pirmos nuolaidos galiojimas             |
| 10  | kiekis_2                | Integer    | Paslaugos kiekis (antru matavimu), kurį surinkus taikoma antra nuolaida    |
| 11  | suma_2                  | Numeric    | Suma už paslaugą, kurią surinkus taikoma antra nuolaida                    |
| 12  | nuolaida_2              | Numeric    | Antros nuolaidos procentas                                                 |
| 13  | terminas_nuo_2          | Date       | Jei ne 'null', rodo, kada prasideda antros nuolaidos galiojimas            |
| 14  | terminas_iki_2          | Date       | Jei ne 'null', rodo, kada baigiasi antros nuolaidos galiojimas             |
| 15  | kiekis_3                | Integer    | Paslaugos kiekis (antru matavimu), kurį surinkus taikoma trečia nuolaida   |
| 16  | suma_3                  | Numeric    | Suma už paslaugą, kurią surinkus, taikoma trečia nuolaida                  |
| 17  | nuolaida_3              | Numeric    | Trečios nuolaidos procentas                                                |
| 18  | terminas_nuo_3          | Date       | Jei ne 'null', rodo, kada prasideda trečios nuolaidos galiojimas           |
| 19  | terminas_iki_3          | Date       | Jei ne 'null', rodo, kada baigiasi trečios nuolaidos galiojimas            |
| 20  | kiekis_4                | Integer    | Paslaugos kiekis (antru matavimu), kurį surinkus taikoma ketvirta nuolaida |
| 21  | suma_4                  | Integer    | Suma už paslaugą, kurią surinkus taikoma ketvirta nuolaida                 |
| 22  | nuolaida_4              | Integer    | Ketvirtos nuolaidos procentas                                              |
| 23  | terminas_nuo_4          | Integer    | Jei ne 'null', rodo, kada prasideda ketvirtos nuolaidos galiojimas         |
| 24  | terminas_iki_4          | Integer    | Jei ne 'null', rodo, kada baigiasi ketvirtos nuolaidos galiojimas          |

<a id="getklientupaslauguruspapkainas"></a>
## 3.18. GetKlientuPaslauguRusPapKainas

### Aprašymas

```csharp
GetKlientuPaslauguRusPapKainas(string sKlientoKodas, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetKlientuPaslauguRusPapKainasXml(string sKlientoKodas, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina klientų papildomas kainas paslaugų rūšims, kurios naudojamos pardavimų operacijose.

### Įėjimo parametrai

sKlientoKodas – Finvaldos kliento kodas, jei NULL, bus pateikiamas sąrašas su visais klientais, kuriems sukurtos papildomos kainos.

tKoregavimoData – Papildomos kainos paskutinio koregavimo data, jei NULL, bus pateikiamos visos kainos.

tSukurimoData – Papildomos kainos sukūrimo data, jei NULL, bus pateikiamos visos kainos.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kliento_kodas             | Char (15)  | Kliento kodas                                                                                |
| 2   | kliento_pavadinimas       | Char (100) | Kliento pavadinimas                                                                          |
| 3   | pasl_rusies_kodas         | Char (13)  | Paslaugos rūšies kodas                                                                       |
| 4   | pasl_rusies_pavadinimas   | Char (50)  | Paslaugos rūšies pavadinimas                                                                 |
| 5   | kaina_korteleje           | Integer    | Siūloma paslaugos pardavimo kaina iš kortelės                                                |
| 6   | kaina_koreleje_su_terminu | Integer    | Siūloma paslaugos pardavimo kainą iš kortelės, jei pardavimo data patenka į nurodytą periodą |
| 7   | terminas_nuo              | Date       | Kainos galiojimo pradžios data                                                               |
| 8   | terminas_iki              | Date       | Kainos galiojimo pabaigos data                                                               |

<a id="getklientuprekiunuol"></a>
## 3.19. GetKlientuPrekiuNuol

### Aprašymas

```csharp
GetKlientuPrekiuNuol(string sKlientoKodas, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetKlientuPrekiuNuolXml(string sKlientoKodas, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina klientų nuolaidas prekėms, kurios naudojamos pardavimų operacijose.

### Įėjimo parametrai

sKlientoKodas – Finvaldos kliento kodas, jei NULL, bus pateikiamas sąrašas su visais klientais, kuriems sukurtos nuolaidos.

tKoregavimoData – Nuolaidos paskutinio koregavimo data, jei NULL, bus pateikiamos visos nuolaidos.

tSukurimoData – Nuolaidos sukūrimo data, jei NULL, bus pateikiamos visos nuolaidos.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kliento_kodas       | Char (15)  | Kliento kodas                                                           |
| 2   | kliento_pavadinimas | Char (100) | Kliento pavadinimas                                                     |
| 3   | prekes_kodas        | Char (20)  | Prekės kodas                                                            |
| 4   | prekes_pavadinimas  | Char (50)  | Prekės pavadinimas                                                      |
| 5   | kiekis_1            | Integer    | Prekės kiekis (antru matavimu), kurį surinkus taikoma pirma nuolaida    |
| 6   | suma_1              | Numeric    | Suma už prekę, kurią surinkus taikoma pirma nuolaida                    |
| 7   | nuolaida_1          | Numeric    | Pirmos nuolaidos procentas                                              |
| 8   | terminas_nuo_1      | Date       | Jei ne 'null', rodo, kada prasideda pirmos nuolaidos galiojimas         |
| 9   | terminas_iki_1      | Date       | Jei ne 'null', rodo, kada baigiasi pirmos nuolaidos galiojimas          |
| 10  | kiekis_2            | Integer    | Prekės kiekis (antru matavimu), kurį surinkus taikoma antra nuolaida    |
| 11  | suma_2              | Numeric    | Suma už prekę, kurią surinkus taikoma antra nuolaida                    |
| 12  | nuolaida_2          | Numeric    | Antros nuolaidos procentas                                              |
| 13  | terminas_nuo_2      | Date       | Jei ne 'null', rodo, kada prasideda antros nuolaidos galiojimas         |
| 14  | terminas_iki_2      | Date       | Jei ne 'null', rodo, kada baigiasi antros nuolaidos galiojimas          |
| 15  | kiekis_3            | Integer    | Prekės kiekis (antru matavimu), kurį surinkus taikoma trečia nuolaida   |
| 16  | suma_3              | Numeric    | Suma už prekę, kurią surinkus taikoma trečia nuolaida                   |
| 17  | nuolaida_3          | Numeric    | Trečios nuolaidos procentas                                             |
| 18  | terminas_nuo_3      | Date       | Jei ne 'null', rodo, kada prasideda trečios nuolaidos galiojimas        |
| 19  | terminas_iki_3      | Date       | Jei ne 'null', rodo, kada baigiasi trečios nuolaidos galiojimas         |
| 20  | kiekis_4            | Integer    | Prekės kiekis (antru matavimu), kurį surinkus taikoma ketvirta nuolaida |
| 21  | suma_4              | Integer    | Suma už prekę, kurią surinkus taikoma ketvirta nuolaida                 |
| 22  | nuolaida_4          | Integer    | Ketvirtos nuolaidos procentas                                           |
| 23  | terminas_nuo_4      | Integer    | Jei ne 'null', rodo, kada prasideda ketvirtos nuolaidos galiojimas      |
| 24  | terminas_iki_4      | Integer    | Jei ne 'null', rodo, kada baigiasi ketvirtos nuolaidos galiojimas       |

<a id="getklientuprekiupapkainas"></a>
## 3.20. GetKlientuPrekiuPapKainas

### Aprašymas

```csharp
GetKlientuPrekiuPapKainas(string sKlientoKodas, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetKlientuPrekiuPapKainasXml(string sKlientoKodas, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina klientų papildomas kainas prekėms, kurios naudojamos pardavimų operacijose.

### Įėjimo parametrai

sKlientoKodas – Finvaldos kliento kodas, jei NULL, bus pateikiamas sąrašas su visais klientais, kuriems sukurtos kainos.

tKoregavimoData – Papildomos kainos paskutinio koregavimo data, jei NULL, bus pateikiamos visos kainos.

tSukurimoData – Papildomos kainos sukūrimo data, jei NULL, bus pateikiamos visos kainos.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kliento_kodas             | Char (15)  | Kliento kodas                                                                             |
| 2   | kliento_pavadinimas       | Char (100) | Kliento pavadinimas                                                                       |
| 3   | prekes_kodas              | Char (20)  | Prekės kodas                                                                              |
| 4   | prekes_pavadinimas        | Char (50)  | Prekės pavadinimas                                                                        |
| 5   | kaina                     | Numeric    | Siūloma prekės pardavimo kaina                                                            |
| 6   | valiuta                   | Char (3)   | Siūloma prekės pardavimo valiuta                                                          |
| 7   | kaina_korteleje           | Integer    | Siūloma prekės pardavimo kaina iš kortelės                                                |
| 8   | kaina_su_terminu          | Numeric    | Siūloma prekės pardavimo kaina, jei pardavimo data patenka į nurodytą periodą             |
| 9   | valiuta_su_terminu        | Char (3)   | Siūloma prekės pardavimo valiuta, jei pardavimo data patenka į nurodytą periodą           |
| 10  | kaina_koreleje_su_terminu | Integer    | Siūloma prekės pardavimo kainą iš kortelės, jei pardavimo data patenka į nurodytą periodą |
| 11  | terminas_nuo              | Date       | Kainos galiojimo pradžios data                                                            |
| 12  | terminas_iki              | Date       | Kainos galiojimo pabaigos data                                                            |

<a id="getklientuprekiurusnuol"></a>
## 3.21. GetKlientuPrekiuRusNuol

### Aprašymas

```csharp
GetKlientuPrekiuRusNuol(string sKlientoKodas, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetKlientuPrekiuRusNuolXml(string sKlientoKodas, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina klientų nuolaidas prekių rūšims, kurios naudojamos pardavimų operacijose.

### Įėjimo parametrai

sKlientoKodas – Finvaldos kliento kodas, jei NULL, bus pateikiamas sąrašas su visais klientais, kuriems sukurtos nuolaidos.

tKoregavimoData – Nuolaidos paskutinio koregavimo data, jei NULL, bus pateikiamos visos nuolaidos.

tSukurimoData – Nuolaidos sukūrimo data, jei NULL, bus pateikiamos visos nuolaidos.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kliento_kodas           | Char (15)  | Kliento kodas                                                           |
| 2   | kliento_pavadinimas     | Char (100) | Kliento pavadinimas                                                     |
| 3   | prek_rusies_kodas       | Char (13)  | Prekės rūšies kodas                                                     |
| 4   | prek_rusies_pavadinimas | Char (50)  | Prekės rūšies pavadinimas                                               |
| 5   | kiekis_1                | Integer    | Prekės kiekis (antru matavimu), kurį surinkus taikoma pirma nuolaida    |
| 6   | suma_1                  | Numeric    | Suma už prekę, kurią surinkus taikoma pirma nuolaida                    |
| 7   | nuolaida_1              | Numeric    | Pirmos nuolaidos procentas                                              |
| 8   | terminas_nuo_1          | Date       | Jei ne 'null', rodo, kada prasideda pirmos nuolaidos galiojimas         |
| 9   | terminas_iki_1          | Date       | Jei ne 'null', rodo, kada baigiasi pirmos nuolaidos galiojimas          |
| 10  | kiekis_2                | Integer    | Prekės kiekis (antru matavimu), kurį surinkus taikoma antra nuolaida    |
| 11  | suma_2                  | Numeric    | Suma už prekę, kurią surinkus taikoma antra nuolaida                    |
| 12  | nuolaida_2              | Numeric    | Antros nuolaidos procentas                                              |
| 13  | terminas_nuo_2          | Date       | Jei ne 'null', rodo, kada prasideda antros nuolaidos galiojimas         |
| 14  | terminas_iki_2          | Date       | Jei ne 'null', rodo, kada baigiasi antros nuolaidos galiojimas          |
| 15  | kiekis_3                | Integer    | Prekės kiekis (antru matavimu), kurį surinkus taikoma trečia nuolaida   |
| 16  | suma_3                  | Numeric    | Suma už prekę, kurią surinkus taikoma trečia nuolaida                   |
| 17  | nuolaida_3              | Numeric    | Trečios nuolaidos procentas                                             |
| 18  | terminas_nuo_3          | Date       | Jei ne 'null', rodo, kada prasideda trečios nuolaidos galiojimas        |
| 19  | terminas_iki_3          | Date       | Jei ne 'null', rodo, kada baigiasi trečios nuolaidos galiojimas         |
| 20  | kiekis_4                | Integer    | Prekės kiekis (antru matavimu), kurį surinkus taikoma ketvirta nuolaida |
| 21  | suma_4                  | Integer    | Suma už prekę, kurią surinkus taikoma ketvirta nuolaida                 |
| 22  | nuolaida_4              | Integer    | Ketvirtos nuolaidos procentas                                           |
| 23  | terminas_nuo_4          | Integer    | Jei ne 'null', rodo, kada prasideda ketvirtos nuolaidos galiojimas      |
| 24  | terminas_iki_4          | Integer    | Jei ne 'null', rodo, kada baigiasi ketvirtos nuolaidos galiojimas       |

<a id="getklientuprekiuruspapkainas"></a>
## 3.22. GetKlientuPrekiuRusPapKainas

### Aprašymas

```csharp
GetKlientuPrekiuRusPapKainas(string sKlientoKodas, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetKlientuPrekiuRusPapKainasXml(string sKlientoKodas, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina klientų papildomas kainas prekių rūšims, kurios naudojamos pardavimų operacijose.

### Įėjimo parametrai

sKlientoKodas – Finvaldos kliento kodas, jei NULL, bus pateikiamas sąrašas su visais klientais, kuriems sukurtos kainos.

tKoregavimoData – Papildomos kainos paskutinio koregavimo data, jei NULL, bus pateikiamos visos kainos.

tSukurimoData – Papildomos kainos sukūrimo data, jei NULL, bus pateikiamos visos kainos.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kliento_kodas             | Char (15)  | Kliento kodas                                                                                |
| 2   | kliento_pavadinimas       | Char (100) | Kliento pavadinimas                                                                          |
| 3   | prek_rusies_kodas         | Char (13)  | Prekės rūšies kodas                                                                          |
| 4   | prek_rusies_pavadinimas   | Char (50)  | Prekės rūšies pavadinimas                                                                    |
| 5   | kaina_korteleje           | Integer    | Siūloma paslaugos pardavimo kaina iš kortelės                                                |
| 6   | kaina_koreleje_su_terminu | Integer    | Siūloma paslaugos pardavimo kainą iš kortelės, jei pardavimo data patenka į nurodytą periodą |
| 7   | terminas_nuo              | Date       | Kainos galiojimo pradžios data                                                               |
| 8   | terminas_iki              | Date       | Kainos galiojimo pabaigos data                                                               |

<a id="getklienturuspaslaugunuol"></a>
## 3.23. GetKlientuRusPaslauguNuol

### Aprašymas

```csharp
GetKlientuRusPaslauguNuol(string sKlientoRusKodas, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetKlientuRusPaslauguNuolXml(string sKlientoRusKodas, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina klientų rūšių nuolaidas paslaugoms, kurios naudojamos pardavimų operacijose.

### Įėjimo parametrai

sKlientoRusKodas – Finvaldos klientų rūšies kodas, jei NULL, bus pateikiamas sąrašas su visomis rūšimis, kurioms sukurtos nuolaidos.

tKoregavimoData – Nuolaidos paskutinio koregavimo data, jei NULL, bus pateikiamos visos nuolaidos.

tSukurimoData – Nuolaidos sukūrimo data, jei NULL, bus pateikiamos visos nuolaidos.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kli_rusies_kodas       | Char (10)  | Kliento rūšies kodas                                                       |
| 2   | kli_rusies_pavadinimas | Char (50)  | Kliento rūšies pavadinimas                                                 |
| 3   | paslaugos_kodas        | Char (20)  | Paslaugos kodas                                                            |
| 4   | paslaugos_pavadinimas  | Char (100) | Paslaugos pavadinimas                                                      |
| 5   | kiekis_1               | Integer    | Paslaugos kiekis (antru matavimu), kurį surinkus taikoma pirma nuolaida    |
| 6   | suma_1                 | Numeric    | Suma už paslaugą, kurią surinkus taikoma pirma nuolaida                    |
| 7   | nuolaida_1             | Numeric    | Pirmos nuolaidos procentas                                                 |
| 8   | terminas_nuo_1         | Date       | Jei ne 'null', rodo, kada prasideda pirmos nuolaidos galiojimas            |
| 9   | terminas_iki_1         | Date       | Jei ne 'null', rodo, kada baigiasi pirmos nuolaidos galiojimas             |
| 10  | kiekis_2               | Integer    | Paslaugos kiekis (antru matavimu), kurį surinkus taikoma antra nuolaida    |
| 11  | suma_2                 | Numeric    | Suma už paslaugą, kurią surinkus taikoma antra nuolaida                    |
| 12  | nuolaida_2             | Numeric    | Antros nuolaidos procentas                                                 |
| 13  | terminas_nuo_2         | Date       | Jei ne 'null', rodo, kada prasideda antros nuolaidos galiojimas            |
| 14  | terminas_iki_2         | Date       | Jei ne 'null', rodo, kada baigiasi antros nuolaidos galiojimas             |
| 15  | kiekis_3               | Integer    | Paslaugos kiekis (antru matavimu), kurį surinkus taikoma trečia nuolaida   |
| 16  | suma_3                 | Numeric    | Suma už paslaugą, kurią surinkus taikoma trečia nuolaida                   |
| 17  | nuolaida_3             | Numeric    | Trečios nuolaidos procentas                                                |
| 18  | terminas_nuo_3         | Date       | Jei ne 'null', rodo, kada prasideda trečios nuolaidos galiojimas           |
| 19  | terminas_iki_3         | Date       | Jei ne 'null', rodo, kada baigiasi trečios nuolaidos galiojimas            |
| 20  | kiekis_4               | Integer    | Paslaugos kiekis (antru matavimu), kurį surinkus taikoma ketvirta nuolaida |
| 21  | suma_4                 | Integer    | Suma už paslaugą, kurią surinkus taikoma ketvirta nuolaida                 |
| 22  | nuolaida_4             | Integer    | Ketvirtos nuolaidos procentas                                              |
| 23  | terminas_nuo_4         | Integer    | Jei ne 'null', rodo, kada prasideda ketvirtos nuolaidos galiojimas         |
| 24  | terminas_iki_4         | Integer    | Jei ne 'null', rodo, kada baigiasi ketvirtos nuolaidos galiojimas          |

<a id="getklienturuspaslaugupapkainas"></a>
## 3.24. GetKlientuRusPaslauguPapKainas

### Aprašymas

```csharp
GetKlientuRusPaslauguPapKainas(string sKlientoRusKodas, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetKlientuRusPaslauguPapKainasXml(string sKlientoRusKodas, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina klientų rūšių papildomas kainas paslaugoms, kurios naudojamos pardavimų operacijose.

### Įėjimo parametrai

sKlientoRusKodas – Finvaldos klientų rūšies kodas, jei NULL, bus pateikiamas sąrašas su visomis rūšimis, kurioms sukurtos papildomos kainos.

tKoregavimoData – Papildomos kainos paskutinio koregavimo data, jei NULL, bus pateikiamos visos kainos.

tSukurimoData – Papildomos kainos sukūrimo data, jei NULL, bus pateikiamos visos kainos.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kli_rusies_kodas          | Char (13) | Kliento rūšies kodas                                                                         |
| 2   | kli_rusies_pavadinimas    | Char (50) | Kliento rūšies pavadinimas                                                                   |
| 3   | paslaugos_kodas           | Char (20) | Paslaugos kodas                                                                              |
| 4   | paslaugos_pavadinimas     | Char (50) | Paslaugos pavadinimas                                                                        |
| 5   | kaina                     | Numeric   | Siūloma paslaugos pardavimo kaina                                                            |
| 6   | valiuta                   | Char (3)  | Siūloma paslaugos pardavimo valiuta                                                          |
| 7   | kaina_korteleje           | Integer   | Siūloma paslaugos pardavimo kaina iš kortelės                                                |
| 8   | kaina_su_terminu          | Numeric   | Siūloma paslaugos pardavimo kaina, jei pardavimo data patenka į nurodytą periodą             |
| 9   | valiuta_su_terminu        | Char (3)  | Siūloma paslaugos pardavimo valiuta, jei pardavimo data patenka į nurodytą periodą           |
| 10  | kaina_koreleje_su_terminu | Integer   | Siūloma paslaugos pardavimo kainą iš kortelės, jei pardavimo data patenka į nurodytą periodą |
| 11  | terminas_nuo              | Date      | Kainos galiojimo pradžios data                                                               |
| 12  | terminas_iki              | Date      | Kainos galiojimo pabaigos data                                                               |

<a id="getklienturuspaslaugurusnuol"></a>
## 3.25. GetKlientuRusPaslauguRusNuol

### Aprašymas

```csharp
GetKlientuRusPaslauguRusNuol(string sKlientoRusKodas, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetKlientuRusPaslauguRusNuolXml(string sKlientoRusKodas, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina klientų rūšių nuolaidas paslaugų rūšims, kurios naudojamos pardavimų operacijose.

### Įėjimo parametrai

sKlientoRusKodas – Finvaldos klientų rūšies kodas, jei NULL, bus pateikiamas sąrašas su visomis rūšimis, kurioms sukurtos nuolaidos.

tKoregavimoData – Nuolaidos paskutinio koregavimo data, jei NULL, bus pateikiamos visos nuolaidos.

tSukurimoData – Nuolaidos sukūrimo data, jei NULL, bus pateikiamos visos nuolaidos.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kli_rusies_kodas        | Char (10) | Kliento rūšies kodas                                                       |
| 2   | kli_rusies_pavadinimas  | Char (50) | Kliento rūšies pavadinimas                                                 |
| 3   | pasl_rusies_kodas       | Char (13) | Paslaugos rūšies kodas                                                     |
| 4   | pasl_rusies_pavadinimas | Char (50) | Paslaugos rūšies pavadinimas                                               |
| 5   | kiekis_1                | Integer   | Paslaugos kiekis (antru matavimu), kurį surinkus taikoma pirma nuolaida    |
| 6   | suma_1                  | Numeric   | Suma už paslaugą, kurią surinkus taikoma pirma nuolaida                    |
| 7   | nuolaida_1              | Numeric   | Pirmos nuolaidos procentas                                                 |
| 8   | terminas_nuo_1          | Date      | Jei ne 'null', rodo, kada prasideda pirmos nuolaidos galiojimas            |
| 9   | terminas_iki_1          | Date      | Jei ne 'null', rodo, kada baigiasi pirmos nuolaidos galiojimas             |
| 10  | kiekis_2                | Integer   | Paslaugos kiekis (antru matavimu), kurį surinkus taikoma antra nuolaida    |
| 11  | suma_2                  | Numeric   | Suma už paslaugą, kurią surinkus taikoma antra nuolaida                    |
| 12  | nuolaida_2              | Numeric   | Antros nuolaidos procentas                                                 |
| 13  | terminas_nuo_2          | Date      | Jei ne 'null', rodo, kada prasideda antros nuolaidos galiojimas            |
| 14  | terminas_iki_2          | Date      | Jei ne 'null', rodo, kada baigiasi antros nuolaidos galiojimas             |
| 15  | kiekis_3                | Integer   | Paslaugos kiekis (antru matavimu), kurį surinkus taikoma trečia nuolaida   |
| 16  | suma_3                  | Numeric   | Suma už paslaugą, kurią surinkus, taikoma trečia nuolaida                  |
| 17  | nuolaida_3              | Numeric   | Trečios nuolaidos procentas                                                |
| 18  | terminas_nuo_3          | Date      | Jei ne 'null', rodo, kada prasideda trečios nuolaidos galiojimas           |
| 19  | terminas_iki_3          | Date      | Jei ne 'null', rodo, kada baigiasi trečios nuolaidos galiojimas            |
| 20  | kiekis_4                | Integer   | Paslaugos kiekis (antru matavimu), kurį surinkus taikoma ketvirta nuolaida |
| 21  | suma_4                  | Integer   | Suma už paslaugą, kurią surinkus taikoma ketvirta nuolaida                 |
| 22  | nuolaida_4              | Integer   | Ketvirtos nuolaidos procentas                                              |
| 23  | terminas_nuo_4          | Integer   | Jei ne 'null', rodo, kada prasideda ketvirtos nuolaidos galiojimas         |
| 24  | terminas_iki_4          | Integer   | Jei ne 'null', rodo, kada baigiasi ketvirtos nuolaidos galiojimas          |

<a id="getklienturuspaslauguruspapkainas"></a>
## 3.26. GetKlientuRusPaslauguRusPapKainas

### Aprašymas

```csharp
GetKlientuRusPaslauguRusPapKainas(string sKlientoRusKodas, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetKlientuRusPaslauguRusPapKainasXml(string sKlientoRusKodas, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina klientų rūšių papildomas kainas paslaugų rūšims, kurios naudojamos pardavimų operacijose.

### Įėjimo parametrai

sKlientoRusKodas – Finvaldos klientų rūšies kodas, jei NULL, bus pateikiamas sąrašas su visomis rūšimis, kurioms sukurtos papildomos kainos.

tKoregavimoData – Papildomos kainos paskutinio koregavimo data, jei NULL, bus pateikiamos visos kainos.

tSukurimoData – Papildomos kainos sukūrimo data, jei NULL, bus pateikiamos visos kainos.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kli_rusies_kodas          | Char (10) | Kliento rūšies kodas                                                                         |
| 2   | kli_rusies_pavadinimas    | Char (50) | Kliento rūšies pavadinimas                                                                   |
| 3   | pasl_rusies_kodas         | Char (13) | Paslaugos rūšies kodas                                                                       |
| 4   | pasl_rusies_pavadinimas   | Char (50) | Paslaugos rūšies pavadinimas                                                                 |
| 5   | kaina_korteleje           | Integer   | Siūloma paslaugos pardavimo kaina iš kortelės                                                |
| 6   | kaina_koreleje_su_terminu | Integer   | Siūloma paslaugos pardavimo kainą iš kortelės, jei pardavimo data patenka į nurodytą periodą |
| 7   | terminas_nuo              | Date      | Kainos galiojimo pradžios data                                                               |
| 8   | terminas_iki              | Date      | Kainos galiojimo pabaigos data                                                               |

<a id="getklienturusprekiunuol"></a>
## 3.27. GetKlientuRusPrekiuNuol

### Aprašymas

```csharp
GetKlientuRusPrekiuNuol(string sKlientoRusKodas, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetKlientuRusPrekiuNuolXml(string sKlientoRusKodas, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina klientų rūšių nuolaidas prekėms, kurios naudojamos pardavimų operacijose.

### Įėjimo parametrai

sKlientoRusKodas – Finvaldos klientų rūšies kodas, jei NULL, bus pateikiamas sąrašas su visomis rūšimis, kurioms sukurtos nuolaidos.

tKoregavimoData – Nuolaidos paskutinio koregavimo data, jei NULL, bus pateikiamos visos nuolaidos.

tSukurimoData – Nuolaidos sukūrimo data, jei NULL, bus pateikiamos visos nuolaidos.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kli_rusies_kodas       | Char (13) | Kliento rūšies kodas                                                    |
| 2   | kli_rusies_pavadinimas | Char (50) | Kliento rūšies pavadinimas                                              |
| 3   | prekes_kodas           | Char (20) | Prekės kodas                                                            |
| 4   | prekes_pavadinimas     | Char (50) | Prekės pavadinimas                                                      |
| 5   | kiekis_1               | Integer   | Prekės kiekis (antru matavimu), kurį surinkus taikoma pirma nuolaida    |
| 6   | suma_1                 | Numeric   | Suma už prekę, kurią surinkus taikoma pirma nuolaida                    |
| 7   | nuolaida_1             | Numeric   | Pirmos nuolaidos procentas                                              |
| 8   | terminas_nuo_1         | Date      | Jei ne 'null', rodo, kada prasideda pirmos nuolaidos galiojimas         |
| 9   | terminas_iki_1         | Date      | Jei ne 'null', rodo, kada baigiasi pirmos nuolaidos galiojimas          |
| 10  | kiekis_2               | Integer   | Prekės kiekis (antru matavimu), kurį surinkus taikoma antra nuolaida    |
| 11  | suma_2                 | Numeric   | Suma už prekę, kurią surinkus taikoma antra nuolaida                    |
| 12  | nuolaida_2             | Numeric   | Antros nuolaidos procentas                                              |
| 13  | terminas_nuo_2         | Date      | Jei ne 'null', rodo, kada prasideda antros nuolaidos galiojimas         |
| 14  | terminas_iki_2         | Date      | Jei ne 'null', rodo, kada baigiasi antros nuolaidos galiojimas          |
| 15  | kiekis_3               | Integer   | Prekės kiekis (antru matavimu), kurį surinkus taikoma trečia nuolaida   |
| 16  | suma_3                 | Numeric   | Suma už prekę, kurią surinkus taikoma trečia nuolaida                   |
| 17  | nuolaida_3             | Numeric   | Trečios nuolaidos procentas                                             |
| 18  | terminas_nuo_3         | Date      | Jei ne 'null', rodo, kada prasideda trečios nuolaidos galiojimas        |
| 19  | terminas_iki_3         | Date      | Jei ne 'null', rodo, kada baigiasi trečios nuolaidos galiojimas         |
| 20  | kiekis_4               | Integer   | Prekės kiekis (antru matavimu), kurį surinkus taikoma ketvirta nuolaida |
| 21  | suma_4                 | Integer   | Suma už prekę, kurią surinkus taikoma ketvirta nuolaida                 |
| 22  | nuolaida_4             | Integer   | Ketvirtos nuolaidos procentas                                           |
| 23  | terminas_nuo_4         | Integer   | Jei ne 'null', rodo, kada prasideda ketvirtos nuolaidos galiojimas      |
| 24  | terminas_iki_4         | Integer   | Jei ne 'null', rodo, kada baigiasi ketvirtos nuolaidos galiojimas       |

<a id="getklienturusprekiupapkainas"></a>
## 3.28. GetKlientuRusPrekiuPapKainas

### Aprašymas

```csharp
GetKlientuRusPrekiuPapKainas(string sKlientoRusKodas, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetKlientuRusPrekiuPapKainasXml(string sKlientoRusKodas, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina klientų rūšių papildomas kainas prekėms, kurios naudojamos pardavimų operacijose.

### Įėjimo parametrai

sKlientoRusKodas – Finvaldos klientų rūšies kodas, jei NULL, bus pateikiamas sąrašas su visomis rūšimis, kurioms sukurtos papildomos kainos.

tKoregavimoData – Papildomos kainos paskutinio koregavimo data, jei NULL, bus pateikiamos visos kainos.

tSukurimoData – Papildomos kainos sukūrimo data, jei NULL, bus pateikiamos visos kainos.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kli_rusies_kodas          | Char (10) | Kliento rūšies kodas                                                                      |
| 2   | kli_rusies_pavadinimas    | Char (50) | Kliento rūšies pavadinimas                                                                |
| 3   | prekes_kodas              | Char (20) | Prekės kodas                                                                              |
| 4   | prekes_pavadinimas        | Char (50) | Prekės pavadinimas                                                                        |
| 5   | kaina                     | Numeric   | Siūloma prekės pardavimo kaina                                                            |
| 6   | valiuta                   | Char (3)  | Siūloma prekės pardavimo valiuta                                                          |
| 7   | kaina_korteleje           | Integer   | Siūloma prekės pardavimo kaina iš kortelės                                                |
| 8   | kaina_su_terminu          | Numeric   | Siūloma prekės pardavimo kaina, jei pardavimo data patenka į nurodytą periodą             |
| 9   | valiuta_su_terminu        | Char (3)  | Siūloma prekės pardavimo valiuta, jei pardavimo data patenka į nurodytą periodą           |
| 10  | kaina_koreleje_su_terminu | Integer   | Siūloma prekės pardavimo kainą iš kortelės, jei pardavimo data patenka į nurodytą periodą |
| 11  | terminas_nuo              | Date      | Kainos galiojimo pradžios data                                                            |
| 12  | terminas_iki              | Date      | Kainos galiojimo pabaigos data                                                            |

<a id="getklienturusprekiurusnuol"></a>
## 3.29. GetKlientuRusPrekiuRusNuol

### Aprašymas

```csharp
GetKlientuRusPrekiuPapKainas(string sKlientoRusKodas, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetKlientuRusPrekiuPapKainasXml(string sKlientoRusKodas, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina klientų rūšių nuolaidas prekių rūšims, kurios naudojamos pardavimų operacijose.

### Įėjimo parametrai

sKlientoRusKodas – Finvaldos klientų rūšies kodas, jei NULL, bus pateikiamas sąrašas su visomis rūšimis, kurioms sukurtos nuolaidos.

tKoregavimoData – Nuolaidos paskutinio koregavimo data, jei NULL, bus pateikiamos visos nuolaidos.

tSukurimoData – Nuolaidos sukūrimo data, jei NULL, bus pateikiamos visos nuolaidos.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kli_rusies_kodas        | Char (10) | Kliento rūšies kodas                                                    |
| 2   | kli_rusies_pavadinimas  | Char (50) | Kliento rūšies pavadinimas                                              |
| 3   | prek_rusies_kodas       | Char (13) | Prekių rūšies kodas                                                     |
| 4   | prek_rusies_pavadinimas | Char (50) | Prekių rūšies pavadinimas                                               |
| 5   | kiekis_1                | Integer   | Prekės kiekis (antru matavimu), kurį surinkus taikoma pirma nuolaida    |
| 6   | suma_1                  | Numeric   | Suma už prekę, kurią surinkus taikoma pirma nuolaida                    |
| 7   | nuolaida_1              | Numeric   | Pirmos nuolaidos procentas                                              |
| 8   | terminas_nuo_1          | Date      | Jei ne 'null', rodo, kada prasideda pirmos nuolaidos galiojimas         |
| 9   | terminas_iki_1          | Date      | Jei ne 'null', rodo, kada baigiasi pirmos nuolaidos galiojimas          |
| 10  | kiekis_2                | Integer   | Prekės kiekis (antru matavimu), kurį surinkus taikoma antra nuolaida    |
| 11  | suma_2                  | Numeric   | Suma už prekę, kurią surinkus taikoma antra nuolaida                    |
| 12  | nuolaida_2              | Numeric   | Antros nuolaidos procentas                                              |
| 13  | terminas_nuo_2          | Date      | Jei ne 'null', rodo, kada prasideda antros nuolaidos galiojimas         |
| 14  | terminas_iki_2          | Date      | Jei ne 'null', rodo, kada baigiasi antros nuolaidos galiojimas          |
| 15  | kiekis_3                | Integer   | Prekės kiekis (antru matavimu), kurį surinkus taikoma trečia nuolaida   |
| 16  | suma_3                  | Numeric   | Suma už prekę, kurią surinkus taikoma trečia nuolaida                   |
| 17  | nuolaida_3              | Numeric   | Trečios nuolaidos procentas                                             |
| 18  | terminas_nuo_3          | Date      | Jei ne 'null', rodo, kada prasideda trečios nuolaidos galiojimas        |
| 19  | terminas_iki_3          | Date      | Jei ne 'null', rodo, kada baigiasi trečios nuolaidos galiojimas         |
| 20  | kiekis_4                | Integer   | Prekės kiekis (antru matavimu), kurį surinkus taikoma ketvirta nuolaida |
| 21  | suma_4                  | Integer   | Suma už prekę, kurią surinkus taikoma ketvirta nuolaida                 |
| 22  | nuolaida_4              | Integer   | Ketvirtos nuolaidos procentas                                           |
| 23  | terminas_nuo_4          | Integer   | Jei ne 'null', rodo, kada prasideda ketvirtos nuolaidos galiojimas      |
| 24  | terminas_iki_4          | Integer   | Jei ne 'null', rodo, kada baigiasi ketvirtos nuolaidos galiojimas       |

<a id="getklienturusprekiuruspapkainas"></a>
## 3.30. GetKlientuRusPrekiuRusPapKainas

### Aprašymas

```csharp
GetKlientuRusPrekiuRusPapKainas(string sKlientoRusKodas, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError)
GetKlientuRusPrekiuRusPapKainasXml(string sKlientoRusKodas, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina klientų rūšių papildomas kainas prekių rūšims, kurios naudojamos pardavimų operacijose

### Įėjimo parametrai

sKlientoRusKodas – Finvaldos klientų rūšies kodas, jei NULL, bus pateikiamas sąrašas su visomis rūšimis, kurioms sukurtos papildomos kainos.

tKoregavimoData – Papildomos kainos paskutinio koregavimo data, jei NULL, bus pateikiamos visos kainos.

tSukurimoData – Papildomos kainos sukūrimo data, jei NULL, bus pateikiamos visos kainos.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kli_rusies_kodas          | Char (10) | Kliento rūšies kodas                                                                         |
| 2   | kli_rusies_pavadinimas    | Char (50) | Kliento rūšies pavadinimas                                                                   |
| 3   | prek_rusies_kodas         | Char (13) | Prekių rūšies kodas                                                                          |
| 4   | prek_rusies_pavadinimas   | Char (50) | Prekių rūšies pavadinimas                                                                    |
| 5   | kaina_korteleje           | Integer   | Siūloma paslaugos pardavimo kaina iš kortelės                                                |
| 6   | kaina_koreleje_su_terminu | Integer   | Siūloma paslaugos pardavimo kainą iš kortelės, jei pardavimo data patenka į nurodytą periodą |
| 7   | terminas_nuo              | Date      | Kainos galiojimo pradžios data                                                               |
| 8   | terminas_iki              | Date      | Kainos galiojimo pabaigos data                                                               |

<a id="getfvsuser"></a>
## 3.31. GetFvsUser

### Aprašymas

```csharp
GetFvsUser(string sUsername, string sPassword, bool writeSchema, out string Xml, out string sError)
```

Metodas pagal parametrus grąžina Finvaldos vartotoją.

### Įėjimo parametrai

sUserName – Naudotojo vardas.

sPassword – Vartotojo slaptažodis.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

XML:

```xml
<Fvs.FvsUser>
<UserName></UserName>
</Fvs.FvsUser>
```

<a id="getobjektas1"></a>
## 3.32. GetObjektas1

### Aprašymas

```csharp
GetObjektas1(string sObj1Kod, bool writeSchema, out string Xml, out string sError)
```

Metodas užpildo ir grąžina konkretaus Finvaldos 1 lygio objekto klasę.

### Įėjimo parametrai

sObj1Kod – Finvaldos 1 lygio objekto kodas.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

XML:

```xml
<Fvs.ObjektasI>
<FvsDatabase></FvsDatabase>
<FvsUser>Fvs.FvsUser</FvsUser>
<bNaujas>False</bNaujas>
<sKodas>0001</sKodas>
<sPavadinimas>Pirmas Objektas 01</sPavadinimas>
<sPavadinimas2></sPavadinimas2>
<sPapildomaInf1></sPapildomaInf1>
<sPapildomaInf2></sPapildomaInf2>
<sPapildomaInf3></sPapildomaInf3>
<sPapildomaInf4></sPapildomaInf4>
<sPapildomaInf5></sPapildomaInf5>
<sPapildomaInf6></sPapildomaInf6>
<sPapildomaInf7></sPapildomaInf7>
<sPapildomaInf8></sPapildomaInf8>
<sPapildomaInf9></sPapildomaInf9>
<sPapildomaInf10></sPapildomaInf10>
<sPozymis1></sPozymis1>
<sPozymis2></sPozymis2>
<sPozymis3></sPozymis3>
<sRusis></sRusis>
<tGaliojaNuo></tGaliojaNuo>
<tGaliojaIki></tGaliojaIki>
</Fvs.ObjektasI>
```

<a id="getobjektas2"></a>
## 3.33. GetObjektas2

### Aprašymas

```csharp
GetObjektas2(string sObj2Kod, bool writeSchema, out string Xml, out string sError)
```

Metodas užpildo ir grąžina konkretaus Finvaldos 2 lygio objekto klasę.

### Įėjimo parametrai

sObj2Kod – Finvaldos 2 lygio objekto kodas.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

XML:

```xml
<Fvs.ObjektasII>
<FvsDatabase></FvsDatabase>
<FvsUser>Fvs.FvsUser</FvsUser>
<bNaujas>False</bNaujas>
<sKodas>0002</sKodas>
<sPavadinimas>Antras Objektas 01</sPavadinimas>
<sPapildomaInf1></sPapildomaInf1>
<sPapildomaInf2></sPapildomaInf2>
<sPapildomaInf3></sPapildomaInf3>
<sPapildomaInf4></sPapildomaInf4>
<sPapildomaInf5></sPapildomaInf5>
<sPapildomaInf6></sPapildomaInf6>
<sPapildomaInf7></sPapildomaInf7>
<sPapildomaInf8></sPapildomaInf8>
<sPapildomaInf9></sPapildomaInf9>
<sPapildomaInf10></sPapildomaInf10>
<sPozymis1></sPozymis1>
<sPozymis2></sPozymis2>
<sPozymis3></sPozymis3>
<sRusis></sRusis>
<tGaliojaNuo></tGaliojaNuo>
<tGaliojaIki></tGaliojaIki>
</Fvs.ObjektasII>
```

<a id="getobjektas3"></a>
## 3.34. GetObjektas3

### Aprašymas

```csharp
GetObjektas3(string sObj3Kod, bool writeSchema, out string Xml, out string sError)
```

Metodas užpildo ir grąžina konkretaus Finvaldos 3 lygio objekto klasę.

### Įėjimo parametrai

sObj3Kod – Finvaldos 3 lygio objekto kodas.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

XML:

```xml
<Fvs.ObjektasIII>
<FvsDatabase></FvsDatabase>
<FvsUser>Fvs.FvsUser</FvsUser>
<bNaujas>False</bNaujas>
<sKodas>0003</sKodas>
<sPavadinimas>Trečias Objektas 01</sPavadinimas>
<sPapildomaInf1></sPapildomaInf1>
<sPapildomaInf2></sPapildomaInf2>
<tGaliojaNuo></tGaliojaNuo>
<tGaliojaIki></tGaliojaIki>
</Fvs.ObjektasIII>
```

<a id="getobjektas4"></a>
## 3.35. GetObjektas4

### Aprašymas

```csharp
GetObjektas4(string sObj4Kod, bool writeSchema, out string Xml, out string sError)
```

Metodas užpildo ir grąžina konkretaus Finvaldos 4 lygio objekto klasę.

### Įėjimo parametrai

sObj4Kod – Finvaldos 4 lygio objekto kodas.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

XML:

```xml
<Fvs.ObjektasIV>
<FvsDatabase></FvsDatabase>
<FvsUser>Fvs.FvsUser</FvsUser>
<bNaujas>False</bNaujas>
<sKodas>0004</sKodas>
<sPavadinimas>Ketvirtas Objektas 01</sPavadinimas>
<sPapildomaInf1></sPapildomaInf1>
<sPapildomaInf2></sPapildomaInf2>
<tGaliojaNuo></tGaliojaNuo>
<tGaliojaIki></tGaliojaIki>
</Fvs.ObjektasIV>
```

<a id="getobjektas5"></a>
## 3.36. GetObjektas5

### Aprašymas

```csharp
GetObjektas5(string sObj5Kod, bool writeSchema, out string Xml, out string sError)
```

Metodas užpildo ir grąžina konkretaus Finvaldos 5 lygio objekto klasę.

### Įėjimo parametrai

sObj5Kod – Finvaldos 5 lygio objekto kodas.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

XML:

```xml
<Fvs.ObjektasV>
<FvsDatabase></FvsDatabase>
<FvsUser>Fvs.FvsUser</FvsUser>
<bNaujas>False</bNaujas>
<sKodas>0005</sKodas>
<sPavadinimas>Penktas Objektas 01</sPavadinimas>
<sPapildomaInf1></sPapildomaInf1>
<sPapildomaInf2></sPapildomaInf2>
<tGaliojaNuo></tGaliojaNuo>
<tGaliojaIki></tGaliojaIki>
</Fvs.ObjektasV>
```

<a id="getobjektas6"></a>
## 3.37. GetObjektas6

### Aprašymas

```csharp
GetObjektas6(string sObj6Kod, bool writeSchema, out string Xml, out string sError)
```

Metodas užpildo ir grąžina konkretaus Finvaldos 6 lygio objekto klasę.

### Įėjimo parametrai

sObj6Kod – Finvaldos 6 lygio objekto kodas.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

XML:

```xml
<Fvs.ObjektasVI>
<FvsDatabase></FvsDatabase>
<FvsUser>Fvs.FvsUser</FvsUser>
<bNaujas>False</bNaujas>
<sKodas>0006</sKodas>
<sPavadinimas>Šeštas Objektas 01</sPavadinimas>
<sPapildomaInf1></sPapildomaInf1>
<sPapildomaInf2></sPapildomaInf2>
<tGaliojaNuo></tGaliojaNuo>
<tGaliojaIki></tGaliojaIki>
</Fvs.ObjektasVI>
```

<a id="getklientas"></a>
## 3.38. GetKlientas

### Aprašymas

```csharp
GetKlientas(string sKliKod, bool writeSchema, out string Xml, out string sError)
```

Metodas užpildo ir grąžina konkretaus Finvaldos kliento klasę.

### Įėjimo parametrai

sKliKod – Finvaldos kliento kodas.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

XML:

```xml
<Fvs.Klientas>
<FvsDatabase></FvsDatabase>
<FvsUser></FvsUser>
<sKodas></sKodas>
<sPavadinimas></sPavadinimas>
<sAdresas></sAdresas>
<sTelefonas></sTelefonas>
<sFaksas></sFaksas>
<sAtsakingasAsmuo></sAtsakingasAsmuo>
<sAtsiskaitymoTerminaiDebt></sAtsiskaitymoTerminaiDebt>
<dDelspinigiaiDebt></dDelspinigiaiDebt>
<sAtsiskaitymoTerminaiKred></sAtsiskaitymoTerminaiKred>
<dDelspinigiaiKred></dDelspinigiaiKred>
<sPvmMokKod></sPvmMokKod>
<sDebtSask></sDebtSask>
<sKredSask></sKredSask>
<nKreditas></nKreditas>
<sBankas></sBankas>
<sBankoSaskaita></sBankoSaskaita>
<sKorespSaskBank></sKorespSaskBank>
<nTipas></nTipas>
<sImKodas></sImKodas>
<sPvmMoketojoKod></sPvmMoketojoKod>
<sPastabos></sPastabos>
<sRusis></sRusis>
<sEMail></sEMail>
<nMaksPradlestosSkolosSum></nMaksPradlestosSkolosSum>
<nSkolaGalimaPradelstiDien></nSkolaGalimaPradelstiDien>
<nAktyvus></nAktyvus>
<sPasiulomaValiuta></sPasiulomaValiuta>
<sYraKlientoPadalinys></sYraKlientoPadalinys>
<sObjektas1></sObjektas1>
<sObjektas2></sObjektas2>
<sObjektas3></sObjektas3>
<sObjektas4></sObjektas4>
<sPozymis1></sPozymis1>
<sPozymis2></sPozymis2>
<sPozymis3></sPozymis3>
<dPapildomaInf>0</dPapildomaInf>
<tKurimoData>2010-01-05 00:00:00</tKurimoData>
<tKoregavimoData>2010-01-05 00:00:00</tKoregavimoData>
</Fvs.Klientas>
```

<a id="getklientasemail"></a>
## 3.39. GetKlientasEMail

### Aprašymas

```csharp
GetKlientasEMail(string sEMail, bool writeSchema, out string Xml, out string sError)
```

Metodas užpildo ir grąžina konkretaus Finvaldos kliento klasę.

### Įėjimo parametrai

sEMail – Finlvados kliento el. pašto adresas.

### Išėjimo parametrai

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

Žr. GetKlientas rezultatas.

<a id="getklientus"></a>
## 3.40. GetKlientus

### Aprašymas

```csharp
GetKlientus(DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas užpildo kiekvieno kliento klasę ir grąžina visų Finvaldoje esančių klientų masyvą, rikiuota pagal kliento kodą.

### Įėjimo parametrai

tKoregavimoData – Kliento paskutinio koregavimo data, jei NULL, bus pateikiami visi klientai.

tSukurimoData – Kliento sukūrimo data, jei NULL, bus pateikiami visi klientai.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

XML:

```xml
<Klientai>
<Fvs.Klientas>
```

...

```xml
</Fvs.Klientas>
<Fvs.Klientas>
```

...

```xml
</Fvs.Klientas>
```

..................

```xml
</Klientai>
```

<a id="getpaslauga"></a>
## 3.41. GetPaslauga

### Aprašymas

```csharp
GetPaslauga(string sPaslaugosKodas, bool writeSchema, out string Xml, out string sError)
```

Metodas užpildo ir grąžina konkrečios Finvaldos paslaugos klasę.

### Įėjimo parametrai

sPaslaugosKodas – Finvlados paslaugos kodas.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

XML:

```xml
<Fvs.Paslauga>
<FvsDatabase></FvsDatabase>
<FvsUser> </FvsUser>
<bNauja></bNauja>
<sKodas></sKodas>
<sPavadinimas></sPavadinimas>
<sBARKodas></sBARKodas>
<sPastaba></sPastaba>
<sRysysSuSask></sRysysSuSask>
<sMokestis></sMokestis>
<sMatVienetas></sMatVienetas>
<dPirkimoKaina></dPirkimoKaina>
<dPardavimoKaina></dPardavimoKaina>
<sPastabos1></sPastabos1>
<sPastabos2></sPastabos2>
<sPastabos3></sPastabos3>
<sPastabos4></sPastabos4>
<sPastabos5></sPastabos5>
<sPastabos6></sPastabos6>
<sPastabos7></sPastabos7>
<sPastabos8></sPastabos8>
<sPastabos9></sPastabos9>
<sPastabos10></sPastabos10>
<sPastabos11></sPastabos11>
<sPastabos12></sPastabos12>
<nAktyvi></nAktyvi>
<sObjektas1></sObjektas1>
<sObjektas2></sObjektas2>
<sObjektas3></sObjektas3>
<sObjektas4></sObjektas4>
<sRusis></sRusis>
<sPozymis1></sPozymis1>
<sPozymis2></sPozymis2>
<sPozymis3></sPozymis3>
<tKurimoData>2010-01-05 00:00:00</tKurimoData>
<tKoregavimoData>2010-01-05 00:00:00</tKoregavimoData>
</Fvs.Paslauga>
```

<a id="getpaslaugos"></a>
## 3.42. GetPaslaugos

### Aprašymas

```csharp
GetPaslaugos(DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas užpildo kiekvienos paslaugos klasę ir grąžina visų Finvaldoje esančių paslaugų masyvą, rikiuota pagal paslaugos kodą.

### Įėjimo parametrai

tKoregavimoData – Paslaugos paskutinio koregavimo data, jei NULL, bus pateikiamos visos paslaugos.

tSukurimoData – Paslaugos sukūrimo data, jei NULL, bus pateikiamos visos paslaugos.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

XML:

```xml
<Paslaugos>
<Fvs.Paslauga>
```

...

```xml
</Fvs.Paslauga>
<Fvs.Paslauga>
```

...

```xml
</Fvs.Paslauga >
```

..................

```xml
</Paslaugos>
```

<a id="getpreke"></a>
## 3.43. GetPreke

### Aprašymas

```csharp
GetPreke(string sPrekesKodas, bool writeSchema, out string Xml, out string sError)
```

Metodas užpildo ir grąžina konkrečios Finvaldos prekės klasę.

### Įėjimo parametrai

sPrekesKodas – Finvlados prekės kodas.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

XML:

```xml
<Fvs.Preke>
<FvsDatabase></FvsDatabase>
<FvsUser>Fvs.FvsUser</FvsUser>
<bNauja>False</bNauja>
<sKodas>PRE_01</sKodas>
<sPavadinimas>Pirmaprek?\_1_1_1_1_1_1</sPavadinimas>
<sBarKodas>00011</sBarKodas>
<sPastaba></sPastaba>
<sRysysSuSask>20130</sRysysSuSask>
<sMatavimoVnt>VNT</sMatavimoVnt>
<sMokestis>18PVM</sMokestis>
<sInformacija></sInformacija>
<sRusis>PRE_RUS_1</sRusis>
<sPozymis1></sPozymis1>
<sPozymis2></sPozymis2>
<sPozymis3></sPozymis3>
<sPozymis4></sPozymis4>
<sPozymis5></sPozymis5>
<sPozymis6></sPozymis6>
<sValiuta>LTL</sValiuta>
<sIntrastatKodas></sIntrastatKodas>
<dKaina1>20</dKaina1>
<dKaina2>0</dKaina2>
<dKaina3>0</dKaina3>
<dKaina4>0</dKaina4>
<dKaina5>0</dKaina5>
<dKaina6>0</dKaina6>
<dNeto>0</dNeto>
<dBruto>0</dBruto>
<dTuris>0</dTuris>
<dAntkainis>0</dAntkainis>
<nVietuSkaicius>0</nVietuSkaicius>
<nAktyvi>1</nAktyvi>
<dPirkimoKaina>10</dPirkimoKaina>
<sPirkimoValiuta>LTL</sPirkimoValiuta>
<sUrl></sUrl>
<sObjektas1></sObjektas1>
<sObjektas2></sObjektas2>
<sObjektas3></sObjektas3>
<sObjektas4></sObjektas4>
<nYraPakuote>0</nYraPakuote>
<nYraPUI>0</nYraPUI>
<nIvedamaGalData>0</nIvedamaGalData>
<nSudetine>0</nSudetine>
<nSavikainosSkaicMetodas>0</nSavikainosSkaicMetodas>
<dPakPo1>0</dPakPo1>
<dPakPo2>0</dPakPo2>
<dPakSt1>0</dPakSt1>
<dPakSt2>0</dPakSt2>
<dPakMe1>0</dPakMe1>
<dPakMe2>0</dPakMe2>
<dPakPl1>0</dPakPl1>
<dPakPl2>0</dPakPl2>
<dPakKo1>0</dPakKo1>
<dPakKo2>0</dPakKo2>
<dPakKi1>0</dPakKi1>
<dPakKi2>0</dPakKi2>
<nMinimalusKiekis>0</nMinimalusKiekis>
<nUzsakomaPrekiu>0</nUzsakomaPrekiu>
<sTiekejas1></sTiekejas1>
<sPreKodTiek1Kataloge></sPreKodTiek1Kataloge>
<sTiekejas2></sTiekejas2>
<sPreKodTiek2Kataloge></sPreKodTiek2Kataloge>
<sTiekejas3></sTiekejas3>
<sPreKodTiek3Kataloge></sPreKodTiek3Kataloge>
<tKurimoData>2010-01-05 00:00:00</tKurimoData>
<tKoregavimoData>2010-01-05 00:00:00</tKoregavimoData>
<sInfo1>Papildoma info (unicode)</sInfo1>
<sInfo2> Papildoma info (unicode)</sInfo2>
<sInfo3> Papildoma info (unicode)</sInfo3>
<sInfo4> Papildoma info (unicode)</sInfo4>
<sInfo5> Papildoma info (unicode)</sInfo5>
<sPrekGrupes>Pirmagrp/AntraGrp/TreciaGrp</sPrekGrupes>
<sKilmesSalis></sKilmesSalis>
</Fvs.Preke>
```

<a id="getprekes"></a>
## 3.44. GetPrekes

### Aprašymas

```csharp
GetPrekes(DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas užpildo kiekvienos prekės klasę ir grąžina visų Finvaldoje esančių prekių masyvą, rikiuota pagal prekės kodą.

### Įėjimo parametrai

tKoregavimoData – Prekės paskutinio koregavimo data, jei NULL, bus pateikiamos visos prekės.

tSukurimoData – Prekės sukūrimo data, jei NULL, bus pateikiamos visos prekės.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

XML:

```xml
<Prekes>
<Fvs.Preke>
```

...

```xml
</Fvs.Preke>
<Fvs.Preke>
```

...

```xml
</Fvs.Preke>
```

..................

```xml
</Prekes >
```

<a id="getprekesimage"></a>
## 3.45. GetPrekesImage

### Aprašymas

```csharp
GetPrekesImage(string sPreKod, DateTime tKoregavimoData, DateTime tSukurimoData, out byte\[\] data, out string sError)
```

Metodas grąžina prekei nurodytą atvaizdą baitų masyvu, užkoduotu JPG formatu.

### Įėjimo parametrai

sPreKod – Prekės, kurios atvaizdas reikalingas, kodas.

tKoregavimoData – Atvaizdo paskutinio koregavimo data.

### Išėjimo parametrai

data – grąžinami duomenys (jpg failas);

sError – Klaidos tekstas.

### Rezultatas

Rezultatas yra JPG failas baitų masyve.

<a id="getprekessandelyje"></a>
## 3.46. GetPrekesSandelyje

### Aprašymas

*GetPrekesSandelyje (string sSanKod, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)*

Analogiškas **GetPrekes()** metodui, tik šiuo atveju prekės imamos tik iš konkretaus sandėlio.

### Įėjimo parametrai

sSanKod – Sandėlio kodas.

tKoregavimoData – Paskutinio koregavimo data, jei NULL, bus pateikiami visi duomenys.

tSukurimoData – Sukūrimo data, jei NULL, bus pateikiami visi duomenys.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

XML:

```xml
<Prekes>
<Fvs.Preke>
```

...

```xml
</Fvs.Preke>
<Fvs.Preke>
```

...

```xml
</Fvs.Preke>
```

..................

```xml
</Prekes >
```

<a id="getprekessandelyjeorder"></a>
## 3.47. GetPrekesSandelyjeOrder

### Aprašymas

*GetPrekesSandelyjeOrder (string sSanKod, int nOrder, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError)*

Analogiškas **GetPrekes*Sandelyje*()** metodui, tik šiuo atveju prekės rikiuojamos pagal parametrą.

### Įėjimo parametrai

sSanKod – Sandėlio kodas.

nOrder – rezultato rikiavimo sąlyga:

> 0 – prekės kodas;
>
> 1 – pirmas prekės požymis;
>
> 2 – antras prekės požymis;
>
> 3 – trečias prekės požymis;
>
> 4 – ketvirtas prekės požymis;
>
> 5 – penktas prekės požymos;
>
> 6 – šeštas prekės požymis;
>
> 7 – prekės papildoma informacija;
>
> 8 – prekės BAR kodas.

tKoregavimoData – Paskutinio koregavimo data, jei NULL, bus pateikiami visi duomenys.

tSukurimoData – Sukūrimo data, jei NULL, bus pateikiami visi duomenys.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

Analogiškas **GetPrekes*Sandelyje*()** metodui**;**

<a id="getprekiurusiessudeti"></a>
## 3.48. GetPrekiuRusiesSudeti

### Aprašymas

```csharp
GetPrekiuRusiesSudeti(string sRusiesKodas, out DataSet Data, out string sError)
GetPrekiuRusiesSudetiXml(string sRusiesKodas, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina sąrašą su visomis prekėmis, kurioms priskirta konkreti rūšis.

### Įėjimo parametrai

sRusiesKodas – Finvaldos prekių rūšies kodas.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kodas       | Char (20) | Prekės kodas       |
| 2   | pavadinimas | Char (50) | Prekės pavadinimas |

<a id="getpardprekperperioda"></a>
## 3.49. GetPardPrekPerPerioda

###  Aprašymas

```csharp
GetPardPrekPerPerioda(string sPrekesKodas, string sSandelioKodas, DateTime tDataNuo, DateTime tDataIki, string sPardZurKodas, bool bItrauktiVisasPrekes, out DataSet Data, out string sError)
GetPardPrekPerPeriodaXml(string sPrekesKodas, string sSandelioKodas, DateTime tDataNuo, DateTime tDataIki, string sPardZurKodas, bool bItrauktiVisasPrekes, bool writeSchema, out string Xml, out string sError)
```

Metodas  grąžina prekių likučius sandėliuose.

### Įėjimo parametrai

sPrekesKodas – jei ne NULL, bus grąžinamas tik nurodytos prekės parduotas kiekis

sSandelioKodas – jei ne NULL, bus grąžinamas parduotas kiekis iš nurodyto sandėlio.

tDataNuo – periodo pradžios data, jei NULL, bus pateikiami visi duomenys.

tDataIki – Pariodo pabaigos data, jei NULL, bus pateikiami visi duomenys.

sPardZurKodas – pardavimo op. žurnalo kodas

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

bItrauktiVisasPrekes – gražinamas visas aktyvių prekių sąrašas, prekės kurios nebuvo parduotos su nuliniais kiekiais ir sumomis

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | preke              | Char (20) | Prekės kodas                                |
| 2   | kiekis             | Double    | Prekės kiekis                               |
| 3   | mato_vnt_pav       | Char(50)  | Prekės mato vieneto pavadinimas             |
| 4   | pirm_antr_mat_sant | Integer   | Prekės pirmo ir antro mato vienetų santykis |
| 5   | pard_suma          | Double    | Pardavimo kaina be PVM (EUR)                |
| 6   | pard_pvm           | Double    | Pardavimo PVM (EUR)                         |

<a id="getpaslaugurusiessudeti"></a>
## 3.50. GetPaslauguRusiesSudeti

### Aprašymas

```csharp
GetPaslauguRusiesSudeti(string sRusiesKodas, out DataSet Data, out string sError)
GetPaslauguRusiesSudetiXml(string sRusiesKodas, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina sąrašą su visomis paslaugomis, kurioms priskirta konkreti rūšis.

### Įėjimo parametrai

sRusiesKodas – Finvaldos paslaugų rūšies kodas.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kodas       | Char (13) | Paslaugos kodas       |
| 2   | pavadinimas | Char (50) | Paslaugos pavadinimas |

<a id="getklientusrusiessudeti"></a>
## 3.51. GetKlientusRusiesSudeti

### Aprašymas

```csharp
GetKlientusRusiesSudeti(string sRusiesKodas, out DataSet Data, out string sError)
GetKlientusRusiesSudetiXml(string sRusiesKodas, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina sąrašą su visais klientais, kurioms priskirta konkreti rūšis.

### Įėjimo parametrai

sRusiesKodas – Finvaldos klientų rūšies kodas.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kodas       | Char (15)  | Kliento kodas       |
| 2   | pavadinimas | Char (100) | Kliento pavadinimas |

<a id="getatsiskaitymoterm"></a>
## 3.52. GetAtsiskaitymoTerm

### Aprašymas

```csharp
GetAtsiskaitymoTerm(out DataSet Data, out string sError)
GetAtsiskaitymoTermXml( bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina sąrašą su visais Finvaldos atsiskaitymo terminais klientams.

### Įėjimo parametra

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kodas               | Char (10) | Atsiskaitymo termino kodas                      |
| 2   | pavadinimas         | Char (50) | Atsiskaitymo termino pavadinimas                |
| 3   | reikia_atsiskaityti | Integer   | Už dokumentą reikia atsiskaityti per tiek dienų |

<a id="getobjektai1set"></a>
## 3.53. GetObjektai1Set

### Aprašymas

```csharp
GetObjektai1Set(string sObj1Kod, object tKoregavimoData, object tSukurimoData, out DataSet Data, out string sError)
GetObjektai1SetXml(string sObj1Kod, object tKoregavimoData, object tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina 1 lygio objektų sąrašą iš Finvaldos.

### Įėjimo parametra

sObj1Kod – Finvaldos 1 lygio objekto kodas, jei NULL, bus pateikiami visi 1 lygio objektai.

tKoregavimoData – Paskutinio koregavimo data, jei NULL, bus pateikiamos visi 1 lygio objektai.

tSukurimoData – Sukūrimo data, jei NULL, bus pateikiamos visi 1 lygio objektai.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kodas        | Char (10) | Objekto kodas                      |
| 2   | pavadinimas  | Char (50) | Objekto pavadinimas                |
| 3   | pavadinimas2 | Char(100) | Antras objekto pavadinimas         |
| 4   | info1        | Char(50)  | Papildoma informacija              |
| 5   | info2        | Char(50)  | Papildoma informacija              |
| 6   | info3        | Char(50)  | Papildoma informacija              |
| 7   | info4        | Char(50)  | Papildoma informacija              |
| 8   | info5        | Char(50)  | Papildoma informacija              |
| 9   | info6        | Char(50)  | Papildoma informacija              |
| 10  | info7        | Char(50)  | Papildoma informacija              |
| 11  | info8        | Char(50)  | Papildoma informacija              |
| 12  | info9        | Char(50)  | Papildoma informacija              |
| 13  | info10       | Char(50)  | Papildoma informacija              |
| 14  | rusis        | Char(10)  | Objekto rūšies kodas               |
| 15  | pozymis1     | Char(10)  | Objekto pirmo požymio kodas        |
| 16  | pozymis2     | Char(10)  | Objekto antro požymio kodas        |
| 17  | pozymis3     | Char(10)  | Objekto trečio požymio kodas       |
| 18  | grupės       | VarChar   | Grupės, kurioms priklauso objektas |
| 19  | galioja_nuo  | Date      | Objekto galiojimo pradžia          |
| 20  | galioja_iki  | Date      | Objekto galiojimo pabaiga          |

<a id="getobjektai2set"></a>
## 3.54. GetObjektai2Set

### Aprašymas

```csharp
GetObjektai2Set(string sObj2Kod, object tKoregavimoData, object tSukurimoData, out DataSet Data, out string sError)
GetObjektai2SetXml(string sObj2Kod, object tKoregavimoData, object tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina 2 lygio objektų sąrašą iš Finvaldos.

### Įėjimo parametra

sObj2Kod – Finvaldos 2 lygio objekto kodas, jei NULL, bus pateikiami visi 2 lygio objektai.

tKoregavimoData – Paskutinio koregavimo data, jei NULL, bus pateikiamos visi 2 lygio objektai.

tSukurimoData – Sukūrimo data, jei NULL, bus pateikiamos visi 2 lygio objektai.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kodas       | Char (10) | Objekto kodas                      |
| 2   | pavadinimas | Char (50) | Objekto pavadinimas                |
| 3   | info1       | Char(50)  | Papildoma informacija              |
| 4   | info2       | Char(50)  | Papildoma informacija              |
| 5   | info3       | Char(50)  | Papildoma informacija              |
| 6   | info4       | Char(50)  | Papildoma informacija              |
| 7   | info5       | Char(50)  | Papildoma informacija              |
| 8   | info6       | Char(50)  | Papildoma informacija              |
| 9   | info7       | Char(50)  | Papildoma informacija              |
| 10  | info8       | Char(50)  | Papildoma informacija              |
| 11  | info9       | Char(50)  | Papildoma informacija              |
| 12  | info10      | Char(50)  | Papildoma informacija              |
| 13  | rusis       | Char(10)  | Objekto rūšies kodas               |
| 14  | pozymis1    | Char(10)  | Objekto pirmo požymio kodas        |
| 15  | pozymis2    | Char(10)  | Objekto antro požymio kodas        |
| 16  | pozymis3    | Char(10)  | Objekto trečio požymio kodas       |
| 17  | grupės      | VarChar   | Grupės, kurioms priklauso objektas |
| 18  | galioja_nuo | Date      | Objekto galiojimo pradžia          |
| 19  | galioja_iki | Date      | Objekto galiojimo pabaiga          |

<a id="getobjektai3set"></a>
## 3.55. GetObjektai3Set

### Aprašymas

```csharp
GetObjektai3Set(string sObj3Kod, object tKoregavimoData, object tSukurimoData, out DataSet Data, out string sError)
GetObjektai3SetXml(string sObj3Kod, object tKoregavimoData, object tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina 3 lygio objektų sąrašą iš Finvaldos.

### Įėjimo parametra

sObj3Kod – Finvaldos 3 lygio objekto kodas, jei NULL, bus pateikiami visi 3 lygio objektai.

tKoregavimoData – Paskutinio koregavimo data, jei NULL, bus pateikiamos visi 3 lygio objektai.

tSukurimoData – Sukūrimo data, jei NULL, bus pateikiamos visi 3 lygio objektai.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kodas       | Char (10) | Objekto kodas                      |
| 2   | pavadinimas | Char (50) | Objekto pavadinimas                |
| 3   | info1       | Char(50)  | Papildoma informacija              |
| 4   | info2       | Char(50)  | Papildoma informacija              |
| 5   | grupės      | VarChar   | Grupės, kurioms priklauso objektas |
| 6   | galioja_nuo | Date      | Objekto galiojimo pradžia          |
| 7   | galioja_iki | Date      | Objekto galiojimo pabaiga          |

<a id="getobjektai4set"></a>
## 3.56. GetObjektai4Set

### Aprašymas

```csharp
GetObjektai4Set(string sObj4Kod, object tKoregavimoData, object tSukurimoData, out DataSet Data, out string sError)
GetObjektai4SetXml(string sObj4Kod, object tKoregavimoData, object tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina 4 lygio objektų sąrašą iš Finvaldos.

### Įėjimo parametra

sObj4Kod – Finvaldos 4 lygio objekto kodas, jei NULL, bus pateikiami visi 4 lygio objektai.

tKoregavimoData – Paskutinio koregavimo data, jei NULL, bus pateikiamos visi 4 lygio objektai.

tSukurimoData – Sukūrimo data, jei NULL, bus pateikiamos visi 4 lygio objektai.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kodas       | Char (10) | Objekto kodas                      |
| 2   | pavadinimas | Char (50) | Objekto pavadinimas                |
| 3   | info1       | Char(50)  | Papildoma informacija              |
| 4   | info2       | Char(50)  | Papildoma informacija              |
| 5   | grupės      | VarChar   | Grupės, kurioms priklauso objektas |
| 6   | galioja_nuo | Date      | Objekto galiojimo pradžia          |
| 7   | galioja_iki | Date      | Objekto galiojimo pabaiga          |

<a id="getobjektai5set"></a>
## 3.57. GetObjektai5Set

### Aprašymas

```csharp
GetObjektai5Set(string sObj5Kod, object tKoregavimoData, object tSukurimoData, out DataSet Data, out string sError)
GetObjektai5SetXml(string sObj5Kod, object tKoregavimoData, object tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina 5 lygio objektų sąrašą iš Finvaldos.

### Įėjimo parametra

sObj5Kod – Finvaldos 5 lygio objekto kodas, jei NULL, bus pateikiami visi 5 lygio objektai.

tKoregavimoData – Paskutinio koregavimo data, jei NULL, bus pateikiamos visi 5 lygio objektai.

tSukurimoData – Sukūrimo data, jei NULL, bus pateikiamos visi 5 lygio objektai.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kodas       | Char (10) | Objekto kodas                      |
| 2   | pavadinimas | Char (50) | Objekto pavadinimas                |
| 3   | info1       | Char(50)  | Papildoma informacija              |
| 4   | info2       | Char(50)  | Papildoma informacija              |
| 5   | grupės      | VarChar   | Grupės, kurioms priklauso objektas |
| 6   | galioja_nuo | Date      | Objekto galiojimo pradžia          |
| 7   | galioja_iki | Date      | Objekto galiojimo pabaiga          |

<a id="getobjektai6set"></a>
## 3.58. GetObjektai6Set

### Aprašymas

```csharp
GetObjektai6Set(string sObj6Kod, object tKoregavimoData, object tSukurimoData, out DataSet Data, out string sError)
GetObjektai6SetXml(string sObj6Kod, object tKoregavimoData, object tSukurimoData, bool writeSchema, out string Xml, out string sError)
```

Metodas grąžina 6 lygio objektų sąrašą iš Finvaldos.

### Įėjimo parametra

sObj6Kod – Finvaldos 6 lygio objekto kodas, jei NULL, bus pateikiami visi 6 lygio objektai.

tKoregavimoData – Paskutinio koregavimo data, jei NULL, bus pateikiamos visi 6 lygio objektai.

tSukurimoData – Sukūrimo data, jei NULL, bus pateikiamos visi 6 lygio objektai.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | kodas       | Char (10) | Objekto kodas                      |
| 2   | pavadinimas | Char (50) | Objekto pavadinimas                |
| 3   | info1       | Char(50)  | Papildoma informacija              |
| 4   | info2       | Char(50)  | Papildoma informacija              |
| 5   | grupės      | VarChar   | Grupės, kurioms priklauso objektas |
| 6   | galioja_nuo | Date      | Objekto galiojimo pradžia          |
| 7   | galioja_iki | Date      | Objekto galiojimo pabaiga          |

<a id="getuvmpardrbusena"></a>
## 3.59. GetUVMPardRBusena

### Aprašymas

*GetUVMPardRBusena (string sZurnalas, int nNumeris, out int nBusena, out string sError)*

Metodas grąžina konkrečios UVM pardavimo rezervavimo operacijos būseną.

### Įėjimo parametra

*sZurnalas* – Operacijos žurnalas.

*nNumeris* – Operacijos numeris.

### Išėjimo parametrai

*nBusena* – grąžinama operacijos būsena.

sError – Klaidos tekstas.

### Rezultatas

0 – Nauja operacija (visos operacijos eilutės nėra įvykdytos).

1 – Užsakymas ruošiamas (visos arba dalis operacijos eilučių yra įvykdytos).

2 – Užsakymas vykdomas (iš operacijos padarytas šablonas, tačiau šablonas dar neįvykdytas).

3 – Užsakymas įvykdytas (iš operacijos padarytas šablonas ir šablonas yra įvykdytas).

4 – Užsakymas anuliuotas (arba pats užsakymas arba šablonas yra anuliuoti).

5 – Užsakymas surinktas (užsakymas nėra įvykdytas, tačiau išsiųstas el. laiškas apie tai, kad užsakymas paruoštas).

<a id="getuvmpardranuliuoti"></a>
## 3.60. GetUVMPardRAnuliuoti

### Aprašymas

GetUVMPardRAnuliuoti(string sZurnaluGrupe, DateTime tNuo, DateTime tIki, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError);

GetUVMPardRAnuliuotiXml(string sZurnaluGrupe, DateTime tNuo, DateTime tIki, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError);

Metodas grąžina užsakymų valdymo modulio anuliuotų pardavimų rezervavimų sąrašą.

### Įėjimo parametrai

sZurnaluGrupe – operacijų žurnalų grupė, jei NULL, bus pateiktos visų žurnalų operacijos.

tNuo – operacijos datos intervalo pradžia. Gali būti NULL.

tIki – operacijos datos intervlo pabaiga. Gali būti NULL.

tKoregavimoData – Paskutinio koregavimo data, jei NULL, bus pateikiami visi duomenys.

tSukurimoData – Sukūrimo data, jei NULL, bus pateikiami visi duomenys.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | zurnalas            | Char (10) | Operacijos žurnalas            |
| 2   | padalinys           | Char (10) | Padalinio kodas                |
| 3   | numeris             | Integer   | Operacijos numeris             |
| 3   | dokumentas          | Char(30)  | Operacijos dokumentas          |
| 4   | pavadinimas1        | Char(50)  | Operacijos pavadinimas 1       |
| 5   | pavadinimas2        | Char(50)  | Operacijos pavadinimas 2       |
| 6   | pavadinimas3        | Char(50)  | Operacijos pavadinimas 3       |
| 7   | pavadinimas4        | Char(50)  | Operacijos pavadinimas 4       |
| 8   | pavadinimas5        | Char(50)  | Operacijos pavadinimas 5       |
| 9   | kliento_kodas       | Char(15)  | Operacijos kliento kodas       |
| 10  | kliento_pavadinimas | Char(150) | Operacijos kliento pavadinimas |
| 11  | data                | DateTime  | Operacijos data                |
| 12  | suma                | double    | Operacijos suma                |
| 13  | valiuta             | Char(3)   | Operacijos valiuta             |
| 14  | adresas             | Char(13)  | Operacijos adreso kodas        |
| 15  | sutartis            | Char(13)  | Operacijos sutarties kodas     |
| 16  | operacijos_tipas    | Char(10)  | Operacijos tipo kodas          |

<a id="getuvmpardrivykdyti"></a>
## 3.61. GetUVMPardRIvykdyti

### Aprašymas

GetUVMPardRIvykdyti(string sZurnaluGrupe, DateTime tNuo, DateTime tIki, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError);

GetUVMPardRIvykdytiXml(string sZurnaluGrupe, DateTime tNuo, DateTime tIki, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError);

Metodas grąžina užsakymų valdymo modulio anuliuotų pardavimų rezervavimų sąrašą.

### Įėjimo parametrai

sZurnaluGrupe – operacijų žurnalų grupė, jei NULL, bus pateiktos visų žurnalų operacijos.

tNuo – operacijos datos intervalo pradžia. Gali būti NULL.

tIki – operacijos datos intervlo pabaiga. Gali būti NULL.

tKoregavimoData – Paskutinio koregavimo data, jei NULL, bus pateikiami visi duomenys.

tSukurimoData – Sukūrimo data, jei NULL, bus pateikiami visi duomenys.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | zurnalas            | Char (10) | Operacijos žurnalas            |
| 2   | padalinys           | Char (10) | Padalinio kodas                |
| 3   | numeris             | Integer   | Operacijos numeris             |
| 3   | dokumentas          | Char(30)  | Operacijos dokumentas          |
| 4   | pavadinimas1        | Char(50)  | Operacijos pavadinimas 1       |
| 5   | pavadinimas2        | Char(50)  | Operacijos pavadinimas 2       |
| 6   | pavadinimas3        | Char(50)  | Operacijos pavadinimas 3       |
| 7   | pavadinimas4        | Char(50)  | Operacijos pavadinimas 4       |
| 8   | pavadinimas5        | Char(50)  | Operacijos pavadinimas 5       |
| 9   | kliento_kodas       | Char(15)  | Operacijos kliento kodas       |
| 10  | kliento_pavadinimas | Char(150) | Operacijos kliento pavadinimas |
| 11  | data                | DateTime  | Operacijos data                |
| 12  | suma                | double    | Operacijos suma                |
| 13  | valiuta             | Char(3)   | Operacijos valiuta             |
| 14  | adresas             | Char(13)  | Operacijos adreso kodas        |
| 15  | sutartis            | Char(13)  | Operacijos sutarties kodas     |
| 16  | operacijos_tipas    | Char(10)  | Operacijos tipo kodas          |

<a id="getuvmpardrneivykdyti"></a>
## 3.62. GetUVMPardRNeivykdyti

### Aprašymas

GetUVMPardRNeivykdyti(string sZurnaluGrupe, DateTime tNuo, DateTime tIki, DateTime tKoregavimoData, DateTime tSukurimoData, out DataSet Data, out string sError);

GetUVMPardRNeivykdytiXml(string sZurnaluGrupe, DateTime tNuo, DateTime tIki, DateTime tKoregavimoData, DateTime tSukurimoData, bool writeSchema, out string Xml, out string sError);

Metodas grąžina užsakymų valdymo modulio anuliuotų pardavimų rezervavimų sąrašą.

### Įėjimo parametrai

sZurnaluGrupe – operacijų žurnalų grupė, jei NULL, bus pateiktos visų žurnalų operacijos.

tNuo – operacijos datos intervalo pradžia. Gali būti NULL.

tIki – operacijos datos intervlo pabaiga. Gali būti NULL.

tKoregavimoData – Paskutinio koregavimo data, jei NULL, bus pateikiami visi duomenys.

tSukurimoData – Sukūrimo data, jei NULL, bus pateikiami visi duomenys.

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas.

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | zurnalas            | Char (10) | Operacijos žurnalas            |
| 2   | padalinys           | Char (10) | Padalinio kodas                |
| 3   | numeris             | Integer   | Operacijos numeris             |
| 3   | dokumentas          | Char(30)  | Operacijos dokumentas          |
| 4   | pavadinimas1        | Char(50)  | Operacijos pavadinimas 1       |
| 5   | pavadinimas2        | Char(50)  | Operacijos pavadinimas 2       |
| 6   | pavadinimas3        | Char(50)  | Operacijos pavadinimas 3       |
| 7   | pavadinimas4        | Char(50)  | Operacijos pavadinimas 4       |
| 8   | pavadinimas5        | Char(50)  | Operacijos pavadinimas 5       |
| 9   | kliento_kodas       | Char(15)  | Operacijos kliento kodas       |
| 10  | kliento_pavadinimas | Char(150) | Operacijos kliento pavadinimas |
| 11  | data                | DateTime  | Operacijos data                |
| 12  | suma                | double    | Operacijos suma                |
| 13  | valiuta             | Char(3)   | Operacijos valiuta             |
| 14  | adresas             | Char(13)  | Operacijos adreso kodas        |
| 15  | sutartis            | Char(13)  | Operacijos sutarties kodas     |
| 16  | operacijos_tipas    | Char(10)  | Operacijos tipo kodas          |

<a id="getklientosaskaitas"></a>
## 3.63. GetKlientoSaskaitas

### Aprašymas

GetKlientoSaskaitas(string sKlientas, string sKlientImonesKodas, string sKlientuGrupe, int nSkolosTipas, string sZurnaluGrupe, string sSerija, int nOperacijosTipas, DateTime tDokumentoDataNuo, DateTime tDokumentoDataIki, out DataSet Data, out string sError);

GetKlientoSaskaitasXml(string sKlientas, string sKlientImonesKodas, string sKlientuGrupe, int nSkolosTipas, string sZurnaluGrupe, string sSerija, int nOperacijosTipas, DateTime tDokumentoDataNuo, DateTime tDokumentoDataIki, bool writeSchema, out string Xml, out string sError);

Metodas gražina kliento sąskaitas

### Įėjimo parametrai

sKlientas – kliento kodas

sKlientImonesKodas – kliento įmonės kodas

sKlientuGrupe – klientų grupės kodas

nSkolosTipas – skolos tipas, 2 – tik neatsiskaitytos, 1 – tik atsiskaitytos, kitu atveju visos.

sZurnaluGrupe – operacijų žurnalų grupė, jei NULL, bus pateiktos visų žurnalų operacijos.

sSerija - operacijos serija

nOperacijosTipas – operacijos tipas (0 - įplaukos, 1 - išmokos, 2 - pirkimai, 3 - pardavimai, 4 - pirkimų grąžinimai, 5 - pardavimų grąžinimai)

tDokumentoDataNuo – dokumento data nuo

tDokumentoDataIki – dokumento data iki

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

### Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | operacija       | Int      | Operacijos tipas (0 - įplaukos, 1 - išmokos, 2 - pirkimai, 3 - pardavimai, 4 - pirkimų grąžinimai, 5 - pardavimų grąžinimai) |
| 2   | operacijos_id   | Long     | Operacijos raktas                                                                                                            |
| 3   | zurnalas        | Char     | Operacijos žurnalas                                                                                                          |
| 4   | padalinys       | Char     | Padalinio kodas                                                                                                              |
| 5   | numeris         | Integer  | Operacijos numeris                                                                                                           |
| 6   | op_tipas        | Char     | Operacijos tipo kodas                                                                                                        |
| 7   | serija          | Char     | Serija                                                                                                                       |
| 8   | dokumentas      | Char     | Operacijos dokumentas                                                                                                        |
| 9   | data            | DateTime | Operacijos data                                                                                                              |
| 10  | mod_data        | DateTime | Mokėjimo data                                                                                                                |
| 11  | klientas        | Char     | Kliento kodas                                                                                                                |
| 12  | im_kodas        | Char     | Kliento imones kodas                                                                                                         |
| 13  | suma_eur        | Double   | Suma eur                                                                                                                     |
| 14  | suma_valiuta    | Double   | Suma valiuta                                                                                                                 |
| 15  | likutis_eur     | Double   | Likutis eur                                                                                                                  |
| 16  | likutis_valiuta | Double   | Likutis valiuta                                                                                                              |
| 17  | valiuta         | Char(3)  | Valiutos kodas                                                                                                               |
| 18  | atsisk          | Int      | 0 – neatsiskaityta, 1 – atsiskaityta                                                                                         |
| 19  | atsisk_data     | DateTime | Atsiskaitymo data                                                                                                            |

<a id="getprekesistorija"></a>
## 3.64. GetPrekesIstorija

###  Aprašymas

GetPrekesIstorija(string sPreKod, string sSandKod, object tDataNuo, out DataSet Data, out string sError);

GetPrekesIstorijaXml(string sPreKod, string sSandKod, object tDataNuo, bool writeSchema, out string Xml, out string sError)

Metodas gražina prekių įstoriją

###  Įėjimo parametrai

sPreKod – prekės kodas

sSandKod – sandėlio kodas

tDataNuo – data nuo

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

###  Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas

###  Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | op_tipid     | Short  | Operacijos tipas              |
| 2   | op_id        | Int    | Operacijos ID                 |
| 3   | op_rusis_pav | String | Operacijos rūšies pavadinimas |
| 4   | zurnalas     | String | Operacijos žurnalo kodas      |
| 5   | op_numeris   | Int    | Operacijos numeris            |
| 6   | op_data      | Date   | Operacijos data               |
| 7   | dok_numeris  | String | Operacijos dokumentas         |
| 8   | klientas     | String | Kliento kodas                 |
| 9   | sandelis     | String | Sandėlio kodas                |
| 10  | prekes       | String | Prekės kodas                  |
| 11  | kiekis       | Double | Kiekis                        |
| 12  | savikaina    | Double | Savikaina                     |
| 13  | mok_data     | Date   | Mokėjimo data                 |
| 14  | dok_data     | Date   | Dokumento data                |

<a id="getveiklapagalobjektus"></a>
## 3.65. GetVeiklaPagalObjektus

### Aprašymas

GetVeiklaPagalObjektus(string sParam, out DataSet Data, out string sError);

GetVeiklaPagalObjektusXml(string sParam, out string Xml, out string sError)

###  Įėjimo parametrai

writeSchema – nurodoma ar įtraukti XML schemą į grąžintiną XML.

sParam – funkcijos parametrai surašyti xml arba json formatu:

```xml
<root>
<DataNuo>2019-09-09</DataNuo><DataIki>2019-12-31</DataIki>
<sKlientas></sKlientas><sObjektas1></sObjektas1><sObjektas2></sObjektas2>
<sObjektas3></sObjektas3><sObjektas4></sObjektas4><sObjektas5></sObjektas5>
<sObjektas6></sObjektas6>
</root>
```

*Arba*

```json
{
“ DataNuo“:“2019-01-01“, “ DataIki“:null, “ sKlientas“:““, sObjektas1“:““, sObjektas2“:““, sObjektas3“:““,
```

sObjektas4“:““, sObjektas5“:““, sObjektas6“:““

```json
}
```

###  Išėjimo parametrai

Data – grąžinami duomenys DataSet objekte;

Xml – grąžinami duomenys Xml formatu, string tipu;

sError – Klaidos tekstas

### Rezultatas

| Nr. | Laukas | Tipas | Aprašymas |
| --- | --- | --- | --- |
| 1   | op_date            | Date   | Operacijos data           |
| 2   | op_tipas           | Int    | Operacijos tipas          |
| 3   | op_numeris         | Int    | Operacijos numeris        |
| 4   | zurnalas           | String | Operacijos žurnalo kodas  |
| 5   | klientas           | String | Kliento kodas             |
| 6   | dokumentas         | String | Operacijos dokumentas     |
| 7   | tipas              | Int    | Prekes/paslaugos/kt tipas |
| 8   | prekes_kodas       | String | Prekės kodas              |
| 9   | prekes_pavadinimas | String | Prekės pavadinimas        |
| 10  | debitas            | Double | Suma debite               |
| 11  | kreditas           | Double | Suma kredite              |
| 12  | pvm                | Double | Pvm suma                  |
| 13  | kiekis             | Int    | Kiekis                    |

<a id="insertnewitem"></a>
## 3.66. InsertNewItem

### Aprašymas

```csharp
InsertNewItem(string ItemClassName, string xmlString, out int nResult, out string sError)
```

Metodas įterpia naują įrašą i Finvaldos duomenų bazę.

Pastabos:

- Aprašymo kodas ‚sKodas‘ yra sudaromas iš didžiųjų raidžių ir skaitmenų, kitu atveju aprašymo sukūrimas bus atmestas.

### Įėjimo parametrai

| Pavadinimas | Tipas | Reikšmė |
| --- | --- | --- |
| ItemClassName | string | Įterpiamo įrašo klasės pavadinimas:<br>Fvs.Preke – prekė,<br>Fvs.Paslauga – paslauga,<br>Fvs.Klientas – klientas,<br>Fvs.Adresas – adresas,<br>Fvs.ObjektasI; Fvs.ObjektasII; Fvs.ObjektasIII; Fvs.ObjektasIV; Fvs.ObjektasV; Fvs.ObjektasVI – objektai,<br>Fvs.Bankas – bankas,<br>Fvs.KlientoRusis – kliento rūšis,<br>Fvs.KlientoIPoz; Fvs.KlientoIIPoz; Fvs.KlientoIIIPoz – kliento požymiai,<br>Fvs.AtsTerminas – atsiskaitymo terminas,<br>Fvs.Sandelis – sandėlis.<br>Fvs.PrekesRusis – prekės rūšis<br>Fvs.PrekesPoz1, Fvs.PrekesPoz2 ... Fvs.PrekesPoz20 – prekės požymiai. |
| xmlString | string | XML failo turinys |

Visų objektų laukų pavadinimai atitinka XML failo tag‘us.

### Išėjimo parametrai

*nResult* – Klaidos kodas (žr. I priedą);

*sError* – Klaidos tekstas.

**Visose lentelėse:**

1.  Lauko tipas;

2.  Lauko pavadinimas;

3.  Lauko aprašymas;

4.  Lauko ilgis (jei tai tekstinis laukas);

5.  Ar laukas būtinas;

6.  Ar laukas yra užpildomas importuojant į Finvaldą su nurodytu parametru;

7.  Lauko pastabos;

#### Fvs.Preke

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sFvsImportoParametras   | importo parametras                                             |     |     |     |                                |
| String^ | sKodas                  | prekės kodas                                                   | 20  | +  |     |                                |
| String^ | sPavadinimas            | prekės pavadinimas                                             | 50  | +  |     |                                |
| String^ | sBarKodas               | prekės spec. kodas                                             | 13  |     |     | dažniausiai BAR kodas          |
| String^ | sPastaba                | pastabos apie prekę                                            | 100 |     |     |                                |
| String^ | sRysysSuSask            | prekės ryšio su sąskaitomis kodas                              | 10  | +  | +  |                                |
| String^ | sMatavimoVnt            | prekės mato vieneto kodas                                      | 10  | +  | +  |                                |
| String^ | sMokestis               | prekės PVM mokesčio kodas                                      | 10  | +  | +  |                                |
| String^ | sInformacija            | papildoma informacija                                          | 10  |     |     |                                |
| String^ | sRusis                  | prekės rūšies kodas                                            | 13  |     |     |                                |
| String^ | sPozymis1               | pirmo prekės požymio kodas                                     | 13  |     |     |                                |
| String^ | sPozymis2               | antro prekės požymio kodas                                     | 13  |     |     |                                |
| String^ | sPozymis3               | trečio prekės požymio kodas                                    | 13  |     |     |                                |
| String^ | sPozymis4               | ketvirto prekės požymio kodas                                  | 13  |     |     |                                |
| String^ | sPozymis5               | penkto prekės požymio kodas                                    | 13  |     |     |                                |
| String^ | sPozymis6               | šešto prekės požymio kodas                                     | 13  |     |     |                                |
| String^ | sValiuta                | prekės pardavimo valiuta                                       | 3   |     |     | pagal nutylėjimą - nacionalinė |
| String^ | sIntrastatKodas         | prekės intrastat kodas                                         | 20  |     |     |                                |
| double  | dKaina1                 | pirma prekės pardavimo kaina                                   |     |     |     |                                |
| double  | dKaina2                 | antra prekės pardavimo kaina                                   |     |     |     |                                |
| double  | dKaina3                 | trečia prekės pardavimo kaina                                  |     |     |     |                                |
| double  | dKaina4                 | ketvirta prekės pardavimo kaina                                |     |     |     |                                |
| double  | dKaina5                 | penkta prekės pardavimo kaina                                  |     |     |     |                                |
| double  | dKaina6                 | šešta prekės pardavimo kaina                                   |     |     |     |                                |
| double  | dNeto                   | neto                                                           |     |     |     |                                |
| double  | dBruto                  | bruto                                                          |     |     |     |                                |
| double  | dTuris                  | tūris                                                          |     |     |     |                                |
| double  | dAntkainis              | prekei taikomas antkainis                                      |     |     |     |                                |
| long    | nAktyvi                 | ar prekė aktyvi                                                |     |     |     | Pagal nutylėjimą – 1           |
| double  | dPirkimoKaina           | prekės pirkimo kaina                                           |     |     |     |                                |
| String^ | sPirkimoValiuta         | prekės pirkimo valiuta                                         | 3   |     |     | pagal nutylėjimą - nacionalinė |
| String^ | sUrl                    | nuoroda į prekę                                                | 255 |     |     |                                |
| String^ | sObjektas1              | pirmas prekės objektas                                         | 10  |     |     |                                |
| String^ | sObjektas2              | antras prekės objektas                                         | 10  |     |     |                                |
| String^ | sObjektas3              | trečias prekės objektas                                        | 10  |     |     |                                |
| String^ | sObjektas4              | ketvirtas prekės objektas                                      | 10  |     |     |                                |
| long    | nYraPakuote             | ar prekė yra pakuotė                                           |     |     |     | pagal nutylėjimą - 0           |
| long    | nYraPUI                 | ar prekei vedama papildoma unikali informacija                 |     |     |     | pagal nutylėjimą - 0           |
| long    | nIvedamaGalData         | ar prekei vedama galiojimo data                                |     |     |     | pagal nutylėjimą - 0           |
| long    | nSudetine               | ar prekė yra sudėtinė                                          |     |     |     | pagal nutylėjimą - 0           |
| long    | nSavikainosSkaicMetodas | prekės savikainos skaičiavimo metodas                          |     |     |     | pagal nutylėjimą - FIFO        |
| double  | dPakPo1                 | popierinės pirminės pakuotės kiekis tenkantis prekės vienetui  |     |     |     |                                |
| double  | dPakPo2                 | antrinės pakuotės kiekis tenkantis prekės vienetui             |     |     |     |                                |
| double  | dPakSt1                 | stiklinės pirminės pakuotės kiekis tenkantis prekės vienetui   |     |     |     |                                |
| double  | dPakSt2                 | stiklinės antrinės pakuotės kiekis tenkantis prekės vienetui   |     |     |     |                                |
| double  | dPakMe1                 | metalinės pirminės pakuotės kiekis tenkantis prekės vienetui   |     |     |     |                                |
| double  | dPakMe2                 | metalinės antrinės pakuotės kiekis tenkantis prekės vienetui   |     |     |     |                                |
| double  | dPakPl1                 | plastikinės pirminės pakuotės kiekis tenkantis prekės vienetui |     |     |     |                                |
| double  | dPakPl2                 | plastikinės antrinės pakuotės kiekis tenkantis prekės vienetui |     |     |     |                                |
| double  | dPakKo1                 | kombinuotos pirminės pakuotės kiekis tenkantis prekės vienetui |     |     |     |                                |
| double  | dPakKo2                 | kombinuotos antrinės pakuotės kiekis tenkantis prekės vienetui |     |     |     |                                |
| double  | dPakKi1                 | kitos pirminės pakuotės kiekis tenkantis prekės vienetui       |     |     |     |                                |
| double  | dPakKi2                 | kitos antrinės pakuotės kiekis tenkantis prekės vienetui       |     |     |     |                                |
| long    | nMinimalusKiekis        | minimalus prekės kiekis sandėliuose                            |     |     |     |                                |
| long    | nUzsakomaPrekiu         | jei kiekis mažesnis už minimalų, užsakoma prekių               |     |     |     |                                |
| String^ | sTiekejas1              | pirmas prekės tiekėjas                                         | 15  |     |     |                                |
| String^ | sPreKodTiek1Kataloge    | prekės kodas pirmojo tiekėjo kataloge                          | 20  |     |     |                                |
| String^ | sTiekejas2              | antras prekės tiekėjas                                         | 15  |     |     |                                |
| String^ | sPreKodTiek2Kataloge    | prekės kodas antrojo tiekėjo kataloge                          | 20  |     |     |                                |
| String^ | sTiekejas3              | trečias prekės tiekėjas                                        | 15  |     |     |                                |
| String^ | sPreKodTiek3Kataloge    | prekės kodas trečiojo tiekėjo kataloge                         | 20  |     |     |                                |
| String^ | sKilmesSalis            | Prekės kilmės šalis                                            | 3   |     |     |                                |

Pvz:

```xml
<Fvs.Preke>
<sFvsImportoParametras> </sFvsImportoParametras>
<sKodas></sKodas>
<sPavadinimas> </sPavadinimas>
<sBarKodas></sBarKodas>
<sPastaba></sPastaba>
<dKaina1></dKaina1>
<dKaina2></dKaina2>
```

...

```xml
</Fvs.Preke>
```

#### Fvs.Paslauga

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sFvsImportoParametras | importo parametras                   |     |     |     |                                        |
| String^ | sKodas                | paslaugos kodas                      | 13  | +  |     |                                        |
| String^ | sPavadinimas          | paslaugos pavadinimas                | 50  | +  |     |                                        |
| String^ | sBARKodas             | specialus paslaugos kodas            | 20  |     |     | dažniausiai naudojamas, kaip BAR kodas |
| String^ | sPastaba              | pastabos apie paslaugą               | 60  |     |     |                                        |
| String^ | sRysysSuSask          | paslaugos ryšio su sąskaitomis kodas | 10  | +  | +  |                                        |
| String^ | sMokestis             | paslaugos PVM mokesčio kodas         | 10  | +  | +  |                                        |
| String^ | sMatVienetas          | paslaugos matavimo vienetas          | 10  |     |     |                                        |
| double  | dPirkimoKaina         | paslaugos pirkimo kaina              |     |     |     | nacionaline valiuta                    |
| double  | dPardavimoKaina       | paslaugos pardavimo kaina            |     |     |     | nacionaline valiuta                    |
| String^ | sPastabos1            | paslaugos pastabos                   | 60  |     |     |                                        |
| String^ | sPastabos2            | paslaugos pastabos                   | 60  |     |     |                                        |
| String^ | sPastabos3            | paslaugos pastabos                   | 60  |     |     |                                        |
| String^ | sPastabos4            | paslaugos pastabos                   | 60  |     |     |                                        |
| String^ | sPastabos5            | paslaugos pastabos                   | 60  |     |     |                                        |
| String^ | sPastabos6            | paslaugos pastabos                   | 60  |     |     |                                        |
| String^ | sPastabos7            | paslaugos pastabos                   | 60  |     |     |                                        |
| String^ | sPastabos8            | paslaugos pastabos                   | 60  |     |     |                                        |
| String^ | sPastabos9            | paslaugos pastabos                   | 60  |     |     |                                        |
| String^ | sPastabos10           | paslaugos pastabos                   | 60  |     |     |                                        |
| String^ | sPastabos11           | paslaugos pastabos                   | 60  |     |     |                                        |
| String^ | sPastabos12           | paslaugos pastabos                   | 60  |     |     |                                        |
| long    | nAktyvi               | ar paslauga                          |     |     |     | pagal nutylėjimą - 1                   |
| String^ | sObjektas1            | pirmas paslaugos objektas            | 10  |     |     |                                        |
| String^ | sObjektas2            | antras paslaugos objektas            | 10  |     |     |                                        |
| String^ | sObjektas3            | trečias paslaugos objektas           | 10  |     |     |                                        |
| String^ | sObjektas4            | ketvirtas paslaugos objektas         | 10  |     |     |                                        |
| String^ | sRusis                | paslaugos rūšies kodas               | 13  |     |     |                                        |
| String^ | sPozymis1             | pirmo paslaugos požymio kodas        | 13  |     |     |                                        |
| String^ | sPozymis2             | antro paslaugos požymio kodas        | 13  |     |     |                                        |
| String^ | sPozymis3             | trečio paslaugos požymio kodas       | 13  |     |     |                                        |

Pvz:

```xml
<Fvs.Paslauga>
<sFvsImportoParametras></sFvsImportoParametras>
<sKodas></sKodas>
<sPavadinimas></sPavadinimas>
<sBARKodas></sBARKodas>
<sPastaba></sPastaba>
<dPardavimoKaina></dPardavimoKaina>
<dPirkimoKaina></dPirkimoKaina>
</Fvs.Paslauga>
```

#### Fvs.Klientas

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sFvsImportoParametras     | importo parametras                                                      |     |     |     |                                   |
| String^ | sKodas                    | kliento kodas                                                           | 15  | +  |     |                                   |
| String^ | sPavadinimas              | kliento pavadinimas                                                     | 100 | +  |     |                                   |
| String^ | sAdresas                  | kliento adresas                                                         | 90  |     |     |                                   |
| String^ | sTelefonas                | kliento telefonas                                                       | 15  |     |     |                                   |
| String^ | sFaksas                   | kliento faksas                                                          | 15  |     |     |                                   |
| String^ | sAtsakingasAsmuo          | kliento atsakingas asmuo                                                | 50  |     |     |                                   |
| String^ | sAtsiskaitymoTerminaiDebt | debitoriaus atsiskaitymop terminas                                      | 10  |     |     |                                   |
| double  | dDelspinigiaiDebt         | delspinigiai, jei laiku neatsiskaito pagal sAtsiskaitymoTerminaiDebt    |     |     |     |                                   |
| String^ | sAtsiskaitymoTerminaiKred | kreditoriaus atsiskaitymo terminas                                      | 10  |     |     |                                   |
| double  | dDelspinigiaiKred         | delspinigiai, jei laiku neatsiskaito pagal sAtsiskaitymoTerminaiKred    |     |     |     |                                   |
| String^ | sPvmMokKod                | kliento PVM mokesčio kodas                                              | 15  | +  | +  |                                   |
| String^ | sDebtSask                 | debitorinės kliento sąskaitos kodas                                     | 20  | +  | +  |                                   |
| String^ | sKredSask                 | kreditorinės kliento sąskaitos kodas                                    | 20  | +  | +  |                                   |
| long    | nKreditas                 | skiriamas kreditas debitoriui                                           |     |     |     |                                   |
| String^ | sBankas                   | kliento banko kodas                                                     | 20  |     |     |                                   |
| String^ | sBankoSaskaita            | kliento banko sąskaitos numeris                                         | 35  |     |     |                                   |
| String^ | sKorespSaskBank           | kliento korespondentinė sąskaita banke                                  | 35  |     |     |                                   |
| long    | nTipas                    | kliento tipas: 0 - dokumento tipo klientas, 1 - sąskaitos tipo klientas |     |     |     | pagal nutylėjimą – dokumento tipo |
| String^ | sImKodas                  | kliento įmonės kodas                                                    | 13  |     |     |                                   |
| String^ | sPvmMoketojoKod           | kliento PVM mokėtojo kodas                                              | 30  |     |     |                                   |
| String^ | sPastabos                 | pastabos apie klientą                                                   | 60  |     |     |                                   |
| String^ | sRusis                    | kliento rūšies kodas                                                    | 10  |     |     |                                   |
| String^ | sEMail                    | kliento elektroninio pašto adresas                                      | 30  |     |     |                                   |
| long    | nMaksPradlestosSkolosSum  | maksimali pradelstos skolos suma                                        |     |     |     |                                   |
| long    | nSkolaGalimaPradelstiDien | skolą galima pradelsti dienų                                            |     |     |     |                                   |
| long    | nAktyvus                  | ar klientas yra aktyvus                                                 |     |     |     | pagal nutylėjimą - 1              |
| String^ | sPasiulomaValiuta         | pasiūloma valiuta sandėlio operacijose                                  | 3   |     |     |                                   |
| String^ | sYraKlientoPadalinys      | Kodas fvs kliento, kuris turi tokį patį įmonės kodą.                    | 15  |     |     |                                   |
| String^ | sObjektas1                | pirmo objekto kodas                                                     | 10  |     |     |                                   |
| String^ | sObjektas2                | antro objekto kodas                                                     | 10  |     |     |                                   |
| String^ | sObjektas3                | trečio objekto kodas                                                    | 10  |     |     |                                   |
| String^ | sObjektas4                | ketvirto objekto kodas                                                  | 10  |     |     |                                   |
| String^ | sPozymis1                 | pirmo kliento požymio kodas                                             | 13  |     |     |                                   |
| String^ | sPozymis2                 | antro kliento požymio kodas                                             | 13  |     |     |                                   |
| String^ | sPozymis3                 | trečio kliento požymio kodas                                            | 13  |     |     |                                   |
| double  | dPapildomaInf             | papildoma informacija                                                   |     |     |     |                                   |
| String^ | sValstybe                 | Valstybė                                                                | 20  |     |     |                                   |
| String^ | sValstybeKodas            | Valstybės ISO kodas                                                     | 3   |     |     |                                   |
| String^ | sMiestas                  | Miestas                                                                 | 20  |     |     |                                   |
| String^ | sPastoKodas               | Pašto kodas                                                             | 20  |     |     |                                   |
| long    | nSiustiFakturas           | Faktūras siųsti el. paštu: 0 – ne, 1 - taip                             |     |     |     |                                   |
| long    | nPvmMokaPirkejas          | Pvm mokestį moka pirkėjas: 0 – ne, 1 - taip                             |     |     |     |                                   |
| int     | nFizinisAsmuo             | Klientas yra fizinis asmuo: 1 -taip, 0 - ne                             |     |     |     |                                   |
| int     | nAtkreiptiDemesi          | 0 – ne, 1 - taip                                                        |     |     |     |                                   |

Pvz:

```xml
<Fvs.Klientas>
<sFvsImportoParametras></sFvsImportoParametras>
<sKodas></sKodas>
<sPavadinimas></sPavadinimas>
<sTelefonas></sTelefonas>
<sPastabos></sPastabos>
</Fvs.Klientas>
```

#### Fvs.Adresas

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sKodas         | adreso kodas               | 13  | +  |     |     |
| String^ | sKlientoKodas  | kliento kodas              | 15  | +  |     |     |
| String^ | sAdresas       | adreso tekstas             | 50  | +  |     |     |
| String^ | sPapildomaInf1 | papildoma informacija      | 50  |     |     |     |
| String^ | sPapildomaInf2 | papildoma informacija      | 50  |     |     |     |
| String^ | sPapildomaInf3 | papildoma informacija      | 50  |     |     |     |
| Double  | dKiekis        | kiekis                     |     |     |     |     |
| Double  | dTalpa         | talpa                      |     |     |     |     |
| String^ | sMiestas       | miestas                    | 30  |     |     |     |
| String^ | sValstybe      | valstybė                   | 30  |     |     |     |
| String^ | sElPastoAdr    | elektroninio pašto adresas | 50  |     |     |     |
| String^ | sTelefonoNr    | telefono numeris           | 20  |     |     |     |
| String^ | sPastoIndeksas | pašto indeksas             | 20  |     |     |     |
| String^ | sPozymis1      | pirmas požymis             | 13  |     |     |     |
| String^ | sPozymis2      | antras požymis             | 13  |     |     |     |
| String^ | sPozymis3      | trečias požymis            | 13  |     |     |     |

Pvz:

```xml
<Fvs.Adresas>
<sKodas></sKodas>
<sKlientoKodas></ sKlientoKodas >
< sAdresas ></ sAdresas >
< sPapildomaInf1></ sPapildomaInf1>
<sValstybe></sValstybe>
</Fvs.Adresas>
```

#### Fvs.ObjektasI

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^  | sKodas          | objekto kodas                   | 10  | +  |     |     |
| String^  | sPavadinimas    | objekto pavadinimas             | 50  | +  |     |     |
| String^  | sPavadinimas2   | papildoma informacija           | 100 |     |     |     |
| String^  | sPapildomaInf1  | papildoma informacija           | 50  |     |     |     |
| String^  | sPapildomaInf2  | papildoma informacija           | 50  |     |     |     |
| String^  | sPapildomaInf3  | papildoma informacija           | 50  |     |     |     |
| String^  | sPapildomaInf4  | papildoma informacija           | 50  |     |     |     |
| String^  | sPapildomaInf5  | papildoma informacija           | 50  |     |     |     |
| String^  | sPapildomaInf6  | papildoma informacija           | 50  |     |     |     |
| String^  | sPapildomaInf7  | papildoma informacija           | 50  |     |     |     |
| String^  | sPapildomaInf8  | papildoma informacija           | 50  |     |     |     |
| String^  | sPapildomaInf9  | papildoma informacija           | 50  |     |     |     |
| String^  | sPapildomaInf10 | papildoma informacija           | 50  |     |     |     |
| String^  | sRusis          | objekto rūšis                   | 10  |     |     |     |
| String^  | sPozymis1       | pirmas požymis                  | 10  |     |     |     |
| String^  | sPozymis2       | antras požymis                  | 10  |     |     |     |
| String^  | sPozymis3       | trečias požymis                 | 10  |     |     |     |
| bool     | bGaliojimas     | ar objekto galiojimas ribojamas |     |     |     |     |
| DateTime | tGaliojaNuo     | galiojimo pradžia               |     |     |     |     |
| DateTime | tGaliojaIki     | galiojimo pabaiga               |     |     |     |     |

Pvz:

```xml
<Fvs.ObjektasI>
<sKodas></sKodas>
<sPavadinimas></sPavadinimas>
<sPavadinimas2></sPavadinimas2>
<sPapildomaInf1></sPapildomaInf1>
<sRusis></sRusis>
</Fvs.ObjektasI>
```

#### Fvs.ObjektasII

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^  | sKodas          | objekto kodas                   | 10  | +  |     |     |
| String^  | sPavadinimas    | objekto pavadinimas             | 50  | +  |     |     |
| String^  | sPapildomaInf1  | papildoma informacija           | 50  |     |     |     |
| String^  | sPapildomaInf2  | papildoma informacija           | 50  |     |     |     |
| String^  | sPapildomaInf3  | papildoma informacija           | 50  |     |     |     |
| String^  | sPapildomaInf4  | papildoma informacija           | 50  |     |     |     |
| String^  | sPapildomaInf5  | papildoma informacija           | 50  |     |     |     |
| String^  | sPapildomaInf6  | papildoma informacija           | 50  |     |     |     |
| String^  | sPapildomaInf7  | papildoma informacija           | 50  |     |     |     |
| String^  | sPapildomaInf8  | papildoma informacija           | 50  |     |     |     |
| String^  | sPapildomaInf9  | papildoma informacija           | 50  |     |     |     |
| String^  | sPapildomaInf10 | papildoma informacija           | 50  |     |     |     |
| String^  | sRusis          | objekto rūšis                   | 10  |     |     |     |
| String^  | sPozymis1       | pirmas požymis                  | 10  |     |     |     |
| String^  | sPozymis2       | antras požymis                  | 10  |     |     |     |
| String^  | sPozymis3       | trečias požymis                 | 10  |     |     |     |
| bool     | bGaliojimas     | ar objekto galiojimas ribojamas |     |     |     |     |
| DateTime | tGaliojaNuo     | galiojimo pradžia               |     |     |     |     |
| DateTime | tGaliojaIki     | galiojimo pabaiga               |     |     |     |     |

Pvz:

```xml
<Fvs.ObjektasII>
<sKodas></sKodas>
<sPavadinimas></sPavadinimas>
<sPapildomaInf1></sPapildomaInf1>
<sRusis></sRusis>
</Fvs.ObjektasII>
```

#### Fvs.ObjektasIII

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^  | sKodas         | objekto kodas                   | 10  | +  |     |     |
| String^  | sPavadinimas   | objekto pavadinimas             | 50  | +  |     |     |
| String^  | sPapildomaInf1 | papildoma informacija           | 50  |     |     |     |
| String^  | sPapildomaInf2 | papildoma informacija           | 50  |     |     |     |
| bool     | bGaliojimas    | ar objekto galiojimas ribojamas |     |     |     |     |
| DateTime | tGaliojaNuo    | galiojimo pradžia               |     |     |     |     |
| DateTime | tGaliojaIki    | galiojimo pabaiga               |     |     |     |     |

Pvz:

```xml
<Fvs.ObjektasIII>
<sKodas></sKodas>
<sPavadinimas></sPavadinimas>
<sPapildomaInf1></sPapildomaInf1>
<sPapildomaInf2></sPapildomaInf2>
</Fvs.ObjektasIII>
```

#### Fvs.ObjektasIV

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^  | sKodas         | objekto kodas                   | 10  | +  |     |     |
| String^  | sPavadinimas   | objekto pavadinimas             | 50  | +  |     |     |
| String^  | sPapildomaInf1 | papildoma informacija           | 50  |     |     |     |
| String^  | sPapildomaInf2 | papildoma informacija           | 50  |     |     |     |
| bool     | bGaliojimas    | ar objekto galiojimas ribojamas |     |     |     |     |
| DateTime | tGaliojaNuo    | galiojimo pradžia               |     |     |     |     |
| DateTime | tGaliojaIki    | galiojimo pabaiga               |     |     |     |     |

Pvz:

```xml
<Fvs.ObjektasIV>
<sKodas></sKodas>
<sPavadinimas></sPavadinimas>
<sPapildomaInf1></sPapildomaInf1>
<sPapildomaInf2></sPapildomaInf2>
</Fvs.ObjektasIV>
```

#### Fvs.ObjektasV

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^  | sKodas         | objekto kodas                   | 10  | +  |     |     |
| String^  | sPavadinimas   | objekto pavadinimas             | 50  | +  |     |     |
| String^  | sPapildomaInf1 | papildoma informacija           | 50  |     |     |     |
| String^  | sPapildomaInf2 | papildoma informacija           | 50  |     |     |     |
| bool     | bGaliojimas    | ar objekto galiojimas ribojamas |     |     |     |     |
| DateTime | tGaliojaNuo    | galiojimo pradžia               |     |     |     |     |
| DateTime | tGaliojaIki    | galiojimo pabaiga               |     |     |     |     |

Pvz:

```xml
<Fvs.ObjektasV>
<sKodas></sKodas>
<sPavadinimas></sPavadinimas>
<sPapildomaInf1></sPapildomaInf1>
<sPapildomaInf2></sPapildomaInf2>
</Fvs.ObjektasV>
```

#### Fvs.ObjektasVI

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^  | sKodas         | objekto kodas                   | 10  | +  |     |     |
| String^  | sPavadinimas   | objekto pavadinimas             | 50  | +  |     |     |
| String^  | sPapildomaInf1 | papildoma informacija           | 50  |     |     |     |
| String^  | sPapildomaInf2 | papildoma informacija           | 50  |     |     |     |
| bool     | bGaliojimas    | ar objekto galiojimas ribojamas |     |     |     |     |
| DateTime | tGaliojaNuo    | galiojimo pradžia               |     |     |     |     |
| DateTime | tGaliojaIki    | galiojimo pabaiga               |     |     |     |     |

Pvz:

```xml
<Fvs.ObjektasVI>
<sKodas></sKodas>
<sPavadinimas></sPavadinimas>
<sPapildomaInf1></sPapildomaInf1>
<sPapildomaInf2></sPapildomaInf2>
</Fvs.ObjektasVI>
```

#### Fvs.Bankas

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sKodas              | Banko kodas                   | 20  | +  |     |     |
| String^ | sPavadinimas        | Banko pavadinimas             | 50  | +  |     |     |
| String^ | sGatve              | Gatvė (adresas)               | 60  |     |     |     |
| String^ | sMiestas            | Miestas                       | 60  |     |     |     |
| String^ | sValstybe           | Valstybė                      | 50  |     |     |     |
| String^ | sSWIFT              | SWIFT kodas                   | 20  |     |     |     |
| String^ | sKoesrespBankoKodas | Koresponduojančio banko kodas | 20  |     |     |     |

Pvz:

```xml
<Fvs.Bankas>
<sKodas></sKodas>
<sPavadinimas></sPavadinimas>
<sGatve></sGatve>
<sMiestas></sMiestas>
<sValstybe></sValstybe>
<sSWIFT></sSWIFT>
<sKoesrespBankoKodas></sKoesrespBankoKodas>
</Fvs.Bankas>
```

#### Fvs.KlientoRusis

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sKodas         | Kliento rūšies kodas       | 10  | +  |     |     |
| String^ | sPavadinimas   | Kliento rūšies pavadinimas | 50  | +  |     |     |
| String^ | sPapildomaInf1 | papildoma informacija      | 100 |     |     |     |
| String^ | sPapildomaInf2 | papildoma informacija      | 100 |     |     |     |

Pvz:

```xml
<Fvs.KlientoRusis>
<sKodas></sKodas>
<sPavadinimas></sPavadinimas>
<sPapildomaInf1></sPapildomaInf1>
<sPapildomaInf2></sPapildomaInf2>
</Fvs.KlientoRusis>
```

#### Fvs.KlientoIPoz; Fvs.KlientoIIPoz; Fvs.KlientoIIIPoz

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sKodas         | Kliento požymio kodas       | 10  | +  |     |     |
| String^ | sPavadinimas   | Kliento požymio pavadinimas | 50  | +  |     |     |
| String^ | sPapildomaInf1 | papildoma informacija       | 100 |     |     |     |
| String^ | sPapildomaInf2 | papildoma informacija       | 100 |     |     |     |

Pvz:

```xml
<Fvs.KlientoIPoz>
<sKodas></sKodas>
<sPavadinimas></sPavadinimas>
<sPapildomaInf1></sPapildomaInf1>
<sPapildomaInf2></sPapildomaInf2>
</Fvs.KlientoIPoz>
```

#### Fvs.AtsTerminas

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sKodas                    | Atsiskaitymo termino kodas                                                           | 10  | +  |     |     |
| String^ | sPavadinimas              | Atsiskaitymo termino pavadinimas                                                     | 50  | +  |     |     |
| Int     | nDienuAtsiskaitymui       | Būtina atsiskaityti per nurodytą skaičių dienų                                       |     |     |     |     |
| Int     | nDienuAtsiskaitymuiSuNuol | Jei atsiskaitoma, per nurodytą skaičių dienų, suteikiama „dNuolaida“ dydžio nuolaida |     |     |     |     |
| Float   | dNuolaida                 | Jei atsiskaitoma per „nDienuAtsiskaitymuiSuNuol“ suteikiama nuolaida                 |     |     |     |     |

Pvz:

```xml
<Fvs.AtsTerminas>
<sKodas></sKodas>
<sPavadinimas></sPavadinimas>
<nDienuAtsiskaitymui></nDienuAtsiskaitymui>
<nDienuAtsiskaitymuiSuNuol></nDienuAtsiskaitymuiSuNuol>
<dNuolaida></dNuolaida>
</Fvs.AtsTerminas>
```

#### Fvs.Sandelis

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sKodas         | Sandėlio kodas        | 10  | +  |     |     |
| String^ | sPavadinimas   | Sandėlio pavadinimas  | 50  | +  |     |     |
| String^ | sSandelininkas | Sandelininkas         | 50  |     |     |     |
| String^ | sPapildomaInf1 | papildoma informacija | 100 |     |     |     |
| String^ | sPapildomaInf2 | papildoma informacija | 100 |     |     |     |
| String^ | sPapildomaInf3 | papildoma informacija | 100 |     |     |     |
| String^ | sObjektas1     | Pirmas objektas       | 10  |     |     |     |
| String^ | sObjektas2     | Antras objektas       | 10  |     |     |     |
| String^ | sObjektas3     | Trečias objektas      | 10  |     |     |     |
| String^ | sObjektas4     | Ketvirtas objektas    | 10  |     |     |     |
| String^ | sObjektas5     | Penktas objektas      | 10  |     |     |     |
| String^ | sObjektas6     | Šeštas objektas       | 10  |     |     |     |

Pvz:

```xml
<Fvs.Sandelis>
<sKodas></sKodas>
<sPavadinimas></sPavadinimas>
<sSandelininkas></sSandelininkas>
<sPapildomaInf1></sPapildomaInf1>
<sPapildomaInf2></sPapildomaInf2>
<sPapildomaInf3></sPapildomaInf3>
<sObjektas1></sObjektas1>
<sObjektas2></sObjektas2>
<sObjektas3></sObjektas3>
<sObjektas4></sObjektas4>
<sObjektas5></sObjektas5>
<sObjektas6></sObjektas6>
</Fvs.Sandelis>
```

#### Fvs.PrekesRusis, Fvs.PrekesPoz1 .. Fvs.PrekesPoz20

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sKodas        | Kodas                    | 20  | +  |     |     |
| String^ | sPavadinimas  | Pavadinimas              | 150 | +  |     |     |
| String^ | sInformacija1 | Papildoma informacija I  | 100 |     |     |     |
| String^ | sInformacija2 | Papildoma informacija II | 100 |     |     |     |

Pvz:

```xml
<Fvs.PrekesRusis>
<sKodas></sKodas>
<sPavadinimas></sPavadinimas>
<sInformacija1></sInformacija1>
<sInformacija2></sInformacija2>
</Fvs.PrekesRusis>
```

**Pastaba**. Metodui galima perduoti tik vieną XML failą. Vienas XML failas atitinka vieną įterpimą.

### Rezultatas

Sėkmingo įterpimo atveju grąžinama tusčia eilutė. Klaidos atveju – klaidos kodas (1 priedas).

<a id="edititem"></a>
## 3.67. EditItem

### Aprašymas

*EditItem (string ItemClassName,string sItemCode, string xmlString, out int nResult, out string sError)*

Metodas koreguoja Finvaldos įrašą ir išsaugo į Finvaldos duomenų bazę.

### Įėjimo parametrai

| Pavadinimas | Tipas | Reikšmė |
| --- | --- | --- |
| ItemClassName | string | Koreguojamo įrašo klasės pavadinimas:<br>Fvs.Preke – prekė,<br>Fvs.Paslauga – paslauga,<br>Fvs.Klientas – klientas,<br>Fvs.Adresas – adresas,<br>Fvs.ObjektasI; Fvs.ObjektasII; Fvs.ObjektasIII; Fvs.ObjektasIV; Fvs.ObjektasV; Fvs.ObjektasVI – objektai,<br>Fvs.Bankas – bankas,<br>Fvs.KlientoRusis – kliento rūšis,<br>Fvs.KlientoIPoz; Fvs.KlientoIIPoz; Fvs.KlientoIIIPoz – kliento požymiai,<br>Fvs.AtsTerminas – atsiskaitymo terminas,<br>Fvs.Sandelis – sandėlis.<br>Fvs.PrekesRusis – prekės rūšis<br>Fvs.PrekesPoz1, Fvs.PrekesPoz2 ... Fvs.PrekesPoz20 – prekės požymiai. |
| sItemCode | string | Koreguojamo įrašo kodas (Fvs.Adresas atveju neprivalomas) |
| xmlString | string | XML failo turinys |

Visų objektų laukų pavadinimai atitinka XML failo tag‘us.

XML formavimas analogiškas įterpimo metodui *InsertNewItem.*

**Pastaba**. Metodui galima perduoti tik vieną XML failą. Vienas XML failas atitinka vieną koreguojamą įrašą.

### Išėjimo parametrai

*nResult* – Klaidos kodas (žr. I priedą);

*sError* – Klaidos tekstas.

### Rezultatas

Sėkmingo koregavimo atveju grąžinama tusčia eilutė. Klaidos atveju – klaidos kodas.

### Klaidų kodai

Analogiškai įterpimo metodui *InsertNewItem.*

<a id="edititemprops"></a>
## 3.68. EditItemProps

### Aprašymas

*EditItemsProps ( string xmlString, out int nResult, out string sError)*

Metodas koreguoja Finvaldos įrašus (prekes ir/arba paslaugas) ir išsaugo į Finvaldos duomenų bazę.

### Įėjimo parametrai

| **Pavadinimas** | **Tipas** | **Reikšmė**       |
|-----------------|-----------|-------------------|
| xmlString       | string    | XML failo turinys |

Šakninis XML failo katalogo mazgas turi būti \<Fvs.EditItemProps\> viename faile gali būti keičiami ir prekių ir paslaugų duomenys, taipogi galima keisti skirtingus parametrus skirtingomas prekių/paslaugų aibėms. Keičiami parametrai nurodomi XML mazgo atributais, prekių/paslaugų aibės nurodomos pakeitimo mazgo vidiniuose mazguose.

**Galima keisti šiuos parametrus:**

### \<Fvs.Prekes\>

| **Tipas** | **Atibuto pavadinimas** | **Paaiškinimas**                               | **Duom. plotis** |
|-----------|-------------------------|------------------------------------------------|------------------|
| bool      | atkreiptiDemesi         | Atkreipti dėmesį                               |                  |
| string    | Rusis                   | Prekės rūšies kodas                            | 13               |
| string    | Poz1 ... Poz20          | Prekės požymio kodas, nuo pirmo iki 20 požymio | 20               |
| string    | Obj1                    | 1 objekto kodas                                | 10               |
| string    | Obj2                    | 2 objekto kodas                                | 10               |
| string    | Obj3                    | 3 objekto kodas                                | 10               |
| string    | Obj4                    | 4 objekto kodas                                | 10               |
| string    | Obj5                    | 5 objekto kodas                                | 10               |
| string    | Obj6                    | 6 objekto kodas                                | 10               |
| string    | Pav                     | Prekės pavadinimas                             | 100              |
| string    | Past                    | Prekės pastabos                                | 255              |
| string    | PapInf                  | Papildoma informacija                          | 13               |
| string    | PapInf1                 | Papildoma informacija (Unicode)                | 100              |
| string    | PapInf2                 | Papildoma informacija (Unicode)                | 100              |
| string    | PapInf3                 | Papildoma informacija (Unicode)                | 100              |
| string    | PapInf4                 | Papildoma informacija (Unicode)                | 100              |
| string    | PapInf5                 | Papildoma informacija (Unicode)                | 100              |
| numeric   | pardKaina1              | 1 pardavimo kaina                              | 12, 4            |
| numeric   | pardKaina2              | 1 pardavimo kaina                              | 12, 4            |
| numeric   | pardKaina3              | 1 pardavimo kaina                              | 12, 4            |
| numeric   | pardKaina4              | 1 pardavimo kaina                              | 12, 4            |
| numeric   | pardKaina5              | 1 pardavimo kaina                              | 12, 4            |
| numeric   | pardKaina6              | 1 pardavimo kaina                              | 12, 4            |
| string    | pardVal                 | Pardavimo valiuta                              | 3                |
| string    | klimesSalis             | Kilmės šalis                                   | 3                |
| string    | sKilmesSalis            | Kilmės šalis                                   | 3                |

### \<Fvs.Paslaugos \>

| **Tipas** | **Atibuto pavadinimas** | **Paaiškinimas**             | **Duom. plotis** |
|-----------|-------------------------|------------------------------|------------------|
| bool      | atkreiptiDemesi         | Atkreipti dėmesį             |                  |
| string    | Rusis                   | Paslaugos rūšies kodas       | 13               |
| string    | Poz1                    | Paslaugos 1 požymio kodas    | 13               |
| string    | Poz2                    | Paslaugos 2 požymio kodas    | 13               |
| string    | Poz3                    | Paslaugos 3 požymio kodas    | 13               |
| string    | Obj1                    | 1 objekto kodas              | 10               |
| string    | Obj2                    | 2 objekto kodas              | 10               |
| string    | Obj3                    | 3 objekto kodas              | 10               |
| string    | Obj4                    | 4 objekto kodas              | 10               |
| string    | Obj5                    | 5 objekto kodas              | 10               |
| string    | Obj6                    | 6 objekto kodas              | 10               |
| string    | Pav                     | Paslaugos pavadinimas        | 50               |
| string    | Past1                   | Paslaugos pastabos (Unicode) | 60               |
| string    | Past2                   | Paslaugos pastabos (Unicode) | 60               |
| string    | Past3                   | Paslaugos pastabos (Unicode) | 60               |
| string    | Past4                   | Paslaugos pastabos (Unicode) | 60               |
| string    | Past5                   | Paslaugos pastabos (Unicode) | 60               |
| string    | Past6                   | Paslaugos pastabos (Unicode) | 60               |
| string    | Past7                   | Paslaugos pastabos (Unicode) | 60               |
| string    | Past8                   | Paslaugos pastabos (Unicode) | 60               |
| string    | Past9                   | Paslaugos pastabos (Unicode) | 60               |
| string    | Past10                  | Paslaugos pastabos (Unicode) | 60               |
| string    | Past11                  | Paslaugos pastabos (Unicode) | 60               |
| string    | Past12                  | Paslaugos pastabos (Unicode) | 60               |
| string    | Past13                  | Paslaugos pastabos (Unicode) | 60               |
| numeric   | pardKaina               | Pardavimo kaina              | 12, 4            |

**Pastaba**. Metodui galima perduoti tik vieną XML failą. Visi faile esantys pakeitimai vykdomi vienoje transakcijoje.

**XML pavyzdys:**

```xml
<?xml version="1.0"?>
<Fvs.EditItemProps>
<Fvs.Prekes atkreiptiDemesi = "1" Rusis = "RUS01" Poz1 = "01_01" Poz2 = "02_02" Poz3 = "F2F2" Obj1 = "901PAL" Obj2 = "02_01" PapInf3 = "info_001" pardKaina3 = "13.13" pardKaina4 = "3.14" pardVal = "EUR">
<Kodas>PRE_01</Kodas>
<Kodas>PRE_02</Kodas>
<Kodas>PRE_03</Kodas>
</Fvs.Prekes>
<Fvs.Prekes Poz4 = "2009" Poz5 = "5_0001" Poz6 = "6POZ" PapInf = "129" Pav = "PAV_2" Past = "PAST_1" PapInf4 = "04_pastaba">
<Kodas>PRE_04</Kodas>
<Kodas>PRE_05</Kodas>
<Kodas>PRE_06</Kodas>
</Fvs.Prekes>
<Fvs.Paslaugos atkreiptiDemesi = "1" Rusis = "001" Poz1 = "01_01" Obj6 = "06_03" Pav = "PAV_1" Past1 = "PAST1_SET1" Past2 = "PAST2_SET1" pardKaina = "1123.58">
<Kodas>T_01</Kodas>
<Kodas>T_03</Kodas>
</Fvs.Paslaugos>
<Fvs.Paslaugos Past13 = "PAST13_001" >
<Kodas>T02_A1</Kodas>
</Fvs.Paslaugos>
</Fvs.EditItemProps>
```

**JSON pavyzdys:**

```json
{
"Fvs.EditItemProps": {
"Fvs.Prekes": {
"Kodas": [
"VIRDULYS",
"PIENAS",
"MILTAI"
],
"atkreiptiDemesi": 1,
"PapInf": "pastebejimas",
"pardKaina1": "15.78"
}
}
}
```

### \<Fvs.Klientas\>

- sPavadinimas (sName)

- sPastabos (sRemarks)

- sAdresas (sAddress)

- sTelefonas (sPhone)

- sEMail (sEMail)

- sValstybe (sCountry)

- sValstybeKodas (sCountryCode)

- sMiestas (sCity)

- sPastoKodas (sPostCode)

- sAtsakingasAsmuo (sRepresentative)

- sBankas (sBank)

- sBankoSaskaita (sBankAccount)

- sKorespSaskBank (sCorrespAccount)

- sPasiulomaValiuta (sCurrency)

- sRusis (sType)

- sPozymis1 (sTag1)

- sPozymis2 (sTag2)

- sPozymis3 (sTag3)

- sObjektas1 (sObject1)

- sObjektas2 (sObject2)

- sObjektas3 (sObject3)

- sObjektas4 (sObject4)

- sObjektas5 (sObject5)

- sObjektas6 (sObject6)

SOAP:

```http
POST http://127.0.0.1:8087/FvsService.asmx HTTP/1.1
Accept-Encoding: gzip,deflate
Content-Type: text/xml;charset=UTF-8
SOAPAction: "http://www.fvs.lt/webservices/EditItemProps"
```

```xml
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://www.fvs.lt/webservices">
<soapenv:Header>
[STD HEADER]
</soapenv:Header>
<soapenv:Body>
<web:EditItemProps>
<web:xmlString><\![CDATA[<?xml version="1.0"?>
<Fvs.EditItemProps>
<Fvs.Klientas sPavadinimas = "testPavadinimas" sRemarks = "testPastabos" sObject1 = "T_OBJ1_00" >
<Kodas>007</Kodas>
<Code>008</Code>
<Code>009</Code>
</Fvs.Klientas>
</Fvs.EditItemProps>]]>
</web:xmlString>
</web:EditItemProps>
</soapenv:Body>
</soapenv:Envelope>
```

JSON:

```json
{
"Fvs.EditItemProps": {
"Fvs.Klientas": {
"Kodas": [
"TEXTA",
"STMT"
],
"sPozymis1": "BE PVM",
"sRusis": "KAUNAS"
}
}
}
```

### Išėjimo parametrai

*nResult* – Klaidos kodas (žr. I priedą);

*sError* – Klaidos tekstas.

### Rezultatas

Sėkmingo koregavimo atveju grąžinama tusčia eilutė. Klaidos atveju – klaidos kodas.

<a id="appendgroup"></a>
## 3.69. AppendGroup

###  Aprašymas

AppendGroup(string ItemClassName, string sGroupCode, string sItemCode, string sItemCode2, out int nResult, out string sError)

Aprašymo grupės papildymas nauju nariu.

###  Įėjimo parametrai

| Pavadinimas | Tipas | Reikšmė |
| --- | --- | --- |
| ItemClassName | string | Koreguojamos grupės klasės pavadinimas:<br>Fvs.Preke<br>– prekių grupė,<br>Fvs.Paslauga<br>– paslaugų grupė,<br>Fvs.Klientas<br>– klientų grupė,<br>Fvs.Adresas<br>– adresų grupė,<br>Fvs.ObjektasI; Fvs.ObjektasII; Fvs.ObjektasIII; Fvs.ObjektasIV; Fvs.ObjektasV; Fvs.ObjektasVI<br>– objektų grupės,<br>Fvs.Sandelis<br>– sandėlių grupė.<br>Fvs.PrekesRusis<br>– prekių rūšių grupė<br>Fvs.Saskaita<br>– sąskaitų grupė<br>Fvs.Gaminys<br>– gaminių grupė |
| sGroupCode | string | Grupės kodas |
| sItemCode | String | Aprašymo kodas (prekės/paslaugos/kt. – kodas) |
| sItemCode2 | String | Kai koreguojama Fvs.Adresas grupė – kliento kodas |

###  Išėjimo parametrai

*nResult* – Klaidos kodas (žr. I priedą);

*sError* – Klaidos tekstas.

###  Rezultatas

Sėkmingo koregavimo atveju grąžinama tusčia eilutė. Klaidos atveju – klaidos kodas.

<a id="insertnewoperation"></a>
## 3.70. InsertNewOperation

### Aprašymas

```csharp
InsertNewOperation(string ItemClassName, string sParamteras, string xmlString, out int nResult, out string sError)
```

Metodas vykdo pirkimo, pardavimo, įplaukos bei vidinio perkėlimo operacijų kūrimą.

Pastaba: Nurodžius eilutėje PVM procentą, PVM sumos nėra apskaičiuojamos, jas taip pat reikia nurodyti.

### Įėjimo parametrai

| Pavadinimas | Tipas | Reikšmė |
| --- | --- | --- |
| ItemClassName | string | Operacijos pavadinimas:<br>PirkDok<br>– Pirkimo vykdymui<br>TrumpasPirkDok<br>– Pirkimo vykdymui<br>PirkUzsDok<br>– Pirkimo užsakymui<br>TrumpasPirkUzsDok<br>– Pirkimo užsakymui<br>PirkGrazDok<br>– Pirkimo grąžinimui<br>TrumpasPirkGrazDok<br>– Pirkimo grąžinimui<br>PardDok<br>– Pardavimo vykdymui<br>TrumpasPardDok<br>- Pardavimo vykdymui<br>PardRezDok<br>– Pardavimo rezervavimui<br>TrumpasPardRezDok<br>- Pardavimo rezervavimui<br>PardGrazDok<br>– Pardavimo grąžinimui<br>TrumpasPardGrazDok<br>– Pardavimo grąžinimui<br>VidPerkDok<br>– Vidiniam perkėlimui<br>NurasymasDok<br>– Nurašymui<br>PajamavimasDok<br>– Pajamavimui<br>IplDok<br>- Įplaukai<br>UVMPardRezDok<br>– Užsakymų valdymo modulio pardavimo rezervavimui<br>TrumpasUVMPardRezDok<br>– Užsakymų valdymo modulio pardavimo rezervavimui<br>UVMAnulDok<br>– Užsakymų valdymo modulio anuliavimo operacija<br>UVMPirkUzsDok<br>– Užsakymų valdymo modulio pirkimo užsakymas<br>TrumpasUVMPirkUzsDok<br>– Užsakymų valdymo modulio pirkimo užsakymas<br>GamybaDok<br>– gamybos operacija<br>UzskaitaDok<br>– užskaitos operacija<br>Inventorizacija<br>– prekių inventorizacija<br>KtNeanalitDok<br>– kita neanalitinė operacija |
| sParametras | string | Importo parametras |
| xmlString | string | XML failo turinys |

Visų objektų laukų pavadinimai atitinka XML failo tag‘us.

### Išėjimo parametrai

*nResult* – Klaidos kodas (žr. I priedą);

*sError* – Klaidos tekstas, jei nResult \> 0, kitu atveju – informacija apie operaciją XML forma.

**Pardavimas:**

Pardavimo objektai:

#### PardDok, PardRezDok, PardGrazDok, UVMPardRezDok

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^  | sKlientas                               | kliento kodas                                  | 15  | +  |     |                                                                                 |
| String^  | sKlientImonesKodas                      | kliento įmonės kodas                           | 30  |     |     | Jeigu nėra nurodytas kliento kodas, jis yra įrašomas pagal kliento įmonės kodą. |
| String^  | sSerija                                 | serijos kodas                                  | 10  |     | +  |                                                                                 |
| String^  | sDokumentas                             | operacijos dokumento numeris                   | 20  | +  |     |                                                                                 |
| String^  | sPavadinimas1                           | pirmas operacijos pavadinimas                  | 50  |     |     |                                                                                 |
| String^  | sPavadinimas2                           | antras operacijos pavadinimas                  | 50  |     |     |                                                                                 |
| String^  | sPavadinimas3                           | trečias operacijos pavadinimas                 | 50  |     |     |                                                                                 |
| String^  | sPavadinimas4                           | ketvirtas operacijos pavadinimas               | 50  |     |     |                                                                                 |
| String^  | sPavadinimas5                           | penktas operacijos pavadinimas                 | 50  |     |     |                                                                                 |
| String^  | sValiuta                                | operacijos valiuta                             | 3   | +  |     |                                                                                 |
| String^  | sSutartis                               | sutarties kodas                                | 13  |     |     |                                                                                 |
| String^  | sKrovVazt                               | krovinio važtaraštis                           | 50  |     |     | nenaudojamas grąžinimuose                                                       |
| String^  | sSurasVieta                             | važtaraščio surašymo vieta,                    | 150 |     |     | nenaudojamas grąžinimuose                                                       |
| String^  | sPakrovimoVieta                         | pakrovimo vieta                                | 150 |     |     | nenaudojamas grąžinimuose                                                       |
| String^  | sPapInfo                                | papildoma krovinio informacija                 | 150 |     |     | nenaudojamas grąžinimuose                                                       |
| String^  | sIskrovimoVieta                         | iškrovimo vieta                                | 150 |     |     | nenaudojamas grąžinimuose                                                       |
| String^  | sKrovSvoris                             | krovinio svoris                                | 50  |     |     | nenaudojamas grąžinimuose                                                       |
| String^  | sKrovIsdAsmuo                           | krovinį išdavęs asmuo                          | 150 |     |     | nenaudojamas grąžinimuose                                                       |
| String^  | sKrovPrAsmuo                            | krovinį priėmęs asmuo                          | 150 |     |     | nenaudojamas grąžinimuose                                                       |
| String^  | sVairuotojas                            | vairuotojas                                    | 150 |     |     | nenaudojamas grąžinimuose                                                       |
| String^  | sMasina                                 | automobilio markė, valstybinis nr.             | 150 |     |     | nenaudojamas grąžinimuose                                                       |
| DateTime | tSurasData                              | važtaraščio surašymo data                      |     |     |     | nenaudojamas grąžinimuose                                                       |
| DateTime | tPakrovimoData                          | pakrovimo data                                 |     |     |     | nenaudojamas grąžinimuose                                                       |
| DateTime | tIskrovimoData                          | iškrovimo data                                 |     |     |     | nenaudojamas grąžinimuose                                                       |
| String^  | sVezejas                                | vežėjas                                        | 15  |     |     | kliento kodas                                                                   |
| String^  | sGavejas                                | gavėjas                                        | 15  |     |     | kliento kodas                                                                   |
| String^  | sAdresas                                | adreso kodas                                   | 13  |     |     |                                                                                 |
| String^  | sPastaba                                | operacijos pastaba                             | 255 |     |     |                                                                                 |
| DateTime | tData                                   | operacijos data                                |     | +  |     |                                                                                 |
| DateTime | tMokejimoData                           | mokėjimo data                                  |     |     |     |                                                                                 |
| String^  | sObjektas1                              | pirmo objekto kodas                            | 10  |     |     |                                                                                 |
| String^  | sObjektas2                              | antro objekto kodas                            | 10  |     |     |                                                                                 |
| String^  | sObjektas3                              | trečio objekto kodas                           | 10  |     |     |                                                                                 |
| String^  | sObjektas4                              | ketvirto objekto kodas                         | 10  |     |     |                                                                                 |
| String^  | sObjektas5                              | penkto objekto kodas                           | 10  |     |     |                                                                                 |
| String^  | sObjektas6                              | šešto objekto kodas                            | 10  |     |     |                                                                                 |
| int      | nVarna                                  | ar operacija rakinta                           |     |     |     | pagal nutylėjima - nerakinta                                                    |
| DateTime | tNuolaidosData                          | nuolaidos data                                 |     |     |     |                                                                                 |
| DateTime | tIsrasymoData | dokumento išrašymo data                        |     |     |     |                                                                                 |
| double   | dNuolaida                               | dokumento nuolaidos procentas                  |     |     |     |                                                                                 |
| int      | nSandorioKodas                          | sandorio kodas                                 |     |     |     |                                                                                 |
| String^  | sPristatymoSalygos                      | pristatymo sąlygos                             | 3   |     |     |                                                                                 |
| int      | nTranspRusis                            | transporto rūšis                               |     |     |     |                                                                                 |
| String^  | sSalisSiunteja                          | šalis siuntėja                                 | 3   |     |     |                                                                                 |
| long     | nPapildomasNr                           | papildomas numeris                             |     |     |     |                                                                                 |
| DateTime | tIvykdymoData                           | įvykdymo data                                  |     |     |     |                                                                                 |
| DateTime | tRegistravimoData                       | registravimo data                              |     |     |     | Tik gražinimuose                                                                |
| DateTime | tDokumentoData                          | dokumento data                                 |     |     |     | Tik gražinimuose                                                                |
| String^  | sDarbuotojas                            | Finvaldos darbuotojo vardas                    | 10  |     |     |                                                                                 |
| String^  | sDokRusis                               | Dokumento rūšis                                | 2   |     |     | Galimos reikšmės: S, SF, D, DS, K, KS, KT, VS, VD, VK                           |
| int      | nIVAZ                                   | Eksportuoti operaciją į iVAZ, 0 – ne, 1 - taip |     |     |     |                                                                                 |
| double   | dGrApvalinimoSuma                       | Suapvalintų centų suma                         |     |     |     |                                                                                 |
| int      | nPozymis                                | Pažymėta – 1, nepažymėta - 0                   |     |     |     |                                                                                 |

#### TrumpasPardDok, TrumpasPardRezDok, TrumpasPardGrazDok, TrumpasUVMPardRDok

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^  | sKlientas          | kliento kodas        | 15  | +  |     |                                                                                 |
| String^  | sKlientImonesKodas | kliento įmonės kodas | 30  |     |     | Jeigu nėra nurodytas kliento kodas, jis yra įrašomas pagal kliento įmonės kodą. |
| DateTime | tData              | operacijos data      |     | +  |     |                                                                                 |
| String^  | sSerija            | serijos kodas        | 10  |     | +  |                                                                                 |
| String^  | sDokumentas        | dokumento numeris    | 20  | +  |     |                                                                                 |
| String^  | sValiuta           | operacijos valiuta   | 3   | +  |     |                                                                                 |
| DateTime | tIvykdymoData      | įvykdymo data        |     |     |     |                                                                                 |
| String^  | sDokRusis          | Dokumento rūšis      | 2   |     |     | Galimos reikšmės: S, SF, D, DS, K, KS, KT, VS, VD, VK                           |

#### PardDokPrekeDetEil

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^       | sKodas          | prekės kodas                                                                        | 20  | +  |     |               |
| String^       | sSandelis       | sandėlio kodas                                                                      | 10  | +  |     |               |
| Numeric(14,2) | dSumaV          | suma valiuta be pvm be nuolaidos                                                    |     | +  |     |               |
| Numeric(14,2) | dSumaL          | suma EUR be pvm be nuolaidos                                                        |     | +  |     |               |
| Numeric(14,2) | dSumaPVMV       | visa pvm suma valiuta                                                               |     |     |     | galutinis pvm |
| Numeric(14,2) | dSumaPVML       | visa pvm suma EUR                                                                   |     |     |     | galutinis pvm |
| Numeric(14,2) | dSumaNV         | prekės nuolaida valiuta                                                             |     |     |     | nuo sumos     |
| Numeric(14,2) | dSumaNL         | prekės nuolaida EUR                                                                 |     |     |     | nuo sumos     |
| Numeric(5,2)  | dNlProc         | prekės nuolaida procentais                                                          |     |     |     |               |
| Numeric(4,2)  | dPVM_Procentas  | PVM procentas                                                                       |     |     | +  |               |
| double        | nKiekis         | prekės kiekis antru matavimu (integer) arba pirmu jei nurodyta ***nPirmasMat=1***   |     | +  |     |               |
| String^       | sObjektas1      | pirmo objekto kodas                                                                 | 10  |     |     |               |
| String^       | sObjektas2      | antro objekto kodas                                                                 | 10  |     |     |               |
| String^       | sObjektas3      | trečio objekto kodas                                                                | 10  |     |     |               |
| String^       | sObjektas4      | ketvirto objekto kodas                                                              | 10  |     |     |               |
| String^       | sObjektas5      | penkto objekto kodas                                                                | 10  |     |     |               |
| String^       | sObjektas6      | šešto objekto kodas                                                                 | 10  |     |     |               |
| Numeric(14,4) | dSumaVntV       | Vieneto suma be PVM ir be nuolaidos valiuta                                         |     |     |     |               |
| Numeric(14,4) | dSumaVntL       | Vieneto suma be PVM ir be nuolaidos EUR                                             |     |     |     |               |
| Numeric(14,4) | dSumaVntPV      | Vieneto suma su PVM ir be nuolaidos valiuta                                         |     |     |     |               |
| Numeric(14,4) | dSumaVntPL      | Vieneto suma be PVM ir be nuolaidos EUR                                             |     |     |     |               |
| Numeric(10,4) | dNeto           | Svoris neto                                                                         |     |     |     |               |
| Numeric(10,4) | dBruto          | Svoris bruto                                                                        |     |     |     |               |
| Numeric(10,5) | dTuris          | Tūris                                                                               |     |     |     |               |
| int           | nPirmasMat      | Pirmas matavimas: 0 –ne, 1 – taip, prekės kiekis *nKiekis* nurodomas pirmu matavimu |     |     |     |               |
| String^       | sPvmKodas       | PVM mokesčio kodas                                                                  | 10  |     |     |               |
| String^       | sIntrastatKodas | Intrastat prekės kodas                                                              | 20  |     |     |               |
| String^       | sKilmesSalis    | Kilmės šalis                                                                        | 3   |     |     |               |
| String^       | sPapInf         | Papildoma informacija                                                               | 30  |     |     |               |
| DateTime      | tIvykdymoData   | įvykdymo data                                                                       |     |     |     |               |
| int           | nPozymis        | Pažymėta – 1, nepažymėta - 0                                                        |     |     |     |               |

#### PardDokPaslaugaDetEil

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^       | sKodas         | paslaugos kodas                                                                      | 13  | +  |     |                                                                                                                                                                               |
| Numeric(14,2) | dSumaV         | suma valiuta be pvm be nuolaidos                                                     |     | +  |     |                                                                                                                                                                               |
| Numeric(14,2) | dSumaL         | suma EUR be pvm be nuolaidos                                                         |     | +  |     |                                                                                                                                                                               |
| Numeric(14,2) | dSumaPVMV      | visa pvm suma valiuta                                                                |     |     |     | galutinis pvm                                                                                                                                                                 |
| Numeric(14,2) | dSumaPVML      | visa pvm suma EUR                                                                    |     |     |     | galutinis pvm                                                                                                                                                                 |
| Numeric(14,2) | dSumaNV        | paslaugos nuolaida valiuta                                                           |     |     |     | nuo sumos                                                                                                                                                                     |
| Numeric(14,2) | dSumaNL        | paslaugos nuolaida EUR                                                               |     |     |     | nuo sumos                                                                                                                                                                     |
| Numeric(5,2)  | dNlProc        | paslaugos nuolaida procentais                                                        |     |     |     |                                                                                                                                                                               |
| Numeric(4,2)  | dPVM_Procentas | PVM procentas                                                                        |     |     | +  |                                                                                                                                                                               |
| double        | nKiekis        | paslaugos kiekis antru matavimu (integer) arba pirmu jei nurodyta ***nPirmasMat=1*** |     | +  |     | Kiekis padaugintas iš 100. Jeigu rekalingas kiekis 0.5 tada nKiekis = 50, jeigu reikalingas kiekis 1 tada nKiekis = 100. Jeigu naudojamas pirmas matavimas dauginti nereikia. |
| String^       | sObjektas1     | pirmo objekto kodas                                                                  | 10  |     |     |                                                                                                                                                                               |
| String^       | sObjektas2     | antro objekto kodas                                                                  | 10  |     |     |                                                                                                                                                                               |
| String^       | sObjektas3     | trečio objekto kodas                                                                 | 10  |     |     |                                                                                                                                                                               |
| String^       | sObjektas4     | ketvirto objekto kodas                                                               | 10  |     |     |                                                                                                                                                                               |
| String^       | sObjektas5     | penkto objekto kodas                                                                 | 10  |     |     |                                                                                                                                                                               |
| String^       | sObjektas6     | šešto objekto kodas                                                                  | 10  |     |     |                                                                                                                                                                               |
| Numeric(14,4) | dSumaVntV      | Vieneto suma be PVM ir be nuolaidos valiuta                                          |     |     |     |                                                                                                                                                                               |
| Numeric(14,4) | dSumaVntL      | Vieneto suma be PVM ir be nuolaidos EUR                                              |     |     |     |                                                                                                                                                                               |
| Numeric(14,4) | dSumaVntPV     | Vieneto suma su PVM ir be nuolaidos valiuta                                          |     |     |     |                                                                                                                                                                               |
| Numeric(14,4) | dSumaVntPL     | Vieneto suma be PVM ir be nuolaidos EUR                                              |     |     |     |                                                                                                                                                                               |
| Numeric(14,4) | dSavikainaL    | Savikaina EUR                                                                        |     |     |     | jei jurodyta, operacijos fiksavimo metu išskleidžiama į dvi sąskaitų det. eilutes (savikainos ir sąnaudų)                                                                     |
| Numeric(14,4) | dSavikainaV    | Savikaina EUR                                                                        |     |     |     | jei jurodyta, operacijos fiksavimo metu išskleidžiama į dvi sąskaitų det. eilutes (savikainos ir sąnaudų)                                                                     |
| String^       | sPvmKodas      | PVM mokesčio kodas                                                                   | 10  |     |     |                                                                                                                                                                               |
| String^       | sPapInf        | Papildoma informacija                                                                | 30  |     |     |                                                                                                                                                                               |
| DateTime      | tIvykdymoData  | įvykdymo data                                                                        |     |     |     |                                                                                                                                                                               |
| int           | nPozymis       | Pažymėta – 1, nepažymėta - 0                                                         |     |     |     |                                                                                                                                                                               |

#### PardDokSaskaitaDetEil

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^       | sKodas     | sąskaitos kodas        | 20  | +  |     |     |
| Numeric(14,2) | dDebetasV  | Debeto suma valiuta    |     | +  |     |     |
| Numeric(14,2) | dDebetasL  | Debeto suma EUR        |     | +  |     |     |
| Numeric(14,2) | dKreditasV | Kredito suma valiuta   |     | +  |     |     |
| Numeric(14,2) | dKreditasL | Kredito suma EUR       |     | +  |     |     |
| String^       | sObjektas1 | pirmo objekto kodas    | 10  |     |     |     |
| String^       | sObjektas2 | antro objekto kodas    | 10  |     |     |     |
| String^       | sObjektas3 | trečio objekto kodas   | 10  |     |     |     |
| String^       | sObjektas4 | ketvirto objekto kodas | 10  |     |     |     |
| String^       | sObjektas5 | penkto objekto kodas   | 10  |     |     |     |
| String^       | sObjektas6 | šešto objekto kodas    | 10  |     |     |     |

#### PardDokGaminysDetEil

Gaminys šiame kontekste naudojamas, kaip konteineris, kuriame yra sutalpintos prekės ir paslaugos (nebūtinos). Gaminio aprašyme Finvaldoje yra aprašomos prekės (žaliavos), papildomos išlaidos (paslaugos) bei gaminiai (šiame kontekste neaktualu). Įtraukta gaminio detali eilutė prieš operacijos fiksavimą Finvaldoje yra išskleidžiama į prekes ir paslaugas.

Sumos iš gaminio eilutės yra priskiriamos tik paslaugoms. T.y. iš gaminio į operaciją įtrauktos prekės turės nulines sumas.

Prekių ir paslaugų kiekis bus suskaičiuotas iš detalioje eilutėje nurodyto kiekio bei gaminio aprašyme nurodytų kiekių.

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^       | sKodas    | paslaugos kodas                                                                    | 13  | +  |     | Gaminio kodas                                         |
| Numeric(14,2) | dSumaV    | suma valiuta be pvm be nuolaidos                                                   |     | +  |     |                                                       |
| Numeric(14,2) | dSumaL    | suma EUR be pvm be nuolaidos                                                       |     | +  |     |                                                       |
| Numeric(14,2) | dSumaPVMV | visa pvm suma valiuta                                                              |     |     |     | galutinis pvm                                         |
| Numeric(14,2) | dSumaPVML | visa pvm suma EUR                                                                  |     |     |     | galutinis pvm                                         |
| Numeric(14,2) | dSumaNV   | paslaugos nuolaida valiuta                                                         |     |     |     | nuo sumos                                             |
| Numeric(14,2) | dSumaNL   | paslaugos nuolaida EUR                                                             |     |     |     | nuo sumos                                             |
| Numeric(5,2)  | dNlProc   | nuolaida procentais                                                                |     |     |     |                                                       |
| double        | nKiekis   | gaminio kiekis antru matavimu (integer) arba pirmu jei nurodyta ***nPirmasMat=1*** |     | +  |     | Laikoma, jog gaminio matavimo vienetų santykis yra 1. |

Pvz:

```xml
<PardDok>
<sKlientas></sKlientas>
<sValiuta></sValiuta>
<sPavadinimas></sPavadinimas>
<tData></tData>
<sDokumentas></sDokumentas>
<PardDokPrekeDetEil>
<sKodas></sKodas>
<nKiekis></nKiekis>
<sSandelis></sSandelis>
<dSumaL></dSumaL>
<dSumaV></dSumaV>
</PardDokPrekeDetEil>
<PardDokPrekeDetEil>
<sKodas></sKodas>
<nKiekis></nKiekis>
<sSandelis></sSandelis>
<dSumaL></dSumaL>
<dSumaV></dSumaV>
</PardDokPrekeDetEil>
<PardDokPaslaugaDetEil>
<sKodas></sKodas>
<nKiekis></nKiekis>
<dSumaL></dSumaL>
<dSumaV></dSumaV>
</PardDokPaslaugaDetEil>
</PardDok>
```

Išsaugojus operaciją grąžinama tokia informacija:

```xml
<OP_DUOMENYS>
<SERIJA>op_serijos_kodas</SERIJA>
<DOKUMENTAS>op_dokumentas</ DOKUMENTAS >
<ZURNALAS>op_žurnalo_kodas</ZURNALAS>
<NUMERIS>op_numeris</NUMERIS>
</<OP_DUOMENYS>
```

**Pastaba**. Metodui galima perduoti tik vieną XML failą. Vienas XML failas atitinka vieną operaciją.

**Pirkimas:**

Pirkimo objektai:

#### PirkDok, PirkUzsDok, PirkGrazDok, UVMPirkUzsDok

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^  | sValiuta           | operacijos valiuta                             | 3   | +  |     |                                                                                            |
| String^  | sKlientas          | kliento kodas                                  | 15  | +  |     |                                                                                            |
| String^  | sKlientImonesKodas | kliento įmonės kodas                           | 30  |     |     | Jeigu nėra nurodytas kliento kodas, jis yra įrašomas pagal kliento įmonės kodą.            |
| String^  | sDokumentas        | operacijos dokumento numeris                   | 20  | +  |     |                                                                                            |
| String^  | sPastaba           | pastaba apie operaciją                         | 255 |     |     |                                                                                            |
| DateTime | tData              | operacijos data                                |     | +  |     |                                                                                            |
| String^  | sObjektas1         | pirmo objekto kodas                            | 10  |     |     |                                                                                            |
| String^  | sObjektas2         | antro objekto kodas                            | 10  |     |     |                                                                                            |
| String^  | sObjektas3         | trečio objekto kodas                           | 10  |     |     |                                                                                            |
| String^  | sObjektas4         | ketvirto objekto kodas                         | 10  |     |     |                                                                                            |
| String^  | sObjektas5         | penkto objekto kodas                           | 10  |     |     |                                                                                            |
| String^  | sObjektas6         | šešto objekto kodas                            | 10  |     |     |                                                                                            |
| String^  | sPavadinimas       | pirmas operacijos pavadinimas                  | 50  |     |     |                                                                                            |
| String^  | sPavadinimas1      | antras operacijos pavadinimas                  | 50  |     |     |                                                                                            |
| String^  | sPavadinimas2      | trečias operacijos pavadinimas                 | 50  |     |     |                                                                                            |
| String^  | sPavadinimas3      | ketvirtas operacijos pavadinimas               | 50  |     |     |                                                                                            |
| String^  | sPavadinimas4      | penktas operacijos pavadinimas                 | 50  |     |     |                                                                                            |
| String^  | sSutartiesKodas    | sutarties kodas                                | 13  |     |     |                                                                                            |
| DateTime | tIsrasymoData      | dokumento išrašymo data                        |     |     |     |                                                                                            |
| DateTime | tMokejimoData      | mokėjimo data                                  |     |     |     |                                                                                            |
| DateTime | tNuolaidosData     | nuolaidos data                                 |     |     |     |                                                                                            |
| DateTime | tKoregavimoData    | paskutinio operacijos koregavimo data          |     |     |     |                                                                                            |
| double   | dNuolaidosProc     | operacijos nuolaidos procentas                 |     |     |     |                                                                                            |
| int      | nVarna             | Ar operacija rakinta                           |     |     |     | pagal nutylėjima – nerakinta                                                               |
| long     | nPapildomasNr      | papildomas operacijos numeris                  |     |     |     |                                                                                            |
| int      | nSandorioKodas     | sandorio kodas                                 |     |     |     |                                                                                            |
| String^  | sPristatymoSalygos | pristatymo sąlygos                             | 3   |     |     |                                                                                            |
| int      | nTransportoRusis   | transporto rūšis                               |     |     |     |                                                                                            |
| String^  | sSalisSiunteja     | šalis siuntėja                                 | 3   |     |     |                                                                                            |
| String^  | sKrovVazt          | krovinio važtaraščio numeris                   | 50  |     |     | tik pirkimų grąžinimuose                                                                   |
| String^  | sSurasVieta        | važtaraščio surašymo vieta                     | 150 |     |     | tik pirkimų grąžinimuose                                                                   |
| String^  | sPakrovimoVieta    | krovinio pakrovimo vieta                       | 150 |     |     | tik pirkimų grąžinimuose                                                                   |
| String^  | sIskrovimoVieta    | krovinio iškrovimo vieta                       | 150 |     |     | tik pirkimų grąžinimuose                                                                   |
| String^  | sKrovSvoris        | krovinio svoris                                | 50  |     |     | tik pirkimų grąžinimuose                                                                   |
| String^  | sKrovIsdAsmuo      | krovinį išdavęs asmuo                          | 150 |     |     | tik pirkimų grąžinimuose                                                                   |
| String^  | sKrovPrAsmuo       | krovinį priėmęs asmuo                          | 150 |     |     | tik pirkimų grąžinimuose                                                                   |
| String^  | sVairuotojas       | vairuotojas                                    | 150 |     |     | tik pirkimų grąžinimuose                                                                   |
| String^  | sMasina            | automobilio markė, valstybinis numeris         | 150 |     |     | tik pirkimų grąžinimuose                                                                   |
| String^  | sPapInfo           | papildoma krovinio informacija                 | 150 |     |     | tik pirkimų grąžinimuose                                                                   |
| DateTime | tSurasData         | surašymo laikas, data                          |     |     |     | tik pirkimų grąžinimuose                                                                   |
| DateTime | tPakrovimoData     | pakrovimo laikas, data                         |     |     |     | tik pirkimų grąžinimuose                                                                   |
| DateTime | tIskrovimoData     | iškrovimo laikas, data                         |     |     |     | tik pirkimų grąžinimuose                                                                   |
| String^  | sAvansininkas      |                                                | 15  |     |     | Tik pirkimuose; tik, kai operacijos tipas – už grynus                                      |
| String^  | sAvansoSerija      |                                                | 10  |     |     | Tik pirkimuose; tik, kai operacijos tipas – už grynus                                      |
| String^  | sAvansoDokumentas  |                                                | 20  |     |     | Tik pirkimuose; tik, kai operacijos tipas – už grynus; būtinas, jei nurodomas avansininkas |
| DateTime | tAvansoData        |                                                |     |     |     | Tik pirkimuose; tik, kai operacijos tipas – už grynus                                      |
| DateTime | tRegistravimoData  | registravimo data                              |     |     |     |                                                                                            |
| DateTime | tDokumentoData     | dokumento data                                 |     |     |     |                                                                                            |
| String^  | sPapIslaiduKodas1  | Papildomų išlaidų kodas                        | 10  |     |     | Tik PirkDok ir PirkUzsDok                                                                  |
| String^  | sPapIslaiduKodas2  | Papildomų išlaidų kodas                        | 10  |     |     | Tik PirkDok ir PirkUzsDok                                                                  |
| String^  | sPapIslaiduKodas3  | Papildomų išlaidų kodas                        | 10  |     |     | Tik PirkDok ir PirkUzsDok                                                                  |
| String^  | sPapIslaiduKodas4  | Papildomų išlaidų kodas                        | 10  |     |     | Tik PirkDok ir PirkUzsDok                                                                  |
| String^  | sDarbuotojas       | Finvaldos darbuotojo vardas                    | 10  |     |     |                                                                                            |
| String^  | sDokRusis          | Dokumento rūšis                                |     |     |     | Galimos reikšmės: S, SF, D, DS, K, KS, KT, VS, VD, VK                                      |
| DateTime | tIvykdymoData      | įvykdymo data                                  |     |     |     |                                                                                            |
| int      | nIVAZ              | Eksportuoti operaciją į iVAZ, 0 – ne, 1 - taip |     |     |     |                                                                                            |
| double   | dGrApvalinimoSuma  | Suapvalintų centų suma                         |     |     |     |                                                                                            |
| int      | nPozymis           | Pažymėta – 1, nepažymėta - 0                   |     |     |     |                                                                                            |

#### TrumpasPirkDok, TrumpasPirkGrazDok, TrumpasPirkUzsDok, TrumpasUVMPirkUzsDok

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sValiuta           | operacijos valiuta      | 3   | +  |     |                                                                                 |
| String^ | sKlientas          | klientas                | 15  | +  |     |                                                                                 |
| String^ | sKlientImonesKodas | kliento įmonės kodas    | 30  |     |     | Jeigu nėra nurodytas kliento kodas, jis yra įrašomas pagal kliento įmonės kodą. |
| String^ | sSerija            | dokumento serijos kodas | 10  |     | +  |                                                                                 |
| String^ | sDokumentas        | dokumento numeris       | 20  | +  |     |                                                                                 |
| String^ | sDokRusis          | Dokumento rūšis         | 2   |     |     | Galimos reikšmės: S, SF, D, DS, K, KS, KT, VS, VD, VK                           |

#### PirkDokPrekeDetEil

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^       | sKodas          | prekės kodas                                                                        | 20  | +  |     |               |
| String^       | sSandelis       | sandėlio kodas                                                                      | 10  | +  |     |               |
| Numeric(14,2) | dSumaV          | prekės suma valiuta be pvm, be nuolaidos                                            |     | +  |     |               |
| Numeric(14,2) | dSumaL          | suma EUR be pvm, be nuolaidos                                                       |     | +  |     |               |
| Numeric(14,2) | dSumaPVMV       | prekės pvm valiuta                                                                  |     |     |     | galutinis pvm |
| Numeric(14,2) | dSumaPVML       | prekės pvm EUR                                                                      |     |     |     | galutinis pvm |
| Numeric(14,2) | dSumaNV         | prekės nuolaida valiuta                                                             |     |     |     | nuo sumos     |
| Numeric(14,2) | dSumaNL         | prekės nuolaida EUR                                                                 |     |     |     | nuo sumos     |
| Numeric(5,2)  | dNlProc         | prekės nuolaida procentais                                                          |     |     |     |               |
| double        | nKiekis         | prekės kiekis antru matavimu (integer) arba pirmu jei nurodyta ***nPirmasMat=1***   |     | +  |     |               |
| String^       | sAtitSer        | prekės atitikties sertifikatas                                                      | 50  |     |     |               |
| DateTime      | tGalData        | prekės galiojimo data                                                               |     |     |     |               |
| String^       | sObjektas1      | pirmo objekto kodas                                                                 | 10  |     |     |               |
| String^       | sObjektas2      | antro objekto kodas                                                                 | 10  |     |     |               |
| String^       | sObjektas3      | trečio objekto kodas                                                                | 10  |     |     |               |
| String^       | sObjektas4      | ketvirto objekto kodas                                                              | 10  |     |     |               |
| String^       | sObjektas5      | penkto objekto kodas                                                                | 10  |     |     |               |
| String^       | sObjektas6      | šešto objekto kodas                                                                 | 10  |     |     |               |
| int           | nPirmasMat      | Pirmas matavimas: 0 –ne, 1 – taip, prekės kiekis *nKiekis* nurodomas pirmu matavimu |     |     |     |               |
| String^       | sPvmKodas       | PVM mokesčio kodas                                                                  | 10  |     |     |               |
| Numeric(4,2)  | dPVM_Procentas  | PVM mokesčio procentas                                                              |     |     |     |               |
| String^       | sIntrastatKodas | Intrastat prekės kodas                                                              | 20  |     |     |               |
| String^       | sKilmesSalis    | Kilmės šalis                                                                        | 3   |     |     |               |
| Numeric(15,5) | dBruto          | Bruto                                                                               |     |     |     |               |
| Numeric(15,5) | dNeto           | Neto                                                                                |     |     |     |               |
| Numeric(15,5) | dTuris          | Tūris                                                                               |     |     |     |               |
| Numeric(14,2) | dPapIsldSumaL1  | Pirmos papildomos išlaidos suma nacionaline valiuta                                 |     |     |     |               |
| Numeric(14,2) | dPapIsldSumaV1  | Pirmos papildomos išlaidos suma operacijos valiuta                                  |     |     |     |               |
| Numeric(14,2) | dPapIsldSumaL2  | Antros papildomos išlaidos suma nacionaline valiuta                                 |     |     |     |               |
| Numeric(14,2) | dPapIsldSumaV2  | Antros papildomos išlaidos suma operacijos valiuta                                  |     |     |     |               |
| Numeric(14,2) | dPapIsldSumaL3  | Trečios papildomos išlaidos suma nacionaline valiuta                                |     |     |     |               |
| Numeric(14,2) | dPapIsldSumaV3  | Trečios papildomos išlaidos suma operacijos valiuta                                 |     |     |     |               |
| Numeric(14,2) | dPapIsldSumaL4  | Ketvirtos papildomos išlaidos suma nacionaline valiuta                              |     |     |     |               |
| Numeric(14,2) | dPapIsldSumaV4  | Ketvirtos papildomos išlaidos suma operacijos valiuta                               |     |     |     |               |
| DateTime      | tIvykdymoData   | įvykdymo data                                                                       |     |     |     |               |
| int           | nPozymis        | Pažymėta – 1, nepažymėta - 0                                                        |     |     |     |               |

#### PirkDokPaslaugaDetEil

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^       | sKodas           | paslaugos kodas                                                                      | 13  | +  |     |                                                                                                                                                                          |
| Numeric(14,2) | dSumaV           | paslaugos suma valiuta be pvm, be nuolaidos                                          |     | +  |     |                                                                                                                                                                          |
| Numeric(14,2) | dSumaL           | paslaugos suma EUR be pvm, be nuolaidos                                              |     | +  |     |                                                                                                                                                                          |
| Numeric(14,2) | dSumaPVMV        | paslaugos pvm valiuta                                                                |     |     |     | galutinis pvm                                                                                                                                                            |
| Numeric(14,2) | dSumaPVML        | paslaugos pvm EUR                                                                    |     |     |     | galutinis pvm                                                                                                                                                            |
| Numeric(14,2) | dSumaNV          | paslaugos nuolaida valiuta                                                           |     |     |     | nuo sumos                                                                                                                                                                |
| Numeric(14,2) | dSumaNL          | paslaugos nuolaida EUR                                                               |     |     |     | nuo sumos                                                                                                                                                                |
| Numeric(5,2)  | dNlProc          | paslaugos nuolaida procentais                                                        |     |     |     |                                                                                                                                                                          |
| double        | nKiekis          | paslaugos kiekis antru matavimu (integer) arba pirmu jei nurodyta ***nPirmasMat=1*** |     | +  |     | Kiekis padaugintas iš 100. Jeigu rekalingas kiekis 0.5 tada nKiekis = 50, jeigu reikalingas kiekis 1 tada nKiekis = 100. Jeigu nurodoma pirmu matavimu dauginti nereikia |
| String^       | sObjektas1       | pirmo objekto kodas                                                                  | 10  |     |     |                                                                                                                                                                          |
| String^       | sObjektas2       | antro objekto kodas                                                                  | 10  |     |     |                                                                                                                                                                          |
| String^       | sObjektas3       | trečio objekto kodas                                                                 | 10  |     |     |                                                                                                                                                                          |
| String^       | sObjektas4       | ketvirto objekto kodas                                                               | 10  |     |     |                                                                                                                                                                          |
| String^       | sObjektas5       | penkto objekto kodas                                                                 | 10  |     |     |                                                                                                                                                                          |
| String^       | sObjektas6       | šešto objekto kodas                                                                  | 10  |     |     |                                                                                                                                                                          |
| Numeric(14,2) | dPapildIslaidosL | papildomos išlaidos EUR                                                              |     |     |     | jei jurodyta, operacijos fiksavimo metu išskleidžiama į dvi sąskaitų det. eilutes (savikainos ir pap. išlaidų)                                                           |
| Numeric(14,2) | dPapildIslaidosV | Papildomoas išlaidos valiuta                                                         |     |     |     | jei jurodyta, operacijos fiksavimo metu išskleidžiama į dvi sąskaitų det. eilutes (savikainos ir pap. išlaidų)                                                           |
| String^       | sPvmKodas        | PVM mokesčio kodas                                                                   | 10  |     |     |                                                                                                                                                                          |
| Numeric(4,2)  | dPVM_Procentas   | PVM mokesčio procentas                                                               |     |     |     |                                                                                                                                                                          |
| String^       | sPastaba         | Pastaba                                                                              | 150 |     |     |                                                                                                                                                                          |
| DateTime      | tIvykdymoData    | įvykdymo data                                                                        |     |     |     |                                                                                                                                                                          |
| int           | nPozymis         | Pažymėta – 1, nepažymėta - 0                                                         |     |     |     |                                                                                                                                                                          |

#### PirkDokSaskaitaDetEil

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^       | sKodas     | sąskaitos kodas        | 20  | +  |     |     |
| Numeric(14,2) | dDebetasV  | Debeto suma valiuta    |     | +  |     |     |
| Numeric(14,2) | dDebetasL  | Debeto suma EUR        |     | +  |     |     |
| Numeric(14,2) | dKreditasV | Kredito suma valiuta   |     | +  |     |     |
| Numeric(14,2) | dKreditasL | Kredito suma EUR       |     | +  |     |     |
| String^       | sObjektas1 | pirmo objekto kodas    | 10  |     |     |     |
| String^       | sObjektas2 | antro objekto kodas    | 10  |     |     |     |
| String^       | sObjektas3 | trečio objekto kodas   | 10  |     |     |     |
| String^       | sObjektas4 | ketvirto objekto kodas | 10  |     |     |     |
| String^       | sObjektas5 | penkto objekto kodas   | 10  |     |     |     |
| String^       | sObjektas6 | šešto objekto kodas    | 10  |     |     |     |

Pvz:

```xml
<PirkUzsDok>
<sKlientas></sKlientas>
<sValiuta></sValiuta>
<sPavadinimas></sPavadinimas>
<tData></tData>
<sDokumentas></sDokumentas>
<PirkDokPrekeDetEil>
<sKodas></sKodas>
<nKiekis></nKiekis>
<sSandelis></sSandelis>
<dSumaL></dSumaL>
<dSumaV></dSumaV>
</PirkDokPrekeDetEil>
<PirkDokPaslaugaDetEil>
<sKodas></sKodas>
<nKiekis></nKiekis>
<dSumaL></dSumaL>
<dSumaV></dSumaV>
</PirkDokPaslaugaDetEil>
<PirkDokPaslaugaDetEil>
<sKodas></sKodas>
<nKiekis></nKiekis>
<dSumaL></dSumaL>
<dSumaV></dSumaV>
</PirkDokPaslaugaDetEil>
</PirkUzsDok>
```

Išsaugojus operaciją grąžinama tokia informacija:

```xml
<OP_DUOMENYS>
<SERIJA>op_serijos_kodas</SERIJA>
<DOKUMENTAS>op_dokumentas</ DOKUMENTAS >
<ZURNALAS>op_žurnalo_kodas</ZURNALAS>
<NUMERIS>op_numeris</NUMERIS>
</<OP_DUOMENYS>
```

**Pastaba**. Metodui galima perduoti tik vieną XML failą. Vienas XML failas atitinka vieną operaciją.

**Įplauka, Išmoka:**

#### IplDok, IsmDok

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^  | sValiuta           | operacijos valiuta            | 3   | +  |     |                                                                                     |
| String^  | sKlientas          | kliento kodas                 | 15  | +  |     |                                                                                     |
| String^  | sKlientImonesKodas | kliento įmonės kodas          | 30  |     |     | Jeigu nėra nurodytas kliento kodas, jis yra įrašomas pagal kliento įmonės kodą.     |
| int      | nTipas             | Operacijos tipas              |     | +  |     | 0 – avansinis mokėjimas, 1 – pardavimų dengimas FIFO metodu, 3 – pardavimų dengimas |
| String^  | sSerija            | Dokumento serija              | 10  |     | +  |                                                                                     |
| String^  | sDokumentas        | operacijos dokumento numeris  | 20  |     | +  |                                                                                     |
| String^  | sSerija2           | II dokumento serija           | 10  |     | +  |                                                                                     |
| String^  | sDokumentas2       | II dokumento numeris          | 20  |     | +  |                                                                                     |
| String^  | sPastaba           | pastaba apie operaciją        | 255 |     |     |                                                                                     |
| DateTime | tData              | operacijos data               |     | +  |     |                                                                                     |
| String^  | sPavadinimas       | pirmas operacijos pavadinimas | 50  |     |     |                                                                                     |
| DateTime | tIsrasymoData      | dokumento išrašymo data       |     |     |     |                                                                                     |
| int      | nVarna             | Ar operacija rakinta          |     |     |     | pagal nutylėjima – nerakinta                                                        |
| String^  | sDarbuotojas       | Finvaldos darbuotojo vardas   | 10  |     |     |                                                                                     |
| int      | nPozymis           | Pažymėta – 1, nepažymėta - 0  |     |     |     |                                                                                     |

#### IplDokDetEil, IsmDokDetEil

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^       | sPavadinimas        | eilutės pavadinimas                             | 50  |     |     |                                                                  |
| Numeric(14,2) | dSumaV              | įplaukos suma                                   |     | +  |     |                                                                  |
| String^       | sSerija             | pardavimo, už kurį atsiskaitinėjima, serija     | 10  |     |     | Būtinas, jei atsiskaitoma už konkrečias operacijas (nTipas == 3) |
| String^       | sDokumentas         | pardavimo, už kurį atsiskaitinėjama, dokumentas | 20  |     |     | Būtinas, jei atsiskaitoma už konkrečias operacijas (nTipas == 3) |
| String^       | sDokNrBendrMokejime | dokumento numeris bendrame mokėjime             | 20  |     |     | Naudojamas bendrame mokėjime (nTipas == 0)                       |
| String^       | sSutartis           | sutarties kodas bendrame mokėjime               | 13  |     |     | Naudojamas bendrame mokėjime (nTipas == 0)                       |
| String^       | sObjektas1          | pirmo objekto kodas                             | 10  |     |     |                                                                  |
| String^       | sObjektas2          | antro objekto kodas                             | 10  |     |     |                                                                  |
| String^       | sObjektas3          | trečio objekto kodas                            | 10  |     |     |                                                                  |
| String^       | sObjektas4          | ketvirto objekto kodas                          | 10  |     |     |                                                                  |

#### Mokejimas

Mokėjimo reikalavimo formavimas išmokoms.

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sKlientoPav | Kliento pavadinimas, jei nenurodytas, bus paimta iš kliento kortelės | 150 |  |  |  |
| String^ | sBankoPav | Gavėjo banko pavadinimas | 150 |  |  |  |
| String^ | sBankoSaskaita | Gavėjo banko sąskaita | 35 |  |  |  |
| String^ | sKorespBankoSaskaita | Gavėjo korespondentinio banko sąskaita | 35 |  |  |  |
| String^ | sMokPaskirtis | Mokėjimo paskirtis | 256 |  |  |  |
| Int | nBankoMokesciai | Banko mokesčiai:<br>1 – mokėtojui<br>2 – gavėjui |  |  |  |  |
| Int | nSkubus | 1 – paprastas<br>2 – skubus<br>3 – labai skubus |  |  |  |  |
| Int | nBankoMokesciai | Užsienio banko mokesčiai:<br>1 – mokėtojui<br>2 – gavėjui<br>3 – mokėtojui ir gavėjui |  |  |  |  |

Pvz:

```xml
<IsmDok>
<sKlientas></sKlientas>
<sValiuta></sValiuta>
<sPavadinimas></sPavadinimas>
<tData></tData>
<sDokumentas></sDokumentas>
<nTipas></nTipas>
<Mokejimas>
<sKlientoPav></sKlientoPav>
<sBankoPav></sBankoPav>
<sBankoSaskaita></sBankoSaskaita>
<sKorespBankoSaskaita></sKorespBankoSaskaita>
<sMokPaskirtis></sMokPaskirtis>
<nBankoMokesciai>1</nBankoMokesciai>
<nUzsBankoMokesciai>1</nUzsBankoMokesciai>
<nSkubus>1</nSkubus>
</Mokejimas>
<IsmDokDetEil>
<sPavadinimas></sPavadinimas>
<dSumaV></dSumaV>
</IsmDokDetEil>
</IsmDok>
<IplDok>
```

...

```xml
<IplDokDetEil>
```

....

```xml
</IplDokDetEil>
</IplDok>
```

Išsaugojus operaciją grąžinama tokia informacija:

```xml
<OP_DUOMENYS>
<SERIJA>op_serijos_kodas</SERIJA>
<DOKUMENTAS>op_dokumentas</ DOKUMENTAS >
<SERIJA2>op_serijos_kodas</SERIJA2>
<DOKUMENTAS2>op_dokumentas</ DOKUMENTAS 2>
<ZURNALAS>op_žurnalo_kodas</ZURNALAS>
<NUMERIS>op_numeris</NUMERIS>
</<OP_DUOMENYS>
```

**Pastaba**. Metodui galima perduoti tik vieną XML failą. Vienas XML failas atitinka vieną operaciją.

**Vidinis perkėlimas:**

#### VidPerkDok

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^  | sPavadinimas | operacijos pavadinimas                         | 50  | +  |     |                                |
| DateTime | tData        | operacijos data                                |     | +  |     |                                |
| String^  | sDokumentas  | dokumento numeris                              | 20  | +  |     | nebūtinas, jei nurodyta serija |
| String^  | sPastaba     | operacijos pastaba                             |     |     |     |                                |
| String^  | sIsSandelio  | sandėlys, iš kurio iškeliamos prekės           | 10  | +  |     |                                |
| String^  | sISandeli    | sandėlys, į kurį keliamos prekės               | 10  | +  |     |                                |
| String^  | sSerija      | dokumento serijos kodas                        | 10  |     | +  |                                |
| String^  | sDarbuotojas | Finvaldos darbuotojo vardas                    | 10  |     |     |                                |
| String^  | sKlientas    | Kliento kodas                                  |     |     |     |                                |
| int      | nIVAZ        | Eksportuoti operaciją į iVAZ, 0 – ne, 1 - taip |     |     |     |                                |
| int      | nPozymis     | Pažymėta – 1, nepažymėta - 0                   |     |     |     |                                |

#### VidPerkDokDetEil

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^       | sKodas         | prekės kodas                                                                        | 20  | +  |     |     |
| double        | nKiekis        | prekės kiekis antru matavimu (integer) arba pirmu jei nurodyta ***nPirmasMat=1***   |     | +  |     |     |
| String^       | sObjektas1     | pirmo objekto kodas                                                                 | 10  |     |     |     |
| String^       | sObjektas2     | antro objekto kodas                                                                 | 10  |     |     |     |
| String^       | sObjektas3     | trečio objekto kodas                                                                | 10  |     |     |     |
| String^       | sObjektas4     | ketvirto objekto kodas                                                              | 10  |     |     |     |
| Numeric(12,4) | dKaina1        | prekės pardavimo kaina sandėlyje                                                    |     |     |     |     |
| Numeric(12,4) | dKaina2        | prekės pardavimo kaina sandėlyje                                                    |     |     |     |     |
| Numeric(12,4) | dKaina3        | prekės pardavimo kaina sandėlyje                                                    |     |     |     |     |
| Numeric(12,4) | dKaina4        | prekės pardavimo kaina sandėlyje                                                    |     |     |     |     |
| Numeric(12,4) | dKaina5        | prekės pardavimo kaina sandėlyje                                                    |     |     |     |     |
| Numeric(12,4) | dKaina6        | prekės pardavimo kaina sandėlyje                                                    |     |     |     |     |
| String^       | sValiuta       | prekės pardavimo valiuta sandėlyje                                                  | 3   |     |     |     |
| String^       | sSandelioVieta | sandėlio vietos kodas                                                               | 20  |     |     |     |
| int           | nPirmasMat     | Pirmas matavimas: 0 –ne, 1 – taip, prekės kiekis *nKiekis* nurodomas pirmu matavimu |     |     |     |     |

Pvz:

```xml
<VidPerkDok>
< sPavadinimas ></sPavadinimas >
< tData ></tData >
<sDokumentas></sDokumentas >
< sPastaba ></sPastaba >
< sIsSandelio ></sIsSandelio >
< sISandeli ></sISandeli >
<sSerija></sSerija>
< VidPerkDokDetEil>
< sKodas ></ sKodas >
< nKiekis ></ nKiekis >
< sObjektas1></ sObjektas1>
< sObjektas2></ sObjektas2>
< sObjektas3></ sObjektas3>
< sObjektas4></ sObjektas4>
< dKaina1></ dKaina1>
< dKaina2></ dKaina2>
< dKaina3></ dKaina3>
< dKaina4></ dKaina4>
< dKaina5></ dKaina5>
< dKaina6></ dKaina6>
< sValiuta ></ sValiuta >
< sSandelioVieta ></ sSandelioVieta >
</ < VidPerkDokDetEil>
</ VidPerkDok >
```

Išsaugojus operaciją grąžinama tokia informacija:

```xml
<OP_DUOMENYS>
<SERIJA>op_serijos_kodas</SERIJA>
<DOKUMENTAS>op_dokumentas</ DOKUMENTAS >
<ZURNALAS>op_žurnalo_kodas</ZURNALAS>
<NUMERIS>op_numeris</NUMERIS>
</<OP_DUOMENYS>
```

**Nurašymas:**

#### NurasymasDok, PajamavimasDok

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^  | sPavadinimas       | operacijos pavadinimas       | 50  |     |     |                                                                                 |
| DateTime | tData              | operacijos data              |     | +  |     |                                                                                 |
| String^  | sDokumentas        | dokumento numeris            | 20  | +  |     |                                                                                 |
| String^  | sPastaba           | operacijos pastaba           | 255 |     |     |                                                                                 |
| String^  | sKlientas          | dokumento klientas           | 15  |     |     |                                                                                 |
| String^  | sKlientImonesKodas | kliento įmonės kodas         | 30  |     |     | Jeigu nėra nurodytas kliento kodas, jis yra įrašomas pagal kliento įmonės kodą. |
| String^  | sDarbuotojas       | Finvaldos darbuotojo vardas  | 10  |     |     |                                                                                 |
| int      | nPozymis           | Pažymėta – 1, nepažymėta - 0 |     |     |     |                                                                                 |

#### NurasymasDokDetEil, PajamavimasDokDetEil

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sKodas       | prekės kodas                                                                        | 20  | +  |     |     |
| double  | nKiekis      | prekės kiekis antru matavimu (integer) arba pirmu jei nurodyta ***nPirmasMat=1***   |     | +  |     |     |
| String^ | sSaskaita    | eilutės sąskaitos kodas                                                             | 10  | +  |     |     |
| String^ | sSandelis    | sandėlio kodas                                                                      | 10  | +  |     |     |
| String^ | sPavadinimas | eilutės pavadinimas                                                                 | 150 |     |     |     |
| String^ | sObjektas1   | pirmo objekto kodas                                                                 | 10  |     |     |     |
| String^ | sObjektas2   | antro objekto kodas                                                                 | 10  |     |     |     |
| String^ | sObjektas3   | trečio objekto kodas                                                                | 10  |     |     |     |
| String^ | sObjektas4   | ketvirto objekto kodas                                                              | 10  |     |     |     |
| String^ | sObjektas5   | penkto objekto kodas                                                                | 10  |     |     |     |
| String^ | sObjektas6   | šešto objekto kodas                                                                 | 10  |     |     |     |
| int     | nPirmasMat   | Pirmas matavimas: 0 –ne, 1 – taip, prekės kiekis *nKiekis* nurodomas pirmu matavimu |     |     |     |     |
| int     | nPozymis     | Pažymėta – 1, nepažymėta - 0                                                        |     |     |     |     |

#### PajamavimasDokDetEil

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sKodas       | prekės kodas                                                                        | 20  | +  |     |     |
| double  | nKiekis      | prekės kiekis antru matavimu (integer) arba pirmu jei nurodyta ***nPirmasMat=1***   |     | +  |     |     |
| String^ | sSaskaita    | eilutės sąskaitos kodas                                                             | 10  | +  |     |     |
| String^ | sSandelis    | sandėlio kodas                                                                      | 10  | +  |     |     |
| double  | dSuma        | Eilutės suma                                                                        |     | +  |     |     |
| String^ | sPavadinimas | eilutės pavadinimas                                                                 | 150 |     |     |     |
| String^ | sObjektas1   | pirmo objekto kodas                                                                 | 10  |     |     |     |
| String^ | sObjektas2   | antro objekto kodas                                                                 | 10  |     |     |     |
| String^ | sObjektas3   | trečio objekto kodas                                                                | 10  |     |     |     |
| String^ | sObjektas4   | ketvirto objekto kodas                                                              | 10  |     |     |     |
| String^ | sObjektas5   | penkto objekto kodas                                                                | 10  |     |     |     |
| String^ | sObjektas6   | šešto objekto kodas                                                                 | 10  |     |     |     |
| int     | nPirmasMat   | Pirmas matavimas: 0 –ne, 1 – taip, prekės kiekis *nKiekis* nurodomas pirmu matavimu |     |     |     |     |
| Int     | nPozymis     | Pažymėta – 1, nepažymėta - 0                                                        |     |     |     |     |

Pvz:

```xml
<NurasymasDok>
<sPavadinimas></sPavadinimas>
<tData></tData>
<sDokumentas></sDokumentas>
<sPastaba></sPastaba>
<sKlientas></sKlientas>
<NurasymasDokDetEil>
<sKodas></sKodas>
<nKiekis></nKiekis>
<sSaskaita></sSaskaita>
<sSandelis></sSandelis>
<dSuma></dSuma>
<sObjektas1></sObjektas1>
<sObjektas2></sObjektas2>
<sObjektas3></sObjektas3>
<sObjektas4></sObjektas4>
</NurasymasDokDetEil>
</NurasymasDok>
```

Išsaugojus operaciją grąžinama tokia informacija:

```xml
<OP_DUOMENYS>
<DOKUMENTAS>op_dokumentas</ DOKUMENTAS >
<ZURNALAS>op_žurnalo_kodas</ZURNALAS>
<NUMERIS>op_numeris</NUMERIS>
</<OP_DUOMENYS>
```

**UVM anuliavimas:**

#### UVMAnulDok

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^  | sPavadinimas | operacijos pavadinimas       | 50  | +  |     |     |
| DateTime | tData        | operacijos data              |     | +  |     |     |
| String^  | sDokumentas  | dokumento numeris            | 20  | +  |     |     |
| String^  | sPastaba     | operacijos pastaba           | 255 |     |     |     |
| String^  | sDarbuotojas | Finvaldos darbuotojo vardas  | 10  |     |     |     |
| int      | nPozymis     | Pažymėta – 1, nepažymėta - 0 |     |     |     |     |

#### UVMAnulDokDetEil

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sZurnalas | anuliuojamos operacijos žurnalas | 10  | +  |     |     |
| long    | nNumeris  | Anuliuojamos operacijos numeris  |     | +  |     |     |

Pvz:

```xml
<UVMAnulDok>
<sDokumentas> </sDokumentas>
<sPavadinimas> </sPavadinimas>
<tData> </tData>
<sPastaba> </sPastaba>
<UVMAnulDokDetEil>
<sZurnalas> </sZurnalas>
<nNumeris> </nNumeris>
</UVMAnulDokDetEil>
</UVMAnulDok>
```

Išsaugojus operaciją grąžinama tokia informacija:

```xml
<OP_DUOMENYS>
<ZURNALAS>op_žurnalo_kodas</ZURNALAS>
<NUMERIS>op_numeris</NUMERIS>
</<OP_DUOMENYS>
```

#### GamybaDok

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^  | sGaminys     | Gaminio kodas                                  | 20  | +  |     |     |
| DateTime | tData        | operacijos data                                |     | +  |     |     |
| String^  | sDokumentas  | dokumento numeris                              | 20  | +  |     |     |
| String^  | sAprasymas   | Aprašymas                                      | 50  | +  |     |     |
| String^  | sAprasymas2  | Antras aprašymo laukas                         | 50  |     |     |     |
| String^  | sPastaba     | operacijos pastaba                             | 255 |     |     |     |
| Double   | dKiekis      | Kiekis                                         |     |     |     |     |
| Long     | nPerkelta    |                                                |     |     |     |     |
| String^  | sKlientas    | Kliento kodas, pajamavimo/nurašymo operacijose | 15  |     |     |     |
| String^  | sDarbuotojas | Finvaldos darbuotojo vardas                    | 10  |     |     |     |
| int      | nPozymis     | Pažymėta – 1, nepažymėta - 0                   |     |     |     |     |

#### GamybaGDetEil (Gaminys)

Privalo būti bent viena eilutė.

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sKodas         | Prekės kodas                                                                        | 20  | +  |     |     |
| String^ | sSandelis      | Sandėlio kodas                                                                      | 10  | +  |     |     |
| double  | nKiekis        | prekės kiekis antru matavimu (integer) arba pirmu jei nurodyta ***nPirmasMat=1***   |     | +  |     |     |
| double  | dSuma          | Suma                                                                                |     |     |     |     |
| Double  | dProcentas     | Procentas                                                                           |     |     |     |     |
| Long    | nVietuSkaicius | Vietų skaičius                                                                      |     |     |     |     |
| Double  | dBruto         | Svoris bruto                                                                        |     |     |     |     |
| Double  | dNeto          | Svoris neto                                                                         |     |     |     |     |
| double  | dTuris         | Tūris                                                                               |     |     |     |     |
| String^ | sObjektas1     | I objekto kodas                                                                     | 10  |     |     |     |
| String^ | sObjektas2     | II objekto kodas                                                                    | 10  |     |     |     |
| String^ | sObjektas3     | III objekto kodas                                                                   | 10  |     |     |     |
| String^ | sObjektas4     | IV objekto kodas                                                                    | 10  |     |     |     |
| String^ | sObjektas5     | V objekto kodas                                                                     | 10  |     |     |     |
| String^ | sObjektas6     | VI objekto kodas                                                                    | 10  |     |     |     |
| int     | nPirmasMat     | Pirmas matavimas: 0 –ne, 1 – taip, prekės kiekis *nKiekis* nurodomas pirmu matavimu |     |     |     |     |

#### GamybaZDetEil (Žaliavos)

Privalo būti bent viena eilutė.

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sKodas     | Prekės kodas                                                                        | 20  | +  |     |     |
| String^ | sSandelis  | Sandėlio kodas                                                                      | 10  | +  |     |     |
| double  | nKiekis    | prekės kiekis antru matavimu (integer) arba pirmu jei nurodyta ***nPirmasMat=1***   |     | +  |     |     |
| String^ | sObjektas1 | I objekto kodas                                                                     | 10  |     |     |     |
| String^ | sObjektas2 | II objekto kodas                                                                    | 10  |     |     |     |
| String^ | sObjektas3 | III objekto kodas                                                                   | 10  |     |     |     |
| String^ | sObjektas4 | IV objekto kodas                                                                    | 10  |     |     |     |
| String^ | sObjektas5 | V objekto kodas                                                                     | 10  |     |     |     |
| String^ | sObjektas6 | VI objekto kodas                                                                    | 10  |     |     |     |
| int     | nPirmasMat | Pirmas matavimas: 0 –ne, 1 – taip, prekės kiekis *nKiekis* nurodomas pirmu matavimu |     |     |     |     |

#### GamybaPDetEil (Paslaugos)

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sKodas     | Paslaugos kodas                                                                     | 13  | +  |     |                                                                                                                                                                           |
| double  | dSuma      | Kaina                                                                               |     | +  |     |                                                                                                                                                                           |
| double  | nKiekis    | prekės kiekis antru matavimu (integer) arba pirmu jei nurodyta ***nPirmasMat=1***   |     | +  |     | Kiekis padaugintas iš 100. Jeigu rekalingas kiekis 0.5 tada nKiekis = 50, jeigu reikalingas kiekis 1 tada nKiekis = 100. Jeigu nurodytas pirmu matavimu dauginti nereikia |
| int     | nPirmasMat | Pirmas matavimas: 0 –ne, 1 – taip, prekės kiekis *nKiekis* nurodomas pirmu matavimu |     |     |     |                                                                                                                                                                           |
| String^ | sObjektas1 | I objekto kodas                                                                     | 10  |     |     |                                                                                                                                                                           |
| String^ | sObjektas2 | II objekto kodas                                                                    | 10  |     |     |                                                                                                                                                                           |
| String^ | sObjektas3 | III objekto kodas                                                                   | 10  |     |     |                                                                                                                                                                           |
| String^ | sObjektas4 | IV objekto kodas                                                                    | 10  |     |     |                                                                                                                                                                           |
| String^ | sObjektas5 | V objekto kodas                                                                     | 10  |     |     |                                                                                                                                                                           |
| String^ | sObjektas6 | VI objekto kodas                                                                    | 10  |     |     |                                                                                                                                                                           |

#### UzskaitaDok

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^  | sPavadinimas | Pavadinimas                 | 50  |     |     |     |
| DateTime | tData        | Operacijos data             |     | +  |     |     |
| String^  | sDebitorius  | Debitoriaus kliento kodas   | 15  | +  |     |     |
| String^  | sKreditorius | Kreditoriaus kliento kodas  | 15  | +  |     |     |
| String^  | sDarbuotojas | Finvaldos darbuotojo vardas | 10  |     |     |     |

#### UzskaitaDebitDetEil

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| double | dSumaV | Suma nacionaline valiuta |  | + |  |  |
| String^ | sSerija | Užskaitomos operacijos serija |  | + |  |  |
| String^ | sDokumentas | Užskaitomos operacijos dokumentas |  | + |  |  |
| int | nTipas | Užskaitos tipas |  |  |  | Užskaitomos operacijos tipas:<br>– Išmoka, 3 – pardavimai, 4 pirkimų grąžinimai,6 - sąskaita |
| String^ | sObjektas1 | I objekto kodas | 10 |  |  | Objekto1...6 reikšmė priimama kai ntipas = 6 |
| String^ | sObjektas2 | II objekto kodas | 10 |  |  |  |
| String^ | sObjektas3 | III objekto kodas | 10 |  |  |  |
| String^ | sObjektas4 | IV objekto kodas | 10 |  |  |  |
| String^ | sObjektas5 | V objekto kodas | 10 |  |  |  |
| String^ | sObjektas6 | VI objekto kodas | 10 |  |  |  |
| String^ | sSaskaita | Sąskaitos kodas, kai klientas saskaitos tipo |  |  |  | Sąskaitos reikšmė priimama, kai nTipas=6 |

#### UzskaitaKreditDetEil

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| double | dSumaV | Suma nacionaline valiuta |  | + |  |  |
| String^ | sSerija | Užskaitomos operacijos serija |  | + |  |  |
| String^ | sDokumentas | Užskaitomos operacijos dokumentas |  | + |  |  |
| int | nTipas | Užskaitos tipas |  |  |  | Užskaitomos operacijos tipas:<br>Įplauka, 2 – pirkimai, 5 pardavimų grąžinimai,6 - sąskaita |
| String^ | sObjektas1 | I objekto kodas | 10 |  |  | Objekto1...6 reikšmė priimama kai ntipas = 6 |
| String^ | sObjektas2 | II objekto kodas | 10 |  |  |  |
| String^ | sObjektas3 | III objekto kodas | 10 |  |  |  |
| String^ | sObjektas4 | IV objekto kodas | 10 |  |  |  |
| String^ | sObjektas5 | V objekto kodas | 10 |  |  |  |
| String^ | sObjektas6 | VI objekto kodas | 10 |  |  |  |
| String^ | sSaskaita | Sąskaitos kodas, kai klientas saskaitos tipo |  |  |  | Sąskaitos reikšmė priimama, kai nTipas=6 |

Pvz:

**// Užskaitų su sąskaitos tipo klientu pavyzdžiai**

```xml
<UzskaitaDok>
<sDebitorius>Klientas</sDebitorius>
<sKreditorius>Klientas_SASK</sKreditorius>
<sPavadinimas>Uzskaita 1</sPavadinimas>
<tData>2016-03-18</tData>
<UzskaitaDebitDetEil>
<nTipas>3</nTipas>
<dSumaV>150</dSumaV>
<sSerija>ABC</sSerija>
<sDokumentas>111222691</sDokumentas>
</UzskaitaDebitDetEil>
</UzskaitaDok>
<UzskaitaDok>
<sDebitorius>Klientas_SASK</sDebitorius>
<sKreditorius>Klientas</sKreditorius>
<sPavadinimas>Uzskaita 2</sPavadinimas>
<tData>2016-03-18</tData>
<UzskaitaKreditDetEil>
<nTipas>2</nTipas>
<dSumaV>270</dSumaV>
<sSerija>A</sSerija>
<sDokumentas>11559</sDokumentas>
</UzskaitaKreditDetEil>
</UzskaitaDok>
```

**Pilnas ir detalus užskaitos pateikimas, kai pateikiamos abi pusės:**

```xml
<UzskaitaDok>
<sDebitorius>Klientas_1</sDebitorius>
<sKreditorius>Klientas_2</sKreditorius>
<sPavadinimas>Uzskaita</sPavadinimas>
<tData>2025-03-18</tData>
<UzskaitaKreditDetEil>
<dSumaV>270</dSumaV>
<nTipas>2</nTipas> //0 – įiplaukos, 2 – pirkimai, 5 – pardavimų gražinimai, 6 – sąskaita (6 tik sąskaitos tipo klientams, pavyzdys apačioje)
<sSerija>A</sSerija>
<sDokumentas>11559</sDokumentas>
</UzskaitaKreditDetEil>
<UzskaitaDebitDetEil>
<nTipas>2</nTipas> //1 – išmokos, 3 – pardavimai, 4 – pirkimų gražinimai, 6 - sąskaita
<dSumaV>270</dSumaV>
<sSerija>B</sSerija>
<sDokumentas>20001</sDokumentas>
<UzskaitaDebitDetEil>
</UzskaitaDok>
```

- nTipas yra privalomas

- Pagal nurodyta seriją ir dokumentą surandama operacija, kuri privalo būti EUR ir data privalo būti ankstesnė nei užskaitos data.

**Pilnas ir detalus užskaitos pateikimas, kai pateikiamos abi pusės, sąskaitos tipo klientams**

```xml
<UzskaitaDok>
<sDebitorius>Klientas_S1</sDebitorius>
<sKreditorius>Klientas_S2</sKreditorius>
<sPavadinimas>Uzskaita</sPavadinimas>
<tData>2025-03-18</tData>
<UzskaitaKreditDetEil>
<nTipas>6</nTipas>
<dSumaV>270</dSumaV>
<sSaskaita>241000</sSaskaita>
</UzskaitaKreditDetEil>
<UzskaitaDebitDetEil>
<nTipas>6</nTipas>
<dSumaV>270</dSumaV>
<sSaskaita>241001</sSaskaita>
<UzskaitaDebitDetEil>
</UzskaitaDok>
```

#### Inventorizacija

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sZurnalas | Operacijos žurnalas |     |     |     | neprivalomas |
| String^ | sSandelis | Sandėlis            |     |     |     | neprivalomas |
| Date    | tData     | Operacijos data     |     | +  |     |              |
| String^ | sKodas    | Prekės kodas        |     | +  |     |              |
| double  | dKiekis   | Prekės kiekis       |     | +  |     |              |

Kiekio saugojimo būdas pateikiamas \<mode\>, galimi variantai: 0 – kiekis užrašomas ant ankstesnės reikšmės, jeigu tą dieną tame sandėlyje jau yra inventorizacija prekei, jos kiekis atnaujinamas, 1 – kiekis sumuojamas, jeigu tą dieną tame sandėlyje jau yra inventorizacija prekei, naujas kiekis pridedamas prie esančio kiekio. Pagal nutylėjimą priskiriama reikšmė 0.

Pavyzdys (root tagas gali būti bet koks, užklausoje galima pateikti kelias operacijias)

```xml
<root>
<mode>0</mode>
<Inventorizacija>
<sZurnalas>INVENT</sZurnalas>
<sSandelis>01</sSandelis>
<tData>2024-03-03</tData>
<sKodas>B.BENZINAS</sKodas>
<sSandelioVieta/>
<dKiekis>15.45</dKiekis>
<sSaskaita>1275</sSaskaita>
<sObjektas1>DOZ94</sObjektas1>
</Inventorizacija>
<Inventorizacija>
<tData>2024-03-04</tData>
<sKodas>B.DYZELINAS_G</sKodas>
<dKiekis>16.789</dKiekis>
<sSaskaita>5091</sSaskaita>
<sObjektas1>DOZ94</sObjektas1>
<sObjektas2>DV02</sObjektas2>
</Inventorizacija>
</root>
```

#### KtNeanalitDok

Kita neanalitinė operacija

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sDokumentas   | Dokumentas                   |     | +  |     |     |
| String^ | sValiuta      | Valiuta                      |     | +  |     |     |
| Date    | tData         | Operacijos data              |     | +  |     |     |
| String^ | sPavadinimas1 | Aprašymas                    |     |     |     |     |
| String^ | sPavadinimas2 | Antras aprašymas             |     |     |     |     |
| String^ | sPastaba      | Pastaba                      |     |     |     |     |
| int     | nPozymis      | Pažymėta – 1, nepažymėta - 0 |     |     |     |     |

#### KtNeanalitDetEil

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sKodas       | Dokumentas       |     | +  |     |     |
| String^ | sPavadinimas | Valiuta          |     | +  |     |     |
| Double  | dDebetasL    | Debetas eur      |     | +  |     |     |
| Double  | dDebetasV    | Debetas valiutas |     |     |     |     |
| Double  | dKreditasL   | Kreditas eur     |     | +  |     |     |
| Double  | dKreditasV   | Kreditas valiuta |     |     |     |     |
| String^ | sObjektas1   | 1 objektas       |     |     |     |     |
| String^ | sObjektas2   | 2 objektas       |     |     |     |     |
| String^ | sObjektas3   | 3 objektas       |     |     |     |     |
| String^ | sObjektas4   | 4 objektas       |     |     |     |     |
| String^ | sObjektas5   | 5 objektas       |     |     |     |     |
| String^ | sObjektas6   | 6 objektas       |     |     |     |     |

Pvz:

```xml
<KtNeanalitDok>
<sDokumentas>TEST2</sDokumentas>
<tData>2024-10-01</tData>
<sValiuta>EUR</sValiuta>
<sPavadinimas1>Aprasymas</sPavadinimas1>
<sPavadinimas2>Aprasymas antras</sPavadinimas2>
<sPastaba>Pastaba</sPastaba>
<KtNeanalitDetEil>
<sKodas>1110</sKodas>
<sPavadinimas>Rytas</sPavadinimas>
<dDebetasV>73</dDebetasV>
<dDebetasL>73</dDebetasL>
<dKreditasV>63</dKreditasV>
<dKreditasL>63</dKreditasL>
<sObjektas1>OBJ1</sObjektas1>
<sObjektas2></sObjektas2>
<sObjektas3></sObjektas3>
<sObjektas4></sObjektas4>
<sObjektas5></sObjektas5>
<sObjektas6></sObjektas6>
</KtNeanalitDetEil>
</KtNeanalitDok>
```

### Rezultatas

Sėkmingos operacijos atveju grąžinamas kodas 0, bei eilutė su išsaugoto operacijos dokumentu, serijos kodu, žurnalus ir operacijos numeriu. Klaidos atveju – klaidos kodas (1 priedas) bei klaidos tekstas.

<a id="deleteoperation"></a>
## 3.71. DeleteOperation

### Aprašymas

```csharp
DeleteOperation(string ItemClassName, string sParamteras, string xmlString, out int nResult, out string sError)
```

Metodas vykdo pirkimo, pardavimo, įplaukos bei vidinio perkėlimo operacijų šalinimą.

### Įėjimo parametrai

| Pavadinimas | Tipas | Reikšmė |
| --- | --- | --- |
| ItemClassName | string | Operacijos pavadinimas:<br>DelPirkDok<br>– Pirkimo vykdymui<br>DelPirkUzsDok<br>– Pirkimo užsakymui<br>DelPirkGrazDok<br>– Pirkimo grąžinimui<br>DelPardDok<br>– Pardavimo vykdymui<br>DelPardRezDok<br>– Pardavimo rezervavimui<br>DelPardGrazDok<br>– Pardavimo grąžinimui<br>DelVidPerkDok<br>– Vidiniam perkėlimui<br>DelIplDok<br>– Įplaukai<br>DelUVMPirkUzsDok<br>– UVM pirkimo užsakymui<br>DelGamybaDok<br>– Gamybos operacija |
| sParametras | string | Importo parametras |
| xmlString | string | XML failo turinys |

Visų objektų laukų pavadinimai atitinka XML failo tag‘us.

### Išėjimo parametrai

*nResult* – Klaidos kodas (žr. I priedą);

*sError* – Klaidos tekstas, jei nResult \> 0, kitu atveju – informacija apie operaciją XML forma.

**DelPirkDok, DelVidPerkDok, DelIplDok, DelPardDok, DelPardRezDok, DelPardGrazDok, DelPirkDok, DelPirkUzsDok, DelPirkGrazDok, DelUVMPirkUzsDok, DelGamybaDok**

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sZurnalas | Operacijos žurnalas | 10  | +  |     |     |
| int     | nNumeris  | Operacijos numeris  |     | +  |     |     |

Pvz.:

```xml
<DelPirkDok>
<sZurnalas></sZurnalas>
<nNumeris></nNumeris>
</DelPirkDok>
```

### Rezultatas

Sėkmingos operacijos atveju grąžinamas kodas 0, bei eilutė su išsaugoto operacijos dokumentu, serijos kodu, žurnalus ir operacijos numeriu. Klaidos atveju – klaidos kodas (1 priedas) bei klaidos tekstas.

<a id="updateoperation"></a>
## 3.72. UpdateOperation

### Aprašymas

```csharp
UpdateOperation(string ItemClassName, string sParamteras, string xmlString, out int nResult, out string sError)
```

Metodas vykdo pardavimo operacijos koregavimą. Nurodomos prekės ir/arba paslaugos, kurios turi būti pašalinamos iš operacijos, bei prekės ar paslaugos, kurios bus įtrauktos į operaciją.

### Įėjimo parametrai

| Pavadinimas | Tipas | Reikšmė |
| --- | --- | --- |
| ItemClassName | string | Operacijos pavadinimas:<br>KoregPardDok<br>– Pardavimo vykdymui<br>KoregPardRezDok<br>– Pardavimo rezervavimui<br>KoregPardGrazDok<br>– Pardavimo gražinimai<br>KoregPirkDok<br>– Pirkimai<br>KoregPirkUzsDok<br>– Pirkimų užsakymai<br>KoregPirkGrazDok<br>– Pirkimų gražinimai<br>KoregVidPerkDok<br>– vidiniai perkėlimai |
| sParametras | string | Importo parametras |
| xmlString | string | XML failo turinys |

Visų objektų laukų pavadinimai atitinka XML failo tag‘us.

### Išėjimo parametrai

*nResult* – Klaidos kodas (žr. I priedą);

*sError* – Klaidos tekstas, jei nResult \> 0, kitu atveju – informacija apie operaciją XML forma.

```xml
<KoregPardDok>
<sZurnalas>PARD111</sZurnalas>
<nNumeris>19</nNumeris>
```

**KoregPardDok, KoregPardRezDok, KoregPirkDok, KoregPirkUzsDok, KoregPirkGrazDok, KoregVidPerkDok**

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sZurnalas | Operacijos žurnalas | 10  | +  |     |     |
| int     | nNumeris  | Operacijos numeris  |     | +  |     |     |

**PardDokHeadEil, PirkDokHeadEil, VidPerkDokHeadEil**

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^  | sSerija           | Operacijos serija                                                     | 10  |     |     |                                     |
| String^  | sDokumentas       | Dokumentas                                                            | 50  |     |     |                                     |
| String^  | sKlientas         | Kliento kodas                                                         |     |     |     | Tik KoregPardDok ir KoregPardRezDok |
| String^  | sDokRusis         | Dokumento rūšis, galimos reikšmės S, SF, D, DS, K, KS, KT, VS, VD, VK | 2   |     |     |                                     |
| String^  | sPavadinimas1     | Papildoma informacija 1                                               | 50  |     |     |                                     |
| String^  | sPavadinimas2     | Papildoma informacija 2                                               | 50  |     |     |                                     |
| String^  | sPavadinimas3     | Papildoma informacija 3                                               | 50  |     |     |                                     |
| String^  | sPavadinimas4     | Papildoma informacija 4                                               | 50  |     |     |                                     |
| String^  | sPavadinimas5     | Papildoma informacija 5                                               | 50  |     |     |                                     |
| String^  | sPastaba          | Pastaba                                                               | 255 |     |     |                                     |
| String^  | sKrovVazt         | Krovinio važtaraštis                                                  | 50  |     |     | **Važtaraščio laukas\***            |
| String^  | sSurasVieta       | Surašymo vieta                                                        | 150 |     |     | **Važtaraščio laukas\***            |
| String^  | sPakrovimoVieta   | Pakrovimo vieta                                                       | 150 |     |     | **Važtaraščio laukas\***            |
| String^  | sIskrovimoVieta   | Iškrovimo vieta                                                       | 150 |     |     | **Važtaraščio laukas\***            |
| String^  | sKrovSvoris       | Krovinio važtaraštis                                                  | 50  |     |     | **Važtaraščio laukas\***            |
| String^  | sKrovIsdAsmuo     | Krovinį išdavęs asmuo                                                 | 150 |     |     | **Važtaraščio laukas\***            |
| String^  | sKrovPrAsmuo      | Krovinį priėmęs asmuo                                                 | 150 |     |     | **Važtaraščio laukas\***            |
| DateTime | tSurasData        | Surašymo data                                                         |     |     |     | **Važtaraščio laukas\***            |
| DateTime | tPakrovimoData    | Pakrovimo data                                                        |     |     |     | **Važtaraščio laukas\***            |
| DateTime | tIskrovimoData    | Iškrovimo data                                                        |     |     |     | **Važtaraščio laukas\***            |
| String^  | sVairuotojas      | Vairuotojas                                                           | 150 |     |     | **Važtaraščio laukas\***            |
| String^  | sMasina           | Transporto priemonė                                                   | 150 |     |     | **Važtaraščio laukas\***            |
| String^  | sPapInfo          | Papildoma informacija                                                 | 150 |     |     | **Važtaraščio laukas\***            |
| String^  | sSutartis         | Sutartis                                                              | 13  |     |     |                                     |
| String^  | sVezejas          | Vežėjas                                                               | 15  |     |     |                                     |
| String^  | sGavejas          | Gavėjas                                                               | 15  |     |     |                                     |
| String^  | sIniciatorius     | Iniciatorius                                                          | 15  |     |     |                                     |
| String^  | sAdresas          | Adresas                                                               | 13  |     |     |                                     |
| String^  | sObjektas1        | Objektas1                                                             | 10  |     |     |                                     |
| String^  | sObjektas2        | Objektas2                                                             | 10  |     |     |                                     |
| String^  | sObjektas3        | Objektas3                                                             | 10  |     |     |                                     |
| String^  | sObjektas4        | Objektas4                                                             | 10  |     |     |                                     |
| DateTime | tMokejimoData     | Mokėjimo data                                                         |     |     |     |                                     |
| String^  | sPapIslaiduKodas1 | Pirmas papildomų išlaidų kodas                                        | 10  |     |     | Tik KoregPirkDok ir KoregPirkUzsDok |
| String^  | sPapIslaiduKodas2 | Antras papildomų išlaidų kodas                                        | 10  |     |     | Tik KoregPirkDok ir KoregPirkUzsDok |
| String^  | sPapIslaiduKodas3 | Trečias papildomų išlaidų kodas                                       | 10  |     |     | Tik KoregPirkDok ir KoregPirkUzsDok |
| String^  | sPapIslaiduKodas4 | Ketvirtas papildomų išlaidų kodas                                     | 10  |     |     | Tik KoregPirkDok ir KoregPirkUzsDok |
| int      | nPozymis          | Operacija pažymėta – 1, nepažymėta - 0                                |     |     |     |                                     |

**\* - Važtaraščio laukai tik pardavimams, pardavimu rezervavimams, pirkimų gražinimams.**

**DelPrekeDetEil**

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sKodas    | prekės kodas   | 20  | +  |     |     |
| String^ | sSandelis | sandėlio kodas | 10  |     |     |     |

**DelPaslaugaDetEil**

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sKodas | paslaugos kodas | 20  | +  |     |     |

**PardDokPrekeDetEil, PirkDokPrekeDetEil**

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^       | sKodas         | prekės kodas                                                                        | 20  | +  |     |                        |
| String^       | sSandelis      | sandėlio kodas                                                                      | 10  | +  |     |                        |
| Numeric(14,2) | dSumaV         | suma valiuta be pvm be nuolaidos                                                    |     | +  |     |                        |
| Numeric(14,2) | dSumaL         | suma EUR be pvm be nuolaidos                                                        |     | +  |     |                        |
| Numeric(14,2) | dSumaPVMV      | visa pvm suma valiuta                                                               |     |     |     | galutinis pvm          |
| Numeric(14,2) | dSumaPVML      | visa pvm suma EUR                                                                   |     |     |     | galutinis pvm          |
| Numeric(14,2) | dSumaNV        | prekės nuolaida valiuta                                                             |     |     |     | nuo sumos              |
| Numeric(14,2) | dSumaNL        | prekės nuolaida EUR                                                                 |     |     |     | nuo sumos              |
| Numeric(5,2)  | dNlProc        | prekės nuolaida procentais                                                          |     |     |     |                        |
| double        | nKiekis        | prekės kiekis antru matavimu (integer) arba pirmu jei nurodyta ***nPirmasMat=1***   |     | +  |     |                        |
| int           | nPirmasMat     | Pirmas matavimas: 0 –ne, 1 – taip, prekės kiekis *nKiekis* nurodomas pirmu matavimu |     |     |     |                        |
| Numeric(14,2) | dPapIsldSumaL1 | Pirmos papildomos išlaidos suma nacionaline valiuta                                 |     |     |     | Tik PirkDokPrekeDetEil |
| Numeric(14,2) | dPapIsldSumaV1 | Pirmos papildomos išlaidos suma operacijos valiuta                                  |     |     |     | Tik PirkDokPrekeDetEil |
| Numeric(14,2) | dPapIsldSumaL2 | Antros papildomos išlaidos suma nacionaline valiuta                                 |     |     |     | Tik PirkDokPrekeDetEil |
| Numeric(14,2) | dPapIsldSumaV2 | Antros papildomos išlaidos suma operacijos valiuta                                  |     |     |     | Tik PirkDokPrekeDetEil |
| Numeric(14,2) | dPapIsldSumaL3 | Trečios papildomos išlaidos suma nacionaline valiuta                                |     |     |     | Tik PirkDokPrekeDetEil |
| Numeric(14,2) | dPapIsldSumaV3 | Trečios papildomos išlaidos suma operacijos valiuta                                 |     |     |     | Tik PirkDokPrekeDetEil |
| Numeric(14,2) | dPapIsldSumaL4 | Ketvirtos papildomos išlaidos suma nacionaline valiuta                              |     |     |     | Tik PirkDokPrekeDetEil |
| Numeric(14,2) | dPapIsldSumaV4 | Ketvirtos papildomos išlaidos suma operacijos valiuta                               |     |     |     | Tik PirkDokPrekeDetEil |

**PardDokPaslaugaDetEil, PirkDokPaslaugaDetEil**

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^       | sKodas     | paslaugos kodas                                                                     | 13  | +  |     |                                                                                                                         |
| Numeric(14,2) | dSumaV     | suma valiuta be pvm be nuolaidos                                                    |     | +  |     |                                                                                                                         |
| Numeric(14,2) | dSumaL     | suma EUR be pvm be nuolaidos                                                        |     | +  |     |                                                                                                                         |
| Numeric(14,2) | dSumaPVMV  | visa pvm suma valiuta                                                               |     |     |     | galutinis pvm                                                                                                           |
| Numeric(14,2) | dSumaPVML  | visa pvm suma EUR                                                                   |     |     |     | galutinis pvm                                                                                                           |
| Numeric(14,2) | dSumaNV    | paslaugos nuolaida valiuta                                                          |     |     |     | nuo sumos                                                                                                               |
| Numeric(14,2) | dSumaNL    | paslaugos nuolaida EUR                                                              |     |     |     | nuo sumos                                                                                                               |
| Numeric(5,2)  | dNlProc    | paslaugos nuolaida procentais                                                       |     |     |     |                                                                                                                         |
| double        | nKiekis    | prekės kiekis antru matavimu (integer) arba pirmu jei nurodyta ***nPirmasMat=1***   |     | +  |     | Kiekis padaugintas iš 100. Jeigu rekalingas kiekis 0.5 tada nKiekis = 50, jeigu reikalingas kiekis 1 tada nKiekis = 100 |
| int           | nPirmasMat | Pirmas matavimas: 0 –ne, 1 – taip, prekės kiekis *nKiekis* nurodomas pirmu matavimu |     |     |     |                                                                                                                         |

***UpdPrekeDetEil (***Visoms operacijoms***)***

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sKodas   | prekės kodas          | 20  | +  |     |                              |
| int     | nKodasN  | Prekės numeris        |     | +  |     |                              |
| int     | nPozymis | Eilutės požymis       |     |     |     | 0 – nepažymėta, 1 - pažymėta |
| String^ | sPapInfo | Papildoma informacija |     |     |     |                              |

***DelPrekeDetEil*** (Vidiniams perkėlimams)

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sKodas  | prekės kodas   | 20  | +  |     |                                                                                                                                                                                            |
| int     | nKodasN | Prekės numeris |     |     |     | Laukas neprivalomas, jeigu laukas nenurodytas, bus pašalintos visos eilutės su nurodytu prekės kodu. Jeigu laukas nurodytas, bus pašalinta tik konkreti eilutė su nurodytu prekės numeriu. |

***AddPrekeDetEil*** (Vidiniams perkėlimams)

| Tipas | Laukas | Aprašymas | Ilgis | Privaloma | Pasirenkama | Pastaba |
| --- | --- | --- | --- | --- | --- | --- |
| String^ | sKodas         | prekės kodas                  | 20  | +  |     |                                                                                                                                                       |
| double  | dKiekis        | Prekės kiekis pirmu matavimus |     | +-  |     | Kiekio laukas nurodomas vienas pasirinktinai, nesvarbu kuris. Pavyzdžiui jeigu kiekis matuojamas kilogramais, tai dKiekis bus 15.98, o nKiekis 15980. |
| int     | nKiekis        | Prekės kiekis                 |     | +-  |     |                                                                                                                                                       |
| String^ | sPavadinimas   | Pavadinimas                   |     |     |     |                                                                                                                                                       |
| String^ | sValiuta       | Valiuta                       | 3   |     |     |                                                                                                                                                       |
| String^ | sObjektas1     | 1 Objektas                    |     |     |     |                                                                                                                                                       |
| String^ | sObjektas2     | 2 Objektas                    |     |     |     |                                                                                                                                                       |
| String^ | sObjektas3     | 3 Objektas                    |     |     |     |                                                                                                                                                       |
| String^ | sObjektas4     | 4 Objektas                    |     |     |     |                                                                                                                                                       |
| String^ | sObjektas5     | 5 Objektas                    |     |     |     |                                                                                                                                                       |
| String^ | sObjektas6     | 6 Objektas                    |     |     |     |                                                                                                                                                       |
| double  | dNeto          | Neto                          |     |     |     |                                                                                                                                                       |
| double  | dBruto         | Bruto                         |     |     |     |                                                                                                                                                       |
| double  | dTuris         | Tūris                         |     |     |     |                                                                                                                                                       |
| int     | nVietuSkaicius | Vietų skaičius                |     |     |     |                                                                                                                                                       |
| double  | dKaina1        | 1 Kaina                       |     |     |     |                                                                                                                                                       |
| double  | dKaina2        | 2 Kaina                       |     |     |     |                                                                                                                                                       |
| double  | dKaina3        | 3 Kaina                       |     |     |     |                                                                                                                                                       |
| double  | dKaina4        | 4 Kaina                       |     |     |     |                                                                                                                                                       |
| double  | dKaina5        | 5 Kaina                       |     |     |     |                                                                                                                                                       |
| double  | dKaina6        | 6 Kaina                       |     |     |     |                                                                                                                                                       |
| String^ | sPapInfo       | Papildoma informacija         |     |     |     |                                                                                                                                                       |
| int     | nPozymis       | Eilutės požymis               |     |     |     | 0 – nepažymėta, 1 - pažymėta                                                                                                                          |

Pvz.:

```xml
<KoregPardDok>
<sZurnalas></sZurnalas>
<nNumeris></nNumeris>
<PardDokHeadEil>
<sPavadinimas1>1</sPavadinimas1>
<sPavadinimas2>2</sPavadinimas2>
<sPavadinimas3>3</sPavadinimas3>
<sPavadinimas4>4</sPavadinimas4>
<sPavadinimas5>5</sPavadinimas5>
<sPastaba>pastaba</sPastaba>
<sKrovVazt>sKrovVazt</sKrovVazt>
<sSurasVieta>sSurasVieta</sSurasVieta>
<sPakrovimoVieta>sPakrovimoVieta</sPakrovimoVieta>
<sIskrovimoVieta>sIskrovimoVieta</sIskrovimoVieta>
<sKrovSvoris>sKrovSvoris</sKrovSvoris>
<sKrovIsdAsmuo>sKrovIsdAsmuo</sKrovIsdAsmuo>
<sKrovPrAsmuo>sKrovPrAsmuo</sKrovPrAsmuo>
<sVairuotojas>sVairuotojas</sVairuotojas>
<sMasina>sMasina</sMasina>
<sPapInfo>sPapInfo</sPapInfo>
<sSutartis>000</sSutartis>
<sVezejas>000000000000</sVezejas>
<sGavejas>000000000000</sGavejas>
<sIniciatorius>000000000000</sIniciatorius>
<sAdresas>01</sAdresas>
<sObjektas1>1</sObjektas1>
<sObjektas2>2</sObjektas2>
<sObjektas3>3</sObjektas3>
<sObjektas4>4</sObjektas4>
</PardDokHeadEil>
<DelPrekeDetEil>
<sKodas></sKodas>
<sSandelis></sSandelis>
</DelPrekeDetEil>
<DelPaslaugaDetEil>
<sKodas></sKodas>
</DelPaslaugaDetEil>
<PardDokPrekeDetEil>
<sKodas></sKodas>
<nKiekis></nKiekis>
<sSandelis></sSandelis>
<dSumaL></dSumaL>
<dSumaV></dSumaV>
</PardDokPrekeDetEil>
<PardDokPrekeDetEil>
<sKodas></sKodas>
<nKiekis></nKiekis>
<sSandelis></sSandelis>
<dSumaL></dSumaL>
<dSumaV></dSumaV>
</PardDokPrekeDetEil>
<PardDokPaslaugaDetEil>
<sKodas></sKodas>
<nKiekis></nKiekis>
<dSumaL></dSumaL>
<dSumaV></dSumaV>
</PardDokPaslaugaDetEil>
</ KoregPardDok >
```

#### KoregVidPerkDok

```xml
<KoregVidPerkDok>
<sZurnalas></sZurnalas> <!—Laukas privalomas, operacija surasti -->
<nNumeris></nNumeris> <!—Laukas privalomas, operacija surasti -->
<VidPerkDok> <!—Operacijos antraštė, laukas neprivalomas-->
<sKlientas></sKlientas>
<sSerija></sSerija>
<sDokumentas></sDokumentas>
<nPozymis></nPozymis>
</VidPerkDok>
<AddPrekeDetEil> <!—Pridedama nauja eilutė, laukas neprivalomas-->
<sKodas>PREKES_KODAS</sKodas>
<sPavadinimas></sPavadinimas>
<dKiekis>100.59</dKiekis>
<nKiekis></nKiekis>
</AddPrekeDetEil>
<AddPrekeDetEil>..</AddPrekeDetEil>
<DelPrekeDetEil> <!—Šalinama , laukas neprivalomas-->
<sKodas>PREKE2</sKodas>
<nKodasN>-1</nKodasN>
</DelPrekeDetEil>
<DelPrekeDetEil>...</DelPrekeDetEil>
<UpdPrekeDetEil> <!—Koreguojama eilutė , laukas neprivalomas-->
<sKodas>PREKE3</sKodas>
<nKodasN>1<nKodasN>
<nPozymis>1</nPozymis>
<sPapInfo>Informacija</sPapInfo>
</UpdPrekeDetEil>
<UpdPrekeDetEil>...</UpdPrekeDetEil>
</KoregVidPerkDok>
```

### Rezultatas

Sėkmingos operacijos atveju grąžinamas kodas 0, bei eilutė su išsaugoto operacijos dokumentu, serijos kodu, žurnalus ir operacijos numeriu. Klaidos atveju – klaidos kodas (1 priedas) bei klaidos tekstas.

<a id="lockoperation-unlockoperation"></a>
## 3.73. LockOperation, UnLockOperation

Operacijos užrakinimas ir atrakinimas. Paduodami parametrai:

- sParametras – Importo parametras

- sZurnlas – operacijos žurnalo kodas

- nNumeris – operacijos numeris

Užrakinimo ir atrakinimo funkcijos turi vienodus parametrus.

<a id="pavyzdžiai-2"></a>
### 3.78. Pavyzdžiai

**SOAP**

```xml
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://www.fvs.lt/webservices">
<soapenv:Header>
<web:AuthHeader>...</web:AuthHeader>
</soapenv:Header>
<soapenv:Body>
<web:LockOperation>
<web:sParametras>MIKRO</web:sParametras>
<web:sZurnalas>\$PARD.</web:sZurnalas>
<web:nNumeris>49193</web:nNumeris>
</web:LockOperation>
</soapenv:Body>
</soapenv:Envelope>
```

Rezultatas:

```xml
<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
<s:Body xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
<LockOperationResponse xmlns="http://www.fvs.lt/webservices">
<LockOperationResult>Success</LockOperationResult>
<nResult>0</nResult>
<sError/>
</LockOperationResponse>
</s:Body>
</s:Envelope>
```

**REST**

POST /FvsServicePure.svc/LockOperation

Content-Type: application/json

```json
{
"sParametras":"MIKRO",
"sZurnalas": "\$PARD.",
"nNumeris": 49193
}
```

Rezultatas:

```json
{"AccessResult":"Success","error":"","nResult":0}
```

<a id="isoperationlocked"></a>
## 3.74. IsOperationLocked

Funkcija tikrina ar operacija yra užrakinta. Paduodami parametrai:

- sZurnlas – žurnalo kodas

- nNumeris – operacijos numeris

Sėkmės atveju galimi atsakymai: 0 – operacija yra neužrakinta, 1 – operacija užrakinta darbuotojo, 2 – operacija užrakinta administratoriaus.

<a id="pavyzdžiai-3"></a>
### 4.31. Pavyzdžiai

**SOAP**

```xml
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://www.fvs.lt/webservices">
<soapenv:Header>
<web:AuthHeader>...</web:AuthHeader>
</soapenv:Header>
<soapenv:Body>
<web:IsOperationLocked>
<web:sZurnalas>\$PARD.</web:sZurnalas>
<web:nNumeris>49193</web:nNumeris>
</web:IsOperationLocked>
</soapenv:Body>
</soapenv:Envelope>
```

Rezultatas:

```xml
<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
<s:Body xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
<IsOperationLockedResponse xmlns="http://www.fvs.lt/webservices">
<IsOperationLockedResult>Success</IsOperationLockedResult>
<nResult>0</nResult>
<sError/>
<IsLocked>2</IsLocked>
</IsOperationLockedResponse>
</s:Body>
</s:Envelope>
```

**REST:**

POST /FvsServicePure.svc/IsOperationLocked

Content-Type: application/json

```json
{
"sZurnalas": "\$PARD.",
"nNumeris": 49193
}
```

Rezultatas

```json
{"AccessResult":"Success","error":"","IsLocked":2}
```

<a id="makeinvoice"></a>
## 3.75. MakeInvoice

###  Aprašymas

MakeInvoice(string sParam, out byte\[\] fileContents, out string sError) – funkcija pagal užduotus parametrus suformuoja sąskaitą faktūrą pdf formatu.

###  Įėjimo parametrai

sParam – faktūros parametrai surašyti į xml/json tekstinę eilutę, pavyzdys su galimomis reikšmėmis:

```xml
<root>
<FakturosKodas>Finvaldos faktūros kodas, pvz PARD_01, PIRK_05</FakturosKodas>
<sSerija>Operacijos serijos kodas</sSerija>
<sDokumentas>Operacijos dokumento numeris</sDokumentas>
<sZurnalas>Operacijos žurnalo kodas</sZurnalas>
<nNumeris>Operacijos numeris</nNumeris>
</root>
```

Analogiškai json: { „FakturosKodas“:“PARD_01“, ....}

###  Išėjimo parametrai

fileContents – suformuota pdf faktūra

sError – klaidos pranešimas.

<a id="makereport"></a>
## 3.76. MakeReport

###  Aprašymas

MakeReport(string sParam, out string fileContents, out string error) – funkcija pagal užduotus parametrus sugeneruoja ataskaitos pdf failą.

Ataskaitų sąrašas gali būti dinamiškai nuskaitomas metodu ReportList.

### Įėjimo parametrai

sParam – ataskaitos filtras pateiktas xml arba json formatu. Tuščių laukų nebūtina pateikti. Visi galimi filtravimo laukai:

```json
{
"Code": "BALANSAS_21",
"Warehouse": "",
"WarehouseGroup": "",
"Goods": {
"Type": "",
"Tag1": "",
"Tag2": "",
"Tag3": "",
"Tag4": "",
"Tag5": "",
"Tag6": "",
"Tag7": "",
"Tag8": "",
"Tag9": "",
"Tag10": "",
"Supplier1": "",
"Supplier2": "",
"Supplier3": ""
},
"Client":
{
"Code":"",
"Group":""
},
"DateFrom": "2000.01.01",
"DateTo": "2023.01.01",
"Logbook": "",
"LogbookGroup": "",
"OpType": "",
"OpTypeGroup": "",
"IncludeReturns": 0
}
```

Arba analogiškai xml formatu:

```xml
<root>
<Code>BALANSAS_21</Code>
```

…

```xml
</root>
```

Filtrų pavyzdžiai kiekvienai ataskaitų grupei. (Čia ‚XX‘ turėtų būti pakeista atskaitos numeriu, PIRKSAR_01, PIRKSAR_02 ir t.t.)

| Ataskaita | Filtras |
| --- | --- |
| Pirkimų sąrašas: PIRKSAR_XX<br>Pardavimų sąrašas: PARDSAR_XX | {<br>"code": "PIRKSAR_01",<br>"Warehouse": "CENTR.",<br>"Goods": {<br>"Type": "",<br>"Tag1": "",<br>...,<br>"Tag10": ""<br>},<br>"Client":<br>{<br>"Code":"KLIENTAS",<br>"Group":"GRUPE1"<br>},<br>"DateFrom": "2022.01.01",<br>"DateTo": "2023.01.01",<br>"Logbook": "PARD",<br>"LogbookGroup": "GRUPE2",<br>"OpType": "PARD",<br>"OpTypeGroup": "GRUPE3",<br>"IncludeReturns": 0<br>} |
| Įplaukų sąrašas, IPLSAR_XX,<br>Išmokų sąrašas, ISMSAR_XX | {<br>"code": "IPLSAR_01",<br>"Client":<br>{<br>"Code":"",<br>"Group":""<br>},<br>"DateFrom": "2022.01.01",<br>"DateTo": "2023.01.01",<br>"Logbook": "",<br>"LogbookGroup": "",<br>"OpType": "",<br>"OpTypeGroup": ""<br>} |
| Skolos datai, SKOL_DAT_XX | {<br>"code": "SKOL_DAT_01",<br>"Client":<br>{<br>"Code":"",<br>"Group":""<br>},<br>"DateTo": "2023.01.01",<br>"LogbookGroup": "",<br>"OpTypeGroup": ""<br>} |
| Einamieji likučiai, ELIK_KL_XX, ELIK_OBJ_XX, ELIK_PD_XX, ELIK_PR_XX, ELIK_PRG_XX, ELIK_SN_XX, ELIK_SV_XX | {<br>"code": "ELIK_KL_01",<br>"Warehouse": "",<br>"WarehouseGroup": "",<br>"Goods": {<br>"Type": "",<br>"Tag1": "",<br>...,<br>"Tag10": "",<br>"Supplier1": "",<br>"Supplier2": "",<br>"Supplier3": ""<br>},<br>"Client":<br>{<br>"Code":"",<br>"Group":""<br>},<br>"DateFrom": "2022.01.01",<br>"DateTo": "2023.01.01",<br>"OpTypeGroup": ""<br>} |
| Balansas, BALANSAS_XX | {<br>"code": "BALANSAS_01",<br>"DateTo": "2023.01.01"<br>} |
| Pelno ataskaita, PELN_XX | {<br>"code": "PELN_01",<br>"DateFrom": "2022.01.01",<br>"DateTo": "2023.01.01"<br>} |
| Skolų apyvartos: SKOLAP_XX | {<br>"code": "SKOLAP_01",<br>"DateTo": "2023.01.01",<br>"Client":<br>{<br>"Code":"",<br>"Group":""<br>},<br>"OpTypeGroup": ""<br>} |

<a id="getoperations"></a>
## 3.77. GetOperations

### Aprašymas

GetOperations(string opReadParams, out DataSet Data, out string error) – funkcija pagal užduotus parametrus skaito finvaldos operacijas.

- FvsServicePure.svc servisas leidžia kreitpis GET arba POST metodais.

### Įėjimo parametrai

opReadParams – funkcijos parametrai xml/json formatu, formatas toks:

```xml
<OpReadParams>
<OpClass>Sales</OpClass>
<fullOp>false<fullOp/> \* true – gražinama operacija su eilutėmis, false – be eilučių.
<filter>
<Journal>PARD</Journal>
<OpDateFrom>2020-01-01</OpDateFrom>
</filter>
<columns>
<column>op_number</column>
<column>op_date</column>
</columns>
<columnsDet> \* detalių eilučių stulpeliai, naudojami tik kai ‚fullOp = true‘
<column>code</column>
<column>title</column>
</columnsDet>
</OpReadParams>
```

**Arba**

```json
{"OpClass":"SalesDet", "fullOp":false,"filter":{"Journal":"", "JournalGroup":"", "OpNumber":0, "Series":"", "OrderNumber":"",
"OpDateFrom":"2020-12-12", "OpDateTill":"", "DateEditedFrom":"", "Client":"", "ClientGroup":"", "OpType":"", "OpTypeGroup":"", "Warehouse":"", "GoodsCode":"", "Object1":"", "Object2":"", "Object3":"", "Object4":"", "Object5":"", "Object6":""}, "columns":{"column":["journal","op_number"]}, "columnsDet":{"column":["code","title"]}}
```

| Parametras | Aprašymas | Galimos reikšmės |
| --- | --- | --- |
| OpClass | Nurodoma operacijos klasė, bus gražinami duomenys tik pasirinktos operacijos klasės | Sales – pardavimai.<br>SalesDet – pardavimų eilutės.<br>SalesReturns<br>– pardavimų gražinimai.<br>SalesReturnsDet<br>– pardavimų gražinimų eilutės.<br>Purchases<br>– pirkimai.<br>PurchasesDet<br>– pirkimų eilutės.<br>PurchasesReturns<br>– pirkimų gražinimai.<br>PurchasesReturnsDet<br>– pirkimų gražinimų eilutės.<br>GenLeadger<br>– kitos neanalitinės operacijos<br>GenLeadgerDet<br>– kitų neanalitinių operacijų eilutės.<br>Capitalization<br>– pajamavimai.<br>CapitalizationDet<br>– pajamavimų eilutės.<br>WriteOff<br>– nurašymai.<br>WriteOffDet<br>– nurašymų eilutės<br>Inflows – įplaukos<br>InflowsDet – įplaukų detalios eilutės<br>Disbursement – išmoka<br>DisbursementDet – išmokų detalios eilutės<br>ClearingOff – užskaita<br>ClearingOffDet – užskaitų detalios eilutės<br>SalesReservations – pardavimų rezervavimai<br>SalesReservationsDet – pardavimų rezervavimų eilutės<br>PurchaseOrders – pirkimų užsakymai<br>PurchaseOrdersDet – pirkimų užsakymų eilutės<br>InternalTransactions – vidiniai perkėlimai<br>InternalTransactionsDet – vidinių perkėlimų eilutės |
| fullOp | Gražinti operaciją be eilučių – false, gražinti operacija su eilutėmis – true. Taikomas tik tada kai "OpClass" yra ne detalių eilučių metodas "Det" | true/false |
| filter | Duomenų atrinkimo filtras<br>Pastabos:<br>Ne visi filtro laukai tinka visoms operacijoms. Todėl jeigu filtras negali būti panaudotas pasirinktai operacijų klasei, bus gražinama klaida.<br>Filtro pavadimai „tagai“ turi būti nurodyti tikslai kaip aprašyme. <Journal> - teisingai, <journal> - neteisingai.<br>Tušti filtro laukai yra ignoruojami. <Journal></Journal> nebus naudojamas.<br>Datų formatas yra „yyyy.MM.dd“ arba „yyyy-MM-dd“ | Journal<br>– operacijos žurnalas<br>JournalGroup<br>– operacijos žurnalų grupė<br>OpNumber<br>– opercijos numeris (int)<br>Series<br>– serija<br>OrderNumber<br>– dokumentas<br>OpDateFrom<br>– operacijos data nuo<br>OpDateTill<br>– operacijos data iki<br>DateEditedFrom<br>– operacijos koregavimo data nuo<br>DateCreatedFrom<br>– operacijos sukūrimo data<br>Client<br>– kliento kodas<br>ClientDeb<br>– kliento debitoriaus kodas užskaitos operacijose<br>ClientCred<br>- kliento kreditoriaus kodas užskaitos operacijose<br>ClientGroup<br>– klientų grupės kodas<br>OpType<br>– operacijos tipo kodas<br>OpTypeGroup<br>– operacijos tipų gruės kodas<br>Description, Description2, Description3, Description4, Description5<br>– operacijos pavadinimas. Galimas filtravimas pagal teksto iškarpą pridedant ‚*‘ simbolį. Pavyzdžiui ‚tekstas*‘ ar ‚*tekstas‘ ar bet kokia teksto seka, kur žvaigždutės reiškia bet kokių simbolių seką.<br>AdvancePaymentSettled<br>– naudojamas tik įplaukų sąraše ‚Inflows‘. Galimos reikšmės ‚true‘ – tik sudengtos, ‚false‘ – tik nesudengtos, jeigu filtre ‚<br>AdvancePaymentSettled<br>‘ nenurodytas tada filtras netaikomas.<br>NotCreatedByUser<br>– atmetamos operacijos kurios buvo sukurtos nurodyto darbuotojo.<br>NotEditedByUser –<br>atmetamos operacijos kurios buvo pakoreguotos nurodyto vartotojo.<br>Papildomi filtrai eilučių metodams (det)<br>Warehouse<br>– sandėlio kodas<br>GoodsCode<br>– prekės/paslaugos kodas<br>Object1..6<br>– objekto kodai |
| columns | Galima nurodyti stulpelių sąrašą ir rezultate bus gražinami tik nurodyti stulpeliai, jeigu sąrašas nenurodomas gražinami visi stulpeliai | Galima naudoti visus stulpelių pavadinimus, kuriuos gražina konkreti užklausa, priklausomai nuo<br>OpClass<br>gražinami stulpeliai skiriasi. Stulpelių sąrašas nebus pateikiamas, nes gali būti plečiamas sekančiose versijose. |
| columnsDet | Detalių eilučių stulpelių sąrašas, nadojamas tik tada kai "fullOp = true". |  |

Visi įmanomi operacijų antraščių laukai (gali būti pateikti ne kiekvieno tipo operacijose)

date_created

date_edited

op_number

journal

op_date

payment_date

issue_date

series

order_number

order_number_a

client

client_a

client_code

client_code_a
client_vatcode

client_vatcode_a

client_title

client_title_a

client_adress

client_adress_a

adress

dress_title

op_type

currency

contract

amount

user_name

description1

description2

description3

description4

description5

op_object1

op_object2

op_object3

op_object4

op_object5

op_object6

initial_debt_nc

initial_debt

paid_amount_nc
paid_amount

debt_nc

debt

initial_debt,

initial_debt_nc,

remark,

carrier,

receiver,

adress_text,

adress_info1,

adress_info2,

adress_info3,

adress_city,

adress_email,

adress_post_code,

adress_country,

adress_phone,

adress_street,

adress_building,

adress_apartment

Vidiniam perkėlimui:

warehouse_from

warehouse_to

Visi įmanomi operacijų detalių eilučių laukai (gali būti pateikti ne kiekvieno tipo operacijose)

date_created

date_edited

op_number

journal

type

code

title

quantity

code_n

warehouse

amount_nc

amount

vat_nc

vat

discount_nc

discount

neto

bruto

volume

extra_info

account_code

place_no

certificate

debt

debt_nc

extra_cost

extra_cost_nc

debit_amount

debit_amount_nc

credit_amount

credit_amount_nc

object1

object2

object3

object4

object5

object6

vat_percent

op_number_det

journal_det

depreciated

positive_impact

negative_impact

primary_cost

### Išėjimo parametrai

Rezultatų failas priklauso nuo pasirinktų stulpelių ir operacijos klasės.

## Pavyzdžiai

POST /FvsServicePure.svc/GetOperations HTTP/1.1

Accept: application/json

Content-Type: application/json

*{*

*"opReadParams": {*

*"OpClass": "Sales",*

*"fullOp": true,*

*"filter": { "OpDateFrom": "2024-05-01"},*

> *"columns": { "column": \["date_created", "date_edited", "op_number", client"\]},*

*"columnsDet": { "column": \["type","code","quantity","amount"\]}*

*}*

*}*

Arba

GET /FvsServicePure.svc/GetOperations?opReadParams={"OpClass":"Sales","fullOp":true,"filter"OpDateFrom":"2024-05-01 }, "columns":{"column":\["op_number","journal","op_date","paid_amount"\]},"columnsDet":{"column":\["type","code","quantity","amount"\]}} HTTP/1.1

Host: localhost:87

Accept: application/json

Content-Type: application/json

<a id="getrecommendedprice"></a>
## 3.79. GetRecommendedPrice

### inParams:

- invoiceType: int

  - 0 - pardavimų op. grupė

  - 1 - pirmimų op. grupė

- invoiceDate: FinDate - operacijos data

  - year: int

  - month: int

    - 1 - sausis

    - 12 - gruodis

  - day: int

    - Pirma mėn. diena == 1

- itemType: int - det. eilutės tipas

  - 1 - prekė

  - 2 - paslauga

- itemCode: string - det. eilutės kodas

- itemAmount: decimal - det. eilutės kiekis

- warehouseCode: string - det. eilutės sandėlio kodas

- clientCode: string - operacijos kliento kodas

- clientAdressCode: string - operacijos (antraštės) adreso kodas

- finUser: string - (Finvaldos) darbuotojas, pagal kurio individualius parametrus bus siūloma kaina (ne tas pats, kaip WS darbuotojas)

### Output

results: GetRecommendedPriceOut

- errorText: string

- errorCode: errorCode

  - 1 - nežinomas aprašymas

  - 2 - nežinomas Finvaldos darbuotojas

- accessResult: int

- price: decimal - siūloma kaina (be nuolaidos, be PVM)

- vat: decimal - siūlomas PVM

- discount: decimal - siūloma nuolaida

### REST

Request

```http
POST http://localhost:8088/FvsServiceR.svc/rest/GetRecommendedPrice HTTP/1.1
Accept-Encoding: gzip,deflate
Content-Type: application/json
```

```json
[STD HEADER]
{
"inParams": {
"invoiceType": 0,
"invoiceDate": { "year": 2022, "month": 4, "day": 6 },
"itemType": 1,
"itemCode": "101",
"itemAmount": 1,
"warehouseCode": "001",
"clientCode": "141577615",
"clientAdressCode": "",
"finUser": "S"
}
}
```

Responce

```json
{
"GetRecommendedPriceResult": 2,
"result": {
"accessResult": 2,
"errorCode": 0,
"errorText": "",
"discount": 8.8,
"price": 44,
"vat": 7.39
}
}
```

### SOAP

Request

```http
POST http://127.0.0.1:8087/FvsService.asmx HTTP/1.1
Accept-Encoding: gzip,deflate
Content-Type: text/xml;charset=UTF-8
SOAPAction: "http://www.fvs.lt/webservices/GetRecommendedPrice"
```

```xml
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://www.fvs.lt/webservices">
<soapenv:Header>
[STD HEADER]
</soapenv:Header>
<soapenv:Body>
<web:GetRecommendedPrice>
<web:inParams>
<web:invoiceType>0</web:invoiceType>
<web:invoiceDate>
<web:year>2022</web:year>
<web:month>4</web:month>
<web:day>6</web:day>
</web:invoiceDate>
<web:itemType>1</web:itemType>
<web:itemCode>101</web:itemCode>
<web:itemAmount>1</web:itemAmount>
<web:warehouseCode>001</web:warehouseCode>
<web:clientCode>141577615</web:clientCode>
<web:clientAdressCode></web:clientAdressCode>
<web:finUser>S</web:finUser>
</web:inParams>
</web:GetRecommendedPrice>
</soapenv:Body>
</soapenv:Envelope>
```

Responce

```xml
<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
<s:Body xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
<GetRecommendedPriceResponse xmlns="http://www.fvs.lt/webservices">
<GetRecommendedPriceResult>Success</GetRecommendedPriceResult>
<results>
<errorText/>
<errorCode>0</errorCode>
<accessResult>2</accessResult>
<price>44</price>
<vat>7.39</vat>
<discount>8.8</discount>
</results>
</GetRecommendedPriceResponse>
</s:Body>
</s:Envelope>
```

### PURE

Request

```http
POST http://localhost:8089/FvsServiceP.svc/GetRecommendedPrice HTTP/1.1
Accept-Encoding: gzip,deflate
Content-Type: application/json
UserName: S
Content-Length: 260
Host: localhost:8089
Connection: Keep-Alive
User-Agent: Apache-HttpClient/4.5.5 (Java/12.0.1)
```

```json
{
"inParams": {
"invoiceType": 0,
"invoiceDate": { "year": 2022, "month": 4, "day": 6 },
"itemType": 1,
"itemCode": "101",
"itemAmount": 1,
"warehouseCode": "001",
"clientCode": "141577615",
"clientAdressCode": "",
"finUser": "S"
}
}
```

<a id="insertdocument"></a>
## 3.80. InsertDocument

InsertDocument(InsertDocumentIn inParams, out InsertDocumentOut results)

### Input

inParams: InsertDocumentIn

- fileName: string - failo pavadinimas su praplėtimu

- fileDescription: string - aprašymas

- regNr: string - registracijos numeris

- compositionDate: FinDate - failo formavimo data

  - year: int

  - month: int

    - 1 - sausis

    - 12 - gruodis

  - day: int

    - Pirma mėn. diena == 1

- searchPhrase: string - paiškos frazė

-

- info: string\[3\] - informacija

- content: string - failo turinys

- finUser: string - (Finvaldos) darbuotojas, pagal kurio individualius parametrus bus siūloma kaina (ne tas pats, kaip WS darbuotojas)

-

### Duomenų užkodavimas

inParams.content

Failo duomenys pateikiami tekstu, kuriame užkoduoti binariniai failo duomenys. Tekstas interpretuojamas simbolių poromis, kiekviena simbolių pora yra vienas baitas, reprezentuojamas šešioliktainiu skaičiumi.

###  C# Kodo pavyzdys

internal static string Encode(byte\[\] binaryData)

```json
{
```

return System.BitConverter.ToString(binaryData).Replace("-", string.Empty);

```json
}
```

### Output

results: AttachDocumentOut

- errorText: string

- errorCode: int

  - 1 - nėra nurodytas failo vardas

  - 2 - nežinomas Finvaldos darbuotojas

  - 3 - nėra nurodytas failo turinys

- accessResult: string

### REST

Request

```http
POST http://localhost:8088/FvsServiceR.svc/rest/InsertDocument HTTP/1.1
Accept-Encoding: gzip,deflate
Content-Type: application/json
```

```json
[STD HEADER]
{
"inParams": {
"fileName": "test00.txt",
"fileDescription": "fileDesc",
"regNr": "",
"compositionDate": { "year": 2022, "month": 4, "day": 6 },
"searchPhrase": "phrase",
"info": [
"infoA", "infoB", "infoC"
]
"content": "4C6F72656D20697073756D",
"finUser": "S"
}
}
```

### SOAP

Request:

```http
POST http://127.0.0.1:8087/FvsService.asmx HTTP/1.1
Accept-Encoding: gzip,deflate
Content-Type: text/xml;charset=UTF-8
SOAPAction: "http://www.fvs.lt/webservices/AttachDocument"
```

```xml
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://www.fvs.lt/webservices">
<soapenv:Header>
[STD HEADER]
</soapenv:Header>
<soapenv:Body>
<web:InsertDocument>
<web:inParams>
<web:fileName>test01.txt</web:fileName>
<web:fileDescription>fileDesc</web:fileDescription>
<web:regNr></web:regNr>
<web:compositionDate>
<web:year>2022</web:year>
<web:month>04</web:month>
<web:day>06</web:day>
</web:compositionDate>
<web:searchPhrase>phrase</web:searchPhrase>
<web:info>
<web:string>infoA</web:string>
<web:string>infoB</web:string>
<web:string>infoC</web:string>
</web:info>
<web:content>4C6F72656D20697073756D</web:content>
<web:finUser>S</web:finUser>
</web:inParams>
</web:InsertDocument>
</soapenv:Body>
</soapenv:Envelope>
```

### PURE

Request

```http
POST http://localhost:8089/FvsServiceP.svc/InsertDocument HTTP/1.1
Accept-Encoding: gzip,deflate
Content-Type: application/json
UserName: S
Content-Length: 396
Host: localhost:8089
Connection: Keep-Alive
User-Agent: Apache-HttpClient/4.5.5 (Java/12.0.1)
```

```json
{
"inParams": {
"fileName": "test00000.txt",
"fileDescription": "b",
"regNr": "c",
"compositionDate": {
"year": 2022,
"month": 4,
"day": 6
},
"searchPhrase": "f",
"info": [
"infoA",
"infoB"
],
"content": "4C6F72656D20697073756D",
"finUser": "S"
}
}
```

<a id="deletedocument"></a>
## 3.81. DeleteDocument

DeleteDocument(string fileName, out string error) – pašalinamas dokumentas iš sistemos, nurodomas tik failo vardas sus plėtiniu. Metodas kviečiamas POST protokolu arba SOAP.

<a id="attachdocument"></a>
## 3.82. AttachDocument

AttachDocument(AttachDocumentIn inParams, out AttachDocumentOut results)

### Input

inParams: AttachDocumentIn

entityType: int - esybės, prie kurios bus prikabintas dokumentas, klasės identifikatorius

entityId - esybės, prie kurios bus prikabintas dokumentas, įrašo identifikatoriai

id1: string

id2: string

finUser: string - (Finvaldos) darbuotojas, kurio vardu atliekama operacija (ne tas pats, kaip WS darbuotojas)

documentId: string - dokumento, kuris bus prikabintas, kodas (failo vardas)

Esybių identifikavimas

(esybės) Klasės identifikatorius

Prie kokios klasės esybės bus prikabinamas dokumentas nurodo parametras entityType: int, kurio leistinos reikšmės yra Finvaldos view'ų identifikatoriai (contents.mdb 🠞 lentelė "view" 🠞 stulpelis "vid"; taipogi FinDataModel::FinViewID).

**Dažnai naudojamos reikšmės:**

1 - Sąskaita; 2 - Klientas; 8 - Prekė; 16 - Paslauga

7 - Pirkimas; 77 - Pirkimo užsakymas; 76 - Pirkimo grąžinimas

3 - Pardavimas; 75 - Pardavimo rezervavimas; 74 - Pardavimo grąžinimas

98 - Pajamavimas; 97 - Nurašymas; 78 - Vidinis perkėlimas

**Aprašymai**

Aprašymai identifikuojami pagal aprašymo kodą (kodus).

Jei aprašymas turi vienintelį kodą (pvz. prekė, paslauga, klientas):

```json
"entityId": { "id1": "PREKĖS_KODAS00", "id2": "" }
```

Jei aprašymas turi dvigubą kodą (pvz. adreso kortelė, prekės įrašas konkurento kainoraštyje):

```json
"entityId": { "id1": "KLIENTO_KODAS", "id2": "ADRESO_KODAS" }
```

Operacijos

Operacijos identifikuojamos pagal žurnalo kodą ir operacijos numerį:

```json
"entityId": { "id1": "PARD", "id2": "42" }
```

### Output

results: AttachDocumentOut

errorText: string

errorCode: int

1 - failas jau yra prikabintas prie nurodytos esybės

2 - nežinomas Finvaldos darbuotojas

accessResult: string

### PVZ:

#### REST

Request

```http
POST http://localhost:8088/FvsServiceR.svc/rest/AttachDocument HTTP/1.1
Accept-Encoding: gzip,deflate
Content-Type: application/json
```

```json
[STD HEADER]
{
"inParams": {
"entityType": 8,
"entityId": { "id1": "010", "id2": "" },
"finUser": "S2",
"documentId": "a.txt"
}
}
```

#### SOAP

Request

```http
POST http://127.0.0.1:8087/FvsService.asmx HTTP/1.1
Accept-Encoding: gzip,deflate
Content-Type: text/xml;charset=UTF-8
SOAPAction: "http://www.fvs.lt/webservices/AttachDocument"
```

```xml
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://www.fvs.lt/webservices">
<soapenv:Header>
[STD HEADER]
</soapenv:Header>
<soapenv:Body>
<web:AttachDocument>
<web:inParams>
<web:entityType>8</web:entityType>
<web:entityId>
<web:id1>010</web:id1>
<web:id2></web:id2>
</web:entityId>
<web:finUser>S2</web:finUser>
<web:documentId>a.txt</web:documentId>
</web:inParams>
</web:AttachDocument>
</soapenv:Body>
</soapenv:Envelope>
```

#### PURE

Request

```http
GET http://localhost:8089/FvsServiceP.svc/AttachDocument?entityType=8&id1=010&finUser=S2&documentId=a.txt HTTP/1.1
Accept-Encoding: gzip,deflate
UserName: S
Content-Type: application/json
Host: localhost:8089
Connection: Keep-Alive
User-Agent: Apache-HttpClient/4.5.5 (Java/12.0.1)
```

### Responce

#### JSON

HTTP/1.1 200 OK

Content-Length: 111

Content-Type: application/octet-stream

Server: Microsoft-HTTPAPI/2.0

Date: Wed, 21 Sep 2022 13:46:53 GMT

```json
{
"AccessResult":"Success",
"error":"",
"result":{
"errorText": "",
"errorCode": 0,
"accessResult": 2
}}
```

#### XML

HTTP/1.1 200 OK

Content-Length: 184

Content-Type: application/octet-stream

Server: Microsoft-HTTPAPI/2.0

Date: Wed, 21 Sep 2022 13:51:37 GMT

```xml
<root>
<AccessResult>Success</AccessResult>
<error></error>
<AttachDocumentOut>
<errorText />
<errorCode>0</errorCode>
<accessResult>2</accessResult>
</AttachDocumentOut>
</root>
```

<a id="getattacheddocuments"></a>
## 3.83. GetAttachedDocuments

GetAttachedDocuments(GetAttachedDocumentsIn inParams, out GetAttachedDocumentsOut results)

### Input

inParams: GetAttachedDocumentsIn

entityType: int

idValues: ID\[\]

id1: string

id2: string

Esybių identifikavimas analogiškai, kaip dokumentų prikabinime.

### Output

results: AttachDocumentOut

errorText: string

errorCode: errorCode

accessResult: int

enitityDocs: EnitityDocs\[\]

idString1: string - esybės, prie kurios prikabintas failas, identifikatorius

idString2: string - esybės, prie kurios prikabintas failas, identifikatorius

docs: AttachedDoc\[\]

name: string - failo vardas su praplėtimu

data: string - failo turinys

### Duomenų interpretavimas

results.enitityDocs\[0\].docs\[0\].data

Failo duomenys pateikiami tekstu, kuriame užkoduoti binariniai failo duomenys. Tekstas interpretuojamas simbolių poromis, kiekviena simbolių pora yra vienas baitas, reprezentuojamas šešioliktainiu skaičiumi.

### C# kodo pavyzdys

```csharp
void DataToDisk(string data, string filePath)
{
byte[] binaryData = new byte[data.Length / 2];
for (int i = 0; i < data.Length; i += 2)
binaryData[i / 2] = ((byte)int.Parse(data.Substring(i, 2), System.Globalization.NumberStyles.HexNumber));
System.IO.File.WriteAllBytes(filePath, binaryData);
}
```

Veiksmas DataToDisk("4C6F72656D20697073756D", "c:\tmp\test.txt") pagamins failą c:\tmp\test.txt, kurio turinys yra tekstas: Lorem ipsum

### PVZ

#### REST

**Request**

```http
POST http://localhost:8088/FvsServiceR.svc/rest/GetAttachedDocuments HTTP/1.1
Accept-Encoding: gzip,deflate
Content-Type: application/json
```

```json
[STD HEADER]
{
"inParams": {
"entityType": 75,
"idValues": [
{ "id1": "4ESAS", "id2": "20" },
{ "id1": "4ESAS", "id2": "21" }
]
}
}
```

**Responce**

```json
{
"GetAttachedDocumentsResult": 2,
"result": {
"accessResult": 2,
"errorCode": 0,
"errorText": "",
"enitityDocs": [{
"docs": [{
"data": "4C6F72656D20697073756D",
"name": "a.txt"
}],
"idString1": "4ESAS",
"idString2": "20"
}, {
"docs": [{
"data": "4C6F72656D20697073756D",
"name": "a.txt"
}, {
"data": "4E65766572207370656E642036206D696E7574657320646F696E6720736F6D657468696E672062792068616E64207768656E20796F752063616E207370656E64203620686F757273206661696C696E6720746F206175746F6D617465206974",
"name": "Ataskaita.txt"
}],
"idString1": "4ESAS",
"idString2": "21"
}]
}
}
```

#### SOAP

**Request**

```http
POST http://127.0.0.1:8087/FvsService.asmx HTTP/1.1
Accept-Encoding: gzip,deflate
Content-Type: text/xml;charset=UTF-8
SOAPAction: "http://www.fvs.lt/webservices/GetAttachedDocuments"
```

```xml
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://www.fvs.lt/webservices">
<soapenv:Header>
[STD HEADER]
</soapenv:Header>
<soapenv:Body>
<web:AttachDocument>
<web:inParams>
<web:idValues>
<web:ID>
<web:id1>4ESAS</web:id1>
<web:id2>20</web:id2>
</web:ID>
<web:ID>
<web:id1>4ESAS</web:id1>
<web:id2>21</web:id2>
</web:ID>
</web:idValues>
<web:entityType>75</web:entityType>
</web:inParams>
</web:AttachDocument>
</soapenv:Body>
</soapenv:Envelope>
```

**Responce**

```xml
<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
<s:Body xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
<GetAttachedDocumentsResponse xmlns="http://www.fvs.lt/webservices">
<GetAttachedDocumentsResult>Success</GetAttachedDocumentsResult>
<result>
<errorText/>
<errorCode>0</errorCode>
<accessResult>2</accessResult>
<enitityDocs>
<EnitityDocs>
<idString1>4ESAS</idString1>
<idString2>20</idString2>
<docs>
<AttachedDoc>
<name>a.txt</name>
<data>4C6F72656D20697073756D</data>
</AttachedDoc>
</docs>
</EnitityDocs>
<EnitityDocs>
<idString1>4ESAS</idString1>
<idString2>21</idString2>
<docs>
<AttachedDoc>
<name>a.txt</name>
<data>4C6F72656D20697073756D</data>
</AttachedDoc>
<AttachedDoc>
<name>Ataskaita.txt</name>
<data>4E65766572207370656E642036206D696E7574657320646F696E6720736F6D657468696E672062792068616E64207768656E20796F752063616E207370656E64203620686F757273206661696C696E6720746F206175746F6D617465206974</data>
</AttachedDoc>
</docs>
</EnitityDocs>
</enitityDocs>
</result>
</GetAttachedDocumentsResponse>
</s:Body>
</s:Envelope>
```

#### PURE

Skirtingai, nei REST ir SOAP variantams, šiuo metodu vienintele užklausa galima gauti prie vienintelės (Finvaldos) esybės prikabintus dokumentus.

**Request**

```http
GET http://localhost:8089/FvsServiceP.svc/GetAttachedDocument?entityType=75&id1=4ESAS&id2=21 HTTP/1.1
Accept-Encoding: gzip,deflate
UserName: S
Content-Type: application/json
Host: localhost:8089
Connection: Keep-Alive
User-Agent: Apache-HttpClient/4.5.5 (Java/12.0.1)
```

Responce (JSON)

```json
{
"AccessResult":"Success",
"error":"",
"result": {
"enitityDocs": [
{
"idString1": "4ESAS",
"idString2": "21",
"docs": [
{
"name": "a.txt",
"data": "436364"
},
{
"name": "Ataskaita.txt",
"data": "436358585676"
},
{
"name": "test.txt",
"data": "4E65766572207370656E642036206D696E7574657320646F696E6720736F6D657468696E672062792068616E64207768656E20796F752063616E207370656E64203620686F757273206661696C696E6720746F206175746F6D617465206974"
}
]
}
],
"errorText": "",
"errorCode": 0,
"accessResult": 2
}}
```

**Responce (XML)**

```xml
<root>
<AccessResult>Success</AccessResult>
<error/>
<GetAttachedDocumentsOut>
<errorText/>
<errorCode>0</errorCode>
<accessResult>2</accessResult>
<enitityDocs>
<EnitityDocs>
<idString1>4ESAS</idString1>
<idString2>21</idString2>
<docs>
<AttachedDoc>
<name>a.txt</name>
```

436364

```xml
</AttachedDoc>
<AttachedDoc>
<name>Ataskaita.txt</name>
```

436358585676

```xml
</AttachedDoc>
<AttachedDoc>
<name>test.txt</name>
```

4E65766572207370656E642036206D696E7574657320646F696E6720736F6D657468696E672062792068616E64207768656E20796F752063616E207370656E64203620686F757273206661696C696E6720746F206175746F6D617465206974

```xml
</AttachedDoc>
</docs>
</EnitityDocs>
</enitityDocs>
</GetAttachedDocumentsOut>
</root>
```

<a id="getuserpermissions"></a>
## 3.84. GetUserPermissions

### Input

- finUser: string - Finvaldos darbuotojo vardas

### Output

results: GetUserPermissionsOut

- errorText: string

- errorCode: errorCode

  - 2 - nežinomas Finvaldos darbuotojas

- accessResult: int

- perrmissions: PermissionRec\[\]

  - perrmisionClass: int

    - 65 - sandėliai

    - 6 - klientai

    - 51 - operacijos tipas

    - 81 - operacijos žurnalas

  - perrmisionCode: string - grupės, kuri specifikuoja darbuotojui leistinus normatyvus, kodas

  - permittedEntities: ID\[\]

    - id1: string

    - id2: string

### Sandėliai

- id1 - sandėlio kodas

- id2 – nenaudojamas

### Klientai

- id1 - kliento kodas

- id2 - nenaudojamas

### Operacijų tipai

- id1 - operacijos klasė

  - 1 - pirkimų grupė

  - 2 - pardavimų grupė

  - 3 - pajamavimai

  - 4 - nurašymai

  - 5 - vidiniai perkėlimai

  - 11 - įplaukos

  - 12 - išmokos

  - 13 - užskaitos

- id2 - operacijos tipo kodas

### Operacijų žurnalai

- id1 - operacijos klasė

  - 1 - Pirkimas

  - 23 - Pirkimo užsakymas

  - 24 - Pirkimo grąžinimas

  - 2 - Pardavimas

  - 25 - Pardavimo rezervavimas

  - 26 - Pardavimas grąžinimas

  - 3 - Pajamavimas

  - 4 - Nurašymas

  - 5 - Vidinis perkėlimas

  - 11 - Įplaukos

  - 12 - Išmokos

  - 13 - Užskaitos

- id2 - operacijos žurnalo kodas

### REST

#### Request

```http
POST http://localhost:8088/FvsServiceR.svc/rest/GetUserPermissions HTTP/1.1
Accept-Encoding: gzip,deflate
Content-Type: application/json
```

```json
[STD HEADER]
{
"finUser": "S5"
}
```

#### Responce

```json
{
"GetUserPermissionsResult": 2,
"results": {
"accessResult": 2,
"errorCode": 0,
"errorText": "",
"perrmissions": [
{
"permittedEntities": [
{ "id1": "3", "id2": "PAJAM" },
{ "id1": "2", "id2": "PARD04" },
{ "id1": "1", "id2": "PIRK" }
],
"perrmisionClass": 81,
"perrmisionCode": "X"
},
{
"permittedEntities": [
{ "id1": "11", "id2": "27101" },
{ "id1": "15", "id2": "27111" },
{ "id1": "1", "id2": "424011" },
{ "id1": "1", "id2": "Y01" },
{ "id1": "2", "id2": "PARD" }
],
"perrmisionClass": 51,
"perrmisionCode": "PERM01"
},
{
"permittedEntities": [
{ "id1": "WH_00", "id2": null },
{ "id1": "WH_02", "id2": null }
],
"perrmisionClass": 65,
"perrmisionCode": "WH_PERM"
}
]
}
}
```

### SOAP

#### Request

POST <http://127.0.0.1:8087/FvsService.asmx> HTTP/1.1

Accept-Encoding: gzip,deflate

Content-Type: text/xml;charset=UTF-8

SOAPAction: "<http://www.fvs.lt/webservices/GetUserPermissions>"

```xml
<soapenv:Envelope xmlns:soapenv="<http://schemas.xmlsoap.org/soap/envelope/>" xmlns:web="<http://www.fvs.lt/webservices>">
<soapenv:Header>
[STD HEADER]
</soapenv:Header>
<soapenv:Body>
<web:GetUserPermissions>
<web:finUser>S5</web:finUser>
</web:GetUserPermissions>
</soapenv:Body>
</soapenv:Envelope>
```

#### Responce

```xml
<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
<s:Body xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
<GetUserPermissionsResponse xmlns="http://www.fvs.lt/webservices">
<GetUserPermissionsResult>Success</GetUserPermissionsResult>
<results>
<errorText/>
<errorCode>0</errorCode>
<accessResult>2</accessResult>
<perrmissions>
<PermissionRec>
<perrmisionClass>81</perrmisionClass>
<perrmisionCode>X</perrmisionCode>
<permittedEntities>
<ID>
<id1>3</id1>
<id2>PAJAM</id2>
</ID>
<ID>
<id1>2</id1>
<id2>PARD04</id2>
</ID>
<ID>
<id1>1</id1>
<id2>PIRK</id2>
</ID>
</permittedEntities>
</PermissionRec>
<PermissionRec>
<perrmisionClass>51</perrmisionClass>
<perrmisionCode>PERM01</perrmisionCode>
<permittedEntities>
<ID>
<id1>11</id1>
<id2>27101</id2>
</ID>
<ID>
<id1>15</id1>
<id2>27111</id2>
</ID>
<ID>
<id1>1</id1>
<id2>424011</id2>
</ID>
<ID>
<id1>1</id1>
<id2>Y01</id2>
</ID>
<ID>
<id1>2</id1>
<id2>PARD</id2>
</ID>
</permittedEntities>
</PermissionRec>
<PermissionRec>
<perrmisionClass>65</perrmisionClass>
<perrmisionCode>WH_PERM</perrmisionCode>
<permittedEntities>
<ID>
<id1>WH_00</id1>
</ID>
<ID>
<id1>WH_02</id1>
</ID>
</permittedEntities>
</PermissionRec>
</perrmissions>
</results>
</GetUserPermissionsResponse>
</s:Body>
</s:Envelope>
```

### PURE

#### Request

```http
GET http://localhost:8089/FvsServiceP.svc/GetUserPermissions?finUser=S5 HTTP/1.1
Accept-Encoding: gzip,deflate
UserName: S
Content-Type: application/json
Host: localhost:8089
Connection: Keep-Alive
User-Agent: Apache-HttpClient/4.5.5 (Java/12.0.1)
```

#### Responce (JSON)

```xml
<\![CDATA[{"AccessResult":"Success","error":"","result":{
"perrmissions": [
{
"perrmisionClass": 81,
"perrmisionCode": "X",
"permittedEntities": [
{
"id1": "3",
"id2": "PAJAM"
},
{
"id1": "2",
"id2": "PARD04"
},
{
"id1": "1",
"id2": "PIRK"
}
],
"hasData": true,
"isEmpty": false
},
{
"perrmisionClass": 51,
"perrmisionCode": "PERM01"
"permittedEntities": [
{
"id1": "11",
"id2": "27101"
},
{
"id1": "15",
"id2": "27111"
},
{
"id1": "1",
"id2": "424011"
},
{
"id1": "1",
"id2": "Y01"
},
{
"id1": "2",
"id2": "PARD"
}
],
"hasData": true,
"isEmpty": false
},
{
"perrmisionClass": 65,
"perrmisionCode": "WH_PERM"
"permittedEntities": [
{
"id1": "WH_00"
},
{
"id1": "WH_02"
}
],
"hasData": true,
"isEmpty": false
}
],
"errorText": "",
"errorCode": 0,
"accessResult": 2
}}]]>
```

#### Responce (XML)

```xml
<root>
<AccessResult>Success</AccessResult>
<error/>
<GetUserPermissionsOut>
<errorText/>
<errorCode>0</errorCode>
<accessResult>2</accessResult>
<perrmissions>
<PermissionRec>
<perrmisionClass>81</perrmisionClass>
<perrmisionCode>X</perrmisionCode>
<permittedEntities>
<ID>
<id1>3</id1>
<id2>PAJAM</id2>
</ID>
<ID>
<id1>2</id1>
<id2>PARD04</id2>
</ID>
<ID>
<id1>1</id1>
<id2>PIRK</id2>
</ID>
</permittedEntities>
</PermissionRec>
<PermissionRec>
<perrmisionClass>51</perrmisionClass>
<perrmisionCode>PERM01</perrmisionCode>
<permittedEntities>
<ID>
<id1>11</id1>
<id2>27101</id2>
</ID>
<ID>
<id1>15</id1>
<id2>27111</id2>
</ID>
<ID>
<id1>1</id1>
<id2>424011</id2>
</ID>
<ID>
<id1>1</id1>
<id2>Y01</id2>
</ID>
<ID>
<id1>2</id1>
<id2>PARD</id2>
</ID>
</permittedEntities>
</PermissionRec>
<PermissionRec>
<perrmisionClass>65</perrmisionClass>
<perrmisionCode>WH_PERM</perrmisionCode>
<permittedEntities>
<ID>
<id1>WH_00</id1>
</ID>
<ID>
<id1>WH_02</id1>
</ID>
</permittedEntities>
</PermissionRec>
</perrmissions>
</GetUserPermissionsOut>
</root>
```

<a id="getdescriptions"></a>
# 4. GetDescriptions

###  Aprašymas

GetDescriptions(string readParams, out DataSet Data, out string error) – funkcija pagal užduotus parametrus skaito finvaldos aprašymus.

- FvsServicePure.svc servisas leidžia kreitpis GET arba POST metodais.

###  Įėjimo parametrai

readParams – funkcijos parametrai xml/json formatu. Sudaryti iš trijų pagrindinių dalių: tipo, filtro, stulpelių.

- "type" – nurodo kokius duomenis gražinti.

- Filtras kiekvienam tipui yra skirtingas (aprašymas pateiktas žemiau lentelėje).

- Stulpelių sąrašas "columns" leidžia nurodyti kuriuos stulpelius gražinti, jeigu sąrašas nenurodytas ar nurodytas tuščias gražinami visi stulpeliai.

  - Rekomenduojame nurodyti tik tuos stulpelius, kurie bus naudojami, tokiu budu užklausos veikia sparčiau.

- Pagal nutylėjimą užklausa laikoma xml tipo. Todėl užklauos antraštėje reikia nurodyti norimą tipą., pagal nurodytą tipą bus gražinamas ir rezultatas xml arba json:

  - Content-Type=application/xml

  - Content-Type=application/json

- Galimas rezultatų puslapiavimas, tam privaloma nurodyti puslapio numerį \[1..x\] ir puslapio dydį \[1..x\]. Parametrai "page" ir "limit". Jeigu parametrai nenurodyt arba nurodyti nuliai rezultatas gražinamas visas ir nepuslapiuojamas.

Pavyzdžiui skaitant likučius datai užklausos parametrai formuojami taip:

```json
{
"type": "StockOnDate",
"page":1,
"limit":100,
"StockOnDate": {
"Date": "",
"Code": "",
"Group": "",
"Type": "",
"TypeGroup": "",
"Supplier": "",
"Warehouse": "",
"WarehouseGroup": "VISI",
"Account": "",
"HasQuantity":""
},
"columns": ["warehouse", "product", "quantity", "primary_cost"]
}
```

Arba analogiškai xml

```xml
<root>
<type>StockOnDate</type>
<page>1</page>
<limit>100</limit>
<StockOnDate>
<Date></Date>
<Code></Code>
<Group></Group>
<Type></Type>
<TypeGroup></TypeGroup>
<Supplier></Supplier>
<Warehouse></Warehouse>
<WarehouseGroup>VISI</WarehouseGroup>
<Account></Account>
<HasQuantity></HasQuantity>
</StockOnDate>
<columns>warehouse</columns>
<columns>product</columns>
<columns>quantity</columns>
<columns>primary_cost</columns>
</root>
```

Skaitant ilgalaikio turto sąrašą, paduodama tokia informacija:

```json
{
"type": "FixedAsset",
"FixedAsset": {
"Codes": []
},
"columns": [ "code", "title", "initial_value", "depreciated", "salvage_value", "residual_value",
"acquisition_date", "commissioning_date", "writeoff_date", "depreciation_date"]
}
```

<a id="stockondate"></a>
## 4.2. StockOnDate

Likučiai datai.

```json
{
"type": "StockOnDate",
"page": 0,
"limit": 0,
"StockOnDate": { \* Filtras
"Date": "", \* Likučiai datai, jeigu data nenurodyta, naudojama einamoji data
"Code": "", \* Prekės kodas
"Group": "", \* Prekių grupės kodas
"Type": "", \* Prekių rūšis
"TypeGroup": "", \* Prekių rūšių grupės kodas
"Supplier": "", \* Tiekėjas
"Warehouse": "", \* Sandėlis
"WarehouseGroup": "", \* Sandėlių grupė
"Account": "", \* Sąskaita
"HasQuantity": "", \* Likutis >0, gražinami tik įrašai su kiekiu didesniu už 0.
"columns": [ \*Gražinamų stulpelių sąrašas, gražinami visi jeigu nenurodyta kitaip.
"warehouse", "warehouse_title", "product", "title", "type", "supplier", "supplier_title", "measure_unit", "quantity", "primary_cost", "account" ]
}
}
```

<a id="fixedasset"></a>
## 4.3. FixedAsset

Ilgailaikio turto sąrašas.

```json
{
"type": "FixedAsset",
"page": 0,
"limit": 0,
"FixedAsset": { \*Filtras
"Codes": [ \*Nurodomas ilgalaikio turto kodų sąrašas (nebūtinas)
"0099",
"0098"
]
},
"columns": \*Gražinamų stulpelių sąrašas, gražinami visi jeigu nenurodyta kitaip.
[ "code", "title", "initial_value", "depreciated", "salvage_value", "residual_value", "acquisition_date", "commissioning_date", "writeoff_date", "depreciation_date" ]
}
```

<a id="products"></a>
## 4.4. Products

Prekių sąrašas. Rekomenduojama skaityti tik tuos stulpelius kurie yra reikalingi, dėl greitaveikos.

```json
{
"type": "Products",
"page": 0,
"limit": 0,
"Products": { \*Filtras
"Codes": ["pirmas", "antras", "trečias"], \*Prekių kodų sąrašas
"Type": "", \*Prekės rūšis
"Tag1": "", \*Prekės 1 požymis
"Tag2": "", \*Prekės 2 požymis
"Tag3": "", \*Prekės 3 požymis
```

...

```json
"Tag20": "", \*Prekės 20 požymis
"Supplier1": "", \*Pirmojo tiekėjo kodas
"Supplier2": "", \*Antrojo tiekėjo kodas
"Supplier3": "", \*Trečiojo tiekėjo kodas
"Object1": "", \*1 objekto kodas
"Object2": "", \*2 objekto kodas
"Object3": "", \*3 objekto kodas
"Object4": "", \*4 objekto kodas
"Object5": "", \*5 objekto kodas
"Object6": "", \*6 objekto kodas
"EditedFrom": "", \*prekės koregavimo data >=
"CreatedFrom": "", \*prekės sukūrimo data >=
"Group": "", \*prekių grupės kodas
},
"columns": \*Gražinamų stulpelių sąrašas, gražinami visi jeigu nenurodyta kitaip.
[ "product", "title", "measure_unit", "measure_unit_ratio", "barcode", "barcodes", "remarks", "information", "type", "purchase_price", "purchase_currency", "sell_price1", "sell_price2", "sell_price3", "sell_price4", "sell_price5", "sell_price6", "sell_currency", "neto", "bruto", "volume", "overcharge", "num_of_places", "vat_percent", "date_created", "date_edited", "info1", "info2", "info3", "info4", "info5", "package_paper1", "package_paper2", "package_glass1", "package_glass2", "package_metal1", "package_metal2", "package_plastic1", "package_plastic2", "package_combined1", "package_combined2", "package_other1", "package_other2", "code_in_supplier1", "code_in_supplier2", "code_in_supplier3", "supplier", "supplier2", "supplier3", "object1", "object2", "object3", "object4", "object5", "object6", "country_of_origin", "quantity", "quantity_with_reserved", "last_purchase_price", "last_purchase_currency",
"tag1", "tag2", "tag3", "tag4", "tag5", "tag6", "tag7", "tag8", "tag9", "tag10", "tag11", "tag12", "tag13", "tag14","tag15", "tag16", "tag17", "tag18", "tag19", "tag20",
"tag1_title", "tag2_title", "tag3_title", "tag4_title", "tag5_title", "tag6_title", "tag7_title", "tag8_title", "tag9_title", "tag10_title", "tag11_title", "tag12_title", "tag13_title", "tag14_title", "tag15_title", "tag16_title", "tag17_title", "tag18_title", "tag19_title", "tag20_title"]
```
>
> \*Vengti naudoti stulpelius quantity/quantity_with_reserved/groups skaitant nefiltruotus didelius sąrašus

```json
}
```

<a id="currentstock"></a>
## 4.5. CurrentStock

Dabartiniai prekių likučiai

```json
{
"type": "CurrentStock",
"page": 0,
"limit": 0,
"Products": { \*Filtras
"Codes": [],
"Warehouse": "",
"WarehouseGroup": "",
"Type": "",
"Tag1": "", "Tag2": "", "Tag3": "", "Tag4": "", "Tag5": "", "Tag6": "", "Tag7": "", "Tag8": "",
"Tag9": "", "Tag10": "", "Tag11": "", "Tag12": "", "Tag13": "", "Tag14": "", "Tag15": "",
"Tag16": "", "Tag17": "", "Tag18": "", "Tag19": "", "Tag20": "",
"Supplier1": "", "Supplier2": "", "Supplier3": "",
"Object1": "", "Object2": "", "Object3": "", "Object4": "", "Object5": "", "Object6": "",
"CreatedFrom": "", "EditedFrom": "", "Group": ""
},
"columns": [
"warehouse", "warehouse_title", "code", "title", "quantity", "quantity_with_reserved",
"measure_unit", "primary_cost", "type", "tag1", "tag2", "tag3", "tag4", "tag5",
"tag6", "tag7", "tag8", "tag9", "tag10", "tag11", "tag12", "tag13", "tag14",
"tag15", "tag16", "tag17", "tag18", "tag19", "tag20", "sell_price1",
"sell_price2", "sell_price3", "sell_price4", "sell_price5", "sell_price6",
"sell_currency", "purchase_price", "purchase_currency", date_created, date_edited
]
}
```

<a id="currentstockdet"></a>
## 4.6. CurrentStockDet

Dabartiniai prekių likučiai detaliai

```json
{
"type": "CurrentStockDet",
"CurrentStockDet": { \*Filtras
"Client":"", \* Kliento kodas
"Supplier":"", \* Tiekėjo kodas
"Logbook":"", \* Žurnalo kodas
```

> OpType":0, \* Operacijos tipas: 2 – pirkimai, 5 – pardavimų gražinimai, 7 – pajamavimai, 8 – vidiniai perkėlimai

```json
"Location":"", \* Vietos kodas
"Codes": ["PIRMAS", "ANTRAS"], \*Prekių kodų sąrašas
"Warehouse": "", \*Sandėlio kodas
"WarehouseGroup": "", \*Sandėlio grupių kodas
"Type": "", \*Prekės rūšis ir požymiai
"Tag1": "", "Tag2": "", "Tag3": "", "Tag4": "", "Tag5": "", "Tag6": "", "Tag7": "", "Tag8": "",
"Tag9": "", "Tag10": "", "Tag11": "", "Tag12": "", "Tag13": "", "Tag14": "", "Tag15": "",
"Tag16": "", "Tag17": "", "Tag18": "", "Tag19": "", "Tag20": "",
"Supplier1": "", "Supplier2": "", "Supplier3": "", \* Tiekėjas prekės kortelėje
"Object1": "", "Object2": "", "Object3": "", \* Objektai operacijoje
"Object4": "", "Object5": "", "Object6": "",
"CreatedFrom": "", "EditedFrom": "", \* Prekės kortelės koregavimo/sukūrimo datos
"Group": "" \*Prekių grupės kodas
},
"columns": [
"warehouse", "warehouse_title", "code", "title", "quantity", "measure_unit", "primary_cost", "primary_cost_unit", "journal", "order_number", "op_type", "op_date", "enter_date", "location", "type", "tag1", "tag2", "tag3", "tag4", "tag5",
"tag6", "tag7", "tag8", "tag9", "tag10", "tag11", "tag12", "tag13", "tag14",
"tag15", "tag16", "tag17", "tag18", "tag19", "tag20", "object1",
"object2", "object3", "object4", "object5", "object6"
]
```

<a id="partnerproducts"></a>
## 4.7. PartnerProducts

Prekės partnerių kataloguose

```json
{
"type": "PartnerProducts",
"page": 0,
"limit": 0,
"PartnerProducts": { \*Filtras
"Products": ["prekes kodas 1", "prekes kodas 2"], \*prekių kodų sąrašas
"Client": "" \*Kliento kodas
},
"columns":
[ "client", "product", "partner_product", "price1", "price2", "price3", "currency", "used_price", "partner_type" ]
}
```

<a id="invoicelist"></a>
## 4.8. InvoiceList

Faktūrų sąrašas, pagal faktūros kodą galima operacija sugeneruoti pdf sąskaitą metodu „MakeInvoice“.

- Stulpelių pasirinkimas, negalimas, visda gražinami visi stulpeliai

- Puslapiavimas negalimas

```json
{
"type": "InvoiceList",
"InvoiceList": {
"OpClass": "PurchaseOrders"
}
}
```

<a id="reportlist"></a>
## 4.9. ReportList

Ataskaitų sąrašas. Pagal gražintą ataskaitos kodą galima sugeneruoti ataskaitą su metodu MakeReport.

```json
{
"type": "ReportList",
"ReportList": {
"Class": "Balansas" \* Galimos klasės: Balansas, Pirkimai, Pardavimai, Iplaukos, Ismokos,
```
>
> SkolosDatai, EinamiejiLikuciai, PelnoAtaskaita

```json
}
}
```

<a id="documentseries"></a>
## 4.10. DocumentSeries

Dokumentų serijų sąrašas, gražinami stulpeliai „code, title, number“. Visada gražinamas visas sąrašas, filtravima negalimas.

```json
{
"type": "DocumentSeries",
"Series":
{
"Type": 0, \* 0 – sąskaitų faktūrų, 1 – atsiskaitymo operacijų, jeigu nenurodyta arba bet kokia kita reikšmė tada filtras netaikomas
"UserName":"WEB" \* Vartotojo vardas, gražinamos serijos tik su kuriomis gali dirbti vartotojas.
}
}
```

<a id="countsales"></a>
## 4.11. CountSales

Pardavimų informacija, gražinami stulpeliai "quantity, sales_sum, settled_sum"

```json
{
"type": "CountSales",
"CountFilter": {
"DateFrom": "2020.01.01", \*Datos filtras, neprivalomas
"DateTo": "2023.01.01", \*Datos filtras, neprivalomas
"Client": "", \*Kliento kodas
"Paid": 0, \*1 – tik operacijos už kurias atsiskaityta, 2 – tik operacijos už kurias neatsiskaityta, visais kitais atvejais skaičiuojamos visos operacijos
}
}
```

<a id="countclients"></a>
## 4.12. CountClients

Klientų skaičius.

```json
{
"type": "CountClients",
"CountFilter": {
"DateFrom": "2020.07.01", \*Klientų sukūrimo data nuo, neprivalomas
"DateTo": "2023.01.01" \*Klientų sukūrimo data iki, neprivalomas
}
}
```

<a id="clientgroups"></a>
## 4.13. ClientGroups

Klientų grupių sąrašas.

```json
{
"type": "ClientGroups",
"columns": [ "code", "title", "info1", "info2" ]
}
```

<a id="logbookgroups"></a>
## 4.14. LogbookGroups

Žurnalų grupių sąrašas.

```json
{
"type": "LogbookGroups",
"columns": [ "code", "title", "info1", "info2" ]
}
```

<a id="optypegroups"></a>
## 4.15. OpTypeGroups

Operacijos tipų grupių sąrašas.

```json
{
"type": "OpTypeGroups",
"columns": [ "code", "title", "info1", "info2" ]
}
```

<a id="warehousegroups"></a>
## 4.16. WareHouseGroups

Sandėlių grupių sąrašas

```json
{
"type": "WarehouseGroups",
"columns": [ "code", "title", "info1", "info2" ]
}
```

<a id="calendarevents"></a>
## 4.17. CalendarEvents

Kalendoriaus įrašai

```json
{
"type": "CalendarEvents",
"CalendarEvents": {
"UserName": "ADMIN.", \*Darbuotojo prisijungimo vardas, laukas privalomas
"CreatedFrom": "2020-01-01", \*Įvykio sukūrimo data >=
"CreatedTo": "2020-02-01", \*Įvykio sukūrimo data <=
"ModifiedFrom": "2020-01-01", \*Įvykio koregavimo data >=
"ModifiedTo": "2020-02-01", \*Įvykio koregavimo data <=
"StartFrom": "2020-01-01", \*Įvykio pradžios data >=
"StartTo": "2020-02-01", \*Įvykio pradžios data <=
"EndFrom": "2020-01-01", \*Įvykio pabaigos data >=
"EndTo": "2020-02-01" \*Įvykio pabaigos data <=
},
"columns": [ "id", "subject", "location", "body", "start", "end", "created", "modified", "label", "allday",
"meeting", "isreminder", "deleted", "user_name", "client", "url" ]
}
```

<a id="companyworkstart"></a>
## 4.18. CompanyWorkStart

Įmonės veiklos pradžios data.

```json
{
"type": "CompanyWorkStart"
}
```

<a id="vehicles"></a>
## 4.19. Vehicles

Transporto priemonių sąrašas. Sąrašas nefiltruojamas, galimas tik puslapiavimas.

```json
{
"type": "Vehicles"
}
```

<a id="clients"></a>
## 4.20. Clients

Klientų sąrašas.

```json
{
"type": "Clients",
"page": 1,
"limit": 2,
"Clients": { \*Filtras
"Codes": ["TEST"], \*Klientų kodų sąrašas
"Type": "", \*Kliento rūšis
"Tag1": "", \*Kliento 1 požymis
"Tag2": "", \*Kliento 2 požymis
"Tag3": "", \*Kliento 3 požymis
"EditedFrom": "", \*Kliento koregavimo data >=
"EditedTill": "", \*Klietno koregavimo data <=
"CreatedFrom": "", \*Kliento sukūrimo data >=
"CreatedTill": "", \*Kliento sukūrimo data <=
"Email": "", \*Kliento email adresas
"VatCode": "", \*Kliento PVM mokėtojo kodas
"CompanyCode": "" \*Kliento įmonės kodas
},
"columns": [
"code", "title", "debt", "address", "phone", "fax", "representative", "bank", "account_debitor", "account_creditor", "company_code", "vat_payer_code", "remarks", "type", "email", "currency", "is_subdivision", "additional_inf", "tag1", "tag2", "tag3", "date_created", "date_edited", "address2", "name2", "country", "country_name", "city", "current_debt", "object1", "object2", "object3", "object4", "object5", "object6", "active", "payment_term_deb", "penalty_deb", "payment_term_cre", "penalty_cre", "vat_payment_code", "debit_account", "credit_account", "credit", "max_amount_of_debt", "debt_can_be_paid_in_days" ]
}
```

<a id="address"></a>
## 4.21. Address

Adresų sąrašas.

```json
{
"type": "Address",
"page": 1,
"limit": 10,
"Clients": {
"Codes": [ "TEST", "TEST2"], \*Klientų kodų sąrašas
"CompanyCode": "", \*Kliento įmonės kodas
"VatCode": "" \*Kliento pvm kodas
},
"Address": {
"Codes": ["SAN1", "SAN2"], \*Adreso kortelės kodų sąrašas
"Tag1": "", \*Adreso 1 požymis
"Tag2": "", \*Adreso 2 požymis
"Tag3": "", \*Adreso 3 požymis
"Tag4": "", \*Adreso 4 požymis
"Tag5": "" \*Adreso 5 požymis
},
"columns": ["client", "code", "info1", "info2", "info3", "tag1", "tag2", "tag3", "tag4", "tag5", "city", "email", "post_code", "country", "phone", "street", "house", "flat"]
}
```

<a id="productionitem"></a>
## 4.22. ProductionItem

Gaminių sąrašas. Sąrašui stulpelių pasirinkimas negalimas, gražinami visi duomenys.

```json
{
"type": "ProductionItem",
"page": 1,
"limit": 10,
"Products":
{
"Codes": [ "TEST", "TEST2"], \*Gaminio kodų sąrašas
"EditedFrom": "", \*Gaminio koregavimo data >=
"CreatedFrom": "" \*Gaminio sukūrimo data >=
}
}
```

<a id="services"></a>
## 4.23. Services

Paslaugų sąrašas.

```json
{
"type": "Services",
"page": 0,
"limit": 0,
"Services": {
"Codes": [ \*Paslaugos kodai
"TEST15",
"TEST19"
],
"Type": "", \*Paslaugos rūšis
"Tag1": "", \*Paslaugos 1 požymis
"Tag2": "", \*Paslaugos 2 požymis
"Tag3": "", \*Paslaugos 3 požymis
"CreatedFrom": "2023.06.01", \*Paslaugos sukūrimo data >=
"EditedFrom": "2023.06.01" \* Paslaugos koregavimo data >=
},
"columns":["code", "title", "barcode", "measure_unit", "purchase_price", "sell_price", "remarks_1", "remarks_2", "remarks_3", "remarks_4", "remarks_5", "remarks_6", "remarks_7", "remarks_8", "remarks_9", "remarks_10", "remarks_11", "remarks_12", "remarks_13", "type", "tag1", "tag2", "tag3", "date_created", "date_edited", "vat_percent"]
}
```

<a id="prices"></a>
## 4.24. Prices

Kainų sąrašas:

```json
{
"type": "Prices",
"Prices": {
"Type": 0, \*Eilutės tipas: 1 – prekė, 2 - paslauga
"Client": "", \*Kliento kodas
"Codes": [ \* prekių/paslaugų kodų sąrašas
"TEST15",
"TEST19"
],
"CreatedFrom":"2020-01-01",
"EditedFrom":"2020-01-01"
},
"columns":["client", "client_title", "type", "code", "title", "quantity_1", "quantity_2", "quantity_3", "quantity_4", "sum_1", "sum_2", "sum_3", "sum_4", "discount_1", "discount_2", "discount_3", "discount_4", "term_from_1", "term_from_2", "term_from_3", "term_from_4", "term_to_1", "term_to_2", "term_to_3", "term_to_4", "price", "currency", "price_card", "price_term", " currency_term", "price_card_term", "term_from", "term_to", "date_created", "date_edited", "adress"]
```

\* type – eilutės tipas (1 – prekė, 2 - paslauga)

\* code – prekės/paslaugos kodas

```json
}
```

<a id="pricesbyitemtype"></a>
## 4.25. PricesByItemType

```json
{
"type": "PricesByItemType",
"Prices": {
"Type": 0, \*Eilutės tipas: 1 – prekė, 2 - paslauga
"Client": "", \*Kliento kodas
"ItemType":"", \* prekės/paslaugos rūšies kodas
"CreatedFrom":"2020-01-01",
"EditedFrom":"2020-01-01"
},
"columns":["client", "client_title", "type", "item_type", "item_name", "quantity_1", "quantity_2", "quantity_3", "quantity_4", "sum_1", "sum_2", "sum_3", "sum_4", "discount_1", "discount_2", "discount_3", "discount_4", "term_from_1", "term_from_2", "term_from_3", "term_from_4", "term_to_1", "term_to_2", "term_to_3", "term_to_4", "price_card", "price_card_term", "term_from", "term_to", "date_created", "date_edited", “adress”]
```

\* type – eilutės tipas (1 – prekė, 2 - paslauga)

\* item_type - prekės/paslaugos rūšies kodas

```json
}
```

<a id="pricesbyclienttype"></a>
## 4.26. PricesByClientType

```json
{
"type": "PricesByClientType",
"Prices": {
"Type": 1, \*Eilutės tipas: 1 – prekė, 2 - paslauga
"ClientType": "", \*Kliento rūšies kodas
"Codes": [ \* prekių/paslaugų kodų sąrašas
"TEST15",
"TEST19"
],
"CreatedFrom":"2020-01-01",
"EditedFrom":"2020-01-01"
},
"columns":["client_type", "client_type_name", "type", "code", "title", "quantity_1", "quantity_2", "quantity_3", "quantity_4", "sum_1", "sum_2", "sum_3", "sum_4", "discount_1", "discount_2", "discount_3", "discount_4", "term_from_1", "term_from_2", "term_from_3", "term_from_4", "term_to_1", "term_to_2", "term_to_3", "term_to_4", "price", "currency", "price_card", "price_term", " currency_term", "price_card_term", "term_from", "term_to", "date_created", "date_edited"]
```

\* type – eilutės tipas (1 – prekė, 2 - paslauga)

\* code – prekės/paslaugos kodas

\* client_type – kliento rūšies kodas

```json
}
```

<a id="pricesbyclientanditemtypes"></a>
## 4.27. PricesByClientAndItemTypes

```json
{
"type": "PricesByClientAndItemTypes",
"Prices": {
"Type": 1, \*Eilutės tipas: 1 – prekė, 2 - paslauga
"ClientType": "", \*Kliento rūšies kodas
"ItemType": "", \* Prekės/paslaugos rūšies kodas
"CreatedFrom":"2020-01-01",
"EditedFrom":"2020-01-01"
},
"columns":["client_type", "client_type_name", "type", "item_type", "item_type_name", "quantity_1", "quantity_2", "quantity_3", "quantity_4", "sum_1", "sum_2", "sum_3", "sum_4", "discount_1", "discount_2", "discount_3", "discount_4", "term_from_1", "term_from_2", "term_from_3", "term_from_4", "term_to_1", "term_to_2", "term_to_3", "term_to_4", "price_card", "price_card_term", "term_from", "term_to", "date_created", "date_edited"]
```

\* type – eilutės tipas (1 – prekė, 2 - paslauga)

\* client_type – kliento rūšies kodas

\* item_type – prekės/paslaugos rūšies kodas

```json
}
```

<a id="barcodes"></a>
## 4.28. BarCodes

```json
{
"type": "BarCodes",
"Products":
{
"Codes": [ "TEST", "TEST2"], \*Prekių kodų sąrašas
"BarCodes": [ "47700001", "47700002"], \*Barkodų sąrašas
"CreatedFrom":"2020-01-05", \* koregavimo data >=
"EditedFrom":"2020-01-05" \* sukūrimo data >=
}
}
```

<a id="tagsandtypes"></a>
## 4.29. TagsAndTypes

Rūšių ir požymių skaitymas. Privalomi filtro parametrai **Type** ir **Number**. **Type** reikšmė nurodo kokio aprašymo rūšis ir požymiai gražinami, o **Number** nurodo požymio numerį, kur 0 yra rušis, o 1..x yra požymio numeris. Galimos reikšmės pateiktos lentelėje, nurodžius neteisingas reikšmes bus gražintas pranešimas su galimomis reikšmėmis.

| **Type** (Gali būti pateikiama tekstinė konstantą arba tekstinis numeris) | **Number** | Aprašymas                          |
|---------------------------------------------------------------------------|------------|------------------------------------|
| "product", "1"                                                            | 0..20      | Prekės rūšis ir požymiai           |
| "service", "2"                                                            | 0..3       | Paslaugos rūšis ir požymiai        |
| "client", "3"                                                             | 0..3       | Kliento rūšis ir požymiai          |
| "address", "4"                                                            | 1..5       | Adreso požymiai                    |
| "contract", "5"                                                           | 0..3       | Sutarties rūšis ir požymiai        |
| "fixedasset", "6"                                                         | 0..4       | Ilgalaikio turto rūšis ir požymiai |
| "lowvalueinventory", "7"                                                  | 0          | Mažaverčio inventoriaus rūšis      |

Pavyzdys kliento rūšių sąrašui nuskaityti

```json
{
"type": "TypesAndTags",
"TypesAndTags": {
"Type": "client",
"Number": 0,
"CreatedFrom": "2020-01-01",
"CreatedTill": "2025-01-01",
"Codes": []
}
}
```

<a id="currencyrates"></a>
## 4.30. CurrencyRates

Valitų kursai už pasirinktą laikotarpį. Pavyzdys skaitymui:

```json
{
"type": "CurrencyRates",
"CurrencyRates": {
"DateFrom": "2025-01-01",
"DateTo": "2025-01-05",
"Codes": ["USD", "DKK"]
}
}
```

## Pavyzdžiai

POST /FvsServicePure.svc/GetDescriptions HTTP/1.1

Accept: application/json

Content-Type: application/json

*{*

*"readParams":*

*{*

*"type":"Products", "page":0,"limit":0,*

*"Products": {"Codes":\["VIRDULYS","MILTAI"\] },*

*"columns":\["product","title","measure_unit","measure_unit_ratio","barcode","sell_price1","sell_currency","neto","bruto","volume","barcode_list"\]*

*}*

*}*

Arba

GET /FvsServicePure.svc/GetDescriptions?readParams={"type":"Products","page":0,"limit":0,"Products":{"Codes":\["VIRDULYS","MILTAI"\]},"columns":\["product","title","measure_unit","measure_unit_ratio","barcode","sell_price1","sell_currency","neto","bruto","volume","barcode_list"\]} HTTP/1.1

Host: localhost:87

Accept: application/json

Content-Type: application/json

<a id="metodų-kvietimas-json-formatu"></a>
# 5. Metodų kvietimas JSON formatu

> Visi metodai yra tie patys, aprašymai tinka visais atvejais, skiriasi tik užklausos ir atsakymo formatai.

Užklausos antraštė visiems metodams:

> Content-Type: application/json; charset=utf-8;
>
> UserName: Vardas
>
> Password: Slaptažodis
>
> ConnString: Prisijungimas
>
> RemoveEmptyStringTags:false
>
> RemoveZeroNumberTags:false
>
> RemoveNewLines:false
>
> Language: 0

Užklausos pavyzdys metodui „GetPaslauga“:

```json
{"sPaslaugosKodas":"NUOMA", "writeSchema":"true"}
```

Užklausos atsakymas:

GetPaslaugaResult=2

sError=

Xml={"?xml":{"@version":"1.0","@encoding":"utf-8"},"Fvs.Paslauga":{"FvsDatabase":"","sKodas":"NUOMA","sPavadinimas":"NUOMA", ...}}

Užklausos pavyzdys metodui „InsertNewItem“:

```json
{
"ItemClassName":"Fvs.ObjektasI",
"xmlString":"
{
```
>
> \\Fvs.ObjektasI\\:
>
```json
{
```
>
> \\sKodas\\:\\OBJ1_TEST\\,
>
> \\sPavadinimas\\:\\Pavadinimas\\
>
```json
}
}“
}
```

# **I Priedas – Klaidos**

2001 – Finvaldos sąrašo (recordset) atidarymo klaida;

2002 – Atminties klaida;

2031 – Transakcijos klaida;

2000 – Nenurodytas importo parametras;

2010 – Klaida programoje (Exception)

2011 – Neteisinga XML failo truktūra

2012 – Trūksta duomenų

<a id="aprašymų-klaidos"></a>
## 6.1. Aprašymų klaidos:

2 – Kartojasi PVM mokėtojo kodas;

3 – kartojasi kliento kodas;

4 – kartojasi įmonės kodas;

5 – nerastas pagrindinis kliento padalinys;

6 – nerastas atsiskaitymo terminas;

7 – nerastas PVM mokestis;

8 – nerastas sąskaitos kodas;

9 – nerastas banko kodas;

10 – nerasta klientų rūšis;

11 – nerasta valiuta;

12 – nerastas pirmas objektas;

13 – nerastas antras objektas;

14 – nerastas trečias objektas;

15 – nerastas ketvirtas objektas;

16 – nerastas pirmas kliento požymis;

17 – nerastas antras kliento požymis;

18 – nerastas trečias kliento požymis;

19 – nerasta prekės rūšis;

20 – nerastas pirmas prekės požymis;

21 – nerastas antras prekės požymis;

22 – Nerastas trečias prekės požymis;

23 – nerastas ketvirtas prekės požymis;

24 – nerastas penktas prekės požymis;

25 – nerastas šeštas prekės požymis;

26 – nerastas kliento kodas;

27 – nerastas intrastat kodas;

28 – kartojais BAR kodas;

29 – kartojasi prekės kodas;

30 – nerastas matavimo vienetas;

32 – nerastas prekių ryšys su sąskaitomis;

33 – nerastas ilgalaikio turto ryšys su sąskaitomis

34 – nerastas sandėlis;

35 – nerastas ilgalaikis turtas;

36 – nerastas serijos kodas;

37 – nerasta prekės sąskaita;

38 - nerasta paslaugos sąskaita;

39 – nerasta prekė;

40 – nerasta sąskaitų faktūrų serija;

41 – nerasta atsiskaitymo dokumentų serija;

42 – nerastas darbuotojas;

43 – nerastas padalinys;

44 – nerasta operacijos tipas;

45 – nerastas žurnalas;

46 – nerasta paslauga;

47 – nerastas komentaras;

48 – nerasta sandėlio vieta;

49 – naujasis mato vientas turi būti smulkesnis užsenąjį;

50 – nerasta klientų rūšies;

51 – nerastas pirmas klientų požymio;

52 – nerastas antras klientų požymio;

53 – nerastas trečias klientų požymis;

54 – nerastas kliento kodas;

55 – nerasta objektų (1 lygio) rūšis;

56 – nerastas pirmas objektų (1 lygio) požymis;

57 – nerastas antras objektų (1 lygio) požymis;

58 – nerastas trečias objektų (1 lygio) požymis;

59 – nerasta objektų (2 lygio) rūšis;

60 – nerastas pirmas objektų (2 lygio) požymis;

61 – nerastas antras objektų (2 lygio) požymis;

62 – nerastas trečias objektų (2 lygio) požymis;

63 – nerasta paslaugų rūšis;

64 – nerasta pirmas paslaugų požymis;

65 – nerastas antras paslaugų požymis;

66 – nerastas trečias paslaugų požymis;

69 – nerastas sutarties kodas;

70 – nerastas kliento adreso kodas;

71 – nerastas pirmas kliento adreso požymis;

72 – nerastas antras kliento adreso požymis;

73 – nerastas trečias kliento adreso požymis;

74 – kartojasi kliento adresas.

<a id="operacijų-klaidos"></a>
## 6.2. Operacijų klaidos:

1001 - naudojamas pardavimo dokumentas;

1002 - naudojamas pardavimo rezervavimo dokumentas;

1003 - pagrindinio rakto nuskaitymo klaida;

1004 - paradvimo rezeravimo koregavimas kopijuojant operaciją;

1005 - pardavimo rezervavimo šalinimas kopijuojant operaciją;

1006 – keičiama žymė;

1007 - kopijuojama pardavimo rezervavimo operacija nerasta duomenų bazėje;

1008 - nerastas operacijos tipas;

1009 - nežinomas eilutės tipas

1010 - prekės trūksta sandėlyje;

1011 – nerastas valiutos koeficientas;

1012 - atstatant prekes į sandėlį nerastas operacijos įrašas;

1013 - prekių jau yra praduota;

1014 - negalima keisti savikainos;

1015 - už operaciją buvo atsiskaitinėta. Ją stornuoti draudžiama;

1016 - operacija buvo perkainota. Ją stornuoti draudžiama;

1017- dalis prekių yra realizuota;

1018 - nesutampa prekių kiekis, nurodytas operacijoje ir duomenų bazėje;

1019 - kreditas nelygus debetui;

1020 - kreditas nelygus debetui balansinėje dalyje;

1021 - sąskaita nėra detali;

1022 - nerastas įrašas apie operacijos atsiskaitymą;

1023 - klientas yra atsiskaitęs didesnei sumai nei operacijos suma;

1024 - klientas yra iš dalies arba visiškai atsiskaitęs! Kliento kodo keisti negalima;

1025 - operacija yra perkainota! Kliento kodo keisti negalima.

1026 - yra suformuotas mokėjimo reikalavimas! Kliento kodo keisti negalima;

1027 - ilgalaikio turto kortelė jau nurašyta. Jos negalima pašalinti, koreguoti sumas bei kiekį!

1028 - ilgalaikio turto kortelė jau užpajamuota!

1029 - ilgalaikio turto kortelės įsigijimo vertė negali būti mažesnė nei likvidacinė vertė plius nusidėvėjimas;

1030 - ilgalaikio turto kortelė yra perkelta vėlesne data;

1031 - ilgalaikio turto kortelei yra paskaičiuotas nusidėvėjimas vėlesne data;

1032 - operacija yra pašalinta;

1033 - operacija yra stornuota/stornuojanti;

1034 - stornuojama operacija buvo koreguota (neatitinka viso suma);

1035 – dokumentas jau naudojamas pirkimo operacijoje;

1036 – nerastas importo parametras;

1037 – operacija neturi deatlių eilučių;

1038 – pakeista kliento skola valiutinei operacijai, už kurią pilnai atsiskaityta;

1039 – negalima trinti užrakinto kintamojo;

1040 – naudojamas pardavimo grąžinimo dokumentas;

1041 – dokumentas jau naudojamas pirkimo grąžinimo operacijoje;

1042 – dokumentas jau naudojamas pajamavimo operacijoje;

1043 – dokumentas jau naudojamas nurašymo operacijoje;

1044 – nerasta pardavimo operacija;

1045 – nerastas įrašas apie pardavimo operacijos kliento skolą;

1046 – operacijoje yra per daug detalių eilučių;

1047 – netinkamas kliento tipas – gali būti tik dokumento tipo;

1048 – įplaukos operacijoje už vieną dokumentą atsiskaityti galima vienintelį kartą;

1049 – nesutampa įplaukos ir pardavimo klientai;

1050 – įplaukos data yra ankstesnė, už pardavimo – kontroliuojama dienomis;

1051 – įplaukos data yra ankstesnė, už pardavimo – kontroliuojama mėnesiais;

1052 – įplaukos data yra ankstesnė, už pardavimo – kontroliuojama metais;

1053 – įplaukoje nurodyta suma viršyja pardavimo sumą;

1054 – įplaukoje nurodyta suma viršyja kliento skolą;

1055 – įmonės parametruose nėra nurodyta, kaip kontroliuoti operacijų datas.

1056 – Nežinomas įplaukos operacijos tipas!

1057 – Įplaukos eilutės suma turi būti didesnė už 0!

1058 – Dokumentas jau naudojamas operacijoje;

1059 – Nerastos operacijos tipą atitinkančios sąskaitos!

1060 – Detalios eilutės sąskaita nerasta sąskaitų plane!

1061 – Nerasta dokumentą atitinkanti sąskaita!

1062 – Nerastas operacijos tipas duomenų bazėje!

1063 – Nerasta operacija;

1064 – Operacija kitam atlikta klientui!

1065 – Atsiskaitoma suma viršija dokumento, už kurį atsiskaitoma, sumą!

1066 – Operacija yra perkainota vėlesne data!

1067 – Prekės kiekis detalioje eilutėje privalo būti teigiamas!

1068 – Prekės kaina detalioje eilutėje privalo būti neneigiama!

1069 – Paslaugos kiekis detalioje eilutėje privalo būti teigiamas!

1070 – Nerasta atitinkama operacija!

1071 – Serija nerasta duomenų bazėje!

1072 – Naudojamas pardavimo dokumentas.

1073 – Klaida nuskaitant pagrindinį operacijos raktą!

1074 – Vidiniame perkėlime sandėliai privalo būti skirtingi.

1075 – (WebService‘o kontekste nenaudojamas).

1076 – Detalioje eilutėje nenurodytas kodas.

1077 – (WebService‘o kontekste nenaudojamas).

1078 – (WebService‘o kontekste nenaudojamas).

1079 – (WebService‘o kontekste nenaudojamas).

1080 – (WebService‘o kontekste nenaudojamas).

1081 – (WebService‘o kontekste nenaudojamas).

1082 – (WebService‘o kontekste nenaudojamas).

1083 – (WebService‘o kontekste nenaudojamas).

1084 – Nerastas gaminio aprašymas arba gaminio aprašyme nėra žaliavų

1085 – Kliento tipas prieštarauja detalių eilučių tipui!

1086 – Dokumentas jau naudojamas UVM anuliavimo operacijoje!

1087 – Operacijos data yra ankstesnė, nei anuliuojamų operacijų!

1088 – Prekės/paslaugos kiekis eilutėje viršija kiekį iš laisvų užsakymų!

1089 – Pardavimo operacijoje bûtina nurodyti sutarties kodà.

1090 – Nerasta kita oepracija.

1091 – Debetas nelygus kreditui (EUR).

1092 – Debetas nelygus kreditui (valiuta).

1093 – Nurodyta netinkama sąskaita: sąskaita turi būti dedali, sąskaitos paskirtis turi būti 'kita'.

<a id="importavimo-klaidos"></a>
## 6.3. Importavimo klaidos

3000 – Nenurodytas naujo/koreguojamo kliento kodas;

3001 – Nenurodytas naujo kliento pavadinimas;

3002 – Nenurodytas naujos/koreguojamos prekės kodas;

3003 – Nenurodytas naujos prekės pavadinimas;

3004 – Nenurodytas naujos/koreguojamos paslaugos kodas;

3005 – Nenurodytas naujos paslaugos pavadinimas;

3006 – Nenurodytas pardavimo (grąžinimo, rezervavimo) klientas;

3007 – Nenurodyta pardavimo (grąžinimo, rezervavimo) valiuta;

3008 – Nenurodyta pardavimo (grąžinimo, rezervavimo) data;

3009 – Nenurodytas pirkimo (grąžinimo, užsakymo) klientas;

3010 – Nenurodyta pirkimo (grąžinimo, užsakymo) valiuta;

3011 – Nenurodyta pirkimo (grąžinimo, užsakymo) data;

3012 – Nenurodytas pirkimo (užsakymo) dokumentas;

3013 – Nenurodytas įplaukos klientas;

3014 – Nenurodytas įplaukos valiuta.

3015 – Nenurodytas sandėlio, iš kurio iškeliamos prekės, kodas;

3016 – Nenurodytas sandėlio, į kurį iškeliamos prekės, kodas;

3017 – Nenurodytas šalinamos operacijos žurnalo kodas;

3018 – Nenurodytas šalinamos operacijos numeris;

3019 – Nenurodytas koreguojamos operacijos žurnalo kodas;

3020 – Nenurodytas koreguojamos operacijos numeris;

3021 – Nenurodytas adreso kodas;

3022 – Nenurodytas adreso kliento kodas;

3023 – Nenurodytas adreso tekstas;

3024 – Nenurodytas UVM anuliavimo operacijos dokumentas.

3025 – Nenurodytas kitos neanalitinës operacijos dokumentas.

<a id="operacijų-šalinimo-klaidos"></a>
## 6.4. Operacijų šalinimo klaidos

4000 – Su šia operacija dirba kitas darbuotojas!

4001 – Nerasti operacijos duomenys!

4002 – Rakintos operacijos pašalinimas uždraustas!

4003 – Nerasti operacijos eilučių duomenys!

4004 – Operacijos data nepatenka į leistiną periodą!

4005 – Operacijos data nepatenka į jums nurodytą datų intervalą!

4006 – Nepavyko nuskaityti operacijos rūšies tipo!

4007 – Stornuotos operacijos šalinti negalima!

4008 – Nepavyko nuskaityti stornuotos operacijos įrašo!

4009 – Ilgalaikis turtas yra nurašytas. Šios operacijos šalinti negalima!

4010 – Ilgalaikis turtas yra parduotas. Šios operacijos šalinti negalima!

4011 – Su ilgalaikiu turtu atlikta pirkimo grąžinimo operacija. Šios operacijos šalinti negalima!

4012 – Su ilgalaikiu turtu atliktos vidinio judėjimo operacijos. Šios operacijos šalinti negalima!

4013 – Ilgalaikiui turtui yra paskaičiuotas nusidėvėjimas. Šios operacijos šalinti negalima!

4014 – Nepavyko nuskaityti įplaukų sąskaitos!

4015 – Už operaciją yra iš dalies arba visiškai atsiskaityta. Operacijos šalinimas uždraustas!

4016 – Ši operacija yra perkainota. Operacijos šalinimas uždraustas!

4017 – Šiai operacijai yra suformuotas mokėjimo reikalavimas. Operacijos šalinimas uždraustas!

4018 – Nerastas įrašas apie operacijos atsiskaitymą!

4019 – Nepavyko nuskaityti rezervuotų prekių kiekio sandėlyje!

4020 – Nepavyko nuskaityti rezervuotų prekių kiekio prekės kortelėje!

4021 – Nepavyko nuskaityti užsakytų prekių kiekio sandėlyje!

4022 – Nepavyko nuskaityti užsakytų prekių kiekio prekės kortelėje!

4023 – Ši operacija atlikta iš gamybos operacijos! Šalinkite gamybos operaciją.

4024 – Ši operacija atlikta iš kuro nurašymo operacijos! Šalinkite kuro nurašymo operaciją.

4025 – Ši operacija atlikta iš gamybos operacijos! Šalinkite gamybos operaciją.

4026 – Iš šios operacijos yra sukurtas šablonas. Ją trinti draudžiama!

4027 – Operacijos detalios eilutės yra panaudotos kitose operacijose!

4028 - Ši operacija atlikta iš gamybos operacijos.

<a id="operacijų-koregavimo-klaidos"></a>
## 6.5. Operacijų koregavimo klaidos

5000 – Nerasta koreguojama operacija;

5001 – Nerastos koreguojamos operacijos detalios eilutės;

5002 – Nerastas prekės matavimo vienetas;

5003 – Konkrečios operacijos klasės koregavimas nėra palaikomas;

5004 – Pašalintos visos detalios eilutės;

5005 – Rakintos operacijos koregavimas uždraustas.

<a id="ii-priedas---papildoma-informacija"></a>
# 7. II Priedas - Papildoma informacija

<a id="ssl-sertifikato-įdiegimas-webservisui"></a>
## 7.1. SSL sertifikato įdiegimas webservisui

1.  Įsigijamas arba kitokiu būdu sugeneruojamas sertifikatas. (pvz: <https://letsencrypt.org>)

2.  Sertifikatas įdiegiamas “Trusted root certification authorities”

![Image 1](FVS_Webservice_media/image1.png)

3.  Atidarom sertifikatą ir nusikopijuojam sertifikato žymę “thumbprint”:

> ![Image 2](FVS_Webservice_media/image2.png)

4.  Atidaromas “Windows powershell” su administratoriaus teisėmis ir įdiegiamas sertifikatas su komanda: netsh http add sslcert ipport=0.0.0.0:87 certhash=9db022f7f4b68590fe6c68d327f31cea3e59f268 appid "{FB170183-0D5F-488B-8000-E20CE7EBA879}"

1.  ipport – nurodomas portas ant kurio dirba webservisas

2.  certhash – nurodoma sertifikato žymė “thumbprint”

3.  appid – aplikacijos unikalus GUID raktas (reikšmė yra nesvarbi, svarbu, kad būtų korektiškas GUID formatas)

4.  senesnėse windows versijose naudojama komanda: httpcfg set ssl -i 0.0.0.0:87 -h 9db022f7f4b68590fe6c68d327f31cea3e59f268

5.  Informacijos šaltinis: <https://docs.microsoft.com/en-us/dotnet/framework/wcf/feature-details/how-to-configure-a-port-with-an-ssl-certificate>

6.  Svarbu. Instaliuotas sertifikatas privalo turėti „private key“, sąraše matoma ikonėlė su raktu. Jeigu rakto nėra, sertifikato failą „\*.crt“ reikia apjungti su rakto failu „\*.key“, pavyzdinė komanda: *openssl.exe pkcs12 -export -out "C:\ServerName.pfx" -inkey "C:\ServerName.key" -in "C:\ServerName.crt".* Tada senas sertifikatas išinstaliuojamas ir suinstaliuojamas naujas “\*.pfx” sertifikatas.

7.  Pastaba. Jeigu neveikia suinstaliuokite sertifikatą į „Personal“ katalogą.

5.  Koreguojamas webserviso konfiguracinis failas FvsWebService.exe.config

1.  Pridedam httpsGetEnabled="true"

```xml
<serviceBehaviors>
<behavior name="BehaviourService">
<serviceMetadata httpGetEnabled="true" httpsGetEnabled="true" />
</behavior>
</serviceBehaviors>
```

2.  Pridedam saugumo nustatymus

```xml
<basicHttpBinding>
<binding name="FvsBasicHttp" ……>
<security mode="Transport">
<transport clientCredentialType="None"></transport>
</security>
</binding>
</basicHttpBinding>
```

3.  Pridedam saugumo nustatymus REST

```xml
<webHttpBinding>
<binding name="FvsWebHttp">
<security mode="Transport">
<transport clientCredentialType="None"></transport>
</security>
</binding>
</webHttpBinding>
```

4.  Pakeičiam serviso nustatymus. REST servisui pridedam “bindingCofiguration”, mexHttpBinding pakeičiam mexHttpsBinding ir serviso adresą pakeičiam iš http į https.

```xml
<service name="FvsWebServiceWcf.FvsService" behaviorConfiguration="BehaviourService" >
<endpoint name="..." address ="" binding="basicHttpBinding" bindingConfiguration="FvsBasicHttp" contract="..."></endpoint>
<endpoint name="..." address ="rest" binding="webHttpBinding" bindingConfiguration="FvsWebHttp" behaviorConfiguration="RestBehaviour" contract="..."></endpoint>
<endpoint address="mex" binding="mexHttpsBinding" contract="IMetadataExchange"/>
<host>
<baseAddresses>
<add baseAddress="https://localhost:87/FvsService.asmx"/>
</baseAddresses>
</host>
</service>
```
