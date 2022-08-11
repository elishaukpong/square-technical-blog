<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;
use Tests\TestCase;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->post = Post::factory()->create([
            'user_id' => $this->user->id
        ]);

    }

    public function test_create_post()
    {
        $user = User::factory()->create();
        $data = Post::factory()
                    ->make([
                        'user_id' => $user->id
                    ])->toArray();

        $post = Post::create($data);
        $this->assertEquals($data['title'], $post->title);
        $this->assertEquals($data['body'], $post->body);
        $this->assertEquals(Carbon::parse($data['publication_date'])->getTimestamp(), $post->publication_date->getTimestamp());
        $this->assertEquals($data['user_id'], $post->author->id);
        $this->assertEquals(Str::slug($data['title']), $post->slug);
    }

    public function test_post_short_body_attribute()
    {
        $this->assertEquals(Str::limit($this->post->body,200), $this->post->short_body);
    }

    public function test_post_date_posted_attribute()
    {
        $this->assertEquals($this->post->publication_date->format('d M Y'), $this->post->date_posted);
    }

    public function test_qualified_key_name()
    {
        $this->assertEquals($this->post->getQualifiedKeyName(), 'posts.slug');
    }

    public function test_post_has_author()
    {
        $this->assertInstanceOf(User::class,$this->post->author);
        $this->assertEquals($this->user->id,$this->post->author->id);
        $this->assertEquals($this->user->name,$this->post->author->name);
        $this->assertEquals($this->user->email,$this->post->author->email);
    }

    public function test_post_with_same_title_does_not_have_same_slug()
    {
        $title = 'Starting out a new blog';

        $firstPost = Post::factory()->create([
            'title' => $title,
            'user_id' => $this->user->id
        ]);

        $secondPost = Post::factory()->create([
            'title' => $title,
            'user_id' => $this->user->id
        ]);

        $this->assertNotEquals($firstPost->slug, $secondPost->slug);
        $this->assertEquals(Str::slug($title), $firstPost->slug);
        $this->assertEquals(Str::slug($title) . "_1", $secondPost->slug);

    }

    public function test_post_has_rules()
    {
        $this->assertEquals(Post::RULES['title'],'required|string');
        $this->assertEquals(Post::RULES['body'],'required|string');
        $this->assertEquals(Post::RULES['publication_date'],'required|date');
        $this->assertEquals(Post::RULES['user_id'],'required|int|exists:users,id');

    }
}
