<?php
namespace App\Models;
use CodeIgniter\Model;
class UserModel extends Model {
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'last_name', 'email', 'hash', 'password', 'rol'];
    protected $useTimestamps = false; // Controlado directamente por MySQL
    /**
    * Busca un usuario por su direccion de correo electronico.
    */

    public function obtenerPorEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }

    /**
    * Obtiene la informacion del usuario por su clave primaria.
    */
    public function obtenerPorId(int $id): ?array
    {
        return $this->find($id);
    }

    /**
    * Registra un cliente validando internamente la no duplicidad de correo.
    */
    public function registrarCliente(array $datos): array
    {
        // 1. Verificacion de duplicidad
        if ($this->obtenerPorEmail($datos['email'])) {
            return [
            'status' => false,
            'message' => 'El correo electronico ya se encuentra registrado.'
            ];
        }

        // 2. Generacion de hash seguro
        $hashPassword = password_hash($datos['password'], PASSWORD_DEFAULT);
        $nuevoUsuario = [
            'name' => $datos['name'],
            'last_name' => $datos['last_name'],
            'email' => $datos['email'],
            'hash' => $hashPassword,
            'password' => $datos['password'], // Requerido por el esquema SQL
            'rol' => 'user'
        ];

        // 3. Insercion en base de datos
        if ($this->insert($nuevoUsuario)) {
            return [
            'status' => true,
            'message' => 'Registro completado con exito. Ya puedes iniciar sesion.'
            ];
        }
        return [
            'status' => false,
            'message' => 'Error al intentar guardar el usuario.'
        ];
    }
}