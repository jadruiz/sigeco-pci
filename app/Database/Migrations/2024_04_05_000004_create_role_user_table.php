<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRoleUserTable extends Migration
{
    protected $tablePrefix;
    protected $tableRoleUserFieldsPrefix;

    public function __construct()
    {
        parent::__construct();
        $this->tablePrefix = config('KACL')->tablePrefix;
        $this->tableRoleUserFieldsPrefix = config('KACL')->tableRoleUserFieldsPrefix;
    }

    public function up()
    {
        $this->forge->addField([
            $this->tableRoleUserFieldsPrefix . 'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            $this->tableRoleUserFieldsPrefix . 'role_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            $this->tableRoleUserFieldsPrefix . 'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);
        $this->forge->addKey($this->tableRoleUserFieldsPrefix . 'id', true);
        $this->forge->createTable($this->tablePrefix . 'role_user', true);
    }

    public function down()
    {
        $this->forge->dropTable($this->tablePrefix . 'role_user');
    }
}
