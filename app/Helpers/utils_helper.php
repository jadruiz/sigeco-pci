<?php
function generateOptionsFromModelData($data)
{
    $options = ['' => 'Todos'];
    foreach ($data as $item) {
        $options[$item['id']] = $item['titulo'];
    }
    return $options;
}

if (!function_exists('str_ends_with')) {
    function str_ends_with($haystack, $needle)
    {
        // Obtén la longitud del string que se busca
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }
        // Compara el final del string con el sufijo
        return substr($haystack, -$length) === $needle;
    }
}

function directory_copy($src, $dst)
{
    $dir = opendir($src);
    @mkdir($dst);

    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                directory_copy($src . '/' . $file, $dst . '/' . $file);
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}
