@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
  <div class="container py-5">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route("dashbroad") }}">Home</a></li>
            <li class="breadcrumb-item active">Jobs</li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3">
        @include('admin.slidebar')
      </div>
      <div class="col-lg-9">
        @include('front.message')
        <div class="card border-0 shadow mb-4">
          <div class="card-body card-form">
            <div class="d-flex justify-content-between">
              <div>
                <h3 class="fs-4 mb-1">Job Applications</h3>
              </div>
              <div style="margin-top: -10px;">
              </div>
            </div>
            <div class="table-responsive">
              <table class="table ">
                <thead class="bg-light">
                  <tr>
                    <th scope="col">Job Title</th>
                    <th scope="col">User</th>
                    <th scope="col">Employer</th>
                    <th scope="col">Applied Date</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody class="border-0">
                  @if($applications->isNotEmpty())
                  @foreach ($applications as $application)
                  <tr>
                    <td> <p>{{ $application->job->title }}</p>
                         <p>{{ $application->id}}</p>
                    </td>
                    <td>{{ $application->user->name }}</td>
                    <td>{{ $application->employer->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($application->applied_date)->format('d M, Y') }}</td>
                    <td>
                   <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                              Action
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                              <li><a class="dropdown-item" href="javascript:void(0);" onclick="deleteAdminApplication({{ $application->id }})">Delete</a></li>
                            </ul> 
                          </div>
                        </td>
                  </tr>

                  @endforeach
                  @endif
                </tbody>
              </table>
            </div>
            <div>
                    {{ $applications->links() }}
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

  function deleteAdminApplication(id) {
    if (confirm("Are you sure you want to delete?")) {
      $.ajax({
        url: '{{ route("admin.jobapp.delete") }}',
        type: "POST",
        data: { id: id },
        dataType: 'json',
        success: function (response) {
          window.location.href = '{{ route("admin.jobapplication") }}';
        }
      });
    }
  }

</script>
@endsection