<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instructeur extends Model
{
    protected $table = 'Instructeur';

    public $timestamps = false;

    protected $fillable = [
        'Voornaam',
        'Tussenvoegsel',
        'Achternaam',
        'Mobiel',
        'DatumInDienst',
        'AantalSterren',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd',
    ];

    protected $casts = [
        'DatumInDienst' => 'date',
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    public function voertuigKoppelingen(): HasMany
    {
        return $this->hasMany(VoertuigInstructeur::class, 'InstructeurId');
    }

    public function getVolledigeNaamAttribute(): string
    {
        return trim(implode(' ', array_filter([
            $this->Voornaam,
            $this->Tussenvoegsel,
            $this->Achternaam,
        ])));
    }
}
