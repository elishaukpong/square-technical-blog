<?php

namespace App\Repositories;

use App\Contracts\PostInterface;
use App\Models\Post;

class PostRepository extends BaseRepository implements PostInterface
{

    protected function getModelClass(): string
    {
        return Post::class;
    }
}
