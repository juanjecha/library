<?php
namespace App\Controllers;
use App\Models\BookModel;
use App\Models\AuthorModel;
use App\Models\EditorialModel;
class BookCartController extends BaseController
{
    private $session;
    private $bookModel;
    private $authorModel;
    private $editorialModel;


    public function __construct() {
        $this->session = session();
        $this->bookModel = new BookModel();
        $this->authorModel = new AuthorModel();
        $this->editorialModel = new EditorialModel();
    }

    /**
    * Muestra el catálogo de libros con paginación
    */
    public function index(){
        $perPage = 6;
        $data = [
            'authors' => $this->authorModel->findAll(), 
            'editorials' => $this->editorialModel->findAll(),
            'libros' => $this->bookModel->getBooks()->paginate($perPage),
            'pager' => $this->bookModel->pager,
        ];
        return view('library/catalog', $data);
    }

    /**
    * Agrega un libro al carrito en sesión con validación de stock
    */
    public function add() {
        $id = $this->request->getPost('id');
        $cantidad = (int) $this->request->getPost('cantidad');
        $formato = $this->request->getPost('formato') ?? 'Físico';
        $libro = $this->bookModel->find($id);

        if (!$libro) {
            return redirect()->back()->with('error', 'El libro especificado no existe.');
        }

        if ($cantidad <= 0 || $cantidad > $libro['stock']) {
            return redirect()->back()->with('error', 'La cantidad solicitada supera el stock
            disponible (Max: ' . $libro['stock'] . ').');
        }

                $carrito = $this->session->get('libro_carrito') ?? [];
        $itemKey = $libro['isbn'] . '_' . str_replace(' ', '', $formato);

        if (isset($carrito[$itemKey])) {
            $nuevaCantidad = $carrito[$itemKey]['cantidad'] + $cantidad;
            if ($nuevaCantidad > $libro['stock']) {
                return redirect()->back()->with('error', 'No puedes agregar más unidades. Supera el stock actual.');
            }
            $carrito[$itemKey]['cantidad'] = $nuevaCantidad;
            $carrito[$itemKey]['subtotal'] = $carrito[$itemKey]['cantidad'] * $carrito[$itemKey]['precio'];
        } else {
            // Nombres de los autores del libro, separados por coma
            $fila = $this->authorModel
                ->select("GROUP_CONCAT(CONCAT(author.name, ' ', author.last_name) SEPARATOR ', ') AS autores", false)
                ->join('book_author', 'book_author.id_author = author.id')
                ->where('book_author.book', $libro['isbn'])
                ->first();

            $carrito[$itemKey] = [
                'id' => $libro['id'],
                'isbn' => $libro['isbn'],
                'titulo' => $libro['title'],
                'autor' => $fila['autores'] ?: 'Sin autor',
                'portada' => $libro['cover'],
                'formato' => $formato,
                'precio' => (float) $libro['price'],
                'cantidad' => $cantidad,
                'subtotal' => $cantidad * (float) $libro['price'],
            ];
        }
        $this->session->set('libro_carrito', $carrito);
        return redirect()->to(site_url('libreria/carrito'))->with('success', 'Libro agregado a tu carrito.');
    }

    /**
    * Visualizar los libros en el carrito y calcular el total
    */
    public function show() {
        $carrito = $this->session->get('libro_carrito') ?? [];
        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['subtotal'];
        }
        $data['carrito'] = $carrito;
        $data['total'] = $total;
        return view('library/carrito', $data);
    }

    /**
    * Elimina un ítem específico usando su llave en el arreglo de sesión
    */
    public function remove($itemKey) {
        $itemKey = urldecode($itemKey);
        $carrito = $this->session->get('libro_carrito') ?? [];
        if (isset($carrito[$itemKey])) {
            unset($carrito[$itemKey]);
            $this->session->set('libro_carrito', $carrito);
        }
        return redirect()->to(site_url('libreria/carrito'))->with('success', 'Ejemplar quitado del carrito.');
    }

    /**
    * Limpia completamente la clave de sesión del carrito
    */
    public function clear() {
    $this->session->remove('libro_carrito');
    return redirect()->to(site_url('libreria/carrito'))->with('success', 'Carrito de libros vaciado.');
    }
}