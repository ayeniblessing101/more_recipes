<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Hashing\BcryptHasher;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\JWTAuth;
use \Tymon\JWTAuth\Exceptions\TokenExpiredException;
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
   
    $user->firstname = $request->firstname;
    $user->lastname = $request->lastname;
    $user->email = $request->email;
    $user->password = (new BcryptHasher)->make($request->password);
    $user->save();
    $statusCode = $user ? 201 : 422;
   
    $token = $this->jwt->attempt($request->only('email', 'password'));
   
    return response()
      ->json([
        'data' => $user,
        'status' => $user ? "success" : "error",
        'token' => $token,
    ], $statusCode);
  }
  /**
   * Authenticates a user
   *
   * @param Request $request request
   *
   * @request \Illuminate\Http\JsonResponse
   */
  public function login(Request $request)
  {
    $this->validate($request, [
      'email' => 'required|email|max:255',
      'password' => 'required'
    ]);
    try {
      if(!$token = $this->jwt->attempt($request->only(['email', 'password'])))
      {
        return response()->json(['message' => 'User not found'], 404);
      }
    }
    catch(TokenExpiredException $e)
    {
      return response()->json(['message' => 'Token Expired'], 500);
    }
    catch (TokenInvalidException $e)
    {
      return response()->json(['message' => 'Invalid credentials'], 500);
    }
    catch (JWTException $e)
    {
      return response()->json(['message' => $e->getMessage()],500);
    }
    return response()->json([
        'message' => 'Login Successful',
        'token' => $token],
      200);
  }
}
