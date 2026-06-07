# ERD - Entity Relationship Diagram

```mermaid
erDiagram
    TypeVoertuig ||--o{ Voertuig : "heeft"
    Instructeur ||--o{ VoertuigInstructeur : "gebruikt"
    Voertuig ||--o{ VoertuigInstructeur : "toegewezen aan"

    TypeVoertuig {
        int Id PK
        varchar TypeVoertuig
        varchar Rijbewijscategorie
        bit IsActief
        varchar Opmerking
        datetime DatumAangemaakt
        datetime DatumGewijzigd
    }

    Instructeur {
        int Id PK
        varchar Voornaam
        varchar Tussenvoegsel
        varchar Achternaam
        varchar Mobiel
        date DatumInDienst
        tinyint AantalSterren
        bit IsActief
        varchar Opmerking
        datetime DatumAangemaakt
        datetime DatumGewijzigd
    }

    Voertuig {
        int Id PK
        varchar Kenteken UK
        varchar Type
        date Bouwjaar
        varchar Brandstof
        int TypeVoertuigId FK
        bit IsActief
        varchar Opmerking
        datetime DatumAangemaakt
        datetime DatumGewijzigd
    }

    VoertuigInstructeur {
        int Id PK
        int VoertuigId FK
        int InstructeurId FK
        date DatumToekenning
        bit IsActief
        varchar Opmerking
        datetime DatumAangemaakt
        datetime DatumGewijzigd
    }
```

## Kardinaliteit

- Eén **TypeVoertuig** kan meerdere **Voertuigen** hebben (1:N)
- Eén **Instructeur** kan meerdere **VoertuigInstructeur** koppelingen hebben (1:N)
- Eén **Voertuig** kan via **VoertuigInstructeur** aan één instructeur tegelijk gekoppeld zijn (N:1 via koppeltabel)
