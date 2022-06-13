<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        if($request->search){
            $data['lists'] = Agent::where('user_id', 'like', "%{$request->search}%" )
                ->orWhere('name', 'like', "%{$request->search}%" )
                ->get();
        }
        else{
            $data['lists'] = Agent::get();
        }
        return view('pages.agent', $data);
    }

    public function destroy($id)
    {
        Agent::find($id)->delete();
        return back()->with('success', 'Deleted Successfully.');
    }
}
