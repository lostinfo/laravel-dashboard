<?php

namespace App\Http\Controllers;


use App\Support\Response;

class ApiController extends Controller
{
    protected $response;

    protected $page_size;

    protected $order_by_column;

    protected $order_by_direction;

    public function __construct()
    {
        $this->response = new Response(\response());

        $this->page_size = request()->input('page_size', 10);

        $this->order_by_column = request()->input('order_by_column', 'id');

        $this->order_by_direction = request()->input('order_by_direction', 'desc');
    }
}
