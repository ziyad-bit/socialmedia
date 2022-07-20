<?php

namespace App\Traits;

trait GetPageCode
{
	public function getPageCode($data):string
	{
		if ($data->hasMorePages()) {
			return  $data->nextCursor()->encode();
		}

		return '';
	}
}
