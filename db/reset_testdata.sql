-- Reset testdata voor Feature2 scenario's (na testen opnieuw uitvoeren)
USE komeet_rijschool;

UPDATE Voertuig SET IsActief = 1, Type = 'Vespa Piaggio' WHERE Id = 10;
UPDATE Voertuig SET IsActief = 0 WHERE Id = 11;

UPDATE VoertuigInstructeur SET IsActief = 1 WHERE Id IN (1, 2, 3, 4, 5, 6);

-- Optioneel: alle voertuigen weer actief
UPDATE Voertuig SET IsActief = 1 WHERE Id NOT IN (11);
