<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    private User $user;
    private Task $task;
    private array $data;

    protected function setUp(): void
    {
        parent::setUp();

        TaskStatus::factory()->create();

        $this->user = User::factory()->create();

        $this->task = Task::factory()
            ->for($this->user, 'createdBy')
            ->create();

        $this->data = Task::factory()
            ->make()
            ->only([
                'name',
                'description',
                'status_id',
                'assigned_to_id',
            ]);
    }

    public function testIndexPage(): void
    {
        $response = $this->get(route('tasks.index'));

        $response->assertOk();
    }

    public function testCreatePageFromGuest(): void
    {
        $response = $this->get(route('tasks.create'));

        $response->assertForbidden();
    }

    public function testEditPageFromGuest(): void
    {
        $response = $this->get(route('tasks.edit', $this->task->id));

        $response->assertForbidden();
    }

    public function testStoreFromGuest(): void
    {
        $response = $this->post(
            route('tasks.store'),
            $this->data
        );

        $response->assertForbidden();

        $this->assertDatabaseMissing('tasks', $this->data);
    }

    public function testUpdateFromGuest(): void
    {
        $response = $this->put(
            route('tasks.update', $this->task->id),
            $this->data
        );

        $response->assertForbidden();

        $this->assertDatabaseMissing('tasks', $this->data);
    }

    public function testDeleteFromGuest(): void
    {
        $response = $this->delete(route('tasks.destroy', $this->task->id));

        $response->assertForbidden();

        $this->assertDatabaseHas('tasks', $this->task->only('id'));
    }

    public function testCreatePageFromUser(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('tasks.create'));

        $response->assertOk();
    }

    public function testEditPageFromUser(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('tasks.edit', $this->task->id));

        $response->assertOk();
    }

    public function testStoreFromUser(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post(
                route('tasks.store'),
                $this->data
            );

        $response
            ->assertRedirectToRoute('tasks.index')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('tasks', $this->data);
    }

    public function testUpdateFromUser(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->put(
                route('tasks.update', $this->task->id),
                $this->data
            );

        $response
            ->assertRedirectToRoute('tasks.index')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('tasks', $this->data);
    }

    public function testDeleteFromCreator(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->delete(route('tasks.destroy', $this->task->id));

        $response
            ->assertRedirectToRoute('tasks.index')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('tasks', $this->task->only('id'));
    }

    public function testDeleteFromNonCreator(): void
    {
        $anotherUser = User::factory()->create();

        $response = $this
            ->actingAs($anotherUser)
            ->delete(route('tasks.destroy', $this->task->id));

        $response->assertForbidden();

        $this->assertDatabaseHas('tasks', $this->task->only('id'));
    }
}
