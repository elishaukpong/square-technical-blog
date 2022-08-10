<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = [
        'publication_date'
    ];

    public $searchable = [
        'title', 'body'
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
}
