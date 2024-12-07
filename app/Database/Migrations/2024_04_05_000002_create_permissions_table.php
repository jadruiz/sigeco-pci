<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePermissionsTable extends Migration
{
    protected $tablePrefix;
    protected $tablePermissionsFieldsPrefix;

    public function __construct()
    {
        parent::__construct();
        $this->tablePrefix = config('KACL')->tablePrefix;
        $this->tablePermissionsFieldsPrefix = config('KACL')->tablePermissionsFieldsPrefix;
    }

    public function up()
    {
        $this->forge->addField([
            $this->tablePermissionsFieldsPrefix . 'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            $this->tablePermissionsFieldsPrefix . 'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            $this->tablePermissionsFieldsPrefix . 'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            $this->tablePermissionsFieldsPrefix . 'module_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);
        $this->forge->addKey($this->tablePermissionsFieldsPrefix . 'id', true);
        $this->forge->createTable($this->tablePrefix . 'permissions', true);
    }

    public function down()
    {
        $this->forge->dropTable($this->tablePrefix . 'permissions', true);
    }
}
