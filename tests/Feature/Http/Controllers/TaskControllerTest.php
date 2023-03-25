<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Task $task;
    private array $data;

    protected function setUp(): void
    {
        parent::setUp();

        TaskStatus::factory()->create();

        $this->user = User::factory()->create();

        $this->task = Task::factory()->create([
            'created_by_id' => $this->user->id,
        ]);

        $this->data = Task::factory()->make()->only([
            'name',
            'description',
            'status_id',
            'assigned_to_id',
        ]);
    }

    public function test_index_page(): void
    {
        $response = $this->get(route('tasks.index'));

        $response->assertOk();
    }

    public function test_create_page_from_guest(): void
    {
        $response = $this->get(route('tasks.create'));

        $response->assertForbidden();
    }

    public function test_edit_page_from_guest(): void
    {
        $response = $this->get(route('tasks.edit', $this->task->id));

        $response->assertForbidden();
    }

    public function test_store_from_guest(): void
    {
        $response = $this->post(
            route('tasks.store'),
            $this->data
        );

        $this->assertDatabaseMissing('tasks', $this->data);

        $response->assertForbidden();
    }

    public function test_update_from_guest(): void
    {
        $response = $this->put(
            route('tasks.update', $this->task->id),
            $this->data
        );

        $this->assertDatabaseMissing('tasks', $this->data);

        $response->assertForbidden();
    }

    public function test_delete_from_guest(): void
    {
        $response = $this->delete(route('tasks.destroy', $this->task->id));

        $this->assertDatabaseHas('tasks', $this->task->only('id'));

        $response->assertForbidden();
    }

    public function test_create_page_from_user(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('tasks.create'));

        $response->assertOk();
    }

    public function test_edit_page_from_user(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('tasks.edit', $this->task->id));

        $response->assertOk();
    }

    public function test_store_from_user(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post(
                route('tasks.store'),
                $this->data
            );

        $this->assertDatabaseHas('tasks', $this->data);

        $response
            ->assertRedirectToRoute('tasks.index')
            ->assertSessionHasNoErrors();
    }

    public function test_update_from_user(): void
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

    public function test_delete_from_creator(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->delete(route('tasks.destroy', $this->task->id));

        $response
            ->assertRedirectToRoute('tasks.index')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('tasks', $this->task->only('id'));
    }

    public function test_delete_from_non_creator(): void
    {
        $anotherUser = User::factory()->create();

        $response = $this
            ->actingAs($anotherUser)
            ->delete(route('tasks.destroy', $this->task->id));

        $this->assertDatabaseHas('tasks', $this->task->only('id'));

        $response->assertForbidden();
    }
}
