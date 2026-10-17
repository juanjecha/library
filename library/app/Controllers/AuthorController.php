<?php
namespace App\Controllers;
use App\Models\AuthorModel;
class AuthorController extends BaseController
{
    private $session;
    private $bookModel;

    public function __construct() {
        $this->session = session();
        $this->bookModel = new AuthorModel();
    }

    public function new(){ 
        $author = $this->request->getPost();
        if (!empty($author["name"]) && !empty($author["last_name"])) {
            $this->bookModel->newAuthor($author);
        }

        $operation = $this->bookModel->newAuthor($author);
        if ($operation['status']) {
            return redirect()->back()->withInput()->with('success', $operation["message"]);

        } else {
            $this->session->setFlashdata('msg_error', $operation['message']);
            return redirect()->back()->withInput()->with('error', $operation["message"]);
        }
    }
}