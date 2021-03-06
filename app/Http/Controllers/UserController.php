<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Faker\Factory as Faker;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $user = $request->user();

        return $user;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $faker = Faker::create();

        // $request->email =
        // $request->username = $faker->unique()->userName;
        // $request->password = 'changeme';

        // $validator = Validator::make($request->all(), [
        //     'username' => 'required|string',
        //     'email' => 'required|email|max:64',
        //     'password' => 'required|string|min:8',
        // ]);

        // if ($validator->fails()) {
        //     return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        // }

        $input = $request->all();

        $input['password'] = Hash::make('changeme');
        $input['username'] = $faker->unique()->userName;
        $input['email'] = $faker->unique()->safeEmail;

        // Creating new user
        $user = User::create($input);

        /**Take note of this: Your user authentication access token is generated here **/
        $data['token'] =  $user->createToken('algoKnows')->accessToken;
        $data['user_data'] = $user;


        return response(['data' => $data, 'message' => 'Account created successfully!', 'status' => true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
    public function logout(Request $request)
    {
        if (Auth::check()) {
            $request->token()->revoke();
            return response()->json(['success' => 'logout_success'], 200);
        } else {
            return response()->json(['error' => 'api.something_went_wrong'], 500);
        }
    }

    public function login(Request $request)
    {
        // Log::debug("login");
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();
            $user = User::findOrFail($authUser->id);

            /**Take note of this: Your user authentication access token is generated here **/
            $data['token'] =  $user->createToken('algoKnows')->accessToken;
            // $data['user_data'] = $user;

            return response(['data' => $data, 'message' => 'Account Logged In successfully!', 'status' => true]);
        }
    }
}
