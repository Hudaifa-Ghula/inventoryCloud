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
	<link rel="stylesheet" type="text/css" href="{{ asset('/css/stylep.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/styled.css') }}">
</head>
<body class="bg-gray-green"> <!-- body with gray background -->
    <div class=" d-flex f-row w-100">
        <!-- left side nav bar start -->
        <i class="fas fa-bars nav-res-icon left"></i>
        <div class="navbar d-res-none">
            <ul class="navbar-list bg-white">
                <a href="/dashboard" class="nav-item ">
                    <i class="fas fa-columns"></i>
                    Dashboard
                </a>
                <a href="/products" class="nav-item active-item">
                    <i class="fas fa-tag"></i>
                    Product
                </a>
                <a href="/inventory" class="nav-item">
                    <i class="fas fa-dolly-flatbed"></i>
                    Inventory
                </a>
                <a href="buy" class="nav-item">
                    <i class="fas fa-shopping-basket"></i>
                    Buy
                </a>
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
            <h3 class="product-title">Products</h3>
            <div class="main-container prod-container bg-white">
                <div class="product">
                    <div class="product-table">
                        <div class="search-bar"> <!-- search bar-->
                            <input type="text" id="search-item" placeholder="Code or Name or Location name or Category group name">
                        </div>
                        <div class="responsive-table"> <!-- responsive table div-->

                            <table cellspacing="0" cellpadding="0"> <!-- Product table-->
                                <thead> <!-- table headings-->
                                    <tr>
                                        <th>Image</th>
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th>Buy</th>
                                        <th>Reorder</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody"> <!-- table body-->




                                </tbody>
                            </table>
                        </div>
                        <!-- load button if there are additional products-->
                        <div class="load-more">
                            <button>Load More</button>
                        </div>

                        <!-- table information i.e. total products, loaded products -->
                        <div class="tfooter">
                            <span class="total" id="totalProd">
                                Total:
                            </span>
                            <span class="loaded" id="loadedProd">
                                Loaded:
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Buy button modal -->
                <div class="ProdModal">
                    <div class="modal-content">
                        <h2 class="green-text">
                            Buy Product <span id="prodCode"></span>
                        </h2>
                        <!-- form  -->
                        <form class="form-container" action="/proBuy" method="POST">
                            @csrf
                            <div>
                                <h3>Price: </h3>
                                $<span id="prodPrice" name ='prodPrice'></span>
                                <input type="hidden" id="p" name='price'>
                                <input type="hidden" id="id" name='id'>
                                <input type="hidden" id="code" name='code'>
                            </div>
                            <h3>Quantity: </h3>
                            <div class="input-field" >
                                <input type="number" value =1  name="qty" placeholder="1" id="qty"> <!-- input field  -->
                            </div>
                            <div  class="button-field">
                                <button type="submit" class="close-btn" id="qtyChange" >Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('/js/scriptp.js') }}"></script>

    <!-- <script src="assets/js/modal.js"></script> -->



    <script>

        // products
        var products = {!! json_encode($products->toArray()) !!};
        var buys = {!! json_encode($buys->toArray()) !!};
        var id = {!! json_encode($id) !!};




        let search= false;
        var text, prodId, price, prodFlag = false;

        if(typeof id != 'undefined'&& id!=0){
            for(let i = 0; i<products.length;i++){
                if(products[i]['code']==id){
                    id = products[i]['id'];
                }
            }
            prodId = id; //get product Id
            prodPrice = this.price;
            changeQuantity();

            document.querySelector(".ProdModal").style.display = "block";
        }

        // if products are less than 10 then remove load button
        if({{sizeof($products)}} <= 10){
            $(".load-more").css("display", "none")
        }

        // on clicking the load button, load all the products
        $(".load-more").click(function(){
            addProducts(products.length);
            $(".load-more").css("display", "none")
        });

        // add Product function
        function addProducts(limit){

            // remove all previous data
            $("td").remove();

            // to count the number of products except searched products
            let count =0;

            if(search == true){
                // search the required records
                for(let i =0; i< limit; i++){
                    if(
                        products[i]['code'].toString().toLowerCase().indexOf(text) >= 0 ||
                        products[i]['dsc'].toString().toLowerCase().indexOf(text) >= 0 ||
                        products[i]['location'].toString().toLowerCase().indexOf(text) >= 0 ||
                        products[i]['category'].toString().toLowerCase().indexOf(text) >= 0
                    ){
                        var row =
                            "<tr>"+
                            "<td>  <img src= /"+ products[i]['img']+ " alt='inventory'></td>" +
                            "<td>"+ products[i]['code']+ "</td>" +
                            "<td>"+ products[i]['dsc']+ "</td>" +
                            '<td><button class="green-b buyBtn" id='+products[i]['id']+' >Buy</button></td>'+
                            '<td><button class="orange-b reorderBtn" id='+products[i]['id']+' >Reorder</button> </td>'+
                            "</tr>";

                            $("#tbody").append(row);
                    }
                    else
                        count++;
                }
                // after searching set search value to false
                search = false;
            } else{
                // load all products if search field is empty
                for(let i =0; i< products.length && i<limit; i++){
                    var row =
                            "<tr>"+
                            "<td>  <img src= /"+ products[i]['img']+ " alt='inventory'></td>" +
                            "<td>"+ products[i]['code']+ "</td>" +
                            "<td>"+ products[i]['dsc']+ "</td>" +
                            '<td><button class="green-b buyBtn" id='+products[i]['id']+' >Buy</button></td>'+
                            '<td><button class="orange-b reorderBtn" id='+products[i]['id']+' >Reorder</button> </td>'+
                            "</tr>";

                        $("#tbody").append(row);
                    }
                }

            // show number of loaded products in table footer
            $("#loadedProd").text("Loaded: "+ (limit-count));

            // display load button if there are more products
            if(limit < products.length ){
                $(".load-more").css("display", "block")
            }
        }

        // by default load only 10 products
        addProducts(10);


        // when user will enter any value in search box
        $("#search-item").on("input",function(){
            text = $("#search-item").val().toString().toLowerCase(); //search string
            search = true; //search flag to true
            addProducts(products.length); //load filtered products
            $(".load-more").css("display", "none") //remove load button
        })

        // show number of total products in table footer
        $("#totalProd").text("Total: "+products.length);

        $(document).on("click",'.reorderBtn',function(){

            prodId = this.id; //get product Id
            prodPrice = this.price;

            if(typeof buys[0] == 'undefined'){
                alert("No purchases yet, make a purchase so you can use the reorder button!");
            }else{


            for(let i=0; i < products.length; i++){
                // find the required product
                if(products[i]["id"] == prodId  ){
                        for(let j =0; j<buys.length; j++){

                            if(products[i]["code"] == buys[j]["code"]){



                    $("#prodCode").text( products[i]["code"]); // display code of selected product in modal title
                    $("#qty").val(buys[j]['qty']); // bu default quantity is 1
                    $("#qty").attr("min",1); // minimum quantity is 1
                    $("#prodPrice").text( products[i]["price"]*buys[j]['qty']); // display cose of selected product
                    document.getElementById("p").value = products[i]["price"];
                    document.getElementById("id").value = products[i]["id"];
                    document.getElementById("code").value = products[i]["code"];
                    price = products[i]["price"]  // get the cost of product


                    modal.style.display = "block"
                    return 0;
                }else{




                }} alert("No records of purchase found for this product, please try again after making a purchase!"); }
            }
        }})
        // Buy button function
        $(document).on("click",'.buyBtn',function(){
            prodId = this.id; //get product Id
            prodPrice = this.price;
            changeQuantity();
        })

        function changeQuantity(){
            for(let i=0; i < products.length; i++){
                // find the required product
                if(products[i]["id"] == prodId  ){
                    $("#prodCode").text( products[i]["code"]); // display code of selected product in modal title
                    $("#qty").val(1); // bu default quantity is 1
                    $("#qty").attr("min",1); // minimum quantity is 1
                    $("#prodPrice").text( products[i]["price"]); // display cose of selected product
                    document.getElementById("p").value = products[i]["price"];
                    document.getElementById("id").value = products[i]["id"];
                    document.getElementById("code").value = products[i]["code"];
                    price = products[i]["price"]  // get the cost of product


                    prodFlag = true;
                }
            }
        }

        $("#qty").change(function(){
            $("#prodPrice").text( Math.round((price* $("#qty").val() + Number.EPSILON) * 100) / 100); //display product price * no. of items
        })/*

        $("#qtyChange").click(function(){
            let totalPrice=  $("#prodPrice").text();
            for(let i=0; i < products.length; i++){
                if(products[i]["id"] == prodId  && totalPrice ){
                    products[i]["price"] = totalPrice;
                }
            }

            addProducts(10);
            $("#qty").val(""); // set quantity to ""

            // if url contain id of product than remove that id
            if(prodFlag){
                window.location.replace("/products");
                prodFlag =false;
            }

            return false
        })*/

        // -------------------------------- Modal to add Quantity --------------------------
        let modal = document.querySelector(".ProdModal");

        // open modal
        $(document).on("click",'.buyBtn',function(){
            modal.style.display = "block"
        })


        // close modal
        let closeBtn = document.querySelector(".close-btn")
        closeBtn.onclick = function(){
            modal.style.display = "none"
        }

        // close modal on clicking anywhere outside the modal
        window.onclick = function(e){
            if(e.target == modal){
                modal.style.display = "none"
            }
        }

        //check url (when user will redirect from inventory to product page)
        const url = window.location.search;
        const urlParams = new URLSearchParams(url);
        const urlId = urlParams.get('id'); // get id from url

        if(urlId){
            prodId = urlId;
            changeQuantity();
            if(prodFlag){
                modal.style.display = "block";
            }
        }

    </script>
</body>
</html>
