<!Doctype html>
<html lang="en">
<head>
	<meta name="author" content="" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale= 1.0" />
	<title>Incloud | Products</title>
    <!-- css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body class="bg-gray-green"> <!-- body with gray background -->
    <div class=" d-flex f-row w-100">

        <!-- left side nav bar start -->
        <i class="fas fa-bars nav-res-icon left"></i>
        <div class="navbar d-res-none">
            <ul class="navbar-list bg-white">
                <a href="/dashboard" class="nav-item">
                    <i class="fas fa-columns"></i>
                    Dashboard
                </a>@if($user->id==$company->admin_id)
                <a href="/products" class="nav-item ">
                    <i class="fas fa-tag"></i>
                    Product
                </a>@endif
                <a href="/inventory" class="nav-item">
                    <i class="fas fa-dolly-flatbed"></i>
                    Inventory
                </a>@if($user->id==$company->admin_id)
                <a href="buy" class="nav-item">
                    <i class="fas fa-shopping-basket"></i>
                    Buy
                </a>@endif
                <a href="sell" class="nav-item">
                    <i class="fas fa-shopping-basket"></i>
                    Sell
                </a>
                <a href="settings" class="nav-item active-item">
                    <i class="fas fa-cog"></i>
                    More
                </a>
            </ul>
        </div>
        <!-- left side nav bar end -->

        <div class="vertically-center r-box">
            <h3 class="product-title">Settings</h3>
            <div class="main-container prod-container bg-white">
                <div class="setting">
                    <div class="sett-sec">
                        <div class="set-sec-title">
                            CURRENT LOGGED IN USER
                        </div>
                        <hr>
                        <div class="set-sec-body">
                            <h3>{{$user->name}}</h3>
                            <span>{{$user->email}}</span><br>
                            <span>Member since {{$user->created_at->diffForHumans()}}</span>

                            <div class="flex">
                                <!--<div  class="button-field">
                                    <a href="profile"><button class="" id="password" >Change Password</button></a>
                                </div>-->
                                <div  class="button-field"><a class="" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();">


                                    <button class="" id="logout" >Logout</button></a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($user->id==$company->admin_id)
                    <div class="sett-sec">
                        <div class="set-sec-title">
                            COMPANY PLAN
                        </div>
                        <hr>
                        <div class="set-sec-collapse-items">

                            <div class="collapsible-item">
                                <div class="flex collapsible">
                                    <i class="fas fa-tag green-bg"></i>
                                    <button type="button" >Current Plan</button>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                                <div class=" content">
                                    <div class="set-sec-body">
                                        <p>Current plan is "{{ucfirst($company->plan)}} plan" Which Ends on: {{$company->expiry}}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- <hr> -->

                            <div class="collapsible-item">
                                <div class="flex collapsible">
                                    <i class="fas fa-sync orange-bg"></i>
                                    <button type="button" >Renew Plan</button>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                                <div class=" content">
                                    <div class="set-sec-body">
                                        <!--Pop up Modal to create company-->

                                        <form class="form-container" method="POST" action="/renu">  <!--form-->
                                            @csrf

                                            <div>
                                                <h3 class="green-text">Please enter number of months of subscribtion</h3>
                                            </div>

                                            <div class="input-field"> <!-- input field box -->
                                                <input type="number" name="months" placeholder="1" id="months"> <!-- input field  -->
                                            </div>

                                            <div class="plan-cards">
                                                <!-- classic plan -->
                                                <div class="card">

                                                    <div class="plan-title">
                                                        <input type="radio" name="planName" value="classic" checked="checked"/>
                                                        CLASSIC
                                                    </div>

                                                    <div class="plan-price">
                                                        <span class="price">  <!--  plan price -->
                                                            $9.99
                                                        </span>
                                                        <span class="price-text"> per organization / month</span>
                                                    </div>

                                                    <div class="plan-body">  <!--  plan body (transactions, products and users include in the plan)  -->
                                                        <span>100 Transactions / Month</span>
                                                        <span>500 Products</span>
                                                        <span>10 Users </span>
                                                    </div>

                                                </div>

                                                <!-- pro plan -->
                                                <div class="card">

                                                    <div class="plan-title">
                                                        <input type="radio" name="planName" value="pro" checked="checked"/>
                                                        PRO
                                                    </div>

                                                    <div class="plan-price">
                                                        <span class="price">  <!--  plan price -->
                                                            $24.99
                                                        </span>
                                                        <span class="price-text"> per organization / month</span>
                                                    </div>

                                                    <div class="plan-body">  <!--  plan body (transactions, products and users include in the plan)  -->
                                                        <span>300 Transactions / Month</span>
                                                        <span>500 Products</span>
                                                        <span>10 Users </span>
                                                    </div>

                                                </div>

                                                <!-- gold plan -->
                                                <div class="card">

                                                    <div class="plan-title">
                                                        <input type="radio" name="planName" value="gold" checked="checked"/>
                                                        GOLD
                                                    </div>

                                                    <div class="plan-price">
                                                        <span class="price">  <!--  plan price -->
                                                            $49.99
                                                        </span>
                                                        <span class="price-text"> per organization / month</span>
                                                    </div>

                                                    <div class="plan-body">  <!--  plan body (transactions, products and users include in the plan)  -->
                                                        <span>1000 Transactions / Month</span>
                                                        <span>500 Products</span>
                                                        <span>10 Users </span>
                                                    </div>
                            <!--
                                                    <div class="button-field">
                                                        <label for="planLabel">
                                                        </label>
                                                    </div> -->

                                            </div>
                                    </div>
                                </div>
                            </div>
                                </div>

                            <!-- <hr> -->

                            <div class="collapsible-item">
                                <div class="flex collapsible">
                                    <i class="fas fa-shopping-cart l-blue-bg"></i>
                                    <button type="button" >Purchase Credits</button>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                                <div class=" content">
                                    <div class="set-sec-body">
                                        <p>Lorem ipsum...</p>
                                    </div>
                                </div>
                            </div>

                            <!-- <hr> -->

                            <div class="collapsible-item">
                                <div class="flex collapsible">
                                    <i class="fas fa-money-check-alt blue-bg"></i>
                                    <button type="button" >Payment History</button>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                                <div class=" content">
                                    <div class="set-sec-body">
                                        <p>Lorem ipsum...</p>
                                    </div>
                                </div>
                            </div>

                            <!-- <hr> -->

                            <div class="collapsible-item">
                                <div class="flex collapsible">
                                    <i class="fas fa-ban red-bg"></i>
                                    <button type="button" >Failed Transaction</button>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                                <div class=" content">
                                    <div class="set-sec-body">
                                        <p>Lorem ipsum...</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- <hr> -->

                    </div>@endif
                    <!-- transactionns  -->
                    <div class="sett-sec">
                        <div class="set-sec-title">
                            Profile
                        </div>
                        <hr>
                        <div class="set-sec-collapse-items">

                            <div class="collapsible-item">
                                <div class="flex collapsible">
                                    <i class="fas fa-key l-blue-bg"></i>
                                    <button type="button" >Change Password</button>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                                <div class=" content">
                                    <div class="set-sec-body"><x-app-layout>

                    @livewire('profile.update-password-form')

            </x-app-layout>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- <hr> -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/scripts.js"></script>

    <!-- <script src="assets/js/modal.js"></script> -->

    <script>
        var coll = document.getElementsByClassName("collapsible");
        var i;

        for (i = 0; i < coll.length; i++) {

            coll[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.maxHeight){
                    content.style.maxHeight = null;
                } else {
                    content.style.maxHeight = content.scrollHeight + "px";
                }


                coll[i-1].lastElementChild.classList.toggle("fa-chevron-right");
                coll[i-1].lastElementChild.classList.toggle("fa-chevron-down");

            });

        }
    </script>
</body>
</html>
