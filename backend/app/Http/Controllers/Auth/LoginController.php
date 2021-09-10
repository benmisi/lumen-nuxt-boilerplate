<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\JWTAuth;

class LoginController extends Controller{
    protected $jwt;
    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function Login(Request $request){
        $this->validate($request, [
            'password' => 'required',
            'email' => 'required|email'
        ]);
     
        try {
             $token = $this->jwt->attempt($request->only('email','password'));
             if(!$token){
                 return response()->json(['status'=>'error','message'=>'Invalid login Details , User not found'],404);
             }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['status' =>'error', 'message' => 'token expired'], 500);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['staus' =>'error', 'message' => 'token invalid'], 500);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['status' =>'error', 'message' => 'unknown error'], 500);
        }
      

        $user = Auth::user();
        $user_info = array("name"=>$user->name,"email"=>$user->email);
        if($user){
            return response()->json([
                'status'=>'success',
                'token'=>$token,
                'user'=>$user_info
            ]);
        }
    }

    public function userDetails(){
        $user = Auth::user();
        $user_info = array("name"=>$user->name,"email"=>$user->email);
        return response()->json(['status'=>'success','user'=>$user_info]);
    }

  public function logout(){
      $token = auth()->tokenById(Auth::user()->id);
      $this->jwt->setToken($token)->invalidate();
      \auth()->logout();
      return response()->json([
        'success' => 'success',
        'message' => 'Signed out successfully!'
    ]);
  }

 public function checkLogin(){
     if(Auth::user()){
         return response()->json(['status'=>'success']);
     }else{
         return response()->json(['status'=>'error']);
     }
 }
}
