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
    $this->post('/api/v1/users/signup', [
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

  /**
   * Test should throw an error if email already exist
   *
   * @return void
   */
  public function testShouldThrowAnErrorIfEmailIsTaken()
  {
    $user = factory(User::class)->create([
      'firstname' => 'Tobi',
      'lastname' => 'Mayowa',
      'email' => 'adebola.akinlabi@gmail.com',
      'password' => '1234'
    ]);

    $this->post('/api/v1/users/signup', [
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

  /**
   * Test should succuessfully autheticate a user
   *
   * @return void
   */
  // public function testShouldAuntheticateAUser()
  // {
  //   $user = factory(User::class)->create([
  //     'firstname' => 'Taiwo',
  //     'lastname' => 'Ajayi',
  //     'email' => 'taiwo.ajayi@gmail.com',
  //     'password' => '1234'
  //   ]);

  //   $this->post('/api/v1/users/login', [
  //     'email' => 'taiwo.ajayi@gmail.com',
  //     'password' => '1234'
  //   ]);

  //   $this
  //     ->seeStatusCode(200)
  //     ->seeJson([
  //       'message' => ['Login Successful']
  //     ]);
  // }
}