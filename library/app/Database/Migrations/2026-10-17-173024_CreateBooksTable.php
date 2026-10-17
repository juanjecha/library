<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class CreateBooksTable extends Migration {

    public function up() {
        $this->forge->addField([
            'id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
            'isbn' => [
            'type' => 'VARCHAR',
            'constraint' => '17',
        ],
            'titulo' => [
            'type' => 'VARCHAR',
            'constraint' => '200',
        ],
            'autor' => [
            'type' => 'VARCHAR',
            'constraint' => '150',
        ],
            'precio' => [
            'type' => 'DECIMAL',
            'constraint' => '10,2',
        ],
            'stock' => [
            'type' => 'INT',
            'constraint' => 11,
            'default' => 0,
        ],
            'created_at' => [
            'type' => 'DATETIME',
            'null' => true,
        ],
        ]);
            $this->forge->addKey('id', true);
            $this->forge->addUniqueKey('isbn');
            $this->forge->createTable('libros');
    }

    public function down(){
        $this->forge->dropTable('libros');
    }
}