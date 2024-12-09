if (!window.__page_initialized__) {
    window.__page_initialized__ = true;
    $(document).ready(function () {
        $('#report-generate').on('click',function(){
            if($('#date-from').val() > $('#date-to').val()){
                return;
            }

            if($('#date-from').val() == '' || $('#date-to').val() == ''){
                return;
            }

            type = $('#report-container').data('transaction-module-type');

            if(type == 'income' || type == 'expense' || type == 'budget'){
                sub_url = '/js-request/transaction/income-expense';
            }else if(type == 'purchase'){
                sub_url = '/js-request/transaction/purchase';
            }


            data = {
                account_id:$('#account').val(),
                budget_id:$('#budget').val(),
                date_from:$('#date-from').val(),
                date_to:$('#date-to').val(),
                transacton_type:type
            };

            $.ajax({
                type: "POST",
                url: base_url + sub_url,
                data: data,
                success: function (response) {
                    console.log(response);
                    data = JSON.parse(response);
                    console.log(data['data']['error_message']);
                    console.log(data['success']);
                    if(data['success'] == false){
                        $('#report-container-data').html("<p class='error'>"+data['data']['error_message']+"</p>");
                    }else{
                        $('#report-container-summary').html(data['data']['transaction_summary_container']);
                        $('#report-container-data').html(data['data']['transaction_details_container']);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr)
                    console.log(ajaxOptions)
                    console.log(thrownError)
                }
            });
        });
    });
}