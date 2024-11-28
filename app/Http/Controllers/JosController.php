<?php

namespace App\Http\Controllers;

use App\Mail\JobNotificationEmail;
use App\Models\Category;
use App\Models\Job;
use App\Models\Jobapplication;
use App\Models\JobType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\SaveJob;




class JosController extends Controller
{
    //
    public function index(Request $request)
    {

        $categories = Category::where("status", 1)->get();
        $jobType = JobType::where("status", 1)->get();

        $jobs = Job::where("status", 1);

        //tim kiem bang keywords
        if (!empty($request->keywords)) {
            $jobs = $jobs->where(function ($query) use ($request) {
                $query->orWhere('title', 'like', '%' . $request->keywords . '%');
                $query->orWhere('keywords', 'like', '%' . $request->keywords . '%');

            });
        }

        //tim kiem bang location
        if (!empty($request->location)) {
            $jobs = $jobs->where('location', $request->location);
        }

        //tim kiem bang category
        if (!empty($request->category)) {
            $jobs = $jobs->where('category_id', $request->category);
        }

        //tim kiem bang jobtype
        $jobTypeArray = [];
        if (!empty($request->jobType)) {
            $jobTypeArray = explode(',', $request->jobType);

            $jobs = $jobs->whereIn('job_type_id', $jobTypeArray);
        }

        //tim kiem bang experience
        if (!empty($request->experience)) {
            $jobs = $jobs->where('experience', $request->experience);

        }

        $jobs = $jobs->with('jobType');


        if ($request->sort == '0') {
            $jobs = $jobs->orderBy('created_at', 'ASC');
        } else {
            $jobs = $jobs->orderBy('created_at', 'DESC');
        }
        $jobs = $jobs->paginate(9);

        return view("front.jobs", [
            "categories" => $categories,
            "jobType" => $jobType,
            "jobs" => $jobs,
            'jobTypeArray' => $jobTypeArray
        ]);
    }

    public function detail($id)
    {

        $job = Job::where([
            'id' => $id,
            'status' => 1
        ])->with(['jobType', 'category', 'user1'])->first();

        if ($job == null) {
            abort(404);
        }

        $count=0;
        if(Auth::user()){
        $count=SaveJob::where([
            'user_id'=>Auth::user()->id,
            'job_id'=>$id
        ])->count();
        }

        $applications=Jobapplication::where('job_id', $id)->with('user')->get();     

        return view("front.jobDetail", [
            "job" => $job,
             "count" => $count,
             "applications" => $applications
        ]);
        
        
    }

    public function applyJob(Request $request){

             $id =$request->id;
             $job=Job::where('id',$id)->first();

             if ($job == null) {
                $message='Job doest not exist';
                session()->flash('error', $message);
                return response()->json([
                     'status'=> false,
                    'message'=> $message,
                    ]);
             }
             
             $employer_id=$job->user_id;
             if($employer_id==Auth::user()->id){
                $message='You can not apply for your own job';
                session()->flash('error', $message);
                return response()->json([
                     'status'=> false,
                    'message'=> $message,
                    ]);
             }

             $applicationCount=Jobapplication::where([
                 'user_id'=>Auth::user()->id,
                 'job_id'=>$id
             ])->count();

             if($applicationCount > 0){
                 $message= 'You have already applied for this job.';
                 session()->flash('error', $message);
                 return response()->json([  
                    'status'=> false,
                    'message'=> $message
                    ]);
             }

             $application= new Jobapplication();
             $application->job_id=$id;
             $application->user_id=Auth::user()->id;
             $application->employer_id=$employer_id;
             $application->application_date=now();
             $application->save();

             $employer = User::where('id', $employer_id)->first();
             $mailData = [
                 'employer' => $employer,
                 'user' => Auth::user(),
                 'job' => $job,
             ];

              Mail::to($employer->email)->send(new JobNotificationEmail($mailData));


             $message='you have successfully applied for this job.';
             session()->flash('success',$message);

             return response()->json([
                 'status'=> true,
                 'message'=> $message
             ]);
    }

    public function saveJob(Request $request){
         $id= $request->id;
         $job = Job::find($id);
         if($job==null){
            session()->flash('error','Job not found.');
             return response()->json([
                 'status'=> false
             ]);
         }

         $count=SaveJob::where([
             'user_id'=>Auth::user()->id,
             'job_id'=>$id
         ])->count();

        if( $count> 0){
            session()->flash('error','You already saved this job.');
             return response()->json([
                 'status'=> false
             ]);
        }

        $saveJob= new SaveJob();
        $saveJob->job_id=$id;
        $saveJob->user_id=Auth::user()->id;
        $saveJob->save();

        session()->flash('success','Job saved successfully.');
        return response()->json([
            'status'=> true,
            'message'=> 'Job saved successfully.'
        ]);

    }

}
