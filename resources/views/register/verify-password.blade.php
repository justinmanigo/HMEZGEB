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


    {{-- email exist --}}
    <div class="container" id="step2_2Container">
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
                                    @if (\Session::has('error'))
                                    <div class="alert alert-danger">
                                        {!! \Session::get('error') !!}
                                    </div>
                                    @endif
                         
                                        <form action="{{route('register.verifyPassword')}}" method="POST" id="step2_2Form"  class="user">
                                            @csrf
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user"
                                                    id="existpassword" name="existpassword" placeholder="Password">
                                            </div>        
                                        <div class="col-sm-12 text-center">
                                            <button  class="btn btn-outline-primary btn-user btn-inline-block">
                                            
                                            <a class="small" href="/create-account">Back to Register</a>
                                            </button>
                                            <button type="submit" class="btn btn-primary btn-user btn-inline-block">
                                                Login Account
                                            </button>
                                        </div>    
                                    </form>
                                    <hr>
                                   
                                    <div class="text-center">
                                        <a class="small" href="/">Already have an account? Login!</a>
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