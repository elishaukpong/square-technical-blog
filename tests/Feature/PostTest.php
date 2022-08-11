<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    public function test_can_view_home_page()
    {
        $response = $this->get('/');

        $response->assertSee([
            'Square 1',
            'Blog',
            'Your best news spot',
            'Offer the best news around the world on all Events, Sports, Tech, Lifestyle and even Wildlife',
            'Join our mailing list or subscribe to RSS to stay upto date',
            'remember knowledge is power',
        ]);
        $response->assertStatus(200);
    }

    public function test_can_view_home_page_with_no_posts_yet()
    {
        $response = $this->get('/');

        $response->assertSee([
            'No Posts Yet',
            'Start Blogging'
        ]);

        $response->assertStatus(200);
    }

    public function test_can_view_home_page_with_posts()
    {
        $response = $this->getPageWithPosts('/');

        $response->assertSee('View More');
        $response->assertStatus(200);
    }

    public function test_can_view_blog_page()
    {
        $response = $this->get('/blog');

        $response->assertStatus(200);
    }

    public function test_can_view_blog_page_with_no_posts_yet()
    {
        $response = $this->get('/blog');

        $response->assertSee([
            'No Posts Yet',
            'Create Post'
        ]);

        $response->assertStatus(200);
    }

    public function test_can_view_blog_page_with_posts()
    {
        $response = $this->getPageWithPosts('/blog');

        $response->assertStatus(200);
    }

    public function test_can_see_pagination_on_blog_page()
    {
        $postCount = 13;
        $this->createPosts($postCount);

        $response = $this->get('/blog');

        $response->assertSee([
            '&laquo; Previous',
            'Next &raquo;',
            'Showing',
            '1',
            'to',
            '12',
            'of',
            $postCount,
            'results'
        ]);

        $response->assertStatus(200);
    }

    public function getPageWithPosts($url): \Illuminate\Testing\TestResponse
    {
        $posts = $this->createPosts(9);

        $response = $this->get($url);

        $posts->each(function ($post) use ($response) {
            $response->assertSee([
                $post->title,
                $post->short_body,
                $post->date_posted,
                $post->author->name,
                route('show.post',$post->slug)
            ]);
        });

        return $response;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function createPosts($count): Collection
    {
        $user = User::factory()->create();

        return Post::factory($count)->create([
            'user_id' => $user->id
        ]);
    }
}
