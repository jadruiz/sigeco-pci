<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    protected $tablePrefix;
    protected $tableUsersFieldsPrefix;

    public function __construct()
    {
        parent::__construct();
        $this->tablePrefix = config('KACL')->tablePrefix;
        $this->tableUsersFieldsPrefix = config('KACL')->tableUsersFieldsPrefix;
    }

    public function up()
    {
        $this->forge->addField([
            $this->tableUsersFieldsPrefix . 'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            $this->tableUsersFieldsPrefix . 'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            $this->tableUsersFieldsPrefix . 'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
            ],
            $this->tableUsersFieldsPrefix . 'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            $this->tableUsersFieldsPrefix . 'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => date('Y-m-d H:i:s'),
            ],
            $this->tableUsersFieldsPrefix . 'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => date('Y-m-d H:i:s'),
            ],
            $this->tableUsersFieldsPrefix . 'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey($this->tableUsersFieldsPrefix . 'id', true);
        $this->forge->createTable($this->tablePrefix . 'users', true);
    }

    public function down()
    {
        $this->forge->dropTable($this->tablePrefix . 'users');
    }
}
