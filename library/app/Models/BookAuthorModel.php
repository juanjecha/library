<?php
namespace App\Models;
use CodeIgniter\Model;
class BookAuthorModel extends Model {
    protected $table = 'book_author';
    protected $primaryKey = 'id';
    protected $allowedFields = ['book', 'id_author'];
    protected $useTimestamps = false; // Controlado directamente por MySQL
    
}