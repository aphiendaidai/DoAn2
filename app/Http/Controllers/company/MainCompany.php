<?php

namespace App\Http\Controllers\company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\JobType;


class MainCompany extends Controller
{
    //
    public function index(){
        return view("company.Dashboard");
    }

    // public function create(){

    //     $categories = Category::OrderBy('id', 'desc')->where('status', 1)->get();
    //     $jobTypes = JobType::OrderBy('id', 'desc')->where('status', 1)->get();

    //     return view('company.mypost.postJob', [
    //         'categories' => $categories,
    //         'jobTypes' => $jobTypes,
    //     ]);
    // }
}
