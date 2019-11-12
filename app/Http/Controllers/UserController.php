<?php

namespace App\Http\Controllers;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Auth;
use  App\User;
class UserController extends Controller
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
$products =  DB::select("select * from users  ");
return response()->json($products);
 }
public function create(Request $request)
{
$product = new User;
$product->name= $request->name;
$product->email = $request->email;
$product->password= $request->password;
DB::table('users')->insert(
['name' => $product->name, 
'email' =>$product->email,
'password' =>$product->password
]);
return response()->json($product);
}
public function show($id)
{
$product = DB::select("select * from users  where  id = '$id' ");

if($product == NULL){
$text = " cette utilisateur n'existe pas ";
return    $text ; 
}else { 
return response()->json($product);
}
}
public function update(Request $request, $id)
{ 
$name = $request->input('name');
$email = $request->input('email');
$password = $request->input('password');
$u = DB::update('update users set name = ? , email = ? , password = ? where id = ?', [ $name , $email,  $password , $id]);
//$u = $product->save();
if($u == NULL){
$text = " erreur dans la modification ";
return $text ;
}else{
$product = DB::select("select * from users  where  id = '$id' ");
return response()->json($product);
}                                      
}

public function destroy($id)
{
$a =  $product = User::find($id);
$product->delete();
if($a == NULL){
$text = "  l'utilisateur  que vous voulez supprimer n'existe pas  ";
return $text ;
} else{
return response()->json(" l'utilisateur  a bien ete suprimer");

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
