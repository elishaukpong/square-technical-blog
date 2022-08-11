<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
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

        $response->assertDontSee('View More');

        $response->assertStatus(200);
    }

    public function test_can_view_home_page_with_posts()
    {
        $response = $this->getPageWithPosts('/');

        $response->assertSee('View More');
        $response->assertDontSee([
            'No Posts Yet',
            'Start Blogging'
        ]);

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

        $response->assertDontSee([
            '&laquo; Previous',
            'Next &raquo;',
            'Showing',
            'results'
        ]);

        $response->assertStatus(200);
    }

    public function test_can_view_blog_page_with_posts()
    {
        $response = $this->getPageWithPosts('/blog');

        $response->assertDontSee([
            'No Posts Yet',
            'Create Post',
            '&laquo; Previous',
            'Next &raquo;',
            'Showing',
            'results'
        ]);

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

    public function test_can_view_single_blog_post_by_slug()
    {
        $post = $this->createPosts(1)
                    ->first();

        $response = $this->get('/blog/'. $post->slug);

        $response->assertSee([
            $post->title,
            $post->short_body,
            $post->date_posted,
            $post->author->name,
            'Author'
        ]);

        $response->assertStatus(200);

    }

    public function test_can_throw_exception_when_post_by_slug_doesnt_exist()
    {

        $response = $this->get('/blog/non-existent-slug');

        $response->assertStatus(404);

    }

    public function test_guest_can_see_auth_buttons()
    {
        $this->seeButtonsOnRoutes(['/', '/blog'], ['Sign in','Sign up']);
    }

    public function test_auth_user_can_see_dashboard_buttons()
    {
        $this->login();
        $this->seeButtonsOnRoutes(['/', '/blog'], ['Dashboard']);
    }

    public function test_guest_cannot_access_post_admin_page()
    {
        $response = $this->get('/admin/posts');
        $response->assertRedirect('/login');

        $response = $this->get('/admin/posts/create');
        $response->assertRedirect('/login');

    }

    public function test_auth_user_can_view_create_post_page()
    {
        $this->login();

        $response = $this->get('/admin/posts/create');

        $response->assertSee(['Create Post','name','body','publication_date', auth()->user()->name]);

        $response->assertStatus(200);

    }

    public function test_auth_user_can_create_post()
    {
        $this->login();

        $post = Post::factory()->make([
                    'user_id' => auth()->id()
                ])->toArray();

        $response = $this->post('/admin/posts',$post);
        $response->assertRedirect('/admin/posts');
        $response->assertStatus(302);

        $this->assertDatabaseHas('posts',[
            'title' => $post['title'],
            'user_id' => $post['user_id'],
            'body' => $post['body'],
        ]);

    }

    public function test_auth_user_cannot_create_post_without_values()
    {
        $this->login();

        $response = $this->post('/admin/posts',[]);

        $response->assertSessionHasErrors([
            'title',
            'body',
            'publication_date',
            'user_id'
        ]);

        $response->assertStatus(302);
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

    public function createPosts($count): Collection
    {
        $user = User::factory()->create();

        return Post::factory($count)->create([
            'user_id' => $user->id
        ]);
    }

    /**
     * @param \Illuminate\Testing\TestResponse $response
     * @return void
     */
    public function seeButtonsOnRoutes(array $routes, array $textToSee): void
    {
        foreach($routes as $route) {

            $response = $this->get($route);
            $response->assertSee($textToSee);

            $response->assertStatus(200);
        }

    }

    public function login()
    {
        Auth::login(User::factory()->create());
        $this->assertAuthenticated();
    }
}
