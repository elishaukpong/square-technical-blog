<?php

namespace App\Http\Controllers;

use App\Contracts\BaseInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class BaseController extends Controller
{
    /**
     * @var BaseInterface
     */
    protected $interface;
    /**
     * @var Request
     */
    protected $request;
    protected $limit = 10;
    protected $viewIndex;
    protected $editView;
    protected $createView;
    protected $showView;
    protected $routeIndex;
    protected $params = [];

    public function __construct(BaseInterface $interface, Request $request)
    {
        $this->interface = $interface;
        $this->request = $request;
    }

    public function index()
    {
        return view($this->viewIndex)->with('entities',$this->interface->paginate($this->limit, $this->request->toArray()));
    }

    public function create()
    {
        return view($this->createView, $this->params);
    }

    public function store()
    {
        $entity = $this->interface->create($this->request->except(['_token', '_method']));

        return $this->makeResponse($entity);
    }

    public function show($id)
    {
        return view($this->showView,['entity'=> Cache::get($id)]);
    }

    public function makeResponse($entity)
    {
        $message = 'Action Not Taken!';

        if ($entity) {
            $message = 'Action was successful';
        }

        if (null === $entity) {
            $message = 'Something Went Wrong!';
        }

        return redirect()->to($this->routeIndex)->with('status',$message);
    }

}
