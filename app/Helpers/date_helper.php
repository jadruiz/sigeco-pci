<?php

if (!function_exists('translate_date_to_spanish')) {
    function translate_date_to_spanish($dateString)
    {
        // Define arrays de traducción para días y meses
        $days = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo',
        ];

        $months = [
            'January' => 'enero',
            'February' => 'febrero',
            'March' => 'marzo',
            'April' => 'abril',
            'May' => 'mayo',
            'June' => 'junio',
            'July' => 'julio',
            'August' => 'agosto',
            'September' => 'septiembre',
            'October' => 'octubre',
            'November' => 'noviembre',
            'December' => 'diciembre',
        ];

        // Reemplaza días y meses en la fecha
        $dateString = str_replace(array_keys($days), $days, $dateString);
        $dateString = str_replace(array_keys($months), $months, $dateString);

        return $dateString;
    }
}
