<?php

namespace App\Services;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class BlogImporter
{
    const BLOG_URL = 'https://sq1-api-test.herokuapp.com/posts';

    public function handle()
    {
        $this->importBlogPosts();
    }

    private function importBlogPosts()
    {
        $request = Http::get(self::BLOG_URL);
        $user = User::whereEmail('admin@blog.com')->first();

        array_walk($request->object()->data, function($importedPost) use ($user) {
            Post::create([
                'title' => $importedPost->title,
                'body' => $importedPost->description,
                'publication_date' => $importedPost->publication_date,
                'user_id' => $user->id
            ]);
        });

        unset($request);
    }
}
