<?php

namespace Tests\Feature;

use App\Models\Groups;
use App\Models\Roles;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GroupReqsTest extends TestCase
{
    use DatabaseTransactions;

    public $auth_user;
    public $data;

    public function setUp():void
    {
        parent::setUp();
        Session::start();

        /** @var \Illuminate\Contracts\Auth\Authenticatable $auth_user */
        $auth_user = User::factory()->create();
        $group     = Groups::factory()->create();

        $this->auth_user = $auth_user;
        $this->actingAs($auth_user);

        $this->data=[
            '_token'   => csrf_token(),
            'group_id' => $group->id,
            'role_id'  => 2,
        ];
    }
    
    #################################     test store     ###############################
    public function test_store():void
    {
        $data=$this->data;
        $response = $this->post('/group/reqs',$data);

        $response->assertStatus(200);
        $response->assertJson(['success'=>true]);

        $this->assertDatabaseHas('group_users',['group_id'=>$data['group_id']]);
    }

    #################################     test show    ###############################
    public function test_show():void
    {
        $data=$this->data;
        $response = $this->post('/group/reqs',$data);

        $response->assertStatus(200);
        $response->assertJson(['success'=>true]);

        $this->assertDatabaseHas('group_users',['group_id'=>$data['group_id']]);
    }
}
