<?php

function aGetAllFile($folder) {
    $aFileArr = [];
    if(is_dir($folder)) {
        $handle = opendir($folder);
        while (($file = readdir($handle)) !== false) {
            //如果是.或者..则跳过
            if($file == "." || $file == "..") {
                continue;
            }
            if(is_file($folder . "/" . $file)) {
                $aFileArr[] = $file;
            } else if (is_dir($folder . "/" . $file)) {
                $aFileArr[file] = aGetAllFile($folder . "/" . file);
            }
        }
        closedir($handle);
    }
    return $aFileArr;
}
$path = "/source/github/php/php-base";
print_r(aGetAllFile($path));