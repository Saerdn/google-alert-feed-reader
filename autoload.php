<?php
/**
 * Register the autoloader.
 *
 * Extended to load multiple namespaces.
 *
 * @param string $class The fully-qualified class name.
 * @return void
 */
spl_autoload_register(function ($class) {
    // Check if class exists as file (in path)
    // Therefor we need to swap the \ with a / and concatenate the path
    $relativeClassFilePath = str_replace('\\', '/', $class);
    $base_dir = __DIR__ . '/src/';
    $file = $base_dir . $relativeClassFilePath . '.php';

    // if the file exists, require it
    if( file_exists($file) ) {
        require $file;
    } else {
        return;
    }
});