$(document).ready(function(){
    function currentMenuActive(menu_id) {
        console.log(menu_id);
        $('.menu-item-list .active').removeClass('active');
        $('#'+menu_id).addClass('active');
    }
});
