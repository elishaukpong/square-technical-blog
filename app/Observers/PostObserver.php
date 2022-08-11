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
        $post = Post::where('slug','LIKE',$slug.'%')->latest()->first();

        //i am suppressing the error that would come with the $count variable
        //when there is no int attached to the slug
        @list($post_slug, $count) = explode('_', $post->slug);

        if($count === null) {
            return "{$slug}_1";
        }
        $count++;
        return $slug ."_". $count;
    }

}
