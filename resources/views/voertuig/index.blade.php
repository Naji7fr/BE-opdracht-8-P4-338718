@extends('layouts.app')

@section('title', 'Alle voertuigen')

@section('content')
@php
    $page = (int) request()->get('page', 1);
    $cleanUrl = route('voertuigen.index', ['page' => $page]);
    $showMelding = session('redirect_melding') && request()->has('melding');
@endphp

<section class="page-alle-voertuigen">
    <h2>Alle voertuigen</h2>

    @if ($showMelding)
        <div class="melding melding-{{ session('redirect_melding_type', 'info') }} melding-timed"
             data-redirect="{{ $cleanUrl }}"
             data-timeout="3000">
            {{ session('redirect_melding') }}
        </div>
    @endif

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
                    <th>Instructeur naam</th>
                    <th>Verwijderen</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($voertuigen as $voertuig)
                    @php
                        $instructeurNaam = trim(implode(' ', array_filter([
                            $voertuig->Voornaam ?? '',
                            $voertuig->Tussenvoegsel ?? '',
                            $voertuig->Achternaam ?? '',
                        ])));
                    @endphp
                    <tr>
                        <td>{{ $voertuig->TypeVoertuig }}</td>
                        <td>{{ $voertuig->Type }}</td>
                        <td>{{ $voertuig->Kenteken }}</td>
                        <td>{{ \App\Services\VoertuigValidator::formatDatum($voertuig->Bouwjaar) }}</td>
                        <td>{{ $voertuig->Brandstof }}</td>
                        <td>{{ $voertuig->Rijbewijscategorie }}</td>
                        <td>{{ $instructeurNaam }}</td>
                        <td class="icon-cell">
                            <form method="post"
                                  action="{{ route('voertuigen.verwijder', ['page' => $page]) }}"
                                  class="inline-form delete-form">
                                @csrf
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
                        <td colspan="8" class="empty-row">Geen voertuigen gevonden.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $voertuigen->links('partials.pagination') }}
</section>
@endsection
