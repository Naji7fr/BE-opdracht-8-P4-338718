# Class Diagram - BE Opdracht 8

```mermaid
classDiagram
    class Router {
        -routes: array
        +get(path, controller, method)
        +post(path, controller, method)
        +dispatch()
    }

    class Controller {
        #view(view, data)
        #redirect(path)
        #baseUrl(path)
    }

    class Model {
        #db: PDO
    }

    class Pagination {
        +PER_PAGE: int
        +getCurrentPage() int
        +getOffset(page) int
        +getTotalPages(total) int
        +buildMeta(total, page) array
    }

    class Database {
        -connection: PDO
        +getConnection() PDO$
    }

    class HomeController {
        +index()
    }

    class InstructeurController {
        -instructeurModel: Instructeur
        -voertuigModel: Voertuig
        +index()
        +voertuigen()
        +verwijderVoertuig()
    }

    class VoertuigController {
        -voertuigModel: Voertuig
        +index()
        +verwijder()
    }

    class Instructeur {
        +countActief() int
        +getAllActief(limit, offset) array
        +getById(id) array
        +getVolledigeNaam(instructeur) string
    }

    class Voertuig {
        +countVoorInstructeur(id) int
        +getVoorInstructeur(id, limit, offset) array
        +countAlle() int
        +getAlle(limit, offset) array
        +getById(id) array
        +isToegewezen(id) bool
        +verwijderVanInstructeur(voertuigId, instructeurId) string
        +verwijderVoertuig(voertuigId) string
    }

    class VoertuigValidator {
        +isPositiveInteger(value) bool$
        +formatSterren(aantal) string$
        +formatDatum(datum) string$
    }

    Controller <|-- HomeController
    Controller <|-- InstructeurController
    Controller <|-- VoertuigController
    Model <|-- Instructeur
    Model <|-- Voertuig
    InstructeurController --> Instructeur
    InstructeurController --> Voertuig
    VoertuigController --> Voertuig
    Model --> Database
    InstructeurController ..> Pagination
    VoertuigController ..> Pagination
    InstructeurController ..> VoertuigValidator
```

## Relaties

| Klasse | Relatie | Doel |
|--------|---------|------|
| Controllers | extends | Controller (basis MVC) |
| Models | extends | Model (PDO toegang) |
| Controllers | uses | Models, Pagination, VoertuigValidator |
| Database | singleton | PDO connectie |
