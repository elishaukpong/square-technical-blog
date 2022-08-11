<?php

namespace App\Services;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BlogImporter
{
    const BLOG_URL = 'https://sq1-api-test.herokuapp.com/posts';
    const USER_EMAIL = 'admin@blog.com';

    public function handle(): void
    {
        $this->importBlogPosts();
    }

    private function importBlogPosts(): void
    {
        $user = User::whereEmail(self::USER_EMAIL)->first();

        $this->getPosts()
            ->each(function($importedPost) use ($user){
                Post::create([
                    'title' => $importedPost->title,
                    'body' => $importedPost->description,
                    'publication_date' => $importedPost->publication_date,
                    'user_id' => $user->id
                ]);
            });
    }

    private function getPosts(): Collection
    {
        try {
            return collect(
                Http::get(self::BLOG_URL)
                    ->object()->data
            );
        } catch (Exception $e){
            Log::info($e);

            return collect([]);
        }
    }
}
