@extends('front.layouts.app')


@section('main')

<section class="section-3 py-5 bg-2 ">
    <div class="container">   
    <form action="" name="searchFrom" id="searchFrom">
  
        <div class="row">
            <div class="col-6 col-md-10 ">
                <h2>Find Jobs</h2>  
            </div>
         
            <div class="col-6 col-md-2">
                <div class="align-end">
                    <select name="sort" id="sort" class="form-control">
                    <option value="1" {{ (Request::get('sort') == '1') ? 'selected' : '' }}>Latest</option>
                    <option value="0" {{ (Request::get('sort') == '0') ? 'selected' : '' }}>Oldest</option>
                        
                    </select>
                </div>
            </div>
        </div>

        <div class="row pt-5">
            <div class="col-md-4 col-lg-3 sidebar mb-4">
                <div class="card border-0 shadow p-4">
                    <div class="mb-4">
                        <h2>Keywords</h2>
                        <input type="text"  value="{{Request::get('keywords')}}" name="keywords" id="keywords" placeholder="keywords" class="form-control">
                    </div>

                    <div class="mb-4">
                        <h2>Location</h2>
                        <input type="text" value="{{Request::get('location')}}" name="location" id="location" placeholder="Location" class="form-control">
                    </div>

                    <div class="mb-4">
                        <h2>Category</h2>
                        <select name="category" id="category" class="form-control">
                        <option value="">Select a Category </option>
                        @if($categories->isNotEmpty())
                        @foreach($categories as $category)
                            <option {{ (Request::get(key: 'category') == $category->id) ? 'selected' : '' }}  value="{{$category->id}}">{{ $category->name }}</option>
                           @endforeach
                        @endif
                        </select>
                    </div>                   

                    <div class="mb-4">
                        <h2>Job Type</h2>
                        @if($jobType->isNotEmpty())
                        @foreach($jobType as $jobType)
                        <div class="form-check mb-2"> 
                            <input {{ (Request::get(key: 'job_type') == $jobType->id) ? 'checked' : '' }} class="form-check-input " name="job_type" type="checkbox" value="{{ $jobType->id }}" id="job-type-{{ $jobType->id }}">    
                            <label class="form-check-label"for="job-type-{{ $jobType->id }}">{{ $jobType->name }}    </label>
                        </div>
                        @endforeach
                        @endif

               
                    </div>

                    <div class="mb-4">
                        <h2>Experience</h2>
                        <select name="experience" id="experience" class="form-control">
                                <option value="">Select Experience</option>
                                <option value="1" {{ (Request::get('experience') == 1) ? 'selected' : '' }}>1 Year</option>
                                <option value="2" {{ (Request::get('experience') == 2) ? 'selected' : ''  }}>2 Years</option>
                                <option value="3" {{ (Request::get('experience') == 3) ? 'selected' : ''  }}>3 Years</option>
                                <option value="4" {{ (Request::get('experience') == 4) ? 'selected' : ''  }}>4 Years</option>
                                <option value="5" {{ (Request::get('experience') == 5) ? 'selected' : ''  }}>5 Years</option>
                                <option value="6" {{ (Request::get('experience') == 6) ? 'selected' : ''  }}>6 Years</option>
                                <option value="7" {{ (Request::get('experience') == 7) ? 'selected' : ''  }}>7 Years</option>
                                <option value="8" {{ (Request::get('experience') == 8) ? 'selected' : '' }}>8 Years</option>
                                <option value="9" {{ (Request::get('experience') == 9)  ? 'selected' : '' }}>9 Years</option>
                                <option value="10" {{ (Request::get('experience') == 10) ? 'selected' : ''  }}>10 Years</option>
                                <option value="10_plus" {{ (Request::get('experience') == '10_plus') ? 'selected' : ''  }}>10+ Years</option>
                            </select>
                    </div>      
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('job') }}" class="btn btn-secondary-mt-3">Clear</a>
              
                </div>
            </div>
            <div class="col-md-8 col-lg-9 ">
                <div class="job_listing_area">                    
                    <div class="job_lists">
                    <div class="row">
                      @if($jobs->isNotEmpty())
                      @foreach($jobs as $job)
                        <div class="col-md-4">
                            <div class="card border-0 p-3 shadow mb-4">
                                <div class="card-body">
                                <div class="d-grid mt-4">
         <img src="{{  asset('../profile_pic/'.$job->user->imgen)}}"
                                    alt="avatar"
                                        class="rounded-circle img-fluid" style="width:80px;">
                                </div>
                                    <h3 class="border-0 fs-5 pb-2 mb-0">{{$job->title}}</h3>
                                    <p>{{ Str::words(strip_tags($job->description), 8)}}</p>
                                    <div class="bg-light p-3 border">
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                            <span class="ps-1">{{$job->location}}</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                            <span class="ps-1">{{$job->jobType->name}}</span>
                                        </p>
                                        <p>{{$job->category->name}}</p>
                                        <p>{{$job->keywords}}</p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                            <span class="ps-1">{{ $job->salary }}</span>
                                        </p>
                                    </div>

                                    <div class="d-grid mt-3">
                                        <a href="{{route('jobdetail', $job->id)}}" class="btn btn-primary btn-lg">Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                                <div class="col-md-12">
                                    {{ $jobs->withQueryString()->links() }}
                                </div>
                            @else
                            <div class="col-md-12">Jobs not found</div>                                
                            @endif       
                    </div>
                    </div>
                </div>
            </div>
            
        </div>
        </form>
    </div>
</section>



@endsection

@section('custom_js')
<script>

  $('#searchFrom').submit(function(e){
    e.preventDefault(); 
    var url='{{ route('job') }}';

    var checkedJobTypes = $("input:checkbox[name='job_type']:checked").map(function(){
            return $(this).val();
        }).get();

    var params = [];
    var sort = $('#sort').val();
    
    if ($("#keywords").val() != '') {
      params.push('keywords=' + $("#keywords").val());
    }
    
    if ($("#location").val() != '') {
      params.push('location=' + $("#location").val());
    }
    
    if ($("#category").val() != '') {
      params.push('category=' + $("#category").val());
    }

    if (checkedJobTypes.length > 0) {
      params.push('jobType=' + checkedJobTypes);
    }
    
    if ($("#experience").val() != '') {
      params.push('experience=' + $("#experience").val());
    }
    

    var queryString = params.join('&');
    
    if (queryString !== '') {
      url += '?' + queryString;

    }else{
    url += '?sort=' + sort;
    }
    
    window.location.href=url;

  });

$('#sort').change(function(){
  $('#searchFrom').submit();
});

</script>
@endSection