<?php
namespace App\Controllers;
use App\Models\BookModel;
use App\Models\AuthorModel;
use App\Models\BookAuthorModel;

class BookController extends BaseController
{
    private $session;
    private $bookModel;
    private $authorModel;
    private $bookAuthorModel;

    public function __construct() {
        $this->session = session();
        $this->bookModel = new BookModel();
        $this->authorModel = new AuthorModel();
        $this->bookAuthorModel = new BookAuthorModel();
    }

    public function new() {
        $rules = [
            'isbn' => 'required|max_length[17]|is_unique[book.isbn]',
            'title' => 'required|max_length[200]',
            'author_ids' => 'required',
            'author_ids.*' => 'is_natural_no_zero|is_not_unique[author.id]',
            'editorial_id' => 'required|is_not_unique[editorial.id]',
            'price' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'cover' => 'uploaded[cover]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png,image/webp]|max_size[cover,2048]',
        ];

        $messages = [
            'isbn' => [
                'required' => 'El ISBN es obligatorio.',
                'is_unique' => 'Ya existe un libro con ese ISBN.',
                'max_length' => 'El ISBN no puede pasar de 17 caracteres.',
            ],
            'title' => [
                'required' => 'El título es obligatorio.',
            ],
            'author_ids' => [
                'required' => 'Selecciona al menos un autor.',
            ],
            'editorial_id' => [
                'required' => 'Selecciona una editorial.',
                'is_not_unique' => 'La editorial seleccionada no existe.',
            ],
            'price' => [
                'required' => 'El precio es obligatorio.',
                'numeric' => 'El precio debe ser un número.',
                'greater_than' => 'El precio debe ser mayor a 0.',
            ],
            'stock' => [
                'required' => 'El stock es obligatorio.',
                'is_natural' => 'El stock debe ser un número entero, 0 o mayor.',
            ],
            'cover' => [
                'uploaded' => 'La portada es obligatoria.',
                'is_image' => 'El archivo debe ser una imagen.',
                'mime_in' => 'La portada debe ser JPG, PNG o WEBP.',
                'max_size' => 'La portada no puede pesar más de 2 MB.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()
                ->with('error_book', implode(' ', $this->validator->getErrors()));
        }

        // Move the cover
        $file = $this->request->getFile('cover');
        $coverName = $file->getRandomName();
        $file->move(FCPATH . 'uploads', $coverName);

        // Save book + authors in one transaction
        $isbn = $this->request->getPost('isbn');
        $authorIds = array_unique((array) $this->request->getPost('author_ids'));

        $db = \Config\Database::connect();
        $db->transStart();

        $this->bookModel->insert([
            'isbn' => trim($isbn),
            'title' => trim($this->request->getPost('title')),
            'id_editorial' => $this->request->getPost('editorial_id'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'cover' => $coverName,
        ]);

        $rows = [];
        foreach ($authorIds as $authorId) {
            $rows[] = ['book' => trim($isbn), 'id_author' => (int) $authorId];
        }
        $this->bookAuthorModel->insertBatch($rows);

        $db->transComplete();

        if (! $db->transStatus()) {
            @unlink(FCPATH . 'uploads/' . $coverName); // don't leave orphan files
            return redirect()->back()->withInput()
                ->with('error_book', 'No se pudo registrar el libro.');
        }

        return redirect()->back()->with('success_book', 'Libro registrado exitosamente.');
    }
}