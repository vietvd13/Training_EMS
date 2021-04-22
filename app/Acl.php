<?php
/**
 * File Acl.php
 *
 * @author Tuan Duong <bacduong@gmail.com>
 * @package Laravue
 * @version 1.0
 */
namespace App;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Class Acl
 *
 * @package App\Laravue
 */
final class Acl
{
    const ROLE_ADMIN = 'admin'; // this role will have all permission
    const ROLE_USER = 'user'; //this rola will have permission about answer survey
    const PERMISSION_PERMISSION_MANAGE = "permission manage";
    public static function roles(): array
    {
        try {
            $class = new \ReflectionClass(__CLASS__);
            $constants = $class->getConstants();
            $roles =  Arr::where($constants, function($value, $key) {
                return Str::startsWith($key, 'ROLE_');
            });

            return array_values($roles);
        } catch (\ReflectionException $exception) {
            return [];
        }
    }

    //permission for view of admin and manager
    // const PERMISSION_VIEW_MENU_MANAGE_QUIZZ = 'view menu quizz';

    /**
     * @param array $exclusives Exclude some permissions from the list
     * @return array
     */
    // public static function permissions(array $exclusives = []): array
    // {
    //     try {
    //         $class = new \ReflectionClass(__CLASS__);
    //         $constants = $class->getConstants();
    //         $permissions = Arr::where($constants, function($value, $key) use ($exclusives) {
    //             return !in_array($value, $exclusives) && Str::startsWith($key, 'PERMISSION_');
    //         });

    //         return array_values($permissions);
    //     } catch (\ReflectionException $exception) {
    //         return [];
    //     }
    // }

    // public static function menuPermissions(): array
    // {
    //     try {
    //         $class = new \ReflectionClass(__CLASS__);
    //         $constants = $class->getConstants();
    //         $permissions = Arr::where($constants, function($value, $key) {
    //             return Str::startsWith($key, 'PERMISSION_VIEW_MENU_');
    //         });

    //         return array_values($permissions);
    //     } catch (\ReflectionException $exception) {
    //         return [];
    //     }
    // }

    /**
     * @return array
     */
}
