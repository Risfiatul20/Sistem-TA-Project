<?php
namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Migrate database for testing
        Artisan::call('migrate');
    }

    protected function tearDown(): void
    {
        // Rollback migrations after test
        Artisan::call('migrate:reset');
        
        parent::tearDown();
    }
}