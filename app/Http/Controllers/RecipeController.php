<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe;
use Auth;

class RecipeController extends Controller 
{
   /**
   * Get all Recipes
   * 
   * @return \Illuminate\Http\JsonResponse
   */
  public function getAllRecipes() 
  {
    $recipes = Recipe::all();

    return response()->json(
      $recipes, 200
    );
  }

  /**
   * Get a Recipe
   * 
   * @return \Illuminate\Http\JsonResponse
   */
  public function getARecipe($recipeId) 
  {
    $recipe = Recipe::findOrFail($recipeId);

    return response()->json(
      $recipe, 200
    );
  }

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
      'description' => $request->description,
      'user_id' => Auth::user()->id
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
   * @param $request
   * @param $recipeId
   * 
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(Request $request, $recipeId)
  {
    $recipe = Recipe::find($recipeId)
                ->where('user_id', Auth::user()->id)
                ->get();

    $recipe->fill($request->all());
    $recipe->save();

    return response()->json([$recipe], 200);
  }

  /**
   * Delete a recipe
   * 
   * @param $recipeId
   * 
   * @return \Illuminate\Http\JsonResponse
   */
  public function delete($recipeId)
  {
    $recipe = Recipe::find($recipeId)
                ->where('user_id', Auth::user()->id)
                ->get();

    $recipe->delete();

    return response()->json([
      'message' => 'Recipe deleted successfully'
    ], 204);
  }
}