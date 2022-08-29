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
	<link rel="stylesheet" type="text/css" href="css/stylei.css">
    <link rel="stylesheet" type="text/css" href="css/styled.css">
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
                <a href="/inventory" class="nav-item active-item">
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
                <a href="settings" class="nav-item">
                    <i class="fas fa-cog"></i>
                    More
                </a>
            </ul>
        </div>
        <!-- left side nav bar end -->

        <div class="vertically-center r-box"> <!-- rbox for navbar-->
            <h3 class="inventory-title">Inventory</h3> <!--Title-->
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
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th>Qty in Hand</th>
                                        <th>Uom</th>
                                        <th>Avg.Cost </th>
                                        <th>Buy</th>
                                        <th>Sold</th>
                                        <th>Add Image</th>

                                    </tr>
                                </thead>
                                <tbody id="tbody">  <!--table body-->

                                </tbody>
                            </table>
                        </div>

                        <div class="load-more">  <!--load more button-->
                            <button>Load More</button>
                        </div>

                        <div class="tfooter">  <!--table info bar-->
                            <span class="total" id="totalInv">
                                Total: 1000
                            </span>
                            <span class="loaded" id="loadedInv">
                                Loaded: 20
                            </span>
                        </div>
                    </div>
                </div>

                <div class="InvModal">  <!--Pop up Modal for sold button -->
                    <div class="modal-content">
                        <h2 class="green-text">  <!--heading-->
                            Sell Product <span id="prodCode"></span>
                        </h2>
                        <form id="form" class="form-container" action="/sellPro" method="POST">  <!--form-->
                            @csrf
                            <h3>  <!--heading-->
                                Quantity:
                            </h3>
                            <div class="input-field" >  <!--input field-->
                                <input type="number" name="qty" placeholder="Quantity Sold" id="qty" oninput="checkzero()"> <!-- input field  -->

                                <input type="hidden" id="id" name='id'></div>
                                <h3 >  <!--heading-->
                                    Price of sale (suggested 10% profit):
                                </h3><div class="input-field"><input type="number" id="p" name='p' placeholder="Selling Price"></div>
                            <div class="button-field">   <!--button-->
                                <button type="submit" class="close-btn" id="qtyChange" onclick="checkzero()">SELL</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="addImageModal">  <!--Pop up Modal to add image-->
                    <div class="modal-content">
                        <h2 class="green-text">  <!--heading-->
                            Product <span id="prodName"></span>
                        </h2>
                        <form class="form-container">  <!--form-->
                            <div class="picture-container form-group" id="icon-img">  <!--image container-->
                                <div class="picture">
                                    <!-- preview image -->
                                    <img id='img-upload' src="images/imgPreview.png" class=" img-responsive"/> <!-- for Image preview-->
                                    <span class="icon">
                                        Select Image <!--img upload text-->
                                    </span>
                                    <input type="file" class="wizard-file" >
                                </div>
                            </div>
                            <div  class="button-field">  <!--button to upload image-->
                                <button class="imgCloseBtn" id="imgAddBtn" >Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/scripti.js"></script>
    <!-- <script src="js/modal.js"></script>-->
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


        var inventory = {!! json_encode($inventory->toArray()) !!};

        // remove load button if there are no more inventories to load
        if(inventory.length <= 10){
            $(".load-more").css("display", "none")
        }

        // show more inventories on clicking the more button
        $(".load-more").click(function(){
            addInventory(inventory.length);
            $(".load-more").css("display", "none")
        });

        // set input field to ""
        $("#qtyInHand").val("");

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
                        inventory[i]['code'].toString().toLowerCase().indexOf(text) >= 0 ||
                        inventory[i]['dsc'].toString().toLowerCase().indexOf(text) >= 0 /*||
                        inventory[i]['location'].toString().toLowerCase().indexOf(text) >= 0/* ||
                        //inventory[i]['locationGroup'].toString().toLowerCase().indexOf(text) >= 0*/
                    ){
                        var row =
                            "<tr>"+
                            "<td>  <img src= "+ inventory[i]['img']+ " alt='inventory'></td>" +
                            "<td>"+ inventory[i]['code']+ "</td>" +
                            "<td>"+ inventory[i]['dsc']+ "</td>" +
                            "<td>"+ inventory[i]['qty']+ "</td>" +
                            "<td>"+ inventory[i]['uom']+ "</td>" +
                            "<td>"+ inventory[i]['cost']+ "</td>" +
                            '<td><button class="green-b" id='+inventory[i]['id']+' >Buy</button></td>'+
                            '<td><button class="red-b sellBtn" id='+inventory[i]['id']+' >Sold</button> </td>'+
                            '<td><button class="blue-b imgBtn" id='+inventory[i]['id']+'>Add Image</button></td>'+


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
                if (inventory.length<limit)
                    limit = inventory.length;
                for(let i =0; i< limit; i++){
                    var row =
                        "<tr>"+
                        "<td>  <img src= "+ inventory[i]['img']+ " alt='inventory'></td>" +
                        "<td>"+ inventory[i]['code']+ "</td>" +
                        "<td>"+ inventory[i]['dsc']+ "</td>" +
                        "<td>"+ inventory[i]['qty']+ "</td>" +
                        "<td>"+ inventory[i]['uom']+ "</td>" +
                        "<td>$"+ inventory[i]['cost']+ "</td>" +
                        '<td><button class="green-b"><a href="/products/'+inventory[i]['code']+'">Buy</a></button></td>'+
                            '<td><button class="red-b sellBtn" id='+inventory[i]['id']+'  >Sold</button> </td>'+
                            '<td><button class="blue-b imgBtn" id='+inventory[i]['id']+'>Add Image</button></td>'+


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
        addInventory(10);

        //upon entering any text in search field
        $("#search-item").on("input",function(){
            text = $("#search-item").val().toString().toLowerCase();
            search = true;
            addInventory(inventory.length);
            $(".load-more").css("display", "none")
        })

        //to show the no. of total inventories in table footer
        $("#totalInv").text("Total: "+inventory.length);

        // on clicking the sold button
        $(document).on("click",'.sellBtn',function(){
            //store inventory id
            invId = this.id;

            // get specific inventory by id to show its data in modal
            for(let i=0; i < inventory.length; i++){
                if(inventory[i]["id"] == this.id  ){
                    $("#qtyInHand").val( inventory[i]["Qty"]);
                    //set maximum no. of quantities
                    $("#qtyInHand").attr("max",inventory[i]["Qty"]);
                }
            }
        })

        //on clicking the change quantity button
        $("#qtyChange").click(function(){

            document.getElementById("form").submit();
        })

/////////////////////////////////
        $(document).on("click",'.sellBtn',function(){
            modal.style.display = "block"
            prodId = this.id; //get product Id
            prodPrice = this.cost;
            changeQuantity();
            checkzero();
        })
        function checkzero(){
            for(let i=0; i < inventory.length; i++){
                // find the required product
                if(inventory[i]["id"] == prodId  ){
            if(inventory[i]["qty"]<1){
                        alert("You don't have enough of this product to sell, Please restock!");
                        modal.style.display = "none"
                        return 0;}

            if(document.getElementById("qty").value>inventory[i]["qty"]){
                            document.getElementById("qty").value = inventory[i]["qty"];

                        }
        }}}


        function changeQuantity(){
            for(let i=0; i < inventory.length; i++){
                // find the required product
                if(inventory[i]["id"] == prodId  ){
                    $("#prodCode").text( inventory[i]["code"]); // display code of selected product in modal title
                    $("#qty").val(1); // bu default quantity is 1
                    $("#qty").attr("min",1); // minimum quantity is 1
                    $("#qty").attr("max", inventory[i]["qty"]);
                    var price = inventory[i]["cost"]*1.1;
                    document.getElementById("p").value = price.toFixed(2);
                    document.getElementById("id").value = inventory[i]["id"];




                }

            }

        }

        // ---------------------------- Modal to Add Image --------------------------------
        let imgModal = document.querySelector(".addImageModal");

        $(document).on("click",'.imgBtn',function(){
            imgModal.style.display = "block";
            invId = this.id;
            for(let i=0; i < inventory.length; i++){
                if(inventory[i]["id"] == invId ){
                    $("#prodName").text(inventory[i]["code"])
                }
            }
        })

        // close modal btn
        let imgCloseBtn = document.querySelector(".imgCloseBtn");
        imgCloseBtn.onclick = function(){
            imgModal.style.display = "none";
        }

        // on clicking the upload image Btn
        $("#imgAddBtn").click(function(){

            // change image
            for(let i=0; i < inventory.length; i++){
                if(inventory[i]["id"] == invId && imgPrev != null ){
                    inventory[i]["img"] = imgPrev;
                }
            }

            // reload all inventories
            addInventory(10);

            // set image preview to null
            imgPrev = null;

            // close modal
            imgModal.style.display = "none";

            //set image preview to default
            $("#img-upload").attr('src', 'assets/images/imgPreview.png');
            $('#img-upload').css({"border": "none", "box-shadow": "none"} );

            //invalid id to null
            invId = null;

            //return false to prevent page from reloading
            return false;
        })

        // close modal on clicking anywhere outside modal
        window.onclick = function(e){
            if(e.target == document.querySelector(".InvModal")){
                document.querySelector(".InvModal").style.display = "none"
            }
            if(e.target == imgModal){
                imgModal.style.display = "none"
            }
        }

        // ---------------------------- Modal for Quantity In hand --------------------------------
        // modal to change quantity in hand
        let modal = document.querySelector(".InvModal");
        let closeBtn = document.querySelector(".close-btn"); // close btn

        // close the modal on clicking close btn
        closeBtn.onclick = function(){
            modal.style.display = "none"
        }

        // open the modal on clicking the open button


    </script>
</body>
</html>
