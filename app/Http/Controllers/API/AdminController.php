<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\admen;

use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use App\Models\User;
use App\Traits\HttpResponses;


use Laravel\Sanctum\HasApiTokens;

class AdminController extends Controller
{

    use HttpResponses;
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admens',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $user = admen::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
         ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    public function login(Request $request)
    {
         $validator = Validator::make($request->all(),[
        'email' => 'required|string|email|max:255',
        'password' => 'required|string|min:8'
    ]);

    if($validator->fails()){
        return response()->json($validator->errors());
    }

     $admen = admen::where('email', $request->email)->first();
     if (!$admen  || !Hash::check($request->password,$admen->password))

        {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = admen::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['message' => 'Hi '.$user->name.', welcome to home','access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    // method for user logout and delete token
    public function logout()
    {
        // auth()->user()->tokens()->delete();
        Auth::guard('admin-api')->user()->tokens()->delete();


        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }


    public function test(){

       return response()->json('asss hole');

    }

    public function profile()
    {

        $admenuser=Auth::user();

        return response()->json($admenuser);
        $this->success([
            'user' => $admenuser,

        ]);

    }
}

