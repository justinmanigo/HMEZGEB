<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HMEZGEB - Accounting Systems</title>

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
                                        <h1 class="h4 text-gray-900 mb-4">Select Accounting System</h1>
                                    </div>
                                      @if (\Session::has('error'))
                                    <div class="alert alert-danger">
                                        {!! \Session::get('error') !!}
                                    </div>
                                    @endif
                                    <form id="form_accouting_system" method="POST" action="{{ url('/switch') }}" class="user">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" id="accounting_system_id" name="accounting_system_id">
                                        @foreach($accountingSystems as $account)
                                            <a class="accounting_system_item btn btn-lg btn-primary mb-3 w-100" href="javascript:void(0)" data-id="{{ $account->accounting_system_id }}" role="button">
                                                {{ $account->name }}
                                            </a>
                                        @endforeach
                                        {{-- <input type="submit" name="accounting_system_id" value="1"> --}}
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}" 
                     onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
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
        var accountingSystemItemElements = document.querySelectorAll('.accounting_system_item');
        var accountingSystemIdElement = document.querySelector('#accounting_system_id');
        var accountingSystemForm = document.querySelector('#form_accouting_system');
        console.log(accountingSystemItemElements);
        for(i = 0; i < accountingSystemItemElements.length; i++) {
            accountingSystemItemElements[i].addEventListener('click', function(event){
                accountingSystemIdElement.value = event.target.dataset.id;
                accountingSystemForm.submit();
            });
        }
    </script>

</body>

</html>