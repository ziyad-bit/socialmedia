<?php

namespace App\Classes\Search;

use App\Interfaces\Search\CreateSearch;

class PaginateSearchFactory implements CreateSearch
{
	public function createSearch(): object
	{
		return new PaginateSearch();
	}
}
