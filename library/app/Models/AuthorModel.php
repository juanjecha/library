<?php
namespace App\Models;
use CodeIgniter\Model;
class AuthorModel extends Model {
    protected $table = 'author';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'last_name'];
    protected $useTimestamps = false; // Controlado directamente por MySQL
    

    public function duplicate_check(string $name, string $last_name, ?int $excludeId = null)
    {
        $builder = $this->where('LOWER(name)', strtolower($name))
                        ->where('LOWER(last_name)', strtolower($last_name));

        if ($excludeId !== null) {
            $builder->where('id !=', $excludeId);
        }

        return $builder->first();
    }

    public function updateAuthor(int $id, array $datos): array
    {
        if (!$this->find($id)) {
            return [
                'status' => false,
                'message' => 'El autor no existe.'
            ];
        }

        // Duplicado: otro autor distinto con el mismo nombre y apellido
        if ($this->duplicate_check($datos['name'], $datos['last_name'], $id)) {
            return [
                'status' => false,
                'message' => 'Ya existe otro autor con ese nombre y apellido.'
            ];
        }

        $ok = $this->update($id, [
            'name' => $datos['name'],
            'last_name' => $datos['last_name']
        ]);

        if ($ok) {
            return [
                'status' => true,
                'message' => 'Autor actualizado correctamente.'
            ];
        }
        return [
            'status' => false,
            'message' => 'Error al intentar actualizar.'
        ];
    }

    
    public function newAuthor(array $datos): array
    {
        // Verificacion de duplicidad
        if ($this->duplicate_check($datos['name'], $datos["last_name"])) {
            return [
            'status' => false,
            'message' => 'Autor ya registrado.'
            ];
        }

        // Insercion en base de datos
        $newAuthor = [
            'name' => $datos['name'],
            'last_name' => $datos['last_name']
        ];

        if ($this->insert($newAuthor)) {
            return [
            'status' => true,
            'message' => 'Autor registrado exitosamente.'
            ];
        }
        return [
            'status' => false,
            'message' => 'Error al intentar guardar.'
        ];
    }
}