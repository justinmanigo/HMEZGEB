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
 
    {{-- input email address --}}
    <div class="container"  id="step1Container">
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
                                    <form action="{{route('register.submitEmail')}}" method="POST"   class="user">
                                        @csrf
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
                                         
                                    
                                    <hr>
                                   
                                    <div class="text-center">
                                        <a class="small" href="/">Already have an account? Login!</a>
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