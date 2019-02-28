<?php

namespace App\Http\Controllers;


use App\Favorite;
use Illuminate\Http\Request;
use JWTAuth;

class DataController extends Controller
{
    private $currentUser;
    public function __construct()
    {
        $this->currentUser = JWTAuth::parseToken()->authenticate();
    }

    public function show()
    {
        $favorites = $this->currentUser->favorites()->get();
        return compact('favorites');
    }

    public function store($id)
    {
        $favorite = new Favorite();
        $favorite->recipeID = $id;
    
        if ($this->currentUser->favorites()->save($favorite)) {
            return response()->json(['success' => true]);
        }

        else {
            return response()->json(['error' => 'could_not_create_favorite'], 500);
        }
    }

    public function check($id)
    {
        $favorite = $this->currentUser->favorites()->where('recipeID', $id);
    
        if (!$favorite->count()) {
            return response()->json(['favorited' => false]);
        } else if ($favorite->count()) {
            return response()->json(['favorited' => true]);
        } else {
            return response()->json(['message' => 'could_not_check_favorite'], 500);
        }
    }

    public function delete($id)
    {
        $favorite = $this->currentUser->favorites()->where('recipeID', $id);
    
        if ($favorite->delete()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['message' => 'could_not_delete_favorite'], 500);
        }
    }

}
