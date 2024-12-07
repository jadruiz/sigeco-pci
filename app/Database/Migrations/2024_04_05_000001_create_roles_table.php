<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolesTable extends Migration
{
    protected $tablePrefix;
    protected $tableRolesFieldsPrefix;

    public function __construct()
    {
        parent::__construct();
        $this->tablePrefix = config('KACL')->tablePrefix;
        $this->tableRolesFieldsPrefix = config('KACL')->tableRolesFieldsPrefix;
    }

    public function up()
    {
        $this->forge->addField([
            $this->tableRolesFieldsPrefix . 'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            $this->tableRolesFieldsPrefix . 'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            $this->tableRolesFieldsPrefix . 'description' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            $this->tableRolesFieldsPrefix . 'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => date('Y-m-d H:i:s'),
            ],
            $this->tableRolesFieldsPrefix . 'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => date('Y-m-d H:i:s'),
            ],
            $this->tableRolesFieldsPrefix . 'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey($this->tableRolesFieldsPrefix . 'id', true);
        $this->forge->createTable($this->tablePrefix . 'roles', true);
    }

    public function down()
    {
        $this->forge->dropTable($this->tablePrefix . 'roles');
    }
}
