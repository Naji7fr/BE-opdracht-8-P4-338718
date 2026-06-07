<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Autorijschool De Komeet')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <h1 class="site-logo"><a href="{{ route('home') }}">Autorijschool De Komeet</a></h1>
        </div>
    </header>
    <main class="container">
        <div class="page-content">
            @yield('content')
        </div>
    </main>
    <footer class="site-footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} Autorijschool De Komeet - BE Opdracht 8</p>
        </div>
    </footer>

    <div id="delete-modal" class="modal" hidden aria-hidden="true">
        <div class="modal-backdrop" data-modal-close></div>
        <div class="modal-dialog" role="dialog" aria-modal="true" aria-labelledby="delete-modal-title">
            <h3 id="delete-modal-title">Voertuig verwijderen</h3>
            <p class="modal-text">Weet u zeker dat u dit voertuig wilt verwijderen?</p>
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" data-modal-close>Annuleren</button>
                <button type="button" class="btn btn-danger" id="delete-modal-confirm">Verwijderen</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
