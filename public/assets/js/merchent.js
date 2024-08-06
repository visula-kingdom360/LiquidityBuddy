$(document).ready(function(){
    // $('.merchent-menu .active').one('click', function() {
    //     console.log('Terse');
    // });

    // if(!$('.menu-link').hasClass('active')){
    //     // $('.menu-link').removeClass('active');
    //     $('.menu-link').addClass('active');

    //     selected_id =$('.menu-link').attr('id');
    //     selectedMenu(selected_id);
    // }

    $('.menu-link').on('click',function () {
        if(!$(this).hasClass('active')){
            $('.menu-link').removeClass('active');
            $(this).addClass('active');

            selected_id =$(this).attr('id');
            selectedMenu(selected_id);
        }
    });
    
    function selectedMenu(selected_id) {
        console.log('test');
        segmentList = '';
    
        $.ajax({
            type: "POST",
            url: "js-request/segment-list",
            data: {
                merc_menu_id:selected_id,
            },
            success: function (response) {
                var data = $.parseJSON(response);
                
                if(data['category'] == 'Data_Issue'){
                    console.log(data['error_message']);
                }else{
                    var base_url = data['baseURL'];
                    var segment_list = data['screenMaps'];

                    segment_list.forEach((segments) => {
                        segmentList += '<a class=" btn btn-segment" href="'+base_url+segments['ScreenURL']+'">'+segments['ScreenTitle']+'</a>';
                    });

                    $('.merchent-body').html(segmentList);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr)
                console.log(ajaxOptions)
                console.log(thrownError)
            }

        });
    }

    function decimalVal(inputID){
        $(inputID).val($(inputID).val().replace(/([-,.€~!@#A-Za-z $%^&*()_+=`{}\[\]\|\\:;'<>])+/g, ''));
    }
    // $(document).on('input', '#alt_contact_num', function () {
    //     $(this).val($(this).val().replace(/([-,.€~!@#A-Za-z $%^&*()_+=`{}\[\]\|\\:;'<>])+/g, ''));
    //   });
});