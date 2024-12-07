<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class KACL extends BaseConfig
{
    // Database settings
    public $tablePrefix = 'kacl_';
    public $tableRolesFieldsPrefix = 'rol_';
    public $tableUsersFieldsPrefix = 'use_';
    public $tableModulesFieldsPrefix = 'mod_';
    public $tableRoleUserFieldsPrefix = 'rus_';
    public $tablePermissionsFieldsPrefix = 'per_';
    public $tablePermissionRoleFieldsPrefix = 'pro_';

    public $loginSuccesfullRedirectURL = '/dashboard'; //URL to be redirected to after successful login
    public $loginURL = '/login';
    public $loginView = 'auth/login';
    public $logoutURL = '/logout';

    public $sessionTagId = 'user_id';
}
