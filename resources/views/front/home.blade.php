@extends('front.layouts.app')

@section('main')
<section class="section-0 lazy d-flex bg-image-style dark align-items-center " class=""
    data-bg="{{asset('assets/images/anh5.jpg')}}">

    <div class="container">
        <div class="row">
            <div class="col-12 col-xl-8">
                <h1>Find your dream job</h1>
                <p>Thounsands of jobs available.</p>
                <div class="banner-btn mt-5"><a href="#" class="btn btn-primary mb-4 mb-sm-0">Explore Now</a></div>
            </div>
        </div>
    </div>
</section>




<section class="section-1 py-5 ">
    <div class="container">
        <div class="card border-0 shadow p-5">
            <form action="{{ route('job') }}" method="GET">
                <div class="row">
                    <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                        <input type="text" class="form-control" name="keywords" id="keywords" placeholder="Keywords">
                    </div>
                    <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                        <input type="text" class="form-control" name="location" id="location" placeholder="Location">
                    </div>
                    <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                        <select name="category" id="category" class="form-control">
                            <option value="">Select a Category </option>
                            @if ($newcategory->isNotEmpty())
                                @foreach ($newcategory as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class=" col-md-3 mb-xs-3 mb-sm-3 mb-lg-0">
                        <div class="d-grid gap-2">
                            <!-- <a href="jobs.html" class="btn btn-primary btn-block">Search</a> -->
                            <button type="submit" class="btn btn-primary btn-block">Search</button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- <section class="section-2 bg-2 py-5">
    <div class="container">
        <h2>Popular Categories</h2>
        @if ($categories->isNotEmpty())
            @foreach ($categories as $category)
            <div class="single_catagory d-inline-block mr-4">
                <div class="single_catagory">
                    <a href="{{ route('job').'?category='.$category->id}}"><h4 class="pb-2">{{ $category->name }}</h4></a>
                    <p class="mb-0"> <span>0</span> Available position</p>
                </div>
            </div> 
            @endforeach                
            @endif

    </div>
</section> -->


<section class="section-2 bg-2 py-5">
    <div class="container text-center">
        <h2 class="mb-5">Popular Categories</h2>
        <div class="row justify-content-center">
            @if ($categories->isNotEmpty())
                @foreach ($categories as $category)
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="category-card p-4 shadow-sm rounded text-center h-100">
                            <a href="{{ route('job') . '?category=' . $category->id }}" class="category-link">
                                <h4 class="pb-2">{{ $category->name }}</h4>
                            </a>
                            <p class="mb-0 text-muted">
                            <span>{{ $count[$category->id] ?? 0 }}</span> Available position
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>


<!-- <section class="section-3  py-5">
    <div class="container">
        <h2>Featured Jobs</h2>
        <div class="row pt-5">
            <div class="job_listing_area">                    
                <div class="job_lists">
                    <div class="row">
                        @if($featuredJobs->isNotEmpty())
                        @foreach($featuredJobs as $featuredJob)
                        
                        <div class="col-md-4">
                            <div class="card border-0 p-3 shadow mb-4">
                                <div class="card-body">
                                    <h3 class="border-0 fs-5 pb-2 mb-0">{{$featuredJob->title}}</h3>
                                    <p>{{ Str::words(strip_tags($featuredJob->description), 8) }}</p>
                                    <div class="bg-light p-3 border">
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                            <span class="ps-1">{{$featuredJob->location}}</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                            <span class="ps-1">{{$featuredJob->jobType->name}}</span>
                                        </p>
                                        @if (!is_null($featuredJob->salary))
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                            <span class="ps-1">{{ $featuredJob->salary }}</span>
                                        </p>
                                        @endif
                                    </div>

                                    <div class="d-grid mt-3">
                                        <a href="{{route('jobdetail', parameters: $featuredJob->id)}}" class="btn btn-primary btn-lg">Details</a>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                      @endforeach
                      @endif               
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->

<section class="section-3 py-5 bg-light">
    <div class="container text-center">
        <h2 class="mb-5">Featured Jobs</h2>
        <div class="row">
            @if($featuredJobs->isNotEmpty())
                @foreach($featuredJobs as $featuredJob)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card job-card border-0 shadow-sm h-100">
                            <div class="card-body p-4">
                                <div class="d-grid mt-4">
                                    <img src="{{  asset('../profile_pic/'.$featuredJob->user->imgen)}}"
                                    alt="avatar"
                                        class="rounded-circle img-fluid" style="width:80px;">
                                </div>

                                <h3 class="job-title fs-5 mb-2">{{ $featuredJob->title }}</h3>
                                <p class="text-muted">{{ Str::words(strip_tags($featuredJob->description), 12) }}</p>

                                <div class="job-details mt-3 p-3 rounded bg-white border">
                                    <p class="mb-1"><strong><i class="fa fa-map-marker text-primary"></i></strong>
                                        {{ $featuredJob->location }}</p>
                                    <p class="mb-1"><strong><i class="fa fa-clock-o text-primary"></i></strong>
                                        {{ $featuredJob->jobType->name }}</p>
                                    @if (!is_null($featuredJob->salary))
                                        <p class="mb-0"><strong><i class="fa fa-usd text-primary"></i></strong>
                                            {{ $featuredJob->salary }}</p>
                                    @endif
                                </div>

                                <div class="d-grid mt-4">
                                    <a href="{{ route('jobdetail', parameters: $featuredJob->id) }}"
                                        class="btn btn-primary btn-block">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>



<!-- <section class="section-3 bg-2 py-5">
    <div class="container">
        <h2>Latest Jobs</h2>
        <div class="row pt-5">
            <div class="job_listing_area">                    
                <div class="job_lists">
                    <div class="row">
                        @if($latestJobs->isNotEmpty())
                        @foreach($latestJobs as $latestJob)
                        
                        <div class="col-md-4">
                            <div class="card border-0 p-3 shadow mb-4">
                                <div class="card-body">
                                    <h3 class="border-0 fs-5 pb-2 mb-0">{{$latestJob->title}}</h3>
                                    <p>{{ Str::words(strip_tags($latestJob->description), 5) }}</p>
                                    <div class="bg-light p-3 border">
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                            <span class="ps-1">{{$latestJob->location}}</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                            <span class="ps-1">{{$latestJob->jobType->name}}</span>
                                        </p>
                                        @if (!is_null($latestJob->salary))
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                            <span class="ps-1">{{ $latestJob->salary }}</span>
                                        </p>
                                        @endif
                                    </div>

                                    <div class="d-grid mt-3">
                                        <a href="{{route('jobdetail', $latestJob->id)}}" class="btn btn-primary btn-lg">Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                      @endforeach
                      @endif               
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->

<section class="section-3 bg-2 py-5">
    <div class="container text-center">
        <h2 class="mb-5">Latest Jobs</h2>
        <div class="row">
            @if($latestJobs->isNotEmpty())
                @foreach($latestJobs as $latestJob)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card job-card border-0 shadow-sm h-100">
                            <div class="card-body p-4">
                            <div class="d-grid mt-4">
                                    <img src="{{  asset('../profile_pic/'.$latestJob->user->imgen)}}"
                                    alt="avatar"
                                        class="rounded-circle img-fluid" style="width:80px;">
                                </div>
                                <h3 class="job-title fs-5 mb-2 text-primary">{{ $latestJob->title }}</h3>
                                <p class="text-muted">{{ Str::words(strip_tags($latestJob->description), 10) }}</p>

                                <div class="job-details mt-3 p-3 rounded bg-white border">
                                    <p class="mb-1"><strong><i class="fa fa-map-marker text-primary"></i></strong>
                                        {{ $latestJob->location }}</p>
                                    <p class="mb-1"><strong><i class="fa fa-clock-o text-primary"></i></strong>
                                        {{ $latestJob->jobType->name }}</p>
                                    @if (!is_null($latestJob->salary))
                                        <p class="mb-0"><strong><i class="fa fa-usd text-primary"></i></strong>
                                            {{ $latestJob->salary }}</p>
                                    @endif
                                </div>

                                <div class="d-grid mt-4">
                                    <a href="{{ route('jobdetail', $latestJob->id) }}"
                                        class="btn btn-primary btn-lg">Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

@endsection