<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Data;
class MainController extends Controller {
	public function storeUser(Request $request) {
		$validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',

          ]);

          $user = User::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
          ]);

          return $user;
    }
    
	public function readUsers() {
		$users = User::all();
        return $users;
    }
    
	public function deleteUser(Request $request) {
		$user = User::find ( $request->id )->delete();
    }
    
	public function editUser(Request $request, $id){
		$user               = User::where('id', $id)->first();
		$user->first_name   = $request->get('first_name');
		$user->last_name    = $request->get('last_name');
        $user->username     = $request->get('username');
        $user->email        = $request->get('email');
		$user->password     = $request->get('password');
		$user->save();
		return $user;
	}
}