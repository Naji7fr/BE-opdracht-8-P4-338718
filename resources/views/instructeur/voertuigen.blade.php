@extends('layouts.app')

@section('title', 'Door Instructeur gebruikte voertuigen')

@section('content')
@php
    $cleanUrl = route('instructeurs.voertuigen', ['id' => $instructeur->Id]);
    $showMelding = session('redirect_melding') && request()->has('melding');
@endphp

<section class="page-voertuigen-instructeur">
    <h2>Door Instructeur gebruikte voertuigen</h2>

    <div class="instructeur-info">
        <p><strong>Naam:</strong> {{ $instructeurNaam }}</p>
        <p><strong>Datum in dienst:</strong> {{ \App\Services\VoertuigValidator::formatDatum($instructeur->DatumInDienst) }}</p>
        <p><strong>Aantal sterren:</strong> {{ \App\Services\VoertuigValidator::formatSterren((int) $instructeur->AantalSterren) }}</p>
    </div>

    @if (session('melding') && !request()->has('melding'))
        <div class="melding melding-{{ session('melding_type', 'info') }}">
            {{ session('melding') }}
        </div>
    @endif

    <div class="action-bar">
        <a class="btn btn-primary" href="{{ route('instructeurs.voertuigen.toevoegen', ['id' => $instructeur->Id]) }}">Toevoegen Voertuig</a>

        @if ($showMelding)
            <div class="melding melding-{{ session('redirect_melding_type', 'info') }} melding-timed"
                 data-redirect="{{ $cleanUrl }}"
                 data-timeout="3000">
                {{ session('redirect_melding') }}
            </div>
        @endif
    </div>

    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Type Voertuig</th>
                    <th>Type</th>
                    <th>Kenteken</th>
                    <th>Bouwjaar</th>
                    <th>Brandstof</th>
                    <th>Rijbewijscategorie</th>
                    <th>Wijzigen</th>
                    <th>Verwijderen</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($voertuigen as $voertuig)
                    <tr>
                        <td>{{ $voertuig->TypeVoertuig }}</td>
                        <td>{{ $voertuig->Type }}</td>
                        <td>{{ $voertuig->Kenteken }}</td>
                        <td>{{ \App\Services\VoertuigValidator::formatDatum($voertuig->Bouwjaar) }}</td>
                        <td>{{ $voertuig->Brandstof }}</td>
                        <td>{{ $voertuig->Rijbewijscategorie }}</td>
                        <td class="icon-cell">
                            <a href="{{ route('instructeurs.voertuigen.wijzig', ['id' => $instructeur->Id, 'voertuig_id' => $voertuig->Id]) }}"
                               class="icon-edit-link"
                               title="Wijzigen"
                               aria-label="Wijzigen">
                                &#9998;
                            </a>
                        </td>
                        <td class="icon-cell">
                            <form method="post"
                                  action="{{ route('instructeurs.voertuigen.verwijder') }}"
                                  class="inline-form delete-form">
                                @csrf
                                <input type="hidden" name="instructeur_id" value="{{ $instructeur->Id }}">
                                <input type="hidden" name="voertuig_id" value="{{ $voertuig->Id }}">
                                <button type="submit"
                                        class="icon-btn icon-delete"
                                        title="Verwijderen"
                                        aria-label="Verwijderen">
                                    &#10006;
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty-row">Geen voertuigen toegewezen.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $voertuigen->links('partials.pagination') }}
</section>
@endsection
