<?php

namespace App\Helpers;

class CustomHelper {
    public static function get_role_name($role)
    {
        if($role == 0) {
            return "Student";
        }else if($role == 1) {
            return "Teacher";
        }else if($role == 5) {
            return "Super Admin";
        }else {
            return "-";
        }
    }
}