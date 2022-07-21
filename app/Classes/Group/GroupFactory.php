<?php

namespace App\Classes\Group;

class GroupFactory
{
	//#############################    get admin   ##################################
	public static function factory(string $type):object|null
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
