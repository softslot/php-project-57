<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    private User $user;
    private Label $label;
    private Task $task;
    private array $data;

    protected function setUp(): void
    {
        parent::setUp();

        TaskStatus::factory()->create();

        $this->user = User::factory()->create();

        $this->label = Label::factory()->create();

        $this->task = Task::factory()->create();

        $this->data = Task::factory()->make()->only(['name']);
    }

    public function testIndexPage(): void
    {
        $response = $this->get(route('labels.index'));

        $response->assertOk();
    }

    public function testCreatePageFromGuest(): void
    {
        $response = $this->get(route('labels.create'));

        $response->assertForbidden();
    }

    public function testEditPageFromGuest(): void
    {
        $response = $this->get(route('labels.edit', $this->label->id));

        $response->assertForbidden();
    }

    public function testStoreFromGuest(): void
    {
        $response = $this->post(
            route('labels.store'),
            $this->data
        );

        $this->assertDatabaseMissing('labels', $this->data);

        $response->assertForbidden();
    }

    public function testUpdateFromGuest(): void
    {
        $response = $this->put(
            route('labels.update', $this->label->id),
            $this->data
        );

        $this->assertDatabaseMissing('labels', $this->data);

        $response->assertForbidden();
    }

    public function testDeleteFromGuest(): void
    {
        $response = $this->delete(route('labels.destroy', $this->label->id));

        $this->assertDatabaseHas('labels', $this->label->only('id'));

        $response->assertForbidden();
    }

    public function testCreatePageFromUser(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('labels.create'));

        $response->assertOk();
    }

    public function testEditPageFromUser(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('labels.edit', $this->label->id));

        $response->assertOk();
    }

    public function testStoreFromUser(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post(
                route('labels.store'),
                $this->data
            );

        $this->assertDatabaseHas('labels', $this->data);

        $response
            ->assertRedirectToRoute('labels.index')
            ->assertSessionHasNoErrors();
    }

    public function testUpdateFromUser(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->put(
                route('labels.update', $this->label->id),
                $this->data
            );

        $response
            ->assertRedirectToRoute('labels.index')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('labels', $this->data);
    }

    public function testDeleteFromUser(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->delete(route('labels.destroy', $this->label->id));

        $response
            ->assertRedirectToRoute('labels.index')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('labels', $this->label->only('id'));
    }

    public function testDeleteLabelAttachedToTask(): void
    {
        $this->task
            ->labels()
            ->attach($this->label);

        $response = $this
            ->actingAs($this->user)
            ->delete(route('labels.destroy', $this->label->id));

        $response
            ->assertRedirectToRoute('labels.index')
            ->assertSessionHasErrors();

        $this->assertDatabaseHas('labels', $this->label->only('id'));
    }
}
