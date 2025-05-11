<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chapter extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'story_id',
        'title',
        'content',
        'order',
    ];

    /**
     * L’histoire parente.
     */
    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }

    /**
     * Les choix disponibles dans ce chapitre.
     */
    public function choices(): HasMany
    {
        return $this->hasMany(Choice::class);
    }
}