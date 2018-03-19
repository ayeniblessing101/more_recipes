<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'description', 'user_id'
  ];

  /**
     * Get the user for a recipe
     */
    public function user() 
    {
        return $this-belongsTo('App\User');
    }

    protected $hidden = ['updated_at', 'created_at'];
}