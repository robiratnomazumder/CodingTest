<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if($request->search){
            if($request->type == 'admin'){
                $data['lists'] = Admin::where('user_id', 'like', "%{$request->search}%" )
                    ->orWhere('name', 'like', "%{$request->search}%" )
                    ->get();
            }
            elseif ($request->type == 'agent'){
                $data['lists'] = Agent::where('user_id', 'like', "%{$request->search}%" )
                    ->orWhere('name', 'like', "%{$request->search}%" )
                    ->get();
            }
            elseif($request->type == 'user'){
                $data['lists'] = User::where('user_id', 'like', "%{$request->search}%" )
                    ->orWhere('name', 'like', "%{$request->search}%" )
                    ->get();
            }
            $data['type_temp'] = $request->type;
        }
        elseif ($request->type){
            if($request->type == 'admin'){
                $data['lists'] = Admin::get();
                $data['type_temp'] = 'admin';
            }
            elseif ($request->type == 'agent'){
                $data['lists'] = Agent::get();
                $data['type_temp'] = 'agent';
            }
            elseif($request->type == 'user'){
                $data['lists'] = User::get();
                $data['type_temp'] = 'user';
            }
        }
        elseif($request->store){
            $data['type_temp'] = 'admin';
            $data['lists'] = Admin::get();

            $data['jsonData'] = Admin::where('user_id', 'like', "%{$request->store}%" )
                ->orWhere('name', 'like', "%{$request->store}%" )
                ->first(['id','user_id','name']);
            if(!$data['jsonData']) return redirect()->route('admin.list');

            $storage = [
                'user_id' => $data['jsonData']->user_id,
                'name'  => $data['jsonData']->name
            ];
            Session::push('storeTableValue.key', $storage);
            $data['jsonLists'] = Session::get('storeTableValue.key');
            return redirect()->route('admin.list');
        }
        else{
            $data['lists'] = Admin::get();
            $data['type_temp'] = 'admin';
        }
        $data['jsonLists'] = Session::get('storeTableValue.key');
        return view('pages.admin', $data);
    }

    public function destroy($id)
    {
        Admin::find($id)->delete();
        return back()->with('success', 'Deleted Successfully.');
    }
}
