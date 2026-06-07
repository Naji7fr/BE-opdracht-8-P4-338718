<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Voertuig extends Model
{
    protected $table = 'Voertuig';

    public $timestamps = false;

    protected $fillable = [
        'Kenteken',
        'Type',
        'Bouwjaar',
        'Brandstof',
        'TypeVoertuigId',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd',
    ];

    protected $casts = [
        'Bouwjaar' => 'date',
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    public function typeVoertuig(): BelongsTo
    {
        return $this->belongsTo(TypeVoertuig::class, 'TypeVoertuigId');
    }

    public function instructeurKoppelingen(): HasMany
    {
        return $this->hasMany(VoertuigInstructeur::class, 'VoertuigId');
    }

    public function actieveKoppeling(): ?VoertuigInstructeur
    {
        return $this->instructeurKoppelingen()->where('IsActief', 1)->first();
    }
}
