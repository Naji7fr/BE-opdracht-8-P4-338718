@extends('layouts.app')

@section('title', 'Autorijschool De Komeet')

@section('content')
<section class="page-home">
    <h2>Welkom bij Autorijschool De Komeet</h2>
    <p class="intro">Beheer instructeurs en voertuigen van de rijschool.</p>

    <nav class="home-links">
        <a class="btn btn-primary" href="{{ route('instructeurs.index') }}">Instructeurs in dienst</a>
        <a class="btn btn-secondary" href="{{ route('voertuigen.index') }}">Alle voertuigen</a>
    </nav>
</section>
@endsection
