<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;



    //This will apply to all test cases.
    //We don't want laravel to handle exception but give us actual data.
    public function setup(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }
}
