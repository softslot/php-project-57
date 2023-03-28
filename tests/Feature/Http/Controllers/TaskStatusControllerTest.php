<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    private User $user;
    private TaskStatus $taskStatus;
    private array $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->taskStatus = TaskStatus::factory()->create();

        $this->data = TaskStatus::factory()->make()->only(['name']);
    }

    public function testIndexPage(): void
    {
        $response = $this->get(route('task_statuses.index'));

        $response->assertOk();
    }

    public function testCreatePageFromGuest(): void
    {
        $response = $this->get(route('task_statuses.create'));

        $response->assertForbidden();
    }

    public function testEditPageFromGuest(): void
    {
        $response = $this->get(route('task_statuses.edit', $this->taskStatus->id));

        $response->assertForbidden();
    }

    public function testStoreFromGuest(): void
    {
        $response = $this->post(
            route('task_statuses.store'),
            $this->data
        );

        $this->assertDatabaseMissing('task_statuses', $this->data);

        $response->assertForbidden();
    }

    public function testUpdateFromGuest(): void
    {
        $response = $this->put(
            route('task_statuses.update', $this->taskStatus->id),
            $this->data,
        );

        $this->assertDatabaseMissing('task_statuses', $this->data);

        $response->assertForbidden();
    }

    public function testDeleteFromGuest(): void
    {
        $response = $this->delete(route('task_statuses.destroy', $this->taskStatus->id));

        $this->assertDatabaseHas('task_statuses', $this->taskStatus->only('id'));

        $response->assertForbidden();
    }

    public function testCreatePageFromUser(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('task_statuses.create'));

        $response->assertOk();
    }

    public function testEditPageFromUser(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('task_statuses.edit', $this->taskStatus->id));

        $response->assertOk();
    }

    public function testStoreFromUser(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post(
                route('task_statuses.store'),
                $this->data
            );

        $this->assertDatabaseHas('task_statuses', $this->data);

        $response
            ->assertRedirectToRoute('task_statuses.index')
            ->assertSessionHasNoErrors();
    }

    public function testUpdateFromUser(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->put(
                route('task_statuses.update', $this->taskStatus->id),
                $this->data
            );

        $response
            ->assertRedirectToRoute('task_statuses.index')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('task_statuses', $this->data);
    }

    public function testDeleteFromUser(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->delete(route('task_statuses.destroy', $this->taskStatus->id));

        $response
            ->assertRedirectToRoute('task_statuses.index')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('task_statuses', $this->taskStatus->only('id'));
    }

    public function testDeleteTaskStatusAttachedToTask(): void
    {
        Task::factory()->create([
            'status_id' => $this->taskStatus->id,
        ]);

        $response = $this
            ->actingAs($this->user)
            ->delete(route('task_statuses.destroy', $this->taskStatus->id));

        $response
            ->assertRedirectToRoute('task_statuses.index')
            ->assertSessionHasErrors();

        $this->assertDatabaseHas('task_statuses', $this->taskStatus->only('id'));
    }
}
