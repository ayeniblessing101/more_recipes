<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Hashing\BcryptHasher;
use Tymon\JWTAuth\JWTAuth;

class UserController extends Controller
{
  /**
   * @var \Tymon\JWTAuth\JWTAuth
   */
  protected $jwt;

  public function __construct(JWTAuth $jwt)
  {
    $this->jwt = $jwt;
  }

  /**
   * Create a new User
   *
   * @param Request $request request
   *
   * @request \Illuminate\Http\JsonResponse
   */
  public function store(Request $request)
  {
    $this->validate($request,[
      'firstname' => 'required',
      'lastname' => 'required',
      'email' => 'required|unique:users|email',
      'password' => 'required',
    ]);

    $user = new User();
    // dd($user);
    $user->firstname = $request->firstname;
    $user->lastname = $request->lastname;
    $user->email = $request->email;
    $user->password = (new BcryptHasher)->make($request->password);

    $user->save();

    $statusCode = $user ? 201 : 422;
    // dd($user);
    $token = $this->jwt->attempt($request->only('email', 'password'));
    // dd($token);
    return response()
      ->json([
        'data' => $user,
        'status' => $user ? "success" : "error",
        'token' => $token,
    ], $statusCode);
  }
}
