<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;
    
    private User $user;
    private TaskStatus $taskStatus;
    private array $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->taskStatus = TaskStatus::factory()->create();

        $this->data = [
            'name' => 'Status #2',
            'user_id' => $this->user->id,
        ];
    }

    public function test_index_page(): void
    {
        $response = $this->get(route('task_statuses.index'));

        $response->assertOk();
    }

    public function test_create_page_from_guest(): void
    {
        $response = $this->get(route('task_statuses.create'));

        $response->assertForbidden();
    }

    public function test_edit_page_from_guest(): void
    {
        $response = $this->get(route('task_statuses.edit', $this->taskStatus->id));

        $response->assertForbidden();
    }

    public function test_store_from_guest(): void
    {
        $response = $this->post(
            route('task_statuses.store'),
            $this->data
        );

        $this->assertDatabaseMissing('task_statuses', $this->data);

        $response->assertForbidden();
    }

    public function test_update_from_guest(): void
    {
        $newData = ['name' => 'New task status name'];
        $response = $this->put(
            route('task_statuses.update', $this->taskStatus->id),
            $newData
        );

        $this->assertDatabaseMissing('task_statuses', $newData);

        $response->assertForbidden();
    }
    
    public function test_delete_from_guest(): void
    {
        $response = $this->delete(route('task_statuses.destroy', $this->taskStatus->id));

        $this->assertDatabaseHas('task_statuses', ['id' => $this->taskStatus->id]);

        $response->assertForbidden();
    }

    public function test_create_page_from_user(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('task_statuses.create'));

        $response->assertOk();
    }

    public function test_edit_page_from_user(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('task_statuses.edit', $this->taskStatus->id));

        $response->assertOk();
    }

    public function test_store_from_user(): void
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

    public function test_update_from_user(): void
    {
        $newData = ['name' => 'New task status name'];
        $response = $this
            ->actingAs($this->user)
            ->put(
                route('task_statuses.update', $this->taskStatus->id),
                $newData
            );

        $response->assertRedirectToRoute('task_statuses.index');

        $this->assertDatabaseHas('task_statuses', $newData);
    }

    public function test_delete_from_user(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->delete(route('task_statuses.destroy', $this->taskStatus->id));

        $response
            ->assertRedirectToRoute('task_statuses.index')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('task_statuses', ['id' => $this->taskStatus->id]);
    }

    public function test_delete_task_status_attached_to_task(): void
    {
        Task::create([
            'name' => 'Task',
            'status_id' => $this->taskStatus->id,
            'created_by_id' => $this->user->id,
        ]);

        $response = $this
            ->actingAs($this->user)
            ->delete(route('task_statuses.destroy', $this->taskStatus->id));

        $response
            ->assertRedirectToRoute('task_statuses.index')
            ->assertSessionHasErrors();

        $this->assertDatabaseHas('task_statuses', ['id' => $this->taskStatus->id]);
    }
}
