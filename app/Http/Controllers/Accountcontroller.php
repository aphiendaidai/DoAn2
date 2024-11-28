<?php

namespace App\Http\Controllers;
use App\Mail\ResetPasswordEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Category;
use App\Models\JobType;
use App\Models\Job;
use App\Models\Jobapplication;
use App\Models\SaveJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class Accountcontroller extends Controller
{
    //
    public function registration()
    {
        return view('front.account.registration');
    }

    public function processRegistration(Request $request)
    {
        $validation = Validator::make($request->all(), ([
            'name' => 'required',
            'email' => 'required | email',
            'password' => 'required | min:6 | same:confirm_password',
            'confirm_password' => 'required',
            'role' => 'required|in:user,company'
        ]));

        if ($validation->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;  // Save role as selected by the user
            $user->save();
            session()->flash('success', 'Registration successfully');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validation->errors()
            ]);
        }
    }

    public function login()
    {
        return view('front.account.login');
    }

    public function authenticate(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required | email',
            'password' => 'required'
        ]);

        if ($validation->passes()) {
            $credentials = $request->only('email', 'password');
            if (auth()->attempt($credentials)) {
                return redirect()->route('account.profile');
            } else {
                return redirect()->route('account.login')->with('error','Either Email/Password is incorrect');

            }
        } else {
            return redirect()->route('account.login')
                ->withErrors($validation->errors())
                ->withInput($request->only('email'));
        }
    }

    public function profile()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();

        return view('front.account.profile', [
            'user' => $user
        ]);
    }




    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        $validation = Validator::make($request->all(), [
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        if ($validation->passes()) {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;
            $user->save();

            session()->flash('success', 'Profile successfully updated');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
            
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validation->errors()
            ]);
        }
    }

    public function updateProfilePic(Request $request)
    {
        $id = Auth::user()->id;

        $validation = Validator::make($request->all(), [
            'imgen' => 'required|image',
        ]);

        if ($validation->passes()) {

            $imgen = $request->imgen;
            $ext = $imgen->getClientOriginalExtension();
            $imagename = $id . '_' . time() . '.' . $ext;
            $imgen->move(public_path('/profile_pic'), $imagename);

            //cập nhập ảnh mới, lỗi cần phải sửa
            //   $source_path = public_path('/profile_pic'.$imagename);
            //   $manager=new ImageManager(ImagickDriver::class);
            //   $image=$manager->read($source_path);
            //   $image=$image->fit(150,150);
            //   $image->toPng()->save(public_path('/profile_pic'.$imagename));

            User::where('id', $id)->update([
                'imgen' => $imagename
            ]);

            session()->flash('success', 'Profile successfully updated');
            return response()->json([
                'status' => true,
                'errors' => []
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validation->errors()
            ]);
        }
    }


    public function logout()
    {
        auth()->logout();
        return redirect()->route('account.login');
    }

    public function createJob()
    {
        $categories = Category::OrderBy('id', 'desc')->where('status', 1)->get();
        $jobTypes = JobType::OrderBy('id', 'desc')->where('status', 1)->get();

        return view('company.mypost.postJob', [
            'categories' => $categories,
            'jobTypes' => $jobTypes,
        ]);
    }

    public function saveJob(Request $request)
    {
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
            $job = new Job();
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->user_id = Auth::user()->id;
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
            $job->save();

            session()->flash('success', 'Job added successfully.');


            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validation->errors()
            ]);
        }
    }

    public function myJobs()
    {

        $jobs = Job::where('user_id', Auth::user()->id)->with('jobType')->orderBy('created_at', 'DESC')->paginate(10);

        // return view('front.account.job.my-job', [
        //     'jobs' => $jobs
        // ]);
        return view('company.myJob.myJob', [
            'jobs' => $jobs
        ]);

    }

    public function editJob(Request $request, $id)
    {
        $categories = Category::OrderBy('id', 'desc')->where('status', 1)->get();
        $jobTypes = JobType::OrderBy('id', 'desc')->where('status', 1)->get();

        $job = Job::where([
            'user_id' => Auth::user()->id,
            'id' => $id,
        ])->first();

        if ($job == null) {
            abort(404);
        }

        return view('company.mypost.edit', [
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'job' => $job
        ]);

    }

    public function updateJob(Request $request, $id)
    {
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
            $job->user_id = Auth::user()->id;
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
            $job->save();

            session()->flash('success', 'Job updated successfully.');


            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validation->errors()
            ]);
        }


    }

    public function deleteJob(Request $request)
    {

        $job = Job::where([
            'user_id' => Auth::user()->id,
            'id' => $request->jobId
        ])->first();

        if ($job == null) {
            session()->flash('error', 'Either job deleted or not found.');
            return response()->json([
                'status' => true
            ]);
        }

        Job::where('id', $request->jobId)->delete();
        session()->flash('success', 'Job deleted successfully.');
        return response()->json([
            'status' => true
        ]);

    }

    public function myJobApplications()
    {

        $jobapplications = Jobapplication::where('user_id', Auth::user()->id)->with('job', 'job.jobType', 'job.applications')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('front.account.job.my-job-applications', [
            'jobapplications' => $jobapplications
        ]);
    }

    public function removeJob(Request $request)
    {

        $jobpplication = Jobapplication::where([
            'user_id' => Auth::user()->id,
            'id' => $request->id,
        ])->first();

        if ($jobpplication == null) {
            session()->flash('error', 'Either job deleted or not found.');
            return response()->json([
                'status' => true
            ]);
        }

        Jobapplication::find( $request->id)->delete();

        session()->flash('success', 'Job application deleted successfully.');
        return response()->json([
            'status' => true
        ]);

    }

    public function savedJobs()
    {
        $savedJobs = SaveJob::where([
            'user_id' => Auth::user()->id,
        ])->with('job', 'job.jobType', 'job.applications')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('front.account.job.saved-jobs', [
            'savedJobs' => $savedJobs
        ]);

    }
    public function removeSaveJob(Request $request)
    {

        $savedJobs = SaveJob::where(
            [
                'id' => $request->id,
                'user_id' => Auth::user()->id
            ]
        )->first();

        if ($savedJobs == null) {
            session()->flash('error', 'Job not found');
            return response()->json([
                'status' => false,
            ]);
        }

        SaveJob::find($request->id)->delete();
        session()->flash('success', 'Job removed successfully.');

        return response()->json([
            'status' => true,
        ]);


    }

    public function changePassword(Request $request){

          $validation = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password'=> 'required|same:new_password',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'status'=> false,
                'errors'=> $validation->errors()
            ]);
       }

    if(Hash::check($request->old_password , Auth::user()->password)==false){
        session()->flash('error', 'Old password is incorrect.');
        return response()->json([
            'status'=> true
        ]);

       }

       $user = User::find(Auth::user()->id);
       $user->password=Hash::make($request->new_password);
       $user->save();

       session()->flash('success','Password changed successfully.');
       return response()->json([
           'status'=> true
       ]);
}

 public function forgetpass(){
    return view('front.account.forget-password');
 }

 public function processForgotPassword(Request $request){
    $validation = Validator::make($request->all(), [
        'email' => 'required|email|exists:users,email'
        ]) ;

        if ($validation->fails()) {
            return redirect()->route('forgetpass')->withInput()->withErrors($validation);
        }

        $token = Str::random(64);

        \DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        \DB::table('password_reset_tokens')->insert([
            'email'=> $request->email,
            'token'=>$token,
            'created_at'=>now()
        ]);

        //gui mail o day
        $user=User::where('email', $request->email)->first();

        $mailData=[
            'user'=>$user,
            'token'=>$token,
            'subject' => 'You have requested to change your password.'
        ];

        Mail::to($request->email)->send(new ResetPasswordEmail($mailData));

        return redirect()->route('forgetpass')->with('success','Reset password email has been sent to your inbox.');
 }

 public function resetpassword($tokenString){
 
    $token =\DB::table('password_reset_tokens')->where('token', $tokenString)->first();
    if($token==null){
        return redirect()->route('forgetpass')->with('error','Invalid token.');
    }
    return view('mail.resetpassword',[
        'tokenString'=>$tokenString,
    ]
);
 }
public function ProcessresetPassword(Request $request){

    $token =\DB::table('password_reset_tokens')->where('token', $request->token)->first();
    if($token==null){
        return redirect()->route('forgetpass')->with('error','Invalid token.');
    }

    $validation = Validator::make($request->all(),[
        'newpassword'=> 'required|min:6',
        'confirmpassword'=> 'required|same:newpassword'
    ]);


    if ($validation->fails()) {
        return redirect()->route('resetpassword',$request->token)->withErrors($validation);
    }
    
    $user=User::where('email', $token->email)->update([
        'password'=> Hash::make($request->newpassword)
    ]);

    return redirect()->route('account.login')->with('success','You have successfully changed your password.');

}

}