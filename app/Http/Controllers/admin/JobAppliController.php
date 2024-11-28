<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jobapplication;


class JobAppliController extends Controller
{
    //
    public function index(){

        $applications = JobApplication::orderBy("created_at","desc")
        ->with("user", "job","employer")
        ->paginate(5);

        return view("admin.jobapplication.list",[
            "applications"=> $applications
        ]);
    }

    public function delete(Request $request){
        $id= $request->id;
        $jobapplication = Jobapplication::find($id);

        if($jobapplication == null){
            session()->flash('error', 'Either job deleted or not found.');
            return response()->json([
                'status' => false,
            ]);
        }
        $jobapplication->delete();
        session()->flash('success', 'Job application deleted successfully.');
        return response()->json([
            'status' => true,
        ]);
        
    }
}
