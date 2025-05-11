<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Choice extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'chapter_id',
        'text',
        'target_chapter_id',
        'impact',
    ];

    /**
     * Le chapitre source de ce choix.
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    /**
     * Le chapitre ciblé par ce choix (nullable).
     */
    public function target(): BelongsTo
    {
        return $this->belongsTo(Chapter::class, 'target_chapter_id');
    }
}