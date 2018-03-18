<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe;

class RecipeController extends Controller 
{
  public function store(Request $request) 
  {
    $this->validate($request, [
      'name' => 'required',
      'description' => 'required'
    ]);

    $data = [
      'name' => $request->name,
      'description' => $request->description
    ];

    $recipe = Recipe::create($data);

    $statusCode = $recipe ? 200 : 422;

    return response()->json([
      'data' => $recipe,
      'created' => true,
    ], $statusCode);
  }
}