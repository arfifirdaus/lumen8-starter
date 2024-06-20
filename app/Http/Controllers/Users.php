<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Users extends Controller
{
  public function register(Request $request)
  {
      $this->validate($request, [
        'email' => 'required|unique:users|email',
        'username' => 'required|unique:users',
        'password' => 'required|min:6',
        'name'=> 'required|string'
      ]);

      $username = $request->input('username');
      $email = $request->input('email');
      $password = Hash::make($request->input('password'));
      $name = $request->input('name');

      $user = User::create([
        'name' => $name,
          'email' => $email,
          'username'=>$username,
          'password'=>$password
      ]);

      return response()->json(['message' => 'Data added successfully'], 201);
  }

  public function login(Request $request)
  {
      $this->validate($request, [
          'username' => 'required|string',
          'password' => 'required|min:6'
      ]);

      $username = $request->input('username');
      $password = $request->input('password');

      $user = User::where('username', $username)->first();
      if (!$user) {
          return response()->json(['message' => 'Login failed'], 401);
      }

      $isValidPassword = Hash::check($password, $user->password);
      if (!$isValidPassword) {
        return response()->json(['message' => 'Login failed'], 401);
      }

      $generateToken = bin2hex(random_bytes(40));
      $user->update([
          'api_token' => $generateToken
      ]);

      return response()->json($user);
  }
} 