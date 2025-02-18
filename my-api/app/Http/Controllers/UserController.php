<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


/**
 * @OA\Info(
 *     title="My API Test",
 *     version="1.0.0",
 *     description="This is a simple API documentation for user management",
 *     @OA\Contact(
 *         email="edwardtua25@gmail.com"
 *     )
 * )
 */

class UserController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/users",
     *   summary="Get all users",
     *   description="To get all data users",
     *   tags={"User"},
     *   @OA\Response(
     *     response=200,
     *     description="Successfully retrieved list of users",
     *     @OA\Schema(
     *       type="array",
     *       @OA\Items(ref="#/definitions/User")
     *     )
     *   )
     * )
     */

    public function getUserAll(){

        return response()->json(User::all());

    }

     /**
     * @OA\Get(
     *   path="/api/users/{id}",
     *   summary="Get user by ID",
     *   description="Get data user by ID",
     *   tags={"User"},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="ID of the user",
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Successfully retrieved user",
     *     @OA\Schema(ref="#/components/schemas/User")
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="User not found"
     *   )
     * )
     */

    public function getUserById($id){
        try {
            $user = User::findOrFail($id);

            return response()->json($user);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return response()->json(['message' => 'User not found'], 404);

        }

    }

    /**
     * @OA\Post(
     *   path="/api/users",
     *   summary="Add a new user",
     *   description="For create new user",
     *   tags={"User"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         type="object",
     *         @OA\Property(property="name", type="string"),
     *         @OA\Property(property="email", type="string"),
     *         @OA\Property(property="age", type="integer")
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Successfully created user",
     *     @OA\Schema(ref="#/definitions/User")
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="Invalid input"
     *   )
     * )
     */



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

  /**
     * @OA\Put(
     *   path="/api/users/{id}",
     *   summary="Update user by ID",
     *   description="Update data user by ID, where ID exits",
     *   tags={"User"},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="ID of the user",
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         type="object",
     *         @OA\Property(property="name", type="string"),
     *         @OA\Property(property="email", type="string"),
     *         @OA\Property(property="age", type="integer")
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Successfully updated user",
     *     @OA\Schema(ref="#/definitions/User")
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="User not found"
     *   )
     * )
     */


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

    /**
     * @OA\Delete(
     *   path="/api/users/{id}",
     *   summary="Delete user by ID",
     *   description="Delete user by ID",
     *   tags={"User"},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="ID of the user",
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Successfully deleted user"
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="User not found"
     *   )
     * )
     */

    public function deleteUser($id){
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(['message' => 'User deleted!'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return response()->json(['message' => 'User not found'], 404);

        }
    }
}
