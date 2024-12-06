$(document).ready(function(){
    // pagination no click
    $('.page-list').on('click',function(){
        transaction_type = $(this).parent().parent().attr('pagination-type');

        $('.'+transaction_type+' .page-list').parent().removeClass('active');
        $(this).parent().addClass('active');
        
        
        // return;

        // $('.page-list').parent().removeClass('active');
        // $(this).parent().addClass('active');
        
        if($(this).parent().hasClass('first')){
            $(this).closest('ul').find('.previous-page').parent().addClass('disabled').attr('disabled',true);
            $(this).closest('ul').find('.next-page').parent().removeClass('disabled').attr('disabled',false);
        }else if($(this).parent().hasClass('last')){
            console.log('last');
            $(this).closest('ul').find('.previous-page').parent().removeClass('disabled').attr('disabled',false);
            $(this).closest('ul').find('.next-page').parent().addClass('disabled').attr('disabled',true);
        }else{
            $(this).closest('ul').find('.previous-page').parent().removeClass('disabled').attr('disabled',false);
            $(this).closest('ul').find('.next-page').parent().removeClass('disabled').attr('disabled',false);
        }
        $('.t-row-'+transaction_type+'-action').addClass('d-none');
        $('.t-row-'+transaction_type+'-action[data-page-no="'+$(this).attr('id')+'"]').removeClass('d-none');

    });

    // pagination click previous
    $('.previous-page').on('click',function(){
        transaction_type = $(this).parent().parent().attr('pagination-type');

        $('.'+transaction_type+' .page-item.active').prev().find('.page-list').click();
    });

    // pagination click next
    $('.next-page').on('click',function(){
        transaction_type = $(this).parent().parent().attr('pagination-type');
        $('.'+transaction_type+' .page-item.active').next().find('.page-list').click();
    });
});