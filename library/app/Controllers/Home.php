<?php

namespace App\Controllers;
use App\Models\BookModel;

class Home extends BaseController
{
    private $bookModel;

    public function __construct() {
        $this->bookModel = new BookModel();
    }

    public function index(): string
    {
        return view('main');
    }

   
}
