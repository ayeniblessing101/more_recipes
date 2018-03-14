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

class UserControllerTest extends TestCase
{
  use DatabaseMigrations;
  /**
   * Test should store a new user in database
   *
   * @return void
   */
  public function testShouldStoreANewUserInTheDatabase()
  {
    $this->post('/api/v1/users', [
      'firstname' => 'Adebola',
      'lastname' => 'Akinlabi',
      'email' => 'adebola.akinlabi@gmail.com',
      'password' => '1234'
    ]);

    // dd($res);
    $this
      ->seeStatusCode(201)
      ->seeJson(['status' => 'success'])
      ->seeInDatabase('users',['email' => 'adebola.akinlabi@gmail.com']);

  }

  public function testShouldThrowAnErrorIfEmailIsTaken()
  {
     $user = factory(User::class)->create([
       'firstname' => 'Tobi',
       'lastname' => 'Mayowa',
       'email' => 'adebola.akinlabi@gmail.com',
       'password' => '1234'
     ]);

     $this->post('/api/v1/users', [
      'firstname' => 'Tobi',
      'lastname' => 'Mayowa',
      'email' => 'adebola.akinlabi@gmail.com',
      'password' => '1234'
    ]);

    $this
      ->seeStatusCode(422)
      ->seeJson([
        "email" => [
          "The email has already been taken."
        ]
      ]);
  }

}