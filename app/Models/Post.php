<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    const RULES = [
        'title' => 'required|string',
        'body' => 'required|string',
        'publication_date' => 'required|date',
        'user_id' => 'required|int|exists:users,id'
    ];

    protected $guarded = [];

    protected $dates = [
        'publication_date'
    ];

    public $searchable = [
        'title'
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getShortBodyAttribute(): string
    {
        return Str::limit($this->body,200);
    }

    public function getDatePostedAttribute(): string
    {
        return $this->publication_date->format('d M Y');
    }

    /**
     * Get the table qualified key name.
     *
     * @return string
     */
    public function getQualifiedKeyName()
    {
        return $this->qualifyColumn('slug');
    }
}
