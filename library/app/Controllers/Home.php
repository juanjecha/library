<?php

namespace App\Controllers;
use App\Models\BookModel;
use App\Models\AuthorModel;
use App\Models\EditorialModel;

class Home extends BaseController
{
    private $bookModel;
    private $authorModel;
    private $editorialModel;

    public function __construct() {
        $this->bookModel = new BookModel();
        $this->authorModel = new AuthorModel();
        $this->editorialModel = new EditorialModel();
    }

    public function index(): string
    {
        $perPage = 6;
        $data = [
            'authors' => $this->authorModel->findAll(), 
            'editorials' => $this->editorialModel->findAll(),
            'libros' => $this->bookModel->getBooks()->paginate($perPage),
            'pager' => $this->bookModel->pager,
        ];
        return view('main',$data);
    }

    public function filt() {
        $q = trim((string) $this->request->getPost('q'));
        //$q = trim((string) $this->request->getGet('q'));



        if ($q !== null) {
            $libros = $this->bookModel->filteredBooks($q);
            $pager = null;
            $data =  ['libros' => $libros, 'pager' => $pager,
                'authors' => $this->authorModel->findAll(),
                'editorials' => $this->editorialModel->findAll()];
            return view("library/cat_filt", $data);

        } else {
            $libros = $this->bookModel->getBooks()->paginate(6);
            $pager = $this->bookModel->pager;
            $data =  ['libros' => $libros, 'pager' => $pager,
                'authors' => $this->authorModel->findAll(),
                'editorials' => $this->editorialModel->findAll()];
            return view("library/catalog", $data);

        }
    }
}