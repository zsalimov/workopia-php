<?php

/**
 * Get the base path
 * 
 * @param string $path
 * @return string
 */
function basePath($path = '')
{
    return __DIR__ . '/' . $path;
}

/**
 * Load a view
 * 
 * @param string $name
 * @return void
 */
function loadView($name, $data = [])
{
    $viewPath = basePath("App/views/{$name}.view.php");

    if (file_exists($viewPath)) {
        extract($data);
        require $viewPath;
    } else {
        echo "View {$name} not found";
    }
}

/**
 * Load a partial
 * 
 * @param string $name
 * @return void
 */
function loadPartial($name, $data = [])
{
    $partialPath = basePath("App/views/partials/{$name}.php");

    if (file_exists($partialPath)) {
        extract($data);
        require $partialPath;
    } else {
        echo "Partial {$name} not found";
    }
}

/**
 * Format salary
 *
 * @param string $salary
 * @return Numberformat
 */
function formatSalary($salary)
{
    return '$' . number_format(floatval($salary));
}

function sanitize($dirty)
{
    return filter_var(trim($dirty), FILTER_SANITIZE_SPECIAL_CHARS);
}

/**
 * Redirect to given URL
 *
 * @param string $uri
 * @return void
 */
function redirect($uri) {
    header("location: {$uri}");
    exit;
}

function dd($params) {
    echo "<pre>";
    var_dump($params);
    echo "</pre>";
    die();
}