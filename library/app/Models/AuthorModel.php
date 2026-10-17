<?php
namespace App\Models;
use CodeIgniter\Model;
class AuthorModel extends Model {
    protected $table = 'author';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'last_name'];
    protected $useTimestamps = false; // Controlado directamente por MySQL
    

    public function duplicate_check(string $name, string $last_name)
    {
        return $this->where('LOWER(name)', strtolower($name))->where('LOWER(last_name)',strtolower($last_name))->first();
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