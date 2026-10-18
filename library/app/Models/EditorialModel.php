<?php
namespace App\Models;
use CodeIgniter\Model;
class EditorialModel extends Model {
    protected $table = 'editorial';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name'];
    protected $useTimestamps = false; // Controlado directamente por MySQL
    

    public function duplicate_check(string $name, ?int $excludeId = null)
    {
        $builder = $this->where('LOWER(name)', strtolower($name));

        if ($excludeId !== null) {
            $builder->where('id !=', $excludeId);
        }

        return $builder->first();
    }

    public function updateEditorial(int $id, array $datos): array
    {
        if (!$this->find($id)) {
            return [
                'status' => false,
                'message' => 'La editorial no existe.'
            ];
        }

        // Duplicado
        if ($this->duplicate_check($datos['name'], $id)) {
            return [
                'status' => false,
                'message' => 'Ya existe la editorial.'
            ];
        }

        $ok = $this->update($id, [
            'name' => $datos['name'],
        ]);

        if ($ok) {
            return [
                'status' => true,
                'message' => 'Editorial actualizada correctamente.'
            ];
        }
        return [
            'status' => false,
            'message' => 'Error al intentar actualizar.'
        ];
    }

    
    public function newEditorial(array $datos): array
    {
        // Verificacion de duplicidad
        if ($this->duplicate_check($datos['name'])) {
            return [
            'status' => false,
            'message' => 'Editorial registrado.'
            ];
        }

        // Insercion en base de datos
        $newEditorial = [
            'name' => $datos['name'],
        ];

        if ($this->insert($newEditorial)) {
            return [
            'status' => true,
            'message' => 'Editorial registrada exitosamente.'
            ];
        }
        return [
            'status' => false,
            'message' => 'Error al intentar guardar.'
        ];
    }
}