<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe;

class RecipeController extends Controller 
{
  /**
   * Create a new Recipe
   * 
   * @param Request $request request
   * 
   * @return \Illuminate\Http\JsonResponse
   */
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

  /**
   * Edit a recipe
   * 
   * @param 
   */
  public function update(Request $request, $recipeId)
  {
    $recipe = Recipe::findOrFail($recipeId);

    $recipe->fill($request->all());
    $recipe->save();

    return $recipe;
  }
}