<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VoertuigInstructeur extends Model
{
    protected $table = 'VoertuigInstructeur';

    public $timestamps = false;

    protected $fillable = [
        'VoertuigId',
        'InstructeurId',
        'DatumToekenning',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd',
    ];

    protected $casts = [
        'DatumToekenning' => 'date',
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    public function voertuig(): BelongsTo
    {
        return $this->belongsTo(Voertuig::class, 'VoertuigId');
    }

    public function instructeur(): BelongsTo
    {
        return $this->belongsTo(Instructeur::class, 'InstructeurId');
    }
}
