$(document).ready(function(){

    $('#income input[name="income-type"]').on('click',function(){
        var selection = $(this).val();
        if(selection == 'one-time'){
            $('#income #initate-date').addClass('d-none');
            $('#income #until-period').addClass('d-none');
            $('#income #until-date').addClass('d-none');
            $('#income #first-payment-section').addClass('d-none');
        }else if(selection == 'monthly'){
            $('#income #initate-date').removeClass('d-none');
            $('#income #until-period').addClass('d-none');
            $('#income #until-date').addClass('d-none');
            $('#income #first-payment-section').removeClass('d-none');
        }else{
            $('#income #initate-date').removeClass('d-none');
            $('#income #until-period').removeClass('d-none');
            $('#income #until-date').removeClass('d-none');
            $('#income #first-payment-section').removeClass('d-none');
        }
    });

    $('#income input[name="first-payment"]').on('click',function(){
        if($(this).is(':checked')){
            var today = new Date().toISOString().slice(0, 10);
            $('#start-date').val(today);
            $('#start-date').addClass('disabled').attr('disabled',true);
            // $('#first-payment-section').removeClass('d-none');
        }else{
            $('#start-date').removeClass('disabled').attr('disabled',false);
            // $('#first-payment-section').addClass('d-none');
        }
    })

    $('#income #payment-btn').on('click',function(){
        console.log('clicked');
        var amount = $('#income #amount').val();
        var description = $('#income #description').val();
        console.log(amount);
        if(amount == '' || amount == 0){
            $('#common-error').text('Please enter amount');
            return;
        }

        console.log(description);
        if(description == ''){
            $('#common-error').text('Please enter description');
            return;
        }

        var type = $('input[name="income-type"]:checked').val();
        var collectionPlan = [];
        console.log(collectionPlan);
        if(type == 'till'){
            var date = $('#start-date').val();
            var planType = $('#until-plan-type').val();
            var paymentPeriod = $('#until-payment-period').val();
            collectionPlan = {
                schedule_type: planType,
                period: paymentPeriod,
                start_date: date,
                make_initial_payment : $('#first-payment').is(':checked')
            }
            
        }else if(type == 'monthly'){
            var date = $('#start-date').val();
            collectionPlan = {
                start_date: date,
                schedule_type: 'C',
                make_initial_payment : $('#first-payment').is(':checked')
            }
        }

        data = {
            amount: amount,
            description: description,
            account_id: $('#current-account-list').val(),
            budget_id: $('#budget-list').val(),
            collection_plan: collectionPlan,
            type: type
        };

        $.ajax({
            type: "POST",
            url: base_url + "/js-request/payment/income",
            data: data,
            success: function (response) {
                if(response.success == false){
                    return;
                }
                // console.log(response);
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr)
                console.log(ajaxOptions)
                console.log(thrownError)
            }
        });
    });
});