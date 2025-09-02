<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_role_name')) {
    function get_role_name($type) {
        switch($type) {
            case 1: return 'Administrator';
            case 2: return 'Vendor';
            case 3: return 'Customer';
            default: return 'User';
        }
    }
}
