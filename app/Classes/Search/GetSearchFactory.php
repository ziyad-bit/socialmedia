<?php

namespace App\Classes\Search;

use App\Interfaces\Search\CreateSearch;

class GetSearchFactory implements  CreateSearch
{
    private string $search;
    private int $items_num;

    public function __construct(string $search , int $items_num)
    {
        $this->search    = $search;
        $this->items_num = $items_num;
    }

    public function createSearch(): object
    {
        return new GetSearch($this->search,$this->items_num);
    }
}
