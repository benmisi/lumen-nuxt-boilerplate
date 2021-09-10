<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\sendMailRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\JWTAuth;

class RegisterController extends Controller{
    protected $jwt;
    private  $emailRepository;
    public function __construct(JWTAuth $jwt,sendMailRepository $emailRepository)
    {
        $this->jwt = $jwt;
        $this->emailRepository = $emailRepository;
    }


    public function Register(Request $request){
        $validator = Validator::make($request->only('name','email','password','password_confirmation'),[
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:10|confirmed'
        ]);
        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' =>'Sorry failed to create account email already taken'], 500);
        }

        try {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);
            $token  = Str::uuid();
            $user->access_token = $token;
            $user->save();
            $this->emailRepository->sendActivationMail($user,$request->input('name'),$token);
            return response()->json(['status'=>'success','message'=>'User successfull registered Please check your email to activate account'],201);
        } catch (\Throwable $th) {
           return response()->json(['status'=>'error','message'=>$th->getMessage()],409);
        }
    }

   public function activate($token){
       $user = User::whereaccess_token($token)->first();
       if(!is_null($user)){
           $user->is_activated=1;
           $user->save();
        return response()->json(['status'=>'success','message'=>'Account successfully activated. Pleae proceed to login'],201);
 
       }else{
        return response()->json(['status'=>'error','message'=>'Account activation failed'],409); 
       }
   }

   public function forgot(Request $request){
    $validator = Validator::make($request->only('email'),[
       
        'email' => 'required|email'
    ]);
    if($validator->fails()) {
        return response()->json(['status' => 'error', 'message' =>'Sorry a valid email is required'], 500);
    }

    $user = User::whereemail($request->email)->first();

    if(!is_null($user)){
    $uuid = Str::uuid();
    $user->access_token = $uuid;
    $user->save();
    $this->emailRepository->sendPasswordResetMail($user,$uuid);
    return response()->json(['status'=>'success','message'=>'Password reset link has been send to your email'],201);
 
    }else{
        return response()->json(['status' => 'error', 'message' =>'Email not found please create account'], 500);
 
    }
   }

   public function reset_password(Request $request){
    $validator = Validator::make($request->only('password','password_confirmation'),[
         'password' => 'required|min:4|confirmed'
    ]);
    if($validator->fails()) {
        return response()->json(['status' => 'error', 'message' =>'Sorry failed to reset your password'], 500);
  
    }
    $user = User::whereaccess_token($request->token)->first();
    $plainPassword = $request->input('password');
    $user->password = app('hash')->make($plainPassword);
    $user->save();
    return response()->json(['status'=>'success','message'=>'Password successfully reset. Proceed to login'],201);

   }
}