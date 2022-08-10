<?php

namespace App\Services;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BlogImporter
{
    const BLOG_URL = 'https://sq1-api-test.herokuapp.com/posts';
    const ADMIN_EMAIL = 'admin@blog.com';

    public function handle(): void
    {
        try {
            $this->importBlogPosts();
        } catch (Exception $e){
            Log::info($e);
        }
    }

    private function importBlogPosts(): void
    {

        $request = Http::get(self::BLOG_URL);
        $user = User::whereEmail(self::ADMIN_EMAIL)->first();

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
