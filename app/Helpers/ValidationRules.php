<?php

namespace App\Helpers;

class ValidationRules
{
    public static function required($value)
    {
        return empty($value) ? "El valor es requerido" : null;
    }

    public static function email($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) ? null : "Formato de correo electrónico inválido";
    }

    public static function integer($value)
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false ? null : "Debe ser un número entero";
    }

    public static function boolean($value)
    {
        return in_array($value, ['0', '1', true, false], true) ? null : "Debe ser 0, 1, true o false";
    }

    public static function minLength($value, $length)
    {
        return strlen($value) >= $length ? null : "El valor debe tener al menos $length caracteres";
    }

    public static function isUnique($value, $tableColumn)
    {
        list($table, $column) = explode('.', $tableColumn);
        $db = \Config\Database::connect();
        $result = $db->table($table)->where($column, $value)->countAllResults();
        return $result === 0 ? null : "El valor ya existe en $tableColumn";
    }
}
