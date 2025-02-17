<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserAll(){

        return response()->json(User::all());

    }

    public function getUserById($id){

        $user = User::findOrFail($id);
        return response()->json($user);

    }

    public function addUser(Request $request){
        $this->validate($request,[
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'age'   => 'required|integer|min:1',
        ]);

        $user = User::create([
            'name'  =>$request->name,
            'email' =>$request->email,
            'age'   =>$request->age
        ]);

        return response()->json($user->refresh(), 201);
    }

    public function updateById(Request $request, $id){
        $user = User::findOrFail($id);

        $this->validate($request,[
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'age'   => 'required|integer|min:1',
        ]);

        $user->update($request->only(['name', 'email', 'age']));

        return response()->json($user, 200);
    }

    public function deleteUser($id){
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted!']);
    }
}
