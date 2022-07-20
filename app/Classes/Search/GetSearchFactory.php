<?php

namespace App\Classes\Search;

use App\Interfaces\Search\CreateSearch;

class GetSearchFactory implements CreateSearch
{
	public function createSearch(): object
	{
		return new GetSearch();
	}
}
