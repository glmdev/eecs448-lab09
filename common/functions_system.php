<?php

function system_root() {
    $root = dirname(dirname(__FILE__));
    return $root;
}

function system_path($path) {
    if ( $path[0] === '/' ) {
        $path = substr($path, 1);
    }

    return implode('/', [system_root(), $path]);
}

function require_system($path, $once = true) {
    if ( $once ) {
        return require_once system_path($path);
    } else {
        return require system_path($path);
    }
}

function system_url($path) {
    if ( $path[0] === '/' ) {
        $path = substr($path, 1);
    }

    return implode('/', [SYSTEM_URL, $path]);
}

function system_redirect($path) {
    header('Location: ' . system_url($path));
    exit;
}
