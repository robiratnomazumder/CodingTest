<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\UserVerify;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(){
        return view('pages.login');
    }

    public function authenticate(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email', 'password' => 'required', 'type' => 'required'
        ]);
        if($validate->fails()){
            foreach ($validate->messages()->getMessages() as $field_name => $messages) {
                return back()->with('error', $messages[0]); }
        }
        if($request->type == 'admin'){
            $credentials = $request->only('email', 'password');
            if (Auth::guard('admin')->attempt($credentials)) {
                Session::put('adminSessionData',$request->type);
                Session::put('GlobalSession',$request->type);
                return redirect()->route('admin.list')->with('success','Logged in successfully!');
            }
        }
        elseif ($request->type == 'agent'){
            $credentials = $request->only('email', 'password');
            if (Auth::guard('agent')->attempt($credentials)) {
                Session::put('agentSessionData',$request->type);
                Session::put('GlobalSession',$request->type);
                return redirect()->route('agent.list')->with('success','Logged in successfully!');
            }
        }
        elseif ($request->type == 'user'){
            $credentials = $request->only('email', 'password');
            if (Auth::guard('user')->attempt($credentials)) {
                Session::put('userSessionData',$request->type);
                Session::put('GlobalSession',$request->type);
                return redirect()->route('user.list')->with('success','Logged in successfully!');
            }
        }
        return back()->with('error', 'Wrong email/password!');
    }

    public function logout(Request $request){
        Session::forget($request->type.'SessionData');
        Session::flush();
        Auth::guard($request->type)->logout();
        return redirect('/login')->with('success', 'Logged out successfully');
    }

    public function register(){
        return view('pages.register');
    }

    public function store(Request $request){
        if($request->type == 'admin') $checkUser = 'required|email|unique:admins|max:50';
        if($request->type == 'agent') $checkUser = 'required|email|unique:agents|max:50';
        if($request->type == 'user') $checkUser = 'required|email|unique:users|max:50';

        $validate = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'type' => 'required',
            'email' => $checkUser,
            'password' => 'required|min:3|max:20',
            'confirm_password' => 'required|min:3|max:20|same:password' ]
        );
        if($validate->fails()){
            foreach ($validate->messages()->getMessages() as $field_name => $messages) {
                return back()->with('error', $messages[0])->withInput(); }
        }

        DB::beginTransaction();
        try {
            if ($request->type == 'admin') {
                $insert = new Admin();
                $checkid = Admin::latest()->first(['id']);
                if ($checkid) $user_id = "ADMIN-" . ($checkid->id + 1000);
                else $user_id = 'ADMIN-' . (1000);
                $insert->user_id = $user_id;
                $message = "Admin";
            } elseif ($request->type == 'agent') {
                $insert = new Agent();
                $checkid = Agent::latest()->first(['id']);
                if ($checkid) $user_id = "AGENT-" . ($checkid->id + 1000);
                else $user_id = 'AGENT-' . (1000);
                $insert->user_id = $user_id;
                $message = "Agent";
            } else {
                $insert = new User();
                $checkid = User::latest()->first(['id']);
                if ($checkid) $user_id = "USER-" . ($checkid->id + 1000);
                else $user_id = 'USER-' . (1000);
                $insert->user_id = $user_id;
                $message = "User";
            }
            $insert->name = $request->name;
            $insert->email = $request->email;
            $insert->password = Hash::make($request->password);
            $insert->save();

            $token = Str::random(64);
            UserVerify::create([
                'user_id' => $insert->id,
                'type' => $request->type,
                'token' => $token,
            ]);
            Mail::send('email.emailVerification', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->from(env('MAIL_USERNAME'),'Mail');
                $message->subject('Email Verification Mail');
            });
            DB::commit();
            return back()->with('success', 'New ' . $message . ' added successfully.');
        }
        catch(\Exception $e){
            dd($e);
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();
        if(!is_null($verifyUser) ){
            if($verifyUser->type == 'admin'){
                $verifyUser->admin->email_verified_at = now();
                $verifyUser->admin->save();
            }
            elseif ($verifyUser->type == 'agent') {
                $verifyUser->agent->email_verified_at = now();
                $verifyUser->agent->save();
            }
            elseif ($verifyUser->type == 'user') {
                $verifyUser->user->email_verified_at = now();
                $verifyUser->user->save();
            }
            $message = "Your e-mail is verified. You can now login.";
        }
        else {
            $message = 'Sorry, your email is not verified.';
        }
        return redirect()->route('login')->with('error', $message);
    }
}
