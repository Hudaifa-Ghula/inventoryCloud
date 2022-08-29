<!Doctype html>
<html lang="en">
<head>
	<meta name="author" content="" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale= 1.0" />
	<title>Incloud | Inventories</title>
    <!-- css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="css/styleby.css">
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
                <a href="buy" class="nav-item  active-item">
                    <i class="fas fa-shopping-basket"></i>
                    Buy
                </a>@endif
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
            <h3 class="inventory-title">Buy</h3> <!--Title-->
            <div class="main-container inv-container bg-white">  <!--main table container-->
                <div class="inventory">
                    <div class="inventory-table">
                        <div class="search-bar">  <!--search bar-->
                            <input type="text" id="search-item" placeholder="Code or Description or Location name or Location group name">
                        </div>
                        <div class="responsive-table">  <!--responsive table div -->
                            <table cellspacing="0" cellpadding="0">  <!--inventiry table-->
                                <thead>  <!--table heading-->
                                    <tr>
                                        <th>Image</th>
                                        <th>Transaction</th>
                                        <th>Amount</th>
                                        <th>Date/Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">  <!--table body-->
                                    <tr>
                                        <td>
                                            <img src="assets/images/logo.jpeg" alt="">
                                        </td>
                                        <td> B001</td>
                                        <td>1000</td>
                                        <td>04-Mar-2017</td>
                                        <td>Complete</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="load-more">  <!--load more button-->
                            <button>Load More</button>
                        </div>
                        <div class="tfooter">  <!--table info bar-->
                            <span class="total" id="totalInv">
                                Total:
                            </span>
                            <span class="loaded" id="loadedInv">
                                Loaded:
                            </span>
                        </div>
                    </div>
                    <div class="export" id="xport">  <!--export button-->
                        <a href="/exportBuy"><button>Export</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/scriptby.js"></script>
    <script src="assets/js/modal.js"></script>
    <script>

        var imgPrev, text, invId;
        let search= false;

        // convert img to data
        function readURLForStore(input) {
            var ele = input.parentElement.parentElement.id;
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    imgPrev =  e.target.result;
                    $( "#"+ ele + ' #img-upload').attr('src', e.target.result);
                    $( "#"+ ele + ' #img-upload').css({"border": "1px solid #fff", "box-shadow": "0px 0px 5px grey"} )

                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // input file
        $(".wizard-file").change(function(){
            readURLForStore(this);
        });

        // inventories
        var inventory = {!! json_encode($buy->toArray()) !!};

        // remove load button if there are no more inventories to load
        if(inventory.length <= 10){
            $(".load-more").css("display", "none")
        }

        // show more inventories on clicking the more button
        $(".load-more").click(function(){
            addInventory(inventory.length);
            $(".load-more").css("display", "none")
        });


        // add inventories function
        function addInventory(limit){

            // remove all columns
            $("td").remove();

            // counter to count inventories other than searched
            let count =0;

            // if search field is not empty
            if(search == true){
                for(let i =0; i< limit; i++){
                    // if searched item match with any inventory than show that inventory
                    if(
                        inventory[i]['id'].toString().toLowerCase().indexOf(text) >= 0 ||
                         inventory[i]['created_at'].toString().toLowerCase().indexOf(text) >= 0

                    ){
                        var row =
                        "<tr>"+
                            "<td>  <img src= "+ inventory[i]['img']+ " alt='inventory'></td>" +
                            "<td>B00"+ inventory[i]['id']+ "</td>" +
                            "<td>$"+ inventory[i]['price']+ "</td>" +
                            "<td>"+ inventory[i]['created_at']+ "</td>" +
                            "<td>"+ inventory[i]['status']+ "</td>" +
                            "</tr>";

                            $("#tbody").append(row);
                    }
                    else //else do nothing except increment the counter
                        count++;
                }
                //after searching all records, set search to false
                search= false;
            } else{
                // if search field is empty than show all inventories
                for(let i =0; i< limit; i++){
                    var row =
                    "<tr>"+
                            "<td>  <img src= "+ inventory[i]['img']+ " alt='inventory'></td>" +
                            "<td>B00"+ inventory[i]['id']+ "</td>" +
                            "<td>$"+ inventory[i]['price']+ "</td>" +
                            "<td>"+ inventory[i]['created_at']+ "</td>" +
                            "<td>"+ inventory[i]['status']+ "</td>" +
                        "</tr>";

                        $("#tbody").append(row);
                }
            }

            //to show the no. of loaded inventories in the table footer
            $("#loadedInv").text("Loaded: "+ (limit-count));

            //show load more button, if there are more inventories
            if(limit < inventory.length ){
                $(".load-more").css("display", "block")
            }
        }

        //on page load, show 10 inventories
        if (typeof inventory[0] == 'undefined') {
            $("td").remove();

                var row =
                        "<tr>"+
                            "<td></td><td></td><td>No buy records yet, Make sell transactions and you will find them here!</td>" +

                        "</tr>";
                        document.getElementById('xport').style.display = "none";

                        $("#tbody").append(row);
                        $("#loadedInv").text("Loaded: 0");
                        $("#totalInv").text("Total: 0");

        }else if(inventory.length<10){
            addInventory(inventory.length);
            $("#loadedInv").text("Loaded: "+ inventory.length);
                        $("#totalInv").text("Total: "+ inventory.length);
        }
        else{
            addInventory(10);



        }

        //upon entering any text in search field
        $("#search-item").on("input",function(){
            text = $("#search-item").val().toString().toLowerCase();
            search = true;
            addInventory(inventory.length);
            $(".load-more").css("display", "none")
        })

        //to show the no. of total inventories in table footer
        $("#totalInv").text("Total: "+inventory.length);
    </script>
</body>
</html>
