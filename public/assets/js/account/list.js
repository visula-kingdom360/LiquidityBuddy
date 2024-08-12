$(document).ready(function(){
    $('#current-account-list, #to-account-list').on('change',function(){
        if($(this).hasClass('current-account-list')){
            account_list_id = 'to-account-list';
            currnet_running_balance_id = 'current-running-balance';
        }else if($(this).hasClass('to-account-list')){
            account_list_id = 'current-account-list';
            currnet_running_balance_id = 'to-running-balance';
        }

        $('#'+currnet_running_balance_id).val($(this).find('option:selected').data('running-balance'));
        $('#'+account_list_id + ' .d-none').removeClass('d-none');
        $('#'+account_list_id + ' .'+$(this).val()).addClass('d-none');
    });

    $('.select-transction-type').on('click',function () {
        if($(this).hasClass('active')){
           return; 
        }
        transid = $(this).attr('transaction-type');
        
        $('.transaction-type-list').each(function() {
            // Your code here, using `this` to refer to the current element
            if(!$(this).hasClass('d-none')){
                $(this).addClass('d-none');
            }
        });

        $('.active').removeClass('active');
        $(this).addClass('active');
        $('#'+transid).removeClass('d-none');
    });

    $('#amount').on('input',function() {
        $(this).val($(this).val().replace(/[^\d]/g, ''));
    });

    $('#transferred').on('click',function(){
        runningBalance = Number($('#transaction-type').val() == 'expense') ? $('#current-running-balance').val().replace(',','').replace('.00','') : $('#to-running-balance').val().replace(',','').replace('.00','');
        
        if(runningBalance < Number($('#amount').val())){
            console.log('Transaction exceeded');
            return;
        }
    
        $.ajax({
            type: "POST",
            url: "js-request/account/transferred",
            data: {
                amount:($('#amount').val() == '')?0:$('#amount').val(),
                transaction_type:$('#transaction-type').val(),
                from_account:$('#current-account-list').val(),
                to_account:$('#to-account-list').val(),
            },
            success: function (response) {
                // console.log(response);
                // var data = $.parseJSON(response);
                
                // if(data['category'] == 'Data_Issue'){
                //     console.log(data['error_message']);
                // }else{
                //     var base_url = data['baseURL'];
                //     var segment_list = data['screenMaps'];

                //     segment_list.forEach((segments) => {
                //         segmentList += '<a class=" btn btn-segment" href="'+base_url+segments['ScreenURL']+'">'+segments['ScreenTitle']+'</a>';
                //     });

                //     $('.merchent-body').html(segmentList);
                // }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr)
                console.log(ajaxOptions)
                console.log(thrownError)
            }

        });


        // $('#amount').val();
        // $('#current-transaction-type').val();
        // $('#current-running-balance').val();
        $('#to-transaction-type').val();
        $('#to-running-balance').val();
    });

    // $('#create-transaction').on('click',function(){
    //     console.log($('#description').val());
    //     console.log($('#amount').val());
    //     console.log($('#transaction-type').val());
    //     console.log($('#account-list').val());
    // });
});