<?php

namespace App\Http\Controllers;

use App\Contracts\PostInterface;
use App\Http\Requests\PostRequest;

class PostController extends BaseController
{
    protected $limit = 12;
    protected $viewIndex = 'admin.posts.index';
    protected $editView = 'admin.posts.edit';
    protected $createView = 'admin.posts.create';
    protected $showView = 'admin.posts.show';
    protected $routeIndex;

    public function __construct(PostInterface $post, PostRequest $request)
    {
        parent::__construct($post,$request);
        $this->routeIndex = route('admin.posts.index');
    }

    public function index()
    {
        $this->request->offsetSet('user_id', auth()->id());

        return parent::index();
    }

}
