$(document).ready(function(){
    $('.payment-check').on('change',function(){

        if($(this).is(':checked')){
            if($('#dued #amount').val() == ''){ $('#dued #amount').val(0); }
            total = (parseFloat($('#dued #amount').val()) + parseFloat($(this).val()));
            $('#dued #amount').val(total);
            // $(this).parent().parent().addClass('d-none');
        }else{
            total = (parseFloat($('#dued #amount').val()) - parseFloat($(this).val()));
            $('#dued #amount').val(total);
            if($('#dued #amount').val() == ''){ $('#dued #amount').val(0); }
            // $(this).parent().parent().removeClass('d-none');
        }
    });

    $('#dued #payment-btn').on('click',function(){
        var amount = $('#dued #amount').val();
        var description = $('#dued #description').val();
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

        payment_list = [];
        $('#dued .payment-check').each(function(){
            if($(this).is(':checked')){
                paymentChecked = {
                    payment_id: $(this).attr('id'),
                    amount: $(this).val()
                }

                payment_list.push(paymentChecked);

            }
        });
        
        console.log(payment_list);

        if(payment_list.length > 0){
            data = {
                account_id: $('#to-account-list').val(),
                budget_id: $('#budget-list').val(),
                description: description,
                amount: amount,
                payment_list: payment_list
            };
            $.ajax({
                type: "POST",
                url: base_url + "/js-request/payment/dued",
                data: data,
                dataType: "json",
                success: function (response) {
                    if(response.status == 'success'){
                        location.reload();
                    }        
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr)
                    console.log(ajaxOptions)
                    console.log(thrownError)
                }
            });
        }

    });
});