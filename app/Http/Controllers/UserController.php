<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use App\Mail\SendMailVerifications;
use Illuminate\Support\Facades\Mail;
use App\verify_user;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        $users=User::get();
        $response=response()->json(['data'=>$users]);
        return view('home')->with('response',$response);
    }
    public function store(Request $request){

        $user=User::create([
            'name'  =>$request->get('name'),
            'email' =>$request->get('email'),
            'password'=>$request->get('password'),
        ]);
        verify_user::create([
            'user_id'=>$user->id,
            'token'  =>sha1(time())
        ]);

        Mail::to($user->email)->send(new SendMailVerifications($user));
        //dd($user);
        return response()->json(['success'=>$user],201);
    }
    public function verify($token){
        $verify_user=verify_user::where('token',$token)->first();
        $status="";
        if(!empty($verify_user)){
            $user=$verify_user->user;

            if(!isset($user->email_verified_at)){
                $verified_user=User::where('id',$user->id)->first();

                $verified_user->email_verified_at=Carbon::now();
                $verified_user->save();
                $status.="Email verified successfully";
            }else{
                $status.="Email already verified";
            }
        }else


        {
            return redirect('home')->with('warning', "Sorry your email cannot be identified.");
        }

        return view ('home')->with('status', $status);
    }
}

