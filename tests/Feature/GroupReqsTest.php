<?php

namespace Tests\Feature;

use App\Models\Group_users;
use App\Models\Groups;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class GroupReqsTest extends TestCase
{
	use DatabaseMigrations;

	public $auth_user;
	public $data;

	public function setUp(): void
	{
		parent::setUp();
		Session::start();

		/** @var \Illuminate\Contracts\Auth\Authenticatable $auth_user */
		$auth_user = User::factory()->create();
		$group     = Groups::factory()->create();

		$this->auth_user = $auth_user;
		$this->actingAs($auth_user);

		$this->data = [
			'_token'   => csrf_token(),
			'group_id' => $group->id,
			'role_id'  => 2,
		];
	}

	//################################     test store     ###############################
	public function test_database_insertion_in_store_method(): void
	{
		$data     = $this->data;
		$response = $this->post('/group-requests', $data);

		$response->assertStatus(200);
		$response->assertJson(['success' => true]);

		$this->assertDatabaseHas('group_users', ['group_id' => $data['group_id']]);
	}

	//################################     test show    ###############################
	public function test_get_group_reqs_from_database_in_show_method(): void
	{
		$auth_user = $this->auth_user;

		$user  = User::factory()->create();
		$group = Groups::factory()->create();
		$role  = Roles::factory()->create(['id' => 2]);

		Group_users::factory()->create([
			'user_id'  => $user->id,
			'group_id' => $group->id,
			'status'   => 0,
			'role_id'  => null,
		]);

		$group_users_auth = Group_users::factory()->create([
			'user_id'  => $auth_user->id,
			'group_id' => $group->id,
			'status'   => 1,
			'role_id'  => $role->id,
		]);

		$response = $this->get('/group-requests/' . $group_users_auth->id);

		$response->assertStatus(200);
		$response->assertJson(['view' => true]);
		$response->assertSee('' . $user->name);
	}

	//################################     test update    ###############################
	public function test_approve_req_in_update_method(): void
	{
		$auth_user = $this->auth_user;

		$user  = User::factory()->create();
		$group = Groups::factory()->create();
		$role  = Roles::factory()->create(['id' => 2]);

		Roles::factory()->create(['id' => 1]);

		$group_user = Group_users::factory()->create([
			'user_id'  => $user->id,
			'group_id' => $group->id,
			'status'   => 0,
		]);

		Group_users::factory()->create([
			'user_id'  => $auth_user->id,
			'group_id' => $group->id,
			'status'   => 1,
			'role_id'  => $role->id,
		]);

		$data = $this->data;

		$response = $this->call('put', '/group-requests/' . $group_user->id, $data);

		$response->assertStatus(200);
		$response->assertJson(['success' => true]);

		$this->assertDatabaseHas('group_users', ['id' => $group_user->id, 'status' => 1]);
	}

	//################################     test ignore    ###############################
	public function test_ignore_req_in_ignore_method(): void
	{
		$auth_user = $this->auth_user;

		$user  = User::factory()->create();
		$group = Groups::factory()->create();
		$role  = Roles::factory()->create(['id' => 2]);

		$group_user = Group_users::factory()->create([
			'user_id'  => $user->id,
			'group_id' => $group->id,
			'status'   => 0,
		]);

		Group_users::factory()->create([
			'user_id'  => $auth_user->id,
			'group_id' => $group->id,
			'status'   => 1,
			'role_id'  => $role->id,
		]);

		$data = $this->data;

		$response = $this->call('put', '/group/requests/ignore/' . $group_user->id, $data);

		$response->assertStatus(200);
		$response->assertJson(['success' => true]);

		$this->assertDatabaseHas('group_users', ['id' => $group_user->id, 'status' => 2]);
	}

	//################################     test delete (leave group)    ###############################
	public function test_auth_user_leave_group_in_delete_method(): void
	{
		$auth_user = $this->auth_user;

		$group = Groups::factory()->create();
		$role  = Roles::factory()->create(['id' => 1]);

		$group_user_auth = Group_users::factory()->create([
			'user_id'  => $auth_user->id,
			'group_id' => $group->id,
			'status'   => 1,
			'role_id'  => $role->id,
		]);

		$data = $this->data;

		$response = $this->call('delete', '/group-requests/' . $group_user_auth->id, $data);

		$response->assertStatus(302);
		$response->assertSessionHas('success');

		$this->assertDatabaseMissing('group_users', ['id' => $group_user_auth->id]);
	}
}
