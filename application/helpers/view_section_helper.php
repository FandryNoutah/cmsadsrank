<?php
$__sections = [];

function start_section($name) {
    global $__sections;
    ob_start();
    $__sections['__current'] = $name;
}

function end_section() {
    global $__sections;
    $name = $__sections['__current'];
    $__sections[$name] = ob_get_clean();
    unset($__sections['__current']);
}

function section($name) {
    global $__sections;
    return isset($__sections[$name]) ? $__sections[$name] : '';
}
