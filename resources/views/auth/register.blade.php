<!Doctype html>
<html lang="en">
<head>
	<meta name="author" content="" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale= 1.0" />
	<title>Sign Up</title>
    <!-- css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body class="bg-gray-green"> <!-- body with gray background -->
    <div class="">
        <div class="form-container">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-heading"> <!-- signup heading -->
                            <h2>Sign Up</h2>
                        </div>
                        <div class="input-field"> <!-- input field box -->
                            <i class="fa fa-user"></i>
                                <input id="name" placeholder="Name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>

                        <div class="input-field"> <!-- input field box -->
                            <i class="fa fa-envelope"></i> <!-- input field icon -->

                                <input id="email" placeholder="Email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="input-field"> <!-- input field box -->
                                <i class="fa fa-key"></i> <!-- input field icon -->

                                <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                        <div class="input-field"> <!-- input field box -->
                            <i class="fa fa-key"></i> <!-- input field icon -->

                                <input id="password-confirm" placeholder="Confirm Password" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                        </div>


<!--
                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">Gender</label>

                            <div class="col-md-6">
                                <input list="genders" name="gender" id="gender">

                                <datalist id="genders">
                                <option value="Male">
                                    <option value="Female">



                                </datalist></div>
                        </div>

                        <div class="form-group row">
                            <label for="number" class="col-md-4 col-form-label text-md-right">Number</label>

                            <div class="col-md-6">
                                <input id="Number" type="text" class="form-control" name="number">
                            </div>
                        </div>-->


                            <div class="button-field">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                            <div class="form-text"> <!-- sign in link -->
                                Already have an account? <a href="{{ route('login') }}">Sign In</a>
                            </div>
                        </div>
                    </form>
                </div>

<!-- js -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>

