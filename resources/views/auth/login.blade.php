<html><head>
    <title>Sign In</title>
    <link href="https://fonts.googleapis.com/css2?family=Courgette&family=Marck+Script&family=Parisienne&family=Satisfy&display=swap" rel="stylesheet">    <!-- google fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">



    </head>
    <body class="bg-gray-green">  <!--body with gray backgroung -->
        <div class="main-container bg-white"> <!-- main container with white backgroung -->
            <div class="left-side-container"> <!-- left side -->
                <div class="logo"> <!-- center aligned logo -->
                    <div class="logo-name">
                        <h1>Incloud</h1>
                    </div>
                    <div class="green-shade"> <!-- green shade around logo -->
                        <img src="assets/images/logo.jpeg" class="img-responsive" alt="">
                    </div>
                </div>
            </div>
            <div class="right-side-container">  <!-- right side container -->
                <div class="form-container">    <!-- signin form container -->
                    <form method="POST" action="{{ route('login') }}">

                        <div class="form-heading"> <!-- Signin form heading -->
                                <h2>User Login</h2>
                        </div>

                        <div class="social-account-links">
                            <div class="form-text">
                                <!-- Or login with -->
                            </div>
                            <a href="#" class="fb-signin">
                                <i class="fab fa-facebook-f"></i>
                                Continue with Facebook
                            </a>
                            <a href="#" class="google-signin">
                                <i class="fab fa-google"></i>
                                Continue with Google
                            </a>
                        </div>

                        <h3><span>OR</span></h3>


                           @csrf

                            <div class="input-field">


                                    <i class="fa fa-envelope"></i>
                                    <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                            </div>

                            <div class="input-field">
                                <i class="fa fa-key"></i>


                                    <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    <i class="fa fa-eye-slash pass"></i>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                            </div>

                            <!--<div class="input-field">

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>

                                </div>
                            </div>-->

                            <div class="button-field">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>
                            </div><div class="reset-pass form-text">


                                    @if (Route::has('password.request'))
                                        <a class="form-text" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                                <div class="form-text">
                                    <a href = "{{ route('register') }}">Create your Account <i class="fa fa-arrow-right"></i></a>

                                </div>

                        </form>
                    </div></div></div></div></body>
                      <!-- js -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/script.js"></script>
    </body>
    </html>





