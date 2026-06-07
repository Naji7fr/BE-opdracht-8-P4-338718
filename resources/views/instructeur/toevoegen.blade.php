@extends('layouts.app')

@section('title', 'Voertuig toevoegen')

@section('content')
<section>
    <h2>Voertuig toevoegen aan instructeur</h2>

    <div class="instructeur-info">
        <p><strong>Instructeur:</strong> {{ $instructeurNaam }}</p>
    </div>

    @if (session('melding'))
        <div class="melding melding-{{ session('melding_type', 'info') }}">
            {{ session('melding') }}
        </div>
    @endif

    <p class="intro">Selecteer een beschikbaar voertuig om toe te wijzen.</p>

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
                    <th>Toewijzen</th>
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
                            <form method="post"
                                  action="{{ route('instructeurs.voertuigen.toevoegen.opslaan') }}"
                                  class="inline-form">
                                @csrf
                                <input type="hidden" name="instructeur_id" value="{{ $instructeur->Id }}">
                                <input type="hidden" name="voertuig_id" value="{{ $voertuig->Id }}">
                                <button type="submit" class="btn btn-primary btn-sm">Toewijzen</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-row">Geen beschikbare voertuigen gevonden.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $voertuigen->appends(['id' => $instructeur->Id])->links('partials.pagination') }}

    <p class="back-link">
        <a href="{{ route('instructeurs.voertuigen', ['id' => $instructeur->Id]) }}">&laquo; Terug naar voertuigen</a>
    </p>
</section>
@endsection
