<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListTest extends TestCase
{

    use RefreshDatabase;


    protected $list;
    public function setUp(): void
    {
        parent::setUp();
        $this->list = TodoList::factory()->create();
    }

    public function test_fetch_all_todo_list(): void
    {
        $response = $this->getJson(route('todo-list.index'));
        $this->assertEquals(1, count($response->json()));
    }

    public function test_fetch_single_todo_list()
    {
        $response = $this->getJson(route('todo-list.show', $this->list->id))->json();
        $this->assertEquals($response['title'], $this->list->title);
    }

    public function test_store_new_todo_list()
    {
        $response = $this->postJson(route('todo-list.store'), ['title' => $this->list->title])
            ->assertCreated()->json();
        $this->assertEquals($this->list->title, $response['title']);
        $this->assertDatabaseHas('todo_lists', ['title' => $this->list->title]);
    }

    public function test_while_storing_todo_list_title_field_is_required()
    {
        $this->withExceptionHandling();
        $response = $this->postJson(route('todo-list.store'))
            ->assertUnprocessable();
        $response->assertJsonValidationErrors(['title']);
    }

    public function test_delete_todo_list_list()
    {
        $this->deleteJson(route('todo-list.destroy', $this->list->id))->assertNoContent();
        $this->assertDatabaseMissing('todo_lists', ['title' => $this->list->title]);
    }

    public function test_update_todo_list()
    {
        $this->patchJson(route('todo-list.update', $this->list->id), ['title' => 'updated title'])
            ->assertOk();
        $this->assertDatabaseHas('todo_lists', ['id' => $this->list->id, 'title' => 'updated title']);
    }

    public function test_while_update_todo_list_title_field_is_required()
    {
        $this->withExceptionHandling();
        $response =  $this->patchJson(route('todo-list.update', $this->list->id))
            ->assertUnprocessable();
        $response->assertJsonValidationErrors(['dd']);
    }
}
