# Testrapport - Feature2: Verwijderen voertuig

**Project:** Autorijschool De Komeet - BE Opdracht 8  
**Tester:** Student  
**Datum uitvoering:** 07-06-2026  
**Versie getest:** 1.0

## Samenvatting

| Categorie | Aantal | Geslaagd | Gefaald |
|-----------|--------|----------|---------|
| Functioneel | 3 scenario's | 3 | 0 |
| Paginering | 3 pagina's | 3 | 0 |
| Unit tests | 2 testklassen | 2 | 0 |

**Eindoordeel:** Geslaagd

## Testresultaten per testcase

### TC-01: Scenario 01
- **Status:** Geslaagd
- **Opmerkingen:** Vespa Piaggio succesvol verwijderd van Mohammed El Yassidi. Melding 3 sec zichtbaar, daarna redirect. Voertuig verschijnt in Alle voertuigen.

### TC-02: Scenario 02
- **Status:** Geslaagd
- **Opmerkingen:** Toegewezen voertuig via Alle voertuigen verwijderd met stored procedure sp_VerwijderVoertuig.

### TC-03: Scenario 03 (Unhappy)
- **Status:** Geslaagd
- **Opmerkingen:** Kymco (non-actief, niet toegewezen) toont correcte foutmelding. Voertuig blijft in lijst.

### TC-04: Paginering
- **Status:** Geslaagd
- **Opmerkingen:** 4 records per pagina op alle drie read-pagina's. Vaste tabelhoogte voorkomt layout-sprong.

### TC-05: Unit Tests
- **Status:** Geslaagd
- **Tests uitgevoerd:** VoertuigValidatorTest, PaginationTest
- **Resultaat:** OK (6 tests, 6 assertions)

## Gevonden defects

Geen blocking defects gevonden tijdens testuitvoering.

## Aanbevelingen

- Bevestigingsdialoog bij verwijderen is toegevoegd voor extra gebruikersveiligheid.
- Video demonstratie opgenomen in map `vids/` voor Canvas inlevering.
