<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use App\Services\BlogImporter;
use Database\Seeders\UserSeeder;
use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Mockery\MockInterface;
use Tests\TestCase;

class BlogImporterTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(UserSeeder::class);
    }

    public function test_importer_can_add_posts()
    {

        $posts  = Post::factory(4)
                        ->imported()
                        ->make();
        Http::fake([ '*' => Http::response(['data' => $posts])]);

        (new BlogImporter())->handle();

        foreach($posts as $post){
            $this->assertDatabaseHas('posts',[
                'title' => $post->title,
                'body' => $post->description,
                'publication_date' => $post->publication_date,
                'user_id' => User::whereEmail('admin@blog.com')->first()->id
            ]);
        }

        $this->assertDatabaseCount('posts',4);
    }

    public function test_can_handle_failed_blog_import_gracefully()
    {
        Http::fake([ '*' => Http::response('', 500)]);

        (new BlogImporter())->handle();
        $this->assertDatabaseCount('posts',0);

    }

}
