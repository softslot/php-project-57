<?php

namespace Tests\Feature;

use Tests\TestCase;

class MainPageTest extends TestCase
{
    public function testMainPage(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
