<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    private array $data;
    private int $taskStatusId;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->taskStatusId = DB::table('task_statuses')
            ->insertGetId([
                'name' => 'Тестовый статус №1',
                'user_id' => $this->user->id,
            ]);

        $this->data = [
            'name' => 'Тестовый статус №2',
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

    public function test_create_page_from_user(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('task_statuses.create'));

        $response->assertOk();
    }

    public function test_edit_page_from_guest(): void
    {
        $response = $this->get(route('task_statuses.edit', $this->taskStatusId));

        $response->assertForbidden();
    }

    public function test_edit_page_from_user(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('task_statuses.edit', $this->taskStatusId));

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

        $response
            ->assertRedirectToRoute('task_statuses.index')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('task_statuses', $this->data);
    }

    public function test_store_from_guest(): void
    {
        $response = $this->post(
            route('task_statuses.store'),
            $this->data
        );

        $response->assertForbidden();
    }

    public function test_delete_from_guest(): void
    {
        $response = $this->delete(route('task_statuses.destroy', $this->taskStatusId));

        $response->assertForbidden();
    }

    public function test_delete_from_another_user(): void
    {
        $id = DB::table('task_statuses')->insertGetId($this->data);

        $anotherUser = User::factory()->create();

        $response = $this->actingAs($anotherUser)
            ->delete(route('task_statuses.destroy', $id));

        $response
            ->assertRedirectToRoute('task_statuses.index')
            ->assertSessionHasErrors();

        $this->assertDatabaseHas('task_statuses', $this->data);
    }

    public function test_update_from_guest(): void
    {
        $newData = ['name' => 'Новое название статуса'];
        $response = $this->put(
            route('task_statuses.update', $this->taskStatusId),
            $newData
        );

        $response->assertForbidden();

        $this->assertDatabaseMissing('task_statuses', $newData);
    }

    public function test_update_from_user(): void
    {
        $newData = ['name' => 'Новое название статуса'];
        $response = $this
            ->actingAs($this->user)
            ->put(
                route('task_statuses.update', $this->taskStatusId),
                $newData
            );

        $response->assertRedirectToRoute('task_statuses.index');

        $this->assertDatabaseHas('task_statuses', $newData);
    }

    public function test_delete_from_owner_user(): void
    {
        $id = DB::table('task_statuses')->insertGetId($this->data);

        $response = $this
            ->actingAs($this->user)
            ->delete(route('task_statuses.destroy', $id));

        $response
            ->assertRedirectToRoute('task_statuses.index')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('task_statuses', $this->data);
    }
}
