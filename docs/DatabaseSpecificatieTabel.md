# Database Specificatie Tabellen - BE Opdracht 8

## Tabel: TypeVoertuig

| Veldnaam | Datatype | Lengte | PK | FK | NULL | Default | Omschrijving |
|----------|----------|--------|----|----|------|---------|--------------|
| Id | INT | - | Ja | - | Nee | AUTO_INCREMENT | Unieke sleutel |
| TypeVoertuig | VARCHAR | 50 | - | - | Nee | - | Naam voertuigtype |
| Rijbewijscategorie | VARCHAR | 10 | - | - | Nee | - | Rijbewijscategorie |
| IsActief | BIT | 1 | - | - | Nee | 1 | Systeemveld actief |
| Opmerking | VARCHAR | 250 | - | - | Ja | NULL | Systeemveld opmerking |
| DatumAangemaakt | DATETIME | 6 | - | - | Nee | CURRENT_TIMESTAMP | Aanmaakdatum |
| DatumGewijzigd | DATETIME | 6 | - | - | Nee | CURRENT_TIMESTAMP | Wijzigingsdatum |

## Tabel: Instructeur

| Veldnaam | Datatype | Lengte | PK | FK | NULL | Default | Omschrijving |
|----------|----------|--------|----|----|------|---------|--------------|
| Id | INT | - | Ja | - | Nee | AUTO_INCREMENT | Unieke sleutel |
| Voornaam | VARCHAR | 50 | - | - | Nee | - | Voornaam instructeur |
| Tussenvoegsel | VARCHAR | 20 | - | - | Ja | NULL | Tussenvoegsel |
| Achternaam | VARCHAR | 50 | - | - | Nee | - | Achternaam |
| Mobiel | VARCHAR | 15 | - | - | Nee | - | Mobiel nummer |
| DatumInDienst | DATE | - | - | - | Nee | - | Datum in dienst |
| AantalSterren | TINYINT | - | - | - | Nee | 0 | Beoordeling sterren |
| IsActief | BIT | 1 | - | - | Nee | 1 | Systeemveld actief |
| Opmerking | VARCHAR | 250 | - | - | Ja | NULL | Systeemveld opmerking |
| DatumAangemaakt | DATETIME | 6 | - | - | Nee | CURRENT_TIMESTAMP | Aanmaakdatum |
| DatumGewijzigd | DATETIME | 6 | - | - | Nee | CURRENT_TIMESTAMP | Wijzigingsdatum |

## Tabel: Voertuig

| Veldnaam | Datatype | Lengte | PK | FK | NULL | Default | Omschrijving |
|----------|----------|--------|----|----|------|---------|--------------|
| Id | INT | - | Ja | - | Nee | AUTO_INCREMENT | Unieke sleutel |
| Kenteken | VARCHAR | 15 | - | - | Nee | - | Kenteken (uniek) |
| Type | VARCHAR | 50 | - | - | Nee | - | Merk/model |
| Bouwjaar | DATE | - | - | - | Nee | - | Bouwdatum |
| Brandstof | VARCHAR | 20 | - | - | Nee | - | Brandstoftype |
| TypeVoertuigId | INT | - | - | TypeVoertuig.Id | Nee | - | FK naar TypeVoertuig |
| IsActief | BIT | 1 | - | - | Nee | 1 | Systeemveld actief |
| Opmerking | VARCHAR | 250 | - | - | Ja | NULL | Systeemveld opmerking |
| DatumAangemaakt | DATETIME | 6 | - | - | Nee | CURRENT_TIMESTAMP | Aanmaakdatum |
| DatumGewijzigd | DATETIME | 6 | - | - | Nee | CURRENT_TIMESTAMP | Wijzigingsdatum |

## Tabel: VoertuigInstructeur

| Veldnaam | Datatype | Lengte | PK | FK | NULL | Default | Omschrijving |
|----------|----------|--------|----|----|------|---------|--------------|
| Id | INT | - | Ja | - | Nee | AUTO_INCREMENT | Unieke sleutel |
| VoertuigId | INT | - | - | Voertuig.Id | Nee | - | FK naar Voertuig |
| InstructeurId | INT | - | - | Instructeur.Id | Nee | - | FK naar Instructeur |
| DatumToekenning | DATE | - | - | - | Nee | - | Datum toekenning |
| IsActief | BIT | 1 | - | - | Nee | 1 | Systeemveld actief |
| Opmerking | VARCHAR | 250 | - | - | Ja | NULL | Systeemveld opmerking |
| DatumAangemaakt | DATETIME | 6 | - | - | Nee | CURRENT_TIMESTAMP | Aanmaakdatum |
| DatumGewijzigd | DATETIME | 6 | - | - | Nee | CURRENT_TIMESTAMP | Wijzigingsdatum |

## Relaties

- Voertuig.TypeVoertuigId → TypeVoertuig.Id (RESTRICT)
- VoertuigInstructeur.VoertuigId → Voertuig.Id (CASCADE)
- VoertuigInstructeur.InstructeurId → Instructeur.Id (CASCADE)
