<?php
namespace App\Controllers;
use App\Models\EditorialModel;
class EditorialController extends BaseController
{
    private $session;
    private $editorialModel;

    public function __construct() {
        $this->session = session();
        $this->editorialModel = new EditorialModel();
    }

    public function new(){ 
        $editorial = $this->request->getPost();
        if (empty($editorial["name"])) {
            return redirect()->back()->withInput()->with("error_edit", "El nombre es obligatorio");
        }

        $operation = $this->editorialModel->newEditorial($editorial);
        if ($operation['status']) {
            return redirect()->back()->withInput()->with('success_editorial', $operation["message"]);

        } else {
            $this->session->setFlashdata('msg_error', $operation['message']);
            return redirect()->back()->withInput()->with('error_author', $operation["message"]);
        }
    }

    public function update($id)
    {
        $editorial = $this->request->getPost();

        if (empty(trim($editorial['edit_name'] ?? '')) ) {
            return redirect()->back()->with('error_editorial', 'El nombre es obligatorio');
        }

        $operation = $this->editorialModel->updateEditorial((int) $id, [
            'name' => trim($editorial['edit_name']),
        ]);

        if ($operation['status']) {
            return redirect()->back()->with('success_editorial', $operation['message']);
        }

        return redirect()->back()->with('error_editorial', $operation['message']);
    }


}