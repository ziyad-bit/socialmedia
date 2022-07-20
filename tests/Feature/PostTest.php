<?php

namespace Tests\Feature;

use App\Models\Friends_user;
use Tests\TestCase;
use App\Models\User;
use App\Models\Posts;
use App\Models\Shares;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    public $auth_user;
    public $data;

    public function setUp():void
    {
        parent::setUp();
        Session::start();

        /** @var \Illuminate\Contracts\Auth\Authenticatable $auth_user */
        $auth_user  = User::factory()->create();

        $this->auth_user = $auth_user;
        $this->actingAs($auth_user);

        $file   = UploadedFile::fake()->image('avatar.jpg');

        $this->data=[
            '_token' => csrf_token(),
            'text'   => 'unique post',
            'photo'  => $file,
        ];
    }

    ###############################      test index_posts     ################################
    public function test_fetch_data_in_index_posts_method():void
    {
        $user = User::factory()->create();

        Friends_user::factory()->create([
            'friend_id' => $this->auth_user->id,
            'user_id'   => $user->id,
        ]);

        $post=Posts::factory()->create([
            'text'    => 'unique post40',
            'user_id' => $user->id,
        ]);

        Shares::factory()->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);

        Posts::factory()->create([
            'text'    => 'unique post20',
            'user_id' => $user->id
        ]);

        Posts::factory()->create([
            'text'    => 'unique post12',
            'user_id' => $this->auth_user->id
        ]);

        $data=$this->data;
        
        $response = $this->postAjax('/',$data);

        $response->assertJson(['view'=>true]);
        $response->assertSee(['unique post20','unique post12','unique post40']);
        $response->assertStatus(200);
    }

    ###############################      test store     ################################
    public function test_database_insertion_in_store_method():void
    {
        $data=$this->data;
        
        $response = $this->postAjax('/post',$data);

        $response->assertJson(['view'=>true]);
        $response->assertStatus(200);
        
        $this->assertDatabaseHas('posts',['text'=>$data['text']]);
    }

    ###############################      test update     ################################
    public function test_database_update_in_update_method():void
    {
        $post=Posts::factory()->create(['user_id' => $this->auth_user->id]);

        $data=$this->data;
        
        $response = $this->call('put','/post/'.$post->id,$data);

        $response->assertJson(['post'=>true]);
        $response->assertStatus(200);
        
        $this->assertDatabaseHas('posts',['text'=>$data['text']]);
    }

    ###############################      test delete     ################################
    public function test_remove_data_in_delete_method():void
    {
        $post=Posts::factory()->create(['user_id' => $this->auth_user->id]);

        $data=$this->data;
        
        $response = $this->call('delete','/post/'.$post->id,$data);

        $response->assertJson(['success_msg'=>true]);
        $response->assertStatus(200);
        
        $this->assertDatabaseMissing('posts',['text'=>$post->text]);
    }
}
