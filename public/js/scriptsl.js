$(document).ready(function(){

    // when input box is focused
    $("input").focusin(function(){
        $(this).parent().addClass("inp-ani"); //input animation class 
        $(this).siblings("i").css({"color":"#4caf50"}) //icons color to green
    })

    // when focus out from input box
    $("input").focusout(function(){
        $(this).parent().css({"box-shadow":" 0px 0px 9px #bdbdbd"});
        $(this).parent().removeClass("inp-ani"); //input animation class removed
        if($(this).val() == ""){ //if input is empty
            $(this).siblings("i").css({"color":"gray"}); //icon colors to grey
        }
    })

    // hide password
    $(".pass.fa-eye").on("click",showHidePass)

    // show password
    $(".pass.fa-eye-slash").on("click",showHidePass)

    function showHidePass(){
        if(this.classList.contains("fa-eye-slash")){
            // show password
            $(this).siblings("input").attr("type","text");
            // chage close eye to open eye
            $(this).addClass("fa-eye")
            $(this).removeClass("fa-eye-slash")
        }else{
            // hide password
            $(this).siblings("input").attr("type","password")
            // chage open eye to close eye
                $(this).addClass("fa-eye-slash")
                $(this).removeClass("fa-eye")
        }
    }

    //nav bar
    $(".nav-link").on("click", function(){
        // $(this).parent("div").addClass("active-link");
        $(".nav-item").removeClass("active-item")
        $(this.parentNode).addClass('active-item');
    })

    // responsive nav
    $(".nav-res-icon").on("click", function(){
        $(".nav-res-icon").toggleClass("left");
        $(".nav-res-icon").toggleClass("right");
        $(".navbar").toggleClass("d-res-none")
        $(".navbar").toggleClass("d-res-block")
    })
    
})

