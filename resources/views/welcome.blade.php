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
            color: #000000;
            border-color: #dddfeb #dddfeb #fff;
        }

        .nav-pills .nav-item {
            border: 1px solid #dddfeb;
            border-color: transparent;
        }

        .nav-pills .nav-item .active
        {
            border: 1px solid #dddfeb;
        }

        .nav-pills .nav-item:hover {
            border:1px solid #1cc88a;
            border-radius:6px;
        }

        #card-login {
            border:0px;
        }

        .login-container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-login-container {
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>



</head>

<body class="bg-light">

    <!-- Outer Row -->
    <div class="row justify-content-center m-0">
        <div class="col-xl-6 col-lg-6 d-none d-lg-flex p-0">
            <div class="login-container">
                <div id="demo" class="carousel slide my-5" data-ride="carousel">

                    <!-- The slideshow -->
                    <div class="carousel-inner">
                        <div class="px-5 mb-5">
                            <div class="px-5">
                                <img src="http://127.0.0.1:8000/img/logo-128x102.png" height="128px" width="auto">
                            </div>
                        </div>
                        <div class="carousel-item active px-5">
                            <div class="px-5">
                                <h1 class="text-primary"><strong>See Everything in One Place</strong></h1>
                                <p>Get a more complete picture of your financial life. We bring together everything from account balances and spending to your free credit score, net worth and more.</p>
                            </div>
                        </div>
                        <div class="carousel-item px-5">
                            <div class="px-5">
                                <h1 class="text-primary"><strong>Save Time & Money</strong></h1>
                                <p>With one place to record from multiple users you will keep track of your finances, there is no need to visit or contact multiple departments. Plus, an internal auditor can follow up and check remotely without having to come to your office.</p>
                            </div>
                        </div>
                        <div class="carousel-item px-5">
                            <div class="px-5">
                                <h1 class="text-primary"><strong>Manage Customers</strong></h1>
                                <p>Track customer's balance & receipts along with account receivables. You will know what is due when it is due, and the cash you have to receive from your customers.</p>
                            </div>
                        </div>
                        <div class="carousel-item px-5">
                            <div class="px-5">
                                <h1 class="text-primary"><strong>Manage Vendors</strong></h1>
                                <p>Track vendor's balance & bills along with account payable. You will know what is due when it is due, and the payment you have to pay to your vendors.</p>
                            </div>
                        </div>
                        <div class="carousel-item px-5">
                            <div class="px-5">
                                <h1 class="text-primary"><strong>Manage Bank Accounts</strong></h1>
                                <p>Track deposits and payments that are made through multiple banks. Check bank balance before preparing cheques and the system will deduct the cheque that is already prepared but not yet withdraw so that you will get exactly how much money actually you/company own.</p>
                            </div>
                        </div>
                        <div class="carousel-item px-5">
                            <div class="px-5">
                                <h1 class="text-primary"><strong>Manage Human Resources</strong></h1>
                                <p>While keeping employees and commission agents list, HMezgeb will handle Payroll, Income Tax, Pension Tax, Loan repayment and more. All you have to record daily activities like new employee/commission agent, over time, allowance, penalties & deductions, loans were taken and repayment plan, advance payment, HMezgeb will handle the rest calculation.</p>
                            </div>
                        </div>
                        <div class="carousel-item px-5">
                            <div class="px-5">
                                <h1 class="text-primary"><strong>Say "Goodbye to Late Fees & Rush"</strong></h1>
                                <p>Get bill pay reminders so you pay bills on time and avoid missed payments and most out of it as long as your record daily business activity no need to prepare VAT Declaration, Income & Pension Taxes, as easy as print & declare, that is all.</p>
                            </div>
                        </div>
                        <div class="carousel-item px-5">
                            <div class="px-5">
                                <h1 class="text-primary"><strong>Stay Secure & Safe on Cloud</strong></h1>
                                <p>We are serious about security that is designed to help you protect access to your account and that you will access anywhere, any time from the cloud server.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 p-0">
            <div class="login-container">
                <div class="container">
                    <div class="row d-flex d-lg-none justify-content-center mb-4">
                        <img src="http://127.0.0.1:8000/img/logo-128x102.png" height="96px" width="auto">
                    </div>
                    <div class="row d-flex justify-content-center">
                        <div class="card o-hidden border-0 shadow-lg w-75">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->

                                <ul class="nav nav-pills nav-fill p-3" id="myTab" role="tablist">
                                    <li class="nav-item mr-2" role="presentation">
                                        <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab"
                                            aria-controls="login" aria-selected="false">Login</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="signup-tab" data-toggle="tab" href="#signup" role="tab"
                                            aria-controls="signup" aria-selected="true">Sign up</a>
                                        </li>
                                    </ul>
                                    <div class="card" class="content-card" id="card-login">
                                        <div class="card-body tab-content" id="myTabContent">

                                            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                                                <div class="card-login-container">
                                                    <div class="p-4 w-100">
                                                        <div class="text-center">
                                                            <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                                        </div>
                                                        @if (\Session::has('error'))
                                                        <div class="alert alert-danger">
                                                            {!! \Session::get('error') !!}
                                                        </div>
                                                        @endif
                                                        <form method="POST" action="{{ route('login') }}" class="user">
                                                            @csrf
                                                            <div class="form-group">
                                                                <input type="email" class="form-control"
                                                                    id="email" name="email" aria-describedby="emailHelp"
                                                                    placeholder="Enter Email Address...">
                                                                @error('email')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="password" class="form-control"
                                                                    id="password" name="password" placeholder="Password">

                                                                @error('password')
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
                                                            <input type="submit" class="btn btn-primary btn-block" value="Login">


                                                        </form>
                                                        <hr>
                                                        <div class="text-center">
                                                            <a class="small" href="forgot-password.html">Forgot Password?</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Register-->
                                            <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="signup-tab">
                                                <div class="card-login-container">
                                                    <div class="p-4 w-100">
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
                                                                <input type="text" class="form-control"
                                                                    id="referralCode" name="referralCode" placeholder="Enter Referral Code">
                                                            </div>

                                                            <button type="submit" class="btn btn-primary btn-block">
                                                                Get started
                                                            </button>
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
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>

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

                // If primaryful, redirect user to create-account view.
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
    <script>
        $(document).ready(function() {
            // Focus on the first input field
            $('#email').focus();
        });

    </script>

</body>

</html>
