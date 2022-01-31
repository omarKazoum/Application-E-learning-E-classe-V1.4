var hidden=false;
$('.btn-toggle-sidebar').css("transform", "rotate(90deg)");
$(function(){
    $('.btn-toggle-sidebar').on("click",function(){

        $('.sidebar').slideToggle(1000);
        if(hidden) {
            $(".content").removeClass('col-12');
            $(".content").addClass('col-9');
            $('.btn-toggle-sidebar').css("transform", "rotate(90deg)");
        }else{
            $('.btn-toggle-sidebar').css("transform", "rotate(-90deg)");
            $(".content").removeClass('col-9');
            $(".content").addClass('col-12');
        }
        hidden=!hidden;
        })
})