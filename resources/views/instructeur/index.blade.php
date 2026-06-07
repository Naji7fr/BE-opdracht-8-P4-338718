@extends('layouts.app')

@section('title', 'Instructeurs in dienst')

@section('content')
<section class="page-instructeurs">
    <h2>Instructeurs in dienst</h2>
    <p class="record-count">Aantal instructeurs: {{ $totaal }}</p>

    @if (session('melding'))
        <div class="melding melding-{{ session('melding_type', 'info') }}">
            {{ session('melding') }}
        </div>
    @endif

    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Voornaam</th>
                    <th>Tussenvoegsel</th>
                    <th>Achternaam</th>
                    <th>Mobiel</th>
                    <th>Datum in dienst</th>
                    <th>Aantal sterren</th>
                    <th>Voertuigen</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($instructeurs as $instructeur)
                    <tr>
                        <td>{{ $instructeur->Voornaam }}</td>
                        <td>{{ $instructeur->Tussenvoegsel }}</td>
                        <td>{{ $instructeur->Achternaam }}</td>
                        <td>{{ $instructeur->Mobiel }}</td>
                        <td>{{ \App\Services\VoertuigValidator::formatDatum($instructeur->DatumInDienst) }}</td>
                        <td>{{ \App\Services\VoertuigValidator::formatSterren((int) $instructeur->AantalSterren) }}</td>
                        <td class="icon-cell">
                            <a href="{{ route('instructeurs.voertuigen', ['id' => $instructeur->Id]) }}"
                               title="Voertuigen bekijken"
                               class="icon-link">
                                <span class="icon-car" aria-hidden="true">&#128663;</span>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-row">Geen instructeurs gevonden.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $instructeurs->links('partials.pagination') }}
</section>
@endsection
