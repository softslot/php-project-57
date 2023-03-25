<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Label;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Label $label;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->label = Label::factory()->create();
    }

    public function test_index_page(): void
    {
        $response = $this->get(route('labels.index'));

        $response->assertOk();
    }

    public function test_create_page_from_guest(): void
    {
        $response = $this->get(route('labels.create'));

        $response->assertForbidden();
    }

    public function test_create_page_from_user(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('labels.create'));

        $response->assertOk();
    }

    public function test_edit_page_from_guest(): void
    {
        $response = $this->get(route('labels.edit', $this->label->id));

        $response->assertForbidden();
    }

    public function test_edit_page_from_user(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('labels.edit', $this->label->id));

        $response->assertOk();
    }
}
