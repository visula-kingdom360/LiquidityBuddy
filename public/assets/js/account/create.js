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
            url: base_url + "/js-request/account/create",
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
});