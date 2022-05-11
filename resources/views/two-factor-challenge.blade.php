<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HMEZGEB - Confirm Password</title>

    <!-- Custom fonts for this template-->
     <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="{{URL::asset('vendor/fontawesome-free/css/all.min.css')}}">  
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="{{URL::asset('css/sb-admin-2.min.css')}}">  



</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-6 col-md-6">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                           
                            <div class="col-lg-12">

                            
                            
                            
                                <div class="p-5">
                                 <div class="col-lg-12 text-center">
                                    {{-- <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-secondary">Login</button>
                                        <button type="button" class="btn btn-secondary">Register</button>
                              
                                     </div> --}}
                                      {{-- <ul class="tab-group">
                                        <li class="tab active"><a href="#signup">Sign Up</a></li>
                                        <li class="tab"><a href="#login">Log In</a></li>
                                    </ul> --}}
                          
                             
                            </div>
                               
                                
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Two Factor Challenge</h1>
                                        <p id="code-label">{{ __('Please enter your authentication code to login.') }}</p>
                                    </div>
                                      @if (\Session::has('error'))
                                    <div class="alert alert-danger">
                                        {!! \Session::get('error') !!}
                                    </div>
                                    @endif
                                    <form method="POST" action="{{ route('two-factor.login') }}" class="user">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="code" name="code">

                                                  @error('code')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Submit
                                        </button>
                                       
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a id="toggle-code-methods" class="small" href="javascript:void(0)">{{ __('Don\'t have access to authentication app?') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

        <!-- Bootstrap core JavaScript-->
    <script src="{{URL::asset('vendor/jquery/jquery.min.js')}}"></script> 
    <script src="{{URL::asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script> 
	{{-- <script src="{{URL::asset(' ')}}"></script>  --}}
    <!-- Core plugin JavaScript-->
    <script src="{{URL::asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script> 

    <!-- Custom scripts for all pages-->
    <script src="{{URL::asset('js/sb-admin-2.min.js')}}"></script> 

    <script>
        var isRecovery = 0;
        var codeLabelElement = document.getElementById('code-label');
        var codeInputElement = document.getElementById('code');
        var codeInputToggle = document.getElementById('toggle-code-methods');
        codeInputToggle.addEventListener('click', toggleCodeMethod)
    
        function toggleCodeMethod()
        {
            console.log(codeInputElement.name);
            if(isRecovery) {
                codeInputToggle.innerText = "Enter a recovery code instead?";
                codeInputElement.name = "code";
                codeLabelElement.innerText = "Please enter your authentication code to login.";
                isRecovery--;
            }
            else {
                codeInputToggle.innerText = "Have access to authentication app?";
                codeInputElement.name = "recovery_code";
                codeLabelElement.innerText = "Please enter your recovery code to login.";
                isRecovery++;
            }
        }
    </script>

</body>

</html>