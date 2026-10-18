// app/Filters/AdminFilter.php
<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session('rol') !== 'admin') {
            return redirect()->to('/libreria/catalogo')
                ->with('error', 'No tienes permiso para realizar esa acción.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}