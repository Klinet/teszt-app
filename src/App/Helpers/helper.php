<?php
function pretty_var_export($data, $return = false)
{
    $exported = var_export($data, true);
    $exported = str_replace('array (', '[', $exported);
    $exported = str_replace(')', ']', $exported);
    $exported = preg_replace('/^(\s*)\[(\s*)$/m', '$1[', $exported);

    if ($return) {
        return $exported;
    }

    echo '<pre>' . $exported . '</pre>';
    return null;
}

function base_path($path = '') {
    $basePath = dirname(__DIR__);
    return $path ? $basePath . DIRECTORY_SEPARATOR . $path : $basePath;
}
