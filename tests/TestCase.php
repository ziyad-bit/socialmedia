<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function postAjax(string $url,array $data=[])
    {
        return $this->post($url,$data,['HTTP_X-Requested-With' => 'XMLHttpRequest']);
    }
}
