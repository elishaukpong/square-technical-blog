<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Str;

class PostObserver
{

    /**
     * Handle the Post "saving" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function creating(Post $post): void
    {
        $slug = Str::slug($post->title);

        if(Post::whereSlug($slug)->exists()){
            $slug = $this->addNumberToSlug($slug);
        }

        $post->slug = $slug;
    }

    private function addNumberToSlug(string $slug): string
    {
        //find the one with the slug using %like%
        //pick the latest
        //break the slug and get the last number
        //increment and youre good
        return $slug;
    }

}
