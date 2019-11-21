<?php
namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller {
	public function storeUser(Request $request) {
		$validatedData = $request->validate([
            'first_name' => 'required',
            'surname' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',

          ]);

          $user = User::create([
            'first_name' => $validatedData['first_name'],
            'surname' => $validatedData['surname'],
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
    $user->surname      = $request->get('surname');
    $user->email        = $request->get('email');
    $user->username     = $request->get('username');
		$user->password     = $request->get('password');
		$user->save();
		return $user;
	}
}