@extends('layouts.app')

@section('title', 'Voertuig wijzigen')

@section('content')
<section>
    <h2>Voertuig wijzigen</h2>

    <div class="instructeur-info">
        <p><strong>Instructeur:</strong> {{ $instructeurNaam }}</p>
        <p><strong>Type voertuig:</strong> {{ $voertuig->TypeVoertuig }} ({{ $voertuig->Rijbewijscategorie }})</p>
        <p><strong>Bouwjaar:</strong> {{ \App\Services\VoertuigValidator::formatDatum($voertuig->Bouwjaar) }}</p>
    </div>

    <form method="post" action="{{ route('instructeurs.voertuigen.wijzig.opslaan') }}" class="edit-form">
        @csrf
        <input type="hidden" name="instructeur_id" value="{{ $instructeur->Id }}">
        <input type="hidden" name="voertuig_id" value="{{ $voertuig->Id }}">

        <div class="form-group">
            <label for="kenteken">Kenteken</label>
            <input type="text" id="kenteken" name="kenteken" value="{{ old('kenteken', $voertuig->Kenteken) }}" maxlength="15" required>
            @error('kenteken')<span class="form-error">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" id="type" name="type" value="{{ old('type', $voertuig->Type) }}" maxlength="50" required>
            @error('type')<span class="form-error">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="brandstof">Brandstof</label>
            <select id="brandstof" name="brandstof" required>
                @foreach (['Benzine', 'Diesel', 'Elektrisch'] as $brandstof)
                    <option value="{{ $brandstof }}" @selected(old('brandstof', $voertuig->Brandstof) === $brandstof)>
                        {{ $brandstof }}
                    </option>
                @endforeach
            </select>
            @error('brandstof')<span class="form-error">{{ $message }}</span>@enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Opslaan</button>
            <a class="btn btn-secondary" href="{{ route('instructeurs.voertuigen', ['id' => $instructeur->Id]) }}">Annuleren</a>
        </div>
    </form>
</section>
@endsection
