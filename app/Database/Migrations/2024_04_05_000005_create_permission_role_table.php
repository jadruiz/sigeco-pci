<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePermissionRoleTable extends Migration
{
    protected $tablePrefix;
    protected $tablePermissionRoleFieldsPrefix;

    public function __construct()
    {
        parent::__construct();
        $this->tablePrefix = config('KACL')->tablePrefix;
        $this->tablePermissionRoleFieldsPrefix = config('KACL')->tablePermissionRoleFieldsPrefix;
    }

    public function up()
    {
        $this->forge->addField([
            $this->tablePermissionRoleFieldsPrefix . 'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            $this->tablePermissionRoleFieldsPrefix . 'permission_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            $this->tablePermissionRoleFieldsPrefix . 'role_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);
        $this->forge->addKey($this->tablePermissionRoleFieldsPrefix . 'id', true);
        $this->forge->createTable($this->tablePrefix . 'permission_role', true);
    }

    public function down()
    {
        $this->forge->dropTable($this->tablePrefix . 'permission_role');
    }
}
