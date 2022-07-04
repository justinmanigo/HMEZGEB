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

    
    {{-- input password --}}
    <div class="container"  id="step2_1Container">
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
                                    @if (\Session::has('error'))
                                    <div class="alert alert-danger">
                                        {!! \Session::get('error') !!}
                                    </div>
                                    @endif
                                        <form action="{{route('register.submitPassword')}}" method="POST"  id="step2_1Form"   class="user">
                                            @csrf
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user"
                                                    id="createPassword"  name="createpassword" placeholder="Password" required>
                                                    @error('createpassword')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user"
                                                id="repeatPassword"  name="repeatPassword" placeholder="Password" required>
                                                @error('repeatPassword')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
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
    </div>   


  



    
     
 




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
         
            // $( "#loginContainer").hide();
            // $( "#step1Container").show();


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
            //         $('#email').text(response.responseJSON.errors.email);
            //         $('#password').text(response.responseJSON.errors.password);
            //     },
            // });
          
        });
    </script>

    {{-- registerForm --}}
    <script type="text/javascript">
        $( "#registerForm" ).on('submit',function(e){
            e.preventDefault();
            let referralCode = $('#referralCode').val();

            // $.ajax({
            //     url: "",
            //     type:"POST",
            //     data:{
            //         "_token": "{{ csrf_token() }}",
            //         referralCode:referralCode,
            //     },
            //     success:function(response){
            //         console.log(response);
            //     },
            //     error: function(response) {
            //         $('#referralCode').text(response.responseJSON.errors.referralCode);
            //     },
            // });
           
        });
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



    <!-- Bootstrap core JavaScript-->
    <script src="{{URL::asset('vendor/jquery/jquery.min.js')}}"></script> 
    <script src="{{URL::asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script> 
	{{-- <script src="{{URL::asset(' ')}}"></script>  --}}
    <!-- Core plugin JavaScript-->
    <script src="{{URL::asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script> 

    <!-- Custom scripts for all pages-->
    <script src="{{URL::asset('js/sb-admin-2.min.js')}}"></script> 
 

</body>

</html>