<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Story extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'created_by',
    ];

    /**
     * L’auteur de l’histoire.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Les chapitres de l’histoire, ordonnés.
     */
    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class)
                    ->orderBy('order');
    }
}