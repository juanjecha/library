<?php
namespace App\Controllers;
use App\Models\UserModel;
class Auth extends BaseController {
    public function index()
    {
        helper(['form']);
        return view('auth/login');
    }

    public function loginAuth()
    {
        $session = session();
        $model = new UserModel();
        $email = trim($this->request->getPost('email'));
        $password = $this->request->getPost('password');

        // Búsqueda centralizada mediante el modelo
        $user = $model->obtenerPorEmail($email);
        if ($user) {
            if (password_verify($password, $user['hash'])) {
                $sessionData = [
                'id' => $user['id'],
                'name' => $user['name'],
                'last_name' => $user['last_name'],
                'email' => $user['email'],
                'rol' => $user['rol'],
                'isLoggedIn' => true
                ];
                $session->set($sessionData);
                $session->regenerate();
                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('msg_error', 'Contraseña incorrecta.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg_error', 'El correo electronico no se encuentra registrado.');
            return redirect()->to('/login');
        }
    }

    public function registerSave()
    {
        //$validation = \Config\Services::validation();
        $rules = [
            "name" => [
                "label" => "nombre(s)",
                "rules" => "required|regex_match[/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/]",
                "errors" => [
                    "required" => "El {field} es obligatorio",
                    "regex_match" => "regex_match[/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/]"
                ]
            ],

            "last_name" => [
                "label" => "apellidos",
                "rules"  => "required|regex_match[/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/]",
                "errors" => [
                    "required"    => "Los {field} son obligatorios",
                    "regex_match" => "Los {field} solo pueden contener letras y espacios"
                    ]
            ],    

            "email" => [
                "label" => "Correo Electrónico",
                "rules" => "required|valid_email",
                "errors" => [
                    "required" => "El {field} es obligatorio",
                    "valid_email" => "Debe ingresar una dirección de correo electrónica válida"
                ]
            ],

            "password" => [
                "label" => "contraseña",
                "rules" => "required|min_length[8]|regex_match[/(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])/]",
                "errors" => [
                    "required" => "La {field} es obligatoria.",
                    "regex_match" => "La {field} debe contener al menos una mayúscula, un número y un carácter especial",
                    "min_length" => "La {field} debe tener al menos 8 caracteres de longitud"
                ]
            ]
        ];

        $session = session();

        // when a rule isn't valid, show errors with modal opened
        if (!$this->validate($rules)) {
            return redirect()->to("/login")->withInput()
            ->with("validation_errors", $this->validator->getErrors())
            ->with("open_modal", true);
        }

        $model = new UserModel();
        $datos = [
            'name' => trim($this->request->getPost('name')),
            'last_name' => trim($this->request->getPost('last_name')),
            'email' => trim($this->request->getPost('email')),
            'password' => $this->request->getPost('password'),

        ];

        // Ejecución de registro con validación en el modelo
        $resultado = $model->registrarCliente($datos);
        if ($resultado['status']) {
            $session->setFlashdata('msg_success', $resultado['message']);
        } else {
            $session->setFlashdata('msg_error', $resultado['message']);
            $session->setFlashdata('open_modal', true);
            return redirect()->to("/login")->withInput(); // Reopen modal after fail
        }
        return redirect()->to('/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}