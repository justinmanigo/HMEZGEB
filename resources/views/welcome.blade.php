<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HMEZGEB - Login</title>

    <!-- Custom fonts for this template-->
     <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="{{URL::asset('vendor/fontawesome-free/css/all.min.css')}}">  
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="{{URL::asset('css/sb-admin-2.min.css')}}">  
    <style>
        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active
        {
            color: #ffffff;
            background-color: #2653d4;
            border-color: #dddfeb #dddfeb #fff;
        }
    </style>



</head>

<body class="bg-gradient-primary">

    <div class="container"  id="loginContainer">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-6">
 

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->

                        
                         {{-- Tab Navigation --}}
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab"
                                    aria-controls="login" aria-selected="false">Login</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="signup-tab" data-toggle="tab" href="#signup" role="tab"
                                    aria-controls="signup" aria-selected="true">Sign up</a>
                            </li>
                        </ul>
                        {{-- Tab Contents --}}
                        <div class="card" class="content-card">
                            <div class="card-body tab-content" id="myTabContent">

                                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                                                <div class="p-4">
                                                    <div class="text-center">
                                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                                    </div>
                                                    @if (\Session::has('error'))
                                                    <div class="alert alert-danger">
                                                        {!! \Session::get('error') !!}
                                                    </div>
                                                    @endif
                                                    <form id="loginForm" class="user">
                                                        @csrf
                                                        <div class="form-group">
                                                            <input type="email" class="form-control form-control-user"
                                                                id="loginEmail" name="loginEmail" aria-describedby="loginEmail"
                                                                placeholder="Enter Email Address...">
                                                            @error('loginEmail')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="password" class="form-control form-control-user"
                                                                id="loginPassword" name="loginpassword" placeholder="Password">

                                                                @error('loginpassword')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="custom-control custom-checkbox small">
                                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                                <label class="custom-control-label" for="customCheck">Remember
                                                                    Me</label>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                                            Login
                                                        </button>
                                                    
                                                    </form>
                                                    <hr>
                                                    <div class="text-center">
                                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                                    </div>
                                                    <div class="text-center">
                                                        <a class="small" href="{{route('register.createAccountView')}}">Create an Account!</a>
                                                    </div>
                                                </div>
                                        
                                    </div>



                                    <!-- Register-->
                                    <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="signup-tab">
                                            <div class="p-5">
                                                <div class="text-center">
                                                    <h1 class="h4 text-gray-900 mb-4">Sign up for free</h1>
                                                </div>
                                                @if (\Session::has('error'))
                                                <div class="alert alert-danger">
                                                    {!! \Session::get('error') !!}
                                                </div>
                                                @endif
                                                <form id="form-register" action="{{route('register.submitReferral')}}" method="POST" class="user">
                                                    @csrf
                                                    <p id="error-referral-code" class="alert alert-danger error-message error-message-referralCode" style="display:none"></p>
                                                    
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="referralCode" name="referralCode" placeholder="Enter Referral Code">

                                                            {{-- @error('referralCode') --}}
                                                                {{-- <span id="error-referral-code-alert" class="invalid-feedback" role="alert" style="display:none">
                                                                    <strong id="error-referral-code-message">{{ $message }}</strong>
                                                                </span> --}}
                                                            {{-- @enderror --}}
                                                    </div>
                                                    
                                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                                        Get started
                                                    </button>
                                                
                                            </div>
                                        </form>
                                    </div>
                                </div> 
                            </div>   
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- input email address --}}
    {{-- <div class="container"  id="step1Container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->

                        <div class="row">
                           
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                    </div>
                                    <form action="step1Form" class="user">
                                        
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="registerEmail" name="registerEmail"
                                                placeholder="Email Address">
                                        </div>

                                        @error('registerEmail')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                       

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Register Accounts
                                        </button>
                                         
                                    </form>
                                    <hr>
                                   
                                    <div class="text-center">
                                        <a class="small" href="login.html">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div>   
            </div>   
        </div>   
    </div> --}}
    
    
    {{-- input password --}}
    {{-- <div class="container"  id="step2_1Container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->

                        <div class="row">
                           
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                    </div>
                                    <form id="step2_1Form" class="user">
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user"
                                                    id="createPassword"  name="createpassword" placeholder="Password">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user"
                                                id="repeatPassword"  name="repeatPassword" placeholder="Password">
                                            </div>
                                      
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Register Accounts
                                        </button>
                                         
                                    </form>
                                    <hr>
                                   
                                    <div class="text-center">
                                        <a class="small" href="login.html">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div>   
            </div>   
        </div>   
    </div>    --}}


        
    {{-- email exist --}}
    {{-- <div class="container" id="step2_2Container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->

                        <div class="row">
                           
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Email already exist!</h1>
                                        <div class="alert alert-warning">
                                        Login detail will be merged with the existing account. If you want to use different login detail, 
                                        go back to change the e-mail. If you want merge login detail for multiple accounts, 
                                        enter your existing password below to confirm.”
                                        </div>
                                    </div>
                                    <form id="step2_2Form" class="user">
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user"
                                                    id="existpassword" placeholder="Password">
                                            </div>        
                                        <div class="col-sm-12 text-center">
                                            <button  class="btn btn-outline-primary btn-user btn-inline-block">
                                            Back to Register
                                            </button>
                                            <button type="submit" class="btn btn-primary btn-user btn-inline-block">
                                                Login Account
                                            </button>
                                        </div>    
                                    </form>
                                    <hr>
                                   
                                    <div class="text-center">
                                        <a class="small" href="login.html">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div>   
            </div>   
        </div>   
    </div> --}}



    
    
       {{-- choose account --}}
       {{-- <div class="container" id="step3Container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->

                        <div class="row">
                           
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Choose an account</h1>
                                    </div>
                                    <form action="" class="user">
                                        <div class="text-center">
                                                <a href="#"> 
                                                    <img src="https://www.business2community.com/wp-content/uploads/2017/08/blank-profile-picture-973460_640.png" width="10%" class="rounded-circle img-fluid" alt="Cinque Terre">
                                                    <span>ABC COMPANY</span>
                                                </a>
                                            <hr>
                                                <a href="#"> 
                                                    <img src="https://www.business2community.com/wp-content/uploads/2017/08/blank-profile-picture-973460_640.png" width="10%" class="rounded-circle img-fluid" alt="Cinque Terre">
                                                    <span>ABC COMPANY</span>
                                                </a>   
                                            <hr>
                                                <a href="#"> 
                                                    <img src="https://www.business2community.com/wp-content/uploads/2017/08/blank-profile-picture-973460_640.png" width="10%" class="rounded-circle img-fluid" alt="Cinque Terre">
                                                    <span>ABC COMPANY</span>
                                                </a>
                                            <hr> 
                                        </div>   
                                                 
                                   
                                    </form>
                                    
                                   
                                   
                                </div>
                            </div>
                        </div>
                    </div>   
                </div>   
            </div>   
        </div>   
    </div>    --}}


     {{-- input password --}}
     {{-- <div class="container"  id="step2_1Container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->

                        <div class="row">
                           
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Company Info!</h1>
                                    </div>
                                    <form id=" " class="user">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user"
                                                    id=" "  name=" " placeholder=" ">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user"
                                                    id=" "  name=" " placeholder=" ">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user"
                                                    id=" "  name=" " placeholder=" ">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user"
                                                    id=" "  name=" " placeholder=" ">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user"
                                                    id=" "  name=" " placeholder=" ">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user"
                                                    id=" "  name=" " placeholder=" ">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user"
                                                    id=" "  name=" " placeholder=" ">
                                            </div>
                                            
                                      
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Submit
                                        </button>
                                         
                                    </form>
                                    <hr>
                                   
                                    <div class="text-center">
                                        <a class="small" href="login.html">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div>   
            </div>   
        </div>   
    </div>   --}}




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
      
        // $( "#step1Container").hide();
        // $( "#step2_1Container").hide();
        // $( "#step2_2Container").hide();
        // $( "#step3Container").hide();

       
    });

    </script>

    {{-- loginForm --}}
    <script type="text/javascript">
        $( "#loginForm" ).on('submit',function(e){
            e.preventDefault();
            let email = $('#loginEmail').val();
            let password = $('#loginPassword').val();
         
            $( "#loginContainer").hide();
            $( "#step1Container").show();


            $.ajax({
                url: "",
                type:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                    email:email,
                    password:password,
                },
                success:function(response){
                    console.log(response);
                },
                error: function(response) {
                    $('#email').text(response.responseJSON.errors.email);
                    $('#password').text(response.responseJSON.errors.password);
                },
            });
          
        });
    </script>

    {{-- registerForm --}}
    <script type="text/javascript">
        // $( "#registerForm" ).on('submit',function(e){
        //     e.preventDefault();
        //     let referralCode = $('#referralCode').val();

        //     // $.ajax({
        //     //     url: "",
        //     //     type:"POST",
        //     //     data:{
        //     //         "_token": "{{ csrf_token() }}",
        //     //         referralCode:referralCode,
        //     //     },
        //     //     success:function(response){
        //     //         console.log(response);
        //     //     },
        //     //     error: function(response) {
        //     //         $('#referralCode').text(response.responseJSON.errors.referralCode);
        //     //     },
        //     // });
           
        // });
    </script>

   {{-- step1Form --}}
    <script type="text/javascript">
        $( "#step1Form" ).on('submit',function(e){
            e.preventDefault();
            let email = $('#registerEmail').val();

            // $.ajax({
            //     url: "",
            //     type:"POST",
            //     data:{
            //         "_token": "{{ csrf_token() }}",
            //         email:email,
            //     },
            //     success:function(response){
            //         console.log(response);
            //     },
            //     error: function(response) {
            //         $('#email').text(response.responseJSON.errors.email);
            //     },
            // });
        
        });
    </script>

    {{-- step2_1Form --}}
    <script type="text/javascript">
        $( "#step2_1Form" ).on('submit',function(e){
            e.preventDefault();
            let password = $('#createPassword').val();
            let repeatPassword = $('#repeatPassword').val();

            // $.ajax({
            //     url: "",
            //     type:"POST",
            //     data:{
            //         "_token": "{{ csrf_token() }}",
            //         email:email,
            //         password:password,
            //     },
            //     success:function(response){
            //         console.log(response);
            //     },
            //     error: function(response) {
            //         $('#email').text(response.responseJSON.errors.name);
            //         $('#repeatPassword').text(response.responseJSON.errors.repeatPassword);
            //     },
            // });
       
        });
    </script>

    {{-- step2_2Form --}}
    <script type="text/javascript">
        $( "#step2_2Form" ).on('submit',function(e){
            e.preventDefault();
            let password = $('#existpassword').val();

            // $.ajax({
            //     url: "",
            //     type:"POST",
            //     data:{
            //         "_token": "{{ csrf_token() }}",
            //         password:password,
            //     },
            //     success:function(response){
            //         console.log(response);
            //     },
            //     error: function(response) {
            //         $('#password').text(response.responseJSON.errors.password);
            //     },
            // });
        
        });
    </script>

    <script type="text/javascript">
        $(document).on('submit', '#form-register', function(e) {
            e.preventDefault();
            console.log(e);
            $('#error-referral-code').hide();

            var request = $.ajax({
                url: e.currentTarget.action,
                method: e.currentTarget.method,
                data: $(e.currentTarget).serialize(),
            });

            request.done(function(response) {
                console.log(response);

                // If successful, redirect user to create-account view.
                window.location.href = "/create-account";
            });

            request.fail(function(response) {
                console.log(response);
                $('#error-referral-code').show().html("Referral code does not exist.");
            });
        });
    </script>

    



    <!-- Bootstrap core JavaScript-->
    <script src="{{URL::asset('vendor/jquery/jquery.min.js')}}"></script> 
    <script src="{{URL::asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script> 
	{{-- <script src="{{URL::asset(' ')}}"></script>  --}}
    <!-- Core plugin JavaScript-->
    <script src="{{URL::asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script> 

    <!-- Custom scripts for all pages-->
    <script src="{{URL::asset('js/sb-admin-2.min.js')}}"></script> 
 
    <!-- Custom script for this page -->
    <script src="{{ url('/js/ajax-submit-updated.js') }}"></script>

</body>

</html>