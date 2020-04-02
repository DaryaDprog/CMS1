<?php

function copyFolder($from, $to)
{
    if (is_dir($from)) {
        @mkdir($to);
        $d = dir($from);
        while (false !== ($entry = $d->read())) {
            if ($entry == "." || $entry == "..") continue;
            copyFolder("$from/$entry", "$to/$entry");
        }
        $d->close();
    } else copy($from, $to);
}

?>
