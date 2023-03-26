<?php

namespace Tests\Feature;

use Tests\TestCase;

class MainPageTest extends TestCase
{
    public function test_main_page(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }
}
