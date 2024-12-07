<?php

namespace App\Libraries;

use App\Models\Admin\GenericDataModel;
use App\Models\Acl\UsuarioModel;
use App\Services\Acl\AuthService;

class ColumnConfig
{
    protected static $authService;
    protected static $usuarioModel;

    /**
     * Inicializa AuthService y UsuarioModel.
     */
    public static function init(AuthService $authService)
    {
        self::$authService = $authService;
        if (!self::$usuarioModel) {
            self::$usuarioModel = new UsuarioModel();
        }
    }

    public static function getConfiguration($moduleKey = 'sustentantes')
    {
        $configPath = APPPATH . "Config/Modules/{$moduleKey}_columns.php";
        if (file_exists($configPath)) {
            $config = require $configPath;
        } else {
            throw new \Exception("Archivo de configuración no encontrado para el módulo: {$moduleKey}");
        }
        // Asegurarse de que $config tenga la clave `columns`
        if (!isset($config['columns'])) {
            throw new \Exception("La configuración para el módulo '{$moduleKey}' debe contener una clave 'columns'.");
        }
        // Filtrar columnas según permisos
        $config['columns'] = self::filterColumnsByPermission($config['columns']);
        // Reasignar índices dt secuencialmente
        $config['columns'] = self::assignDtIndexesSequentially($config['columns']);
        return $config;
    }

    /**
     * Filtra las columnas según permisos de usuario y reindexa
     * 
     * @param array $columns
     * @return array
     */
    protected static function filterColumnsByPermission(array $columns): array
    {
        $filteredColumns = array_filter($columns, function ($column) {
            return empty($column['permission']) || self::$authService->hasPermission($column['permission']);
        });

        return array_values($filteredColumns);  // Asegura un índice secuencial
    }

    /**
     * Reasigna índices `dt` secuencialmente y reindexa el array de columnas.
     *
     * @param array $columns
     * @return array
     */
    protected static function assignDtIndexesSequentially(array $columns): array
    {
        $reindexedColumns = [];
        $dtIndex = 0;

        foreach ($columns as $column) {
            $column['dt'] = $dtIndex;
            $reindexedColumns[] = $column;
            $dtIndex++;
        }

        return $reindexedColumns;
    }

    public static function getColumnAndFilterConfig($configKey)
    {
        $config = self::getConfiguration($configKey);
        $columns = $config['columns'] ?? [];
        $filter_tabs = $config['filter_tabs'] ?? [];
        return [
            'columns' => $columns,
            'filter_tabs' => $filter_tabs
        ];
    }
}
