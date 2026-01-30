<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class RoleHelper {
    /**
     * Get Role ID dynamically from mst__roles table
     *
     * @param string $roleName
     * @return int|null
     */
    public static function getRole($roleName) {
        return DB::table('mst__roles')->where('id', $roleName)->value('name');
    }

}
