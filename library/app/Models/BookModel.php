<?php
namespace App\Models;
use CodeIgniter\Model;
class BookModel extends Model{
    protected $table = 'book';
    protected $primaryKey = 'id';
    protected $allowedFields = ['isbn', 'title', 'price', 'stock', 'id_editorial', 'cover'];
    protected $useTimestamps = false;

    public function duplicate_check(string $title, int $editorial, ?int $excludeId = null)
    {
        $builder = $this->where('LOWER(title)', strtolower($title))
                        ->where('id_editorial', $editorial);

        if ($excludeId !== null) {
            $builder->where('id !=', $excludeId);
        }

        return $builder->first();
    }

    public function updateBook(int $id, array $datos): array
    {
        if (!$this->find($id)) {
            return [
                'status' => false,
                'message' => 'El libro no existe.'
            ];
        }

        // Duplicado
        if ($this->duplicate_check($datos['title'], $datos["id_editorial"], $id)) {
            return [
                'status' => false,
                'message' => 'Ya existe ese libro.'
            ];
        }

        $ok = $this->update($id, [
            'isbn' => $datos['isbn'],
            'title' => $datos['title'],
            'price' => $datos['price'],
            'stock' => $datos['stock'],
            'id_editorial' => $datos['id_editorial'],
            'cover' => $datos['cover']
        ]);

        if ($ok) {
            return [
                'status' => true,
                'message' => 'Libro actualizado correctamente.'
            ];
        }
        return [
            'status' => false,
            'message' => 'Error al intentar actualizar.'
        ];
    }

    public function getBooks() {
    return $this->select(
            "book.id, book.isbn, book.title, book.price, book.stock, book.cover, book.id_editorial, editorial.name AS editorial,
             (SELECT GROUP_CONCAT(book_author.id_author) FROM book_author WHERE book_author.book = book.isbn) AS author_ids,
             (SELECT GROUP_CONCAT(CONCAT(author.name, ' ', author.last_name) ORDER BY author.last_name SEPARATOR ', ')
                FROM book_author
                INNER JOIN author ON author.id = book_author.id_author
                WHERE book_author.book = book.isbn) AS authors",
            false
        )
        ->join('editorial', 'book.id_editorial = editorial.id', 'inner');
    }

    public function filteredBooks($q) {

        $query = "SELECT book.id, book.isbn, book.title, book.price, book.stock, book.cover, book.id_editorial, editorial.name AS editorial,
                  (SELECT GROUP_CONCAT(CONCAT(author.name, ' ', author.last_name) ORDER BY author.last_name SEPARATOR ', ')
                    FROM book_author
                    INNER JOIN author ON author.id = book_author.id_author
                    WHERE book_author.book = book.isbn) AS authors,
                  (SELECT GROUP_CONCAT(book_author.id_author)
                    FROM book_author
                    WHERE book_author.book = book.isbn) AS author_ids
                  FROM book
                  INNER JOIN editorial
                  ON editorial.id = book.id_editorial
                  WHERE book.title LIKE :q: OR editorial.name LIKE :q: or EXISTS(
                                                                        SELECT 1
                                                                        FROM book_author
                                                                        INNER JOIN author ON author.id = book_author.id_author
                                                                        WHERE book_author.book = book.isbn
                                                                        AND CONCAT(author.name, ' ', author.last_name) LIKE :q:
                                                                        )
                  ";

        $like = '%' . addcslashes($q, '%_\\') . '%';
        return $this->query($query, ['q' => $like])->getResultArray();
    }

}