<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;

class Homecontroller extends Controller
{
    public function index()
    {
        $categories = Category::where("status", 1)->orderBy("id", "ASC")->take(5)->get();

        $newcategory = Category::where("status", 1)->orderBy("id", "desc")->get();

        $count = $categories->mapWithKeys(function ($category) {
            return [$category->id => Job::where('category_id', $category->id)->count()];
        });
        


        $featuredJobs = Job::where("status", 1)->orderBy("created_at", "desc")->with('jobType','user1' )->where('isFeatured', 1)->take(6)->get();

        $latestJobs = Job::where('status', 1)
            ->with('jobType','user1')
            ->orderBy('created_at', 'DESC')
            ->take(6)->get();


        return view('front.home', [
            'categories' => $categories,
            'featuredJobs' => $featuredJobs,
            'latestJobs' => $latestJobs,
            'newcategory' => $newcategory,
            'count' => $count
                ]);
    }

    public function contact()
    {
        return view('front.contact');
    }
}
