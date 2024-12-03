$(document).ready(function(){
    $('#account-name').on('focusin',function(){
        $('.error-message').html("&nbsp;");
    });
    
    $('#amount').on('focusout',function(){
        //  TODO:: currently no decimal places are allowed, need to fix this for 2 decimal places
        $(this).val().replace(/[^0-9]/g, '');
        
        if($(this).val() == ''){$(this).val(0);}

        $('#amount').val(parseFloat($(this).val()).toFixed(2));
        
        if($(this).val() != '' && $(this).val() != '0.00'){
            $('.error-message').html("&nbsp;");
        }
    });

    // create account click
    $('#create-account-btn').on('click',function(){

        if($('#account-name').val() == ''){
            $('.error-message').text('* Name is required');
            return;
        }

        if($('#amount').val() == '' || $('#amount').val() == '0.00'){
            $('.error-message').text('* Amount is required');
            return;
        }
        $.ajax({
            type: "POST",
            url: "js-request/account/create",
            data: {
                groupID:$('#account-group-list').val(),
                accountName:$('#account-name').val(),
                amount:$('#amount').val(),
            },
            success: function (data) {
                window.location.reload();
            }
        });
    });

    // pagination no click
    $('.page-list').on('click',function(){
        $('.page-list').parent().removeClass('active');
        $(this).parent().addClass('active');
        
        if($(this).parent().hasClass('first')){
            $('.previous-page').parent().addClass('disabled').attr('disabled',true);
            $('.next-page').parent().removeClass('disabled').attr('disabled',false);
        }else if($(this).parent().hasClass('last')){
            $('.previous-page').parent().removeClass('disabled').attr('disabled',false);
            $('.next-page').parent().addClass('disabled').attr('disabled',true);
        }else{
            $('.previous-page').parent().removeClass('disabled').attr('disabled',false);
            $('.next-page').parent().removeClass('disabled').attr('disabled',false);
        }
        $('.t-row-acount-action').addClass('d-none');
        $('.t-row-acount-action[data-page-no="'+$(this).attr('id')+'"]').removeClass('d-none');

    });

    // pagination click previous
    $('.previous-page').on('click',function(){
        $('.page-item.active').prev().find('.page-list').click();
    });

    // pagination click next
    $('.next-page').on('click',function(){
        $('.page-item.active').next().find('.page-list').click();
    });
});