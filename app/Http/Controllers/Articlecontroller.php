<?php

namespace App\Http\Controllers;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Auth;
use  App\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Articlecontroller extends Controller
{
     /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
/*  mes functions   */



public function index()
{
$products =  DB::select("select * from articles  ");
return response()->json($products);
 }
public function create(Request $request)
{
$product = new Article;
$product->nom= $request->nom;
$product->numero = $request->numero;
DB::table('articles')->insert(
['nom' => $product->nom, 
'numero' =>$product->numero
]);
return response()->json($product);
}
public function show($id)
{
$product = DB::select("select * from articles  where  id = '$id' ");

if($product == NULL){
$text = " cette article n'existe pas ";
return    $text ; 
}else { 
return response()->json($product);
}
}
public function update(Request $request, $id)
{ 
$nom = $request->input('nom');
$numero = $request->input('numero');
$u = DB::update('update articles set nom = ? , numero = ?  where id = ?', [ $nom , $numero , $id]);
//$u = $product->save();
if($u == NULL){
$text = " erreur dans la modification ";
return $text ;
}else{
$product = DB::select("select * from articles  where  id = '$id' ");
return response()->json($product);
}                                      
}

public function destroy($id)
{
$a =  $product = Article::find($id);
$product->delete();
if($a == NULL){
$text = "  l'article  que vous voulez supprimer n'existe pas  ";
return $text ;
} else{
return response()->json(" l'article  a bien ete suprimer");

}
}

    /**
     * Get the authenticated User.
     *
     * @return Response
     */
    public function profile()
    {
        return response()->json(['user' => Auth::user()], 201);
    }

    /**
     * Get all User.
     *
     * @return Response
     */
    public function allUsers()
    {
         return response()->json(['users' =>  User::all()], 200);
    }

    /**
     * Get one user.
     *
     * @return Response
     */
    public function singleUser($id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json(['user' => $user], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'user not found!'], 404);
        }

    }

}
