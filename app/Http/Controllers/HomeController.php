<?php

namespace App\Http\Controllers;

use App\Contracts\PostInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends BaseController
{
    protected $limit = 12;
    protected $viewIndex = 'welcome';
    protected $editView = 'admin.posts.edit';
    protected $createView = 'admin.posts.create';
    protected $showView = 'posts.show';
    protected $routeIndex;

    public function __construct(PostInterface $post, Request $request)
    {
        parent::__construct($post,$request);
    }

    public function index()
    {
        $posts = Cache::remember('posts', now()->addMinutes(30), function(){
            $this->interface->builder()->latest()->limit(9)->get();
        });

        return view($this->viewIndex, ['posts' => $posts]);
    }

    public function posts()
    {
        $this->viewIndex = 'posts.index';
        return parent::index();
    }

    public function suggest()
    {
        return $this->interface->filter($this->request->toArray())
            ->latest()->limit(5)->get()
            ->toJson();
    }
}
