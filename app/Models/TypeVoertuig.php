<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeVoertuig extends Model
{
    protected $table = 'TypeVoertuig';

    public $timestamps = false;

    protected $fillable = [
        'TypeVoertuig',
        'Rijbewijscategorie',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd',
    ];

    protected $casts = [
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    public function voertuigen(): HasMany
    {
        return $this->hasMany(Voertuig::class, 'TypeVoertuigId');
    }
}
