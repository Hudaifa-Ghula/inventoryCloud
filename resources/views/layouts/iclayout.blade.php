<!Doctype html>
<html lang="en">
<head>
	<meta name="author" content="" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale= 1.0" />
	<title>Incloud | Landing</title>
    <!-- css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="css/styled.css">
</head>
<body class="bg-gray-green"> <!-- body with gray background -->
    <div class=" d-flex f-row w-100">
        <!-- left side nav bar start -->
        <i class="fas fa-bars nav-res-icon left"></i>
        <div class="navbar d-res-none">
            <ul class="navbar-list bg-white">
                <a href="/dashboard" class="nav-item active-item">
                    <i class="fas fa-columns"></i>
                    Dashboard
                </a>@can('is_admin', $company)
                <a href="/products" class="nav-item ">
                    <i class="fas fa-tag"></i>
                    Product
                </a>@endcan
                <a href="/inventory" class="nav-item">
                    <i class="fas fa-dolly-flatbed"></i>
                    Inventory
                </a>@can('is_admin', $company)
                <a href="buy" class="nav-item">
                    <i class="fas fa-shopping-basket"></i>
                    Buy
                </a>@endcan
                <a href="sell" class="nav-item">
                    <i class="fas fa-shopping-basket"></i>
                    Sell
                </a>
                <a href="settings" class="nav-item">
                    <i class="fas fa-cog"></i>
                    More
                </a>
            </ul>
        </div>
        <!-- left side nav bar end -->

        <div class="vertically-center r-box"> <!-- rbox for navbar-->
            <h3 class="product-title">Dashboard</h3>
            <div class="main-container bg-white f-col">
                <div class="form-container  company-form">
                    <form action="" class="center-form" id="companyForm">
                        <div id="errorMsg">
                            <!-- error message here -->
                        </div>

                        <div class="cards">
                            <!-- card -->
                            @if (!is_null($company))


                            <div class="card">

                                <div class="card-body">  <!--  card body (transactions, products and users include in the plan)  -->
                                    <div>
                                        <span class="bold">COMPANY: </span><span id="cp_company">{{$company->name}}</span>
                                    </div>
                                    <div>
                                        <span class="bold">PLAN: </span><span id="cp_name">{{$company->plan}}</span>
                                    </div>
                                    <div>
                                        <span class="bold">END: </span><span id="cp_date">Ends on {{$company->expiry}} <br></span>
                                    </div>
                                </div>

                            </div>
                            @else
                            <div class="card">

                                <div class="card-body">  <!--  card body (transactions, products and users include in the plan)  -->
                                    <div>
                                        <span class="bold">COMPANY: </span><span id="cp_company">No data</span>
                                    </div>
                                    <div>
                                        <span class="bold">PLAN: </span><span id="cp_name">No data</span>
                                    </div>
                                    <div>
                                        <span class="bold">END: </span><span id="cp_date">No data</span>
                                    </div><br>
                                    <div>
                                        <span class="bold">*Get started by creating a company</span>
                                    </div>
                                </div>



                                <div class="button-field"> <!-- button box -->
                                    <button type="button" class="addCompany"> Create New Company</button>
                                </div>

                            </div>
                            @endif
                            <!-- card -->
                            <div class="card">

                                <div class="card-body">  <!--  card body (transactions, products and users include in the plan)  -->
                                    <h3>Members</h3>
                                    <div class="members">
                                        <!-- <span>abc@gmail.com</span>
                                        <span>xyz@gmail.com</span> -->
                                    </div>
                                </div>
                                @can('is_admin', $company)
                                <div class="button-field"> <!-- button box -->
                                    <button type="submit" class="addMember"> Add Member</button>
                                </div>@endcan
                            </div>

                            <!-- card -->
                            <div class="card">
                                @can('is_admin', $company)
                                <div class="card-body">  <!--  card body (transactions, products and users include in the plan)  -->
                                    <div>
                                        <span class="bold">Sold: </span>
                                        <span class="num"> </span>
                                    </div>
                                    <div>
                                        <span class="bold">Buy: </span>
                                        <span class="num"> </span>
                                    </div>
                                    <div>
                                        <span class="bold">Profit: </span>
                                        <span class="num"> </span>
                                    </div>
                                </div>
                                @endcan

                            </div>
                        </div>
                    </form>
                </div>
                <div class="apis">
                    Stock apis
                </div>

            </div>
        </div>
    </div>
    <div class="memberModal">  <!--Pop up Modal to add image-->
        <div class="modal-content">
            <h2 class="green-text">  <!--heading-->
                Add Member
            </h2>
            <form class="form-container" id="memberForm">

                <div class="input-field"> <!-- input field box -->
                    <input type="text" name="userId" placeholder="User Id" id="userId"> <!-- input field  -->
                </div>
                <div class="input-field"> <!-- input field box -->
                    <input type="password" name="password" placeholder="Password" id="password"> <!-- input field  -->
                    <i class="fa fa-eye-slash pass"></i>
                </div>

                <div class="button-field text-right"> <!-- button box -->
                    <button type="submit" class="add"  id="addBtn"> Add </button>
                </div>
            </form>
        </div>
    </div>


    <div class="planModal">  <!--Pop up Modal to create company-->
        <div class="modal-content">

            <form class="form-container">  <!--form-->
                @csrf

                <div>
                    <h3 class="green-text">Please enter the company name</h3>
                </div>

                <div class="input-field"> <!-- input field box -->
                    <input type="text" name="companyName" placeholder="Company Name" id="companyName"> <!-- input field  -->
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
                <div  class="button-field text-right">  <!--button to upload image-->
                    <button type="submit" class="close-btn" id="createCompany" >Create</button>
                </div>
            </form>
        </div>
    </div>
    <!-- js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/scriptd.js"></script>

    <script>
        let modal = document.querySelector(".planModal");
        let mModal = document.querySelector(".memberModal");
        let closeBtn = document.querySelector(".close-btn"); // close btn
        let closeBtn2 = document.querySelector("#addBtn"); // close btn

        // close the modal on clicking close btn
        closeBtn.onclick = function(){
            modal.style.display = "none";
        }

        closeBtn2.onclick = function(){
            mModal.style.display = "none"
        }

        // open the modal on clicking the open button
        $(document).on("click",'.addCompany',function(){
            modal.style.display = "block";
            return false;
        })


        // open the modal on clicking the open button
        $(document).on("click",'.addMember',function(){
            mModal.style.display = "block";
            return false;
        })


        // close modal on clicking anywhere outside modal
        window.onclick = function(e){
            if(e.target == mModal){
                mModal.style.display = "none"
            }
            if(e.target == modal){
                modal.style.display = "none"
            }
        }

        // create company
        var company, plan, date;

        $("#createCompany").on("click", function(event){
            event.preventDefault();
            company = $('input[name="companyName"]').val();
            plan = $('input[name="planName"]:checked').val();

            if(company == "" || company == " " || plan == "" || plan == " "){
                $("#errorMsg").text("Company name and Plan is required to create a company");
                $("#errorMsg").show();
                setTimeout(function() { $("#errorMsg").hide(); }, 3000);
            }
            else{
                // date after one month
                var today = new Date();
                today.setDate(today.getDate()+30);
                var day = String(today.getDate()).padStart(2, '0');
                var month = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                var year= today.getFullYear();
                date = month + '/' + day + '/' + year;

                $("#cp_company").text(company);
                $("#cp_name").text(plan);
                $("#cp_date").text(date);
            }

            $('input[name="companyName"]').val("");
        })

        // members
        var members = {!! json_encode($members->toArray()) !!};


        addMember();

        function addMember(){
            for(let i=1; i< members.length; i++){
                $(".members").append("<span>"+members[i]['email']+"</span>");
            }
        }

        $("#addBtn").on("click", function(event){
            event.preventDefault();
            let uId = $('input[name="userId"]').val();
            let uPass = $('input[name="password"]').val();

            if(uId == "" || uId == " " || uPass == "" || uPass == " "){
                $("#errorMsg").text("User Id and Password are required to add a member");
                $("#errorMsg").show();
                setTimeout(function() { $("#errorMsg").hide(); }, 3000);
            }else{
                members.push(uId);
                $( ".members span" ).remove();
                addMember()
            }

            $('input[name="userId"]').val("");
            $('input[name="password"]').val("");
        })

    </script>
</body>
</html>
