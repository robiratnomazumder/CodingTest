<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if($request->search){
            $data['lists'] = User::where('user_id', 'like', "%{$request->search}%" )
                ->orWhere('name', 'like', "%{$request->search}%" )
                ->get();
        }
        else{
            $data['lists'] = User::get();
        }
        return view('pages.user', $data);
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return back()->with('success', 'Deleted Successfully.');
    }
}
