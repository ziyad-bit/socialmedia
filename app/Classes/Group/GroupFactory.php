<?php

namespace App\Classes\Group;

use App\Classes\Group\Group;
use App\Classes\Group\GroupReq;
use App\Classes\Group\GroupAdmin;
use App\Classes\Group\GroupUsers;

class GroupFactory
{
    ##############################    get admin   ##################################
    public static function factory(string $type):object
    {
        if ($type == 'GroupReq') {
            return new GroupReq();
        }

        if ($type == 'GroupAdmin') {
            return new GroupAdmin();
        }

        if ($type == 'GroupUsers') {
            return new GroupUsers();
        }

        if ($type == 'Group') {
            return new Group();
        }

        return null;
    }
}
