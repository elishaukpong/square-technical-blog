<?php

namespace App\Services;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
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
                try{
                    $post = Post::create([
                        'title' => $importedPost->title,
                        'body' => $importedPost->description,
                        'publication_date' => $importedPost->publication_date,
                        'user_id' => $user->id
                    ]);

                    Cache::rememberForever($post->slug, fn() => $post);

                }catch(Exception $e){
                    Log::info('Error occured while adding this post');
                    Log::info($e);
                }

            });
    }

    protected function getPosts(): Collection
    {

        try {
            $response = Http::get(self::BLOG_URL);
            $data = $response->throw()->object()->data;

            return collect($data);

        } catch (RequestException | Exception $e){
            Log::info($e);

            return collect([]);
        }
    }
}
