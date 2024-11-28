<html class="no-js" lang="en_AU" />
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>JobQuest | Find Best Jobs</title>
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />
	<meta name="HandheldFriendly" content="True" />
	<meta name="pinterest" content="nopin" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/ui/trumbowyg.min.css" integrity="sha512-Fm8kRNVGCBZn0sPmwJbVXlqfJmPC13zRsMElZenX6v721g/H7OukJd8XzDEBRQ2FSATK8xNF9UYvzsCtUpfeJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- Bootstrap CSS -->



    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />
	
	<!-- Fav Icon -->
	<link rel="shortcut icon" type="image/x-icon" href="#" />
</head>
<body data-instant-intensity="mousedown">
<header>
	<nav class="navbar navbar-expand-lg navbar-light bg-white shadow py-3">
		<div class="container">
		<a class="navbar-brand fw-bold text-primary" href="{{route('home')}}" style="font-size: 1.5rem;">
                <i class="fa fa-briefcase me-2"></i>JobQuest
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ms-0 ms-sm-0 me-auto mb-2 mb-lg-0 ms-lg-4">
					<li class="nav-item">
						<a class="nav-link" aria-current="page" href="{{route('home')}}">Home</a>
					</li>	
					<li class="nav-item">
						<a class="nav-link" aria-current="page" href="{{route('job')}}">Find Jobs</a>
					</li>										
				</ul>			
				@if(!Auth::check())	
				<a class="btn btn-outline-primary me-2" href="{{ route('account.login') }}" type="submit">Login</a>
				@else
				@if(Auth::user()->role =='admin')
				<a class="btn btn-outline-primary me-2" href="{{ route('dashbroad') }}" type="submit">Administrator</a>
				@endif
				@if(Auth::user()->role =='company')
				<a class="btn btn-outline-primary me-2" href="{{ route('company.main') }}" type="submit">Company</a>
				@endif
				<a class="btn btn-outline-primary me-2" href="{{ route('account.profile') }}" type="submit">Account</a>		
						@if(Auth::user()->role == 'admin' || Auth::user()->role == 'company')
				<a class="btn btn-primary" href="{{ route('account.createJob') }}" type="submit">Post a Job</a>
				@endif
				@endif

			</div>
		</div>
	</nav>
</header>





@yield(section: 'main')


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
			<div class="modal-header">
        <h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="profileForm" name="profileForm" action="" method="post">
				<div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="imgen"  name="imgen">
								<p class="text-danger" id="imgenError" name="imgenError"></p>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mx-3">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            
        </form>
      </div>
    </div>
  </div>
</div>


<footer class="bg-dark text-light py-5">
    <div class="container">
        <div class="row">
            <!-- Services Section -->
            <div class="col-md-4 mb-4">
                <h5 class="text-uppercase mb-3">Services</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-light footer-link">Home</a></li>
                    <li><a href="{{ route('account.login') }}" class="text-light footer-link">Login</a></li>
                    <li><a href="{{ route('account.registration') }}" class="text-light footer-link">Register</a></li>
                    <li><a href="#" class="text-light footer-link">Advertisement</a></li>
                </ul>
            </div>

            <!-- Website Admin Section -->
            <div class="col-md-4 mb-4">
                <h5 class="text-uppercase mb-3">Website Admin</h5>
                <ul class="list-unstyled">
                    <li><a href="https://www.facebook.com/bia.aphien.332" target="_blank" class="text-light footer-link">Facebook</a></li>
                    <li><a href="https://www.instagram.com/phien862005/" target="_blank" class="text-light footer-link">Instagram</a></li>
                    <li><a href="https://www.tiktok.com/@djsjsisunnwhwu" target="_blank" class="text-light footer-link">TikTok</a></li>
                    <li><a href="https://x.com/azinzin09191" target="_blank" class="text-light footer-link">Twitter</a></li>
                </ul>
            </div>

            <!-- Legal Section -->
            <div class="col-md-4 mb-4">
                <h5 class="text-uppercase mb-3">Legal</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-light footer-link">Terms of Use</a></li>
                    <li><a href="#" class="text-light footer-link">Privacy Policy</a></li>
                    <li><a href="#" class="text-light footer-link">Cookie Policy</a></li>
                </ul>
            </div>
        </div>
        <!-- Footer Bottom -->
        <div class="footer-bottom text-center mt-4">
            <p class="mb-0 text-white-50">&copy; 2024 ACME Industries Ltd. by Phien Company</p>
        </div>
    </div>
</footer>

<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<!-- <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script> -->
<script src="{{ asset('assets/js/instantpages.5.1.0.min.js') }}"></script>
<script src="{{ asset('assets/js/lazyload.17.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.5.1.3.min.js')}}"></script>
<script src="{{asset('assets/js/slick.min.js')}}"></script>
<script src="{{asset('assets/js/lightbox.min.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js" integrity="sha512-YJgZG+6o3xSc0k5wv774GS+W1gx0vuSI/kr0E0UylL/Qg/noNspPtYwHPN9q6n59CTR/uhgXfjDXLTRI+uIryg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
	$('.textarea').trumbowyg();

	
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
});


$("#profileForm").submit(function(e){
		e.preventDefault();

		var formData = new FormData(this);
		$.ajax({
			url: '{{ route('account.updateProfilePic') }}',
			type: "POST",
			dataType: "json",
      data: formData,
			contentType: false,
			processData:false,
			success: function(response) {
			if(response.status==false){
				var errors=response.errors;
			if(errors.imgen){
				$("#imgenError").html(errors.imgen);
			}
			}else{
				window.location.href = "{{ url()->current() }}";
			}
			}
		
		});
	});
</script>
@yield('custom_js')

</body>
</html>