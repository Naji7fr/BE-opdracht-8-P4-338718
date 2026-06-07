<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'De Komeet') ?></title>
    <link rel="stylesheet" href="<?= htmlspecialchars($baseUrl ?? '') ?>/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <h1 class="site-logo"><a href="<?= htmlspecialchars($baseUrl ?? '') ?>/">Autorijschool De Komeet</a></h1>
        </div>
    </header>
    <main class="container">
