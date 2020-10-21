<?php

$files = array_merge(
    glob('./config/*.php' ?: []),
);

$config = array_map(function ($file){

    return require $file;
},$files);

return array_merge_recursive(...$config);