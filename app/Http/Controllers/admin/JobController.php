<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Job;
use App\Models\JobType;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;




class JobController extends Controller
{
    //
    public function index(){
        
    $jobs=Job::orderBy("created_at","desc")->with('user', 'applications')->paginate(6);

        return view("admin.job.list",[
            "jobs"=> $jobs
        ]);
    }

    public function edit($id){

        $job=Job::findOrFail($id);

        $categories=Category::orderBy("name", "ASC")->get();
        $jobTypes=JobType::orderBy("name","ASC")->get();

        return view("admin.job.edit",[
            "job"=> $job,
            "categories"=> $categories,
            "jobTypes"=> $jobTypes
        ]);

    }

    public function update(Request $request, $id){
       
        $rules = [

            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'jobType' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required',
            'company_name' => 'required|min:3|max:75',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->passes()) {
            $job = Job::find($id);
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->website;
            $job->status = $request->status;
            $job->isFeatured = (!empty($request->isFeatured)) ? $request->isFeatured : 0;
            $job->save();
            session()->flash('success', 'Job updated successfully.');


            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } 
        else {
            return response()->json([
                'status' => false,
                'errors' => $validation->errors()
            ]);
        }
    }

    public function deleteAdminJob(Request $request)
    {

        $job = Job::where([
            'id' => $request->id
        ])->first();

        if ($job == null) {
            session()->flash('error', 'Either job deleted or not found.');
            return response()->json([
                'status' => false,
            ]);
        }

        Job::where('id', $request->id)->delete();

        session()->flash('success', 'Job deleted successfully.');
        return response()->json([
            'status' => true
        ]);

    }


}