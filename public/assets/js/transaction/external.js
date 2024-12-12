$(document).ready(function(){

    $('#external input[name="expense-type"]').on('click',function(){
        var selection = $(this).val();
        if(selection == 'charity' || selection == 'other'){
            $('#external #description-input').removeClass('d-none');
            $('#external #travel-mode-input').addClass('d-none');
            $('#external #from-location-input').addClass('d-none');
            $('#external #to-location-input').addClass('d-none');

        }else{
            $('#external #description-input').addClass('d-none');
            $('#external #travel-mode-input').removeClass('d-none');
            $('#external #from-location-input').removeClass('d-none');
            $('#external #to-location-input').removeClass('d-none');
        }
    })

    $('#payment-btn').on('click',function(){

        external_pay_type = '';
        description = $('#external #description').val();
        external_data_list = [];

        if($('#external input[name="expense-type"]:checked').val() == 'travel'){
            external_pay_type = 'T';
            external_data_list = {
                travel_mode: $('#external #travel-mode').val(),
                from_location: $('#external #from-location').val(),
                to_location: $('#external #to-location').val()
            }

            description = external_data_list.travel_mode +' - '+ external_data_list.from_location +' - '+ external_data_list.to_location;


        }else if($('#external input[name="expense-type"]:checked').val() == 'charity'){
            external_pay_type = 'C';
        }else{
            external_pay_type = 'O';
        }

        var period = 1;
        var scheduled_info = [];

        if($('#schedule-payment-checkbox').is(':checked')){
            if($('#payment-plan-type').val() != 'I'){
                period = $('#scheduled-payment-period').val();
            }

            scheduled_info = {
                start_date : ($('#payment-plan-start-date').val()) ? $('#payment-plan-start-date').val() : today,
                period:period,
                schedule_type:($('#payment-plan-type').val())?$('#payment-plan-type').val():'I',
                make_initial_payment:($('#init-payment').is(':checked'))?1:0,
            }
        }

        data = {
            amount:($('#external #amount').val() == '')?0:$('#external #amount').val(),
            description: description,
            current_account:$('#external #current-account-list').val(),
            budget:$('#external #budget-list').val(),
            scheduled_info:(scheduled_info != '')?scheduled_info:'',
            external_pay_type: external_pay_type,
            external_data_list: external_data_list
        };
        console.log(data);
    
        $.ajax({
            type: "POST",
            url: base_url + "/js-request/payment/expense",
            data: data,
            success: function (response) {
                if(response.success == false){
                    return;
                }
                window.location.reload();
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