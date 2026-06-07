# Testplan - Feature2: Verwijderen voertuig

**Project:** Autorijschool De Komeet - BE Opdracht 8  
**Tester:** Student  
**Datum:** 07-06-2026  
**Versie:** 1.0

## Testomgeving

| Item | Waarde |
|------|--------|
| Browser | Chrome / Edge |
| Server | XAMPP Apache + MySQL |
| URL | http://localhost/opdracht8/public/ |
| Database | komeet_rijschool |

## Testcases

### TC-01: Scenario 01 - Voertuig verwijderen van instructeur

| Stap | Actie | Verwacht resultaat | Resultaat |
|------|-------|-------------------|-----------|
| 1 | Open homepage | Homepage De Komeet zichtbaar | |
| 2 | Klik "Instructeurs in dienst" | Overzicht instructeurs, gesorteerd op sterren aflopend | |
| 3 | Controleer paginering | Max 4 records per pagina | |
| 4 | Klik auto-icoon bij Mohammed El Yassidi | Pagina voertuigen instructeur | |
| 5 | Controleer sortering | Gesorteerd op Rijbewijscategorie aflopend | |
| 6 | Klik Verwijderen bij Vespa (DRS-52-P) | Bevestigingsdialoog | |
| 7 | Bevestig verwijderen | Rode melding: "Het door u geselecteerde voertuig is verwijderd" | |
| 8 | Wacht 3 seconden | Redirect naar scherm zonder melding | |
| 9 | Controleer lijst | Vespa niet meer in lijst instructeur | |
| 10 | Ga naar Alle voertuigen | Vespa staat als niet-toegewezen voertuig | |

### TC-02: Scenario 02 - Voertuig verwijderen via Alle voertuigen

| Stap | Actie | Verwacht resultaat | Resultaat |
|------|-------|-------------------|-----------|
| 1 | Open homepage, klik "Alle voertuigen" | Overzicht alle voertuigen | |
| 2 | Controleer sortering | Bouwjaar aflopend, daarna achternaam aflopend | |
| 3 | Klik kruis bij toegewezen voertuig El Yassidi | Bevestigingsdialoog | |
| 4 | Bevestig | Succesmelding 3 seconden zichtbaar | |
| 5 | Na redirect | Voertuig verwijderd uit lijst | |

### TC-03: Scenario 03 - Non-actief voertuig (Unhappy)

| Stap | Actie | Verwacht resultaat | Resultaat |
|------|-------|-------------------|-----------|
| 1 | Open Alle voertuigen | Kymco (STP-12-U) zichtbaar, geen instructeur | |
| 2 | Klik kruis bij Kymco | Foutmelding: non actief kan niet verwijderd | |
| 3 | Wacht 3 seconden | Melding verdwijnt, voertuig nog in lijst | |

### TC-04: Paginering

| Stap | Actie | Verwacht resultaat | Resultaat |
|------|-------|-------------------|-----------|
| 1 | Open Instructeurs in dienst (5 records) | Pagina 1: 4 records, pagina 2: 1 record | |
| 2 | Wissel van pagina | Rustig beeld, geen layout-sprong | |

### TC-05: Unit Tests

| Stap | Actie | Verwacht resultaat | Resultaat |
|------|-------|-------------------|-----------|
| 1 | Voer `vendor/bin/phpunit` uit | Alle tests slagen (groen) | |

## Acceptatiecriteria

- [ ] Alle scenario's werken volgens user story
- [ ] Stored procedures worden aangeroepen bij verwijderen
- [ ] Paginering max 4 records op alle read-pagina's
- [ ] Validatie en foutafhandeling aanwezig
- [ ] 2 Unit tests met screenshot resultaat
