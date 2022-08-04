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
                           
                            <div id="step1" class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Enter your email address</h1>
                                    </div>
                                    <form id="form-step1" action="{{ url('/check-email-registration') }}" method="POST" class="user">
                                        @csrf
                                        <p id="step1-error" class="alert alert-danger" style="display:none">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="email" name="email"
                                                placeholder="Email Address" value="{{ \Session::get('referralEmail') }}" required>
                                        </div>
                                    
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Next
                                        </button>                                    
                                    </form>
                                </div>
                            </div>

                            {{-- If email does exist. --}}
                            <div id="step2a" style="display:none" class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Enter your current password</h1>
                                    </div>
                                    <form id="form-step2a" action="{{ url('/validate-account') }}" method="POST" class="user">
                                        @csrf
                                        <p>Your email <strong id="step2a-email"></strong> already exists in our system. Please re-enter your password to confirm your identity and proceed with the referral.</p>
                                        <p id="step2a-error" class="alert alert-danger error-message error-message-email" style="display:none">
                                       
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="step2a-password" name="password"
                                                placeholder="Current Password">
                                            <p class="alert alert-danger error-message error-message-password" style="display:none">
                                        </div>
                                    
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Authenticate and Merge Accounts
                                        </button>
                                        
                                        <hr>

                                        <div class="text-center">
                                            <a class="small form-step2-back" href="javascript:void(0)" role="button">Go Back</a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- If email does not exist. --}}
                            <div id="step2b" style="display:none" class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Enter your new credentials</h1>
                                    </div>
                                    <form id="form-step2b" action="{{ url('/create-account') }}" method="POST" class="user">
                                        @csrf
                                        <p>Our system indicates you're creating a new account. Kindly enter your preferred password to proceed with the registration.</p>
                                        <p id="step2b-error" class="alert alert-danger error-message-email error-message" style="display:none">
                                        
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="step2b-new-password" name="new_password"
                                                placeholder="New Password">
                                                <p class="alert alert-danger error-message error-message-new_password" style="display:none">
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="step2b-confirm-password" name="confirm_password"
                                                placeholder="Confirm Password">
                                                <p class="alert alert-danger error-message error-message-confirm_password" style="display:none">
                                        </div>
                                    
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Register Account
                                        </button>                
                                        
                                        <hr>

                                        <div class="text-center">
                                            <a class="small form-step2-back" href="javascript:void(0)" role="button">Go Back</a>
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

    <!-- Bootstrap core JavaScript-->
    <script src="{{URL::asset('vendor/jquery/jquery.min.js')}}"></script> 
    <script src="{{URL::asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script> 
	{{-- <script src="{{URL::asset(' ')}}"></script>  --}}
    <!-- Core plugin JavaScript-->
    <script src="{{URL::asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script> 

    <!-- Custom scripts for all pages-->
    <script src="{{URL::asset('js/sb-admin-2.min.js')}}"></script> 

    <script src="{{ url('/js/ajax-submit-updated.js') }}"></script>
    <script>
        // TODO: On form submit, make an AJAX call to check whether the email already exists in the system or not yet.
        // (Step 2A) If email exists, prompt the user to enter his/her current password indicating the user wishes to merge accounts.
        // (Step 2B) Otherwise, prompt the user to enter new passwords. 

        $(document).on('submit', '#form-step1', function(e) {
            e.preventDefault();
            console.log(e);

            var email = $('#email').val();
            $('#step1-error').hide();

            var request = $.ajax({
                url: e.currentTarget.action,
                method: e.currentTarget.method,
                data: $(e.currentTarget).serialize(),
            });

            request.done(function(response) {
                console.log(response);
                // If email exists, proceed to Step 2A
                if(response.email_exists == true) {
                    $('#step2a').show();
                    $('#step2a-email').html(email);
                }
                // Otherwise, proceed to Step 2B
                else {
                    $('#step2b').show();
                }

                $('#step1').hide();
            });

            request.fail(function(response) {
                console.log(response);
                if(response.responseJSON.email_exists == true) {
                    $('#step1-error').show().html(response.responseJSON.error);
                }
                else {
                    $('#step1-error').show().html("Referral code does not exist.");
                }
            });
        });

        $(document).on('click', '.form-step2-back', function(e) {
            e.preventDefault();
            $('#step2a').hide();
            $('#step2b').hide();
            $('#step1').show();
        });

        $(document).on('submit', '#form-step2a', function(e) {
            e.preventDefault();

            $('.error-message').hide();

            var request = $.ajax({
                url: e.currentTarget.action,
                method: e.currentTarget.method,
                data: $(e.currentTarget).serialize() + '&email=' + $('#email').val(),
            });

            request.done(function(response){
                console.log(response);
                window.location.href = "/onboarding";
            });

            request.fail(function(response){
                console.log(response);
                
                if(response.status != 422)
                {
                    $('#step2a-error').show().html(response.responseJSON.message);
                }
                else
                {
                    console.log(response.responseJSON.errors);
                    try {
                        showFormErrorsUpdated(response.responseJSON.errors, e.currentTarget.id);
                    }
                    catch (err) {
                        console.log("showFormErrorsUpdated function can't be loaded. (Requires ajax-submit-updated.js)");
                        $('#step2a-error').show().html("An unknown error has occured. Please try again later.");
                    }
                }
            });
        })

        $(document).on('submit', '#form-step2b', function(e){
            e.preventDefault();

            $('.error-message').hide()

            console.log(e);
            console.log($(e.currentTarget).serialize());

            var request = $.ajax({
                url: e.currentTarget.action,
                method: e.currentTarget.method,
                data: $(e.currentTarget).serialize() + `&email=${$('#email').val()}`,
            });

            request.done(function(response) {
                console.log(response);
                window.location.href = "/onboarding";
            });

            request.fail(function(response) {
                console.log(response);

                if(response.status != 422)
                {
                    $('#step2b-error').show().html(response.responseJSON.message);
                }
                else
                {
                    console.log(response.responseJSON.errors);
                    try {
                        showFormErrorsUpdated(response.responseJSON.errors, e.currentTarget.id);
                    }
                    catch (err) {
                        console.log("showFormErrorsUpdated function can't be loaded. (Requires ajax-submit-updated.js)");
                        $('#step2b-error').show().html("An unknown error has occured. Please try again later.");
                    }
                }
            });
            

        });

    </script>

</body>

</html>