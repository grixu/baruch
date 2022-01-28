<?php
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\CreatesApplication;

uses(TestCase::class, CreatesApplication::class, LazilyRefreshDatabase::class)
    ->in('Integration', 'Unit');

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}
