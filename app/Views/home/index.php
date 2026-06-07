<?php
$baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
$baseUrl = str_replace('\\', '/', $baseUrl);
?>

<section class="page-home">
    <h2>Welkom bij Autorijschool De Komeet</h2>
    <p class="intro">Beheer instructeurs en voertuigen van de rijschool.</p>

    <nav class="home-links">
        <a class="btn btn-primary" href="<?= htmlspecialchars($baseUrl) ?>/instructeurs">Instructeurs in dienst</a>
        <a class="btn btn-secondary" href="<?= htmlspecialchars($baseUrl) ?>/voertuigen">Alle voertuigen</a>
    </nav>
</section>
