@extends('front.layouts.app')


@section('main')
<section class="section-5 bg-2">
  <div class="container py-5">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Account Settings</li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3">
        @include('front.account.slidebar')
      </div>
      <div class="col-lg-9">
        @include('front.message')
        <div class="card border-0 shadow mb-4 p-3">
          <div class="card-body card-form">
            <div class="d-flex justify-content-between">
              <div>
                <h3 class="fs-4 mb-1">Jobs Applied</h3>
              </div>
              @if( Auth::user()->role == 'company')
              <div style="margin-top: -10px;">
                <a href="{{ route('account.createJob') }}" class="btn btn-primary">Post a Job</a>
              </div>
              @endif

            </div>
            <div class="table-responsive">
              <table class="table ">
                <thead class="bg-light">
                  <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Application date	</th>
                    <th scope="col">Applicant</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody class="border-0">
                  @if($jobapplications->isNotEmpty())
                     @foreach ($jobapplications as $jobapplication)
                  <tr class="active">
                    <td>
                      <div class="job-name fw-500">{{ $jobapplication->job->title }}</div>
                      <div class="info1">{{ $jobapplication->job->jobType->name }}  . {{ $jobapplication->job->location }}</div>

                    </td>
                    <td>{{ \Carbon\Carbon::parse($jobapplication->created_at)->format('d M, Y') }}</td>
                    <td>{{round($jobapplication->job->applications->count()) }} Applications</td>
                    <td>
                      @if($jobapplication->job->status == 1)
                      <div class="job-status text-capitalize">Active</div>
                      @else
                      <div class="job-status text-capitalize">Block</div>
                      @endif
                    </td>
                    <td>

                      <div class="action-dots float-end">
                        <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
</button>

                        <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item" href="{{route('jobdetail',$jobapplication->job->id)}}"> <i class="fa fa-eye"
                                aria-hidden="true"></i> View</a></li>
                                
                          <li><a class="dropdown-item" href="#" onclick="removeJob({{ $jobapplication->id }})" > <i class="fa fa-trash" aria-hidden="true"></i>
                              Remove</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td colspan="5">No Job Applied</td>
                  </tr>
                  @endif

                 
                </tbody>

              </table>
            </div>
            <div>
                            {{ $jobapplications->links() }}
             </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('custom_js')

<script>
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    function removeJob(id){
       if(confirm('Are you sure want to delete?')){
      $.ajax({
        url: "{{ route('account.removeJob') }}",
        type: "POST",
        data:{id:id},
        dataType: 'json',
        success: function (response) {
          window.location.href='{{ route("account.myJobApplications") }}';
        }
      });

       }
    }
</script>
@endSection