<?php
// Load the Forbiz Common Core
require_once __DIR__.'/ForbizCommonCore.php';

// Windows?
if(DIRECTORY_SEPARATOR === '\\') {
    `chcp 65001`; // UTF-8로 변경
}

/**
 * Reference to the Nuna method.
 *
 * Returns current Nuna instance object
 *
 * @return Nuna
 */
if (!function_exists('get_instance')) {

    function &get_instance()
    {
        return ForbizCli::get_instance();
    }
}

if (!function_exists('getForbiz')) {

    function getForbiz()
    {
        return getForbizCli();
    }
}

function getForbizCli()
{
    static $forbiz = null;

    if (get_instance() === null) {
        if ($forbiz === null) {
            $forbiz = new ForbizCli();
        }

        return $forbiz;
    }

    return get_instance();
}
// Set a mark point for benchmarking
$BM->mark('loading_time:_base_classes_end');
