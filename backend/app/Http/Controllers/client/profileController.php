<?php
namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class profileController extends Controller{

 public function __construct()
 {
     $this->middleware('auth');
     
 }

 public function index(){
    $user = Auth::user();
    return response()->json(['status'=>'success','user'=>$user]);
 }

 public function update(Request $request){

    $validator = Validator::make($request->only('name','email','password','password_confirmation'),[
        'name' => 'required|string',
        'email' => 'required|email|unique:users,id',
        'password' => 'required|min:10|confirmed'
    ]);

    $user = Auth::user();

    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $plainPassword = $request->input('password');
    $user->password = app('hash')->make($plainPassword);
    $user->save();

    return response()->json(['status'=>'success','message'=>'Profile successfully changed']);
 }

}