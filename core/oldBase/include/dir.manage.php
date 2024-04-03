<?php
if (!function_exists('rmdirr')) {

    function rmdirr($target, $verbose = false)
    // removes a directory and everything within it
    {
        $exceptions = array('.', '..');
        if (!$sourcedir  = @opendir($target)) {
            if ($verbose) echo '<strong>Couldn&#146;t open '.$target."</strong><br />\n";
            return false;
        }
        while (false !== ($sibling = readdir($sourcedir))) {
            if (!in_array($sibling, $exceptions)) {
                $object = str_replace('//', '/', $target.'/'.$sibling);
                if ($verbose) echo 'Processing: <strong>'.$object."</strong><br />\n";
                if (is_dir($object)) rmdirr($object);
                if (is_file($object)) {
                    $result = @unlink($object);
                    if ($verbose && $result) echo "File has been removed<br />\n";
                    if ($verbose && (!$result)) echo "<strong>Couldn&#146;t remove file</strong>";
                }
            }
        }
        closedir($sourcedir);
        if ($result = @rmdir($target)) {
            if ($verbose) echo "Target directory has been removed<br />\n";
            return true;
        }
        if ($verbose) echo "<strong>Couldn&#146;t remove target directory</strong>";
        return false;
    }
}