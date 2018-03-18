<?php
/**
 * Created by ApotiEri.
 * User: andela
 * Date: 11/03/2018
 * Time: 8:28 PM
 */

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\User;

class RecipeControllerTest extends TestCase
{
  use DatabaseMigrations;

  // public function testShouldCreateANewRecipe() {

  //   $user = factory(User::class)->create([
  //     'firstname' => 'moni',
  //     'lastname' => 'alabi',
  //     'email' => 'moni.alabi@gmail.com',
  //     'password' => '1234'
  //   ]);

  //   $token = JWTAuth::fromUser($user);
   
  //   $headers = ['Authorization' => "Bearer $token"];
  //   dd($headers);
  //   $recipe = [
  //     'name' => 'Akara',
  //     'description' => 'It is an african meal'
  //   ];
  //   $response = $this->post('/api/v1/recipes',$recipe, $headers);
  //   dd($response);
  //   $response
  //   ->seeStatusCode(201);

  //   // $this
  //   //   ->seeStatusCode(201)
  //   //   ->seeJson([
  //   //     'created' => true
  //   // ]);
  // }
}