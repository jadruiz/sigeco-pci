<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateModulesTable extends Migration
{
    protected $tablePrefix;
    protected $tableModulesFieldsPrefix;

    public function __construct()
    {
        parent::__construct();
        $this->tablePrefix = config('KACL')->tablePrefix;
        $this->tableModulesFieldsPrefix = config('KACL')->tableModulesFieldsPrefix;
    }

    public function up()
    {
        $this->forge->addField([
            $this->tableModulesFieldsPrefix . 'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            $this->tableModulesFieldsPrefix . 'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            $this->tableModulesFieldsPrefix . 'description' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            $this->tableModulesFieldsPrefix . 'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => date('Y-m-d H:i:s'),
            ],
            $this->tableModulesFieldsPrefix . 'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => date('Y-m-d H:i:s'),
            ],
            $this->tableModulesFieldsPrefix . 'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey($this->tableModulesFieldsPrefix . 'id', true);
        $this->forge->createTable($this->tablePrefix . 'modules', true);
    }

    public function down()
    {
        $this->forge->dropTable($this->tablePrefix . 'modules');
    }
}
