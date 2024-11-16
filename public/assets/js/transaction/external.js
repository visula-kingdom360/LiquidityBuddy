$(document).ready(function(){
    $('#payment-btn').on('click',function(){

        if($('#external input[name="expense-type"]:checked').val() == 'travel'){
        // }else{
        }

        var period = 1;
        var scheduled_info = [];

        if($('#schedule-payment-checkbox').is(':checked')){
            if($('#payment-plan-type').val() != 'I'){
                period = $('#scheduled-payment-period').val();
            }
            // schedule_type = $('#payment-plan-type').val();

            scheduled_info = {
                start_date : ($('#payment-plan-start-date').val()) ? $('#payment-plan-start-date').val() : today,
                period:period,
                schedule_type:($('#payment-plan-type').val())?$('#payment-plan-type').val():'I'
            }
        }

        data = {
            amount:($('#external #amount').val() == '')?0:$('#external #amount').val(),
            description:$('#external #description').val(),
            current_account:$('#external #current-account-list').val(),
            budget:$('#external #budget-list').val(),
            scheduled_info:(scheduled_info != '')?scheduled_info:''
        };
        console.log(data);
    
        $.ajax({
            type: "POST",
            url: "js-request/payment/expense",
            data: data,
            success: function (response) {

            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr)
                console.log(ajaxOptions)
                console.log(thrownError)
            }

        });

        $('#to-transaction-type').val();
        $('#to-running-balance').val();
    });
});