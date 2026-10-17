<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    /**
     * Se ejecuta ANTES de que el controlador procese la solicitud.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Verifica si la variable de sesión existe y está activa
        // (Ajusta 'isLoggedIn' al nombre que uses en tu loginAuth, ej: 'logueado' o 'id_usuario')
        if (! $session->get('isLoggedIn')) {
            $session->setFlashdata('msg_error', 'Debes iniciar sesión para acceder a esta sección.');
            return redirect()->to('/login');
        }
    }

    /**
     * Se ejecuta DESPUÉS de que el controlador procesó la solicitud.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se requiere ninguna acción posterior
    }
}