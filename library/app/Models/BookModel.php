<?php
namespace App\Models;
use CodeIgniter\Model;
class BookModel extends Model{
    protected $table = 'book';
    protected $primaryKey = 'id';
    protected $allowedFields = ['isbn', 'title', 'price', 'stock', 'id_editorial', 'cover'];
    protected $useTimestamps = true;

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

    
    public function newBook(array $datos): array
    {
        // Verificacion de duplicidad
        if ($this->duplicate_check($datos['title'], $datos["id_editorial"])) {
            return [
            'status' => false,
            'message' => 'Libro ya registrado.'
            ];
        }

        // Insercion en base de datos
        $newBook = [
            'isbn' => $datos['isbn'],
            'title' => $datos['title'],
            'price' => $datos['price'],
            'stock' => $datos['stock'],
            'id_editorial' => $datos['id_editorial'],
            'cover' => $datos['cover']
        ];

        if ($this->insert($newBook)) {
            return [
            'status' => true,
            'message' => 'Libro registrado exitosamente.'
            ];
        }
        return [
            'status' => false,
            'message' => 'Error al intentar guardar.'
        ];
    }
}