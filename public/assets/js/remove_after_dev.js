(function ($, Drupal) {
    'use strict';
  
    /**
     * Twig: templates/cancel_order.html.twig
     **/
  
    var language = '';
    var form_error_state = [];
  
    var addError = (ele, msg) => Drupal.behaviors.o2a_main.addError(ele, msg);
    var removeError = (ele) => Drupal.behaviors.o2a_main.removeError(ele);
  
    Drupal.behaviors.order_cancel = {
      init: function () {
        language = Drupal.behaviors.o2a_main.getMain('language');
      }
    }
  
    $(document).ready(function () {
      Drupal.behaviors.order_cancel.init();
      handleCancellationReason();
            
      if (!drupalSettings.conditional.is_multiple_order) {
        $(".rj-accordion-icon i.fas").trigger('click');
        // jQuery(".rj-accordion-icon i.fas").removeClass("fa-chevron-down").addClass("fa-chevron-up");
      }
  
    });
  
    $(document).on('change', 'input[type=radio][name=radio_stacked]', function(){
      var val = $("input[name=radio_stacked]:checked").val();
      if (val === '6') {
        $('.o2a-order-cancellation #other_reason_input').removeClass('d-none');
        $('.o2a-order-cancellation #other_reason_input #other_reason').attr('required', 'required');
        // $('.summary-item-cancellation_fee').addClass()
      } else {
        $('.o2a-order-cancellation #other_reason_input').addClass('d-none');
        $('.o2a-order-cancellation #other_reason_input #other_reason').removeAttr('required');
        $('#other_reason_input').removeClass('float');
        $('#other_reason').val('');
        $('#other_reason').attr('placeholder',drupalSettings.label.cancellation_reason);
        $('#display_count').text(0);
        var ele = $('#other_reason');
        // $(ele).parent().find(".text-danger").addClass('d-none');
        removeError(ele);
        form_error_state['other_reason'] = false;
  
      }
  
      handleCancellationReason()
    });
  
    // Update he UI depending on the selected cancellation reason
    function handleCancellationReason() {
      // cancellation fee when no cancellation reasons are found
      if($('input[type=radio][name=radio_stacked]').length == 0) {
        $('.order-summary-header .refund-amount').text(drupalSettings.cost.transaction_amount);
        $('.order-summary-header .cancellation-fee').text(drupalSettings.cost.zero_fee);
        $('.order-summary-header .total-cost').text(drupalSettings.cost.total_amount);
        return false;
      }
  
      if($('input[type=radio][name=radio_stacked]:checked').attr('cancellationsfee') == "N") {
        $('.order-summary-header .refund-amount').text(drupalSettings.cost.transaction_amount);
        $('.order-summary-header .cancellation-fee').text(drupalSettings.cost.zero_fee);
        $('.order-summary-header .total-cost').text(drupalSettings.cost.total_amount);
      } else {
        $('.order-summary-header .refund-amount').text(drupalSettings.cost.refund_amt);
        $('.order-summary-header .cancellation-fee').text(drupalSettings.cost.cancellation_fee);
        $('.order-summary-header .total-cost').text(drupalSettings.cost.total_amount);
      }
    }
  
    // filed validations ----------------------------------------------------------------------------------
    function validateField(ele, errorMsg, hasCheckType, checkType, typeErrorMsg) {
      var element = $(`#${ele}`);
      var eleVal = $.trim(element.val());
      if (eleVal == '') {
        // $(element).parent().find(".text-danger").removeClass('d-none');
        form_error_state[ele] = true;
  
        return addError(element, errorMsg);
      } else {
        if (hasCheckType == 'has') {
          if (checkType == 'string') {
            var pat =/^[A-Za-z ]+$/;
            if (ele == 'ac_holder_name') {
              pat =/^[A-Za-z. ]+$/;
            }
            if (pat.test(eleVal)) {
              // $(element).parent().find(".text-danger").addClass('d-none');
              removeError(element);
              form_error_state[ele] = false;
  
            } else {
              // $(element).parent().find(".text-danger").removeClass('d-none');
              form_error_state[ele] = true;
  
              return addError(element, typeErrorMsg);
            }
          } else if (checkType == 'number') {
            if (!isNaN(eleVal)) {
              // $(element).parent().find(".text-danger").addClass('d-none');
              removeError(element);
              form_error_state[ele] = false;
  
            } else {
              // $(element).parent().find(".text-danger").removeClass('d-none');
              form_error_state[ele] = true;
  
              return addError(element, typeErrorMsg);
            }
          } else if (checkType == 'alphanumeric') {
            if (/^[A-Za-z0-9 ]+$/i.test(eleVal)) {
              // $(element).parent().find(".text-danger").addClass('d-none');
              removeError(element);
              form_error_state[ele] = false;
  
            } else {
              // $(element).parent().find(".text-danger").removeClass('d-none');
              form_error_state[ele] = true;
  
              return addError(element, typeErrorMsg);
            }
          }
        } else {
          // $(element).parent().find(".text-danger").addClass('d-none');
          removeError(element);
          form_error_state[ele] = false;
  
        }
      }
    }
  
    $(document).on('blur','#other_reason', () => {
      validateField('other_reason', drupalSettings.error_messages.o2a_cancel_reason, 'hasnot', '', ''); // element, errormsg, hasCheckType, checkType, typeErrorMsg
    })
  
    $(document).on('click', '#other_reason', () => {
      removeError($('#other_reason'));
    });
  
    $(document).on('blur', '#ac_holder_name', () => {
      validateField('ac_holder_name', drupalSettings.error_messages.o2a_account_holder_required, 'has', 'string', drupalSettings.error_messages.o2a_ac_holder_alphabet); // element, errormsg, hasCheckType, checkType, typeErrorMsg
    });
  
    $(document).on('blur', '#name_of_bank', () => {
      validateField('name_of_bank', drupalSettings.error_messages.o2a_bank_name_required, 'hasnot', '', ''); // element, errormsg, hasCheckType, checkType, typeErrorMsg
    });
  
    $(document).on('blur', '#ac_number', () => {
      validateField('ac_number', drupalSettings.error_messages.o2a_account_number_required, 'has', 'number', drupalSettings.error_messages.o2a_ac_num_digit); // element, errormsg, hasCheckType, checkType, typeErrorMsg
    });
  
    $(document).on('blur', '#alt_contact_num', () => {
      var t = validateField('alt_contact_num', drupalSettings.error_messages.o2a_contact_required, 'has', 'number', drupalSettings.error_messages.o2a_contact_digits); // element, errormsg, hasCheckType, checkType, typeErrorMsg
  
      // skip other validation if already has error
      if($('#alt_contact_num').val() == ''){
        return false;
      }
  
  
      $('#loading-s').removeClass('d-none');
      $('#submit_cancel_order').addClass('d-none');
  
      let mobileNum = $('#alt_contact_num');
      // Ajax
      $.ajax({
        url: '/api/o2a/validate-mobile-number?number='+mobileNum.val()+'&lang='+language,
        type: 'GET',
        success: function (res) {
          if (res.success == false) {
            addError(mobileNum, drupalSettings.error_messages.o2a_s2_invalid_mob_number);
            // $('#alt_contact_num').siblings('small').removeClass('d-none');
            form_error_state['alt_contact_num'] = true;
          } else {
            removeError(mobileNum);
            // $('#alt_contact_num').siblings('small').addClass('d-none');
            form_error_state['alt_contact_num'] = false;
          }
          $('#loading-s').addClass('d-none');
          $('#submit_cancel_order').removeClass('d-none');
  
        },
        fail: function () {
          $('#loading-s').addClass('d-none');
  
          console.error('api error')
        }
      });
    });
  
    $(document).on('blur', '#bank_branch', () => {
      validateField('bank_branch', drupalSettings.error_messages.o2a_bank_branch_required, 'has', 'alphanumeric', drupalSettings.error_messages.o2a_branch_alphanumeric); // element, errormsg, hasCheckType, checkType, typeErrorMsg
    });
  
    $(document).on('blur', '#branch_code', () => {
      validateField('branch_code', drupalSettings.error_messages.o2a_branch_code_required, 'has', 'alphanumeric', drupalSettings.error_messages.o2a_branch_code_alphanumeric); // element, errormsg, hasCheckType, checkType, typeErrorMsg
    });
  
    // $(document).on('blur', '#other_reason', () => {
    //   validateField('other_reason', drupalSettings.error_messages.o2a_cancel_reason, 'hasnot', '', ''); // element, errormsg, hasCheckType, checkType, typeErrorMsg
    // });
  
    $(document).on('change', 'input#agree_tc', function(){
      if($(this).is(":checked")) {
        form_error_state['tnc'] = false;
        removeError($('.tnc-error'));
        $('.tnc-error-wrapper .icon').removeClass('invalid-icon');
      }
    })
  
    // Collect data and Call the cancellation endpoint
    function callCancelOrder() {
      $('#confirm-to-order-cancel-modal').modal('hide')
      var selected_reason = $('input[type=radio][name=radio_stacked]:checked');
      var cancellation_reasons = '';
  
      if ($('#other_reason').val() != '') {
        cancellation_reasons = $('#other_reason').val();
      } else {
        cancellation_reasons = $(selected_reason).next('label').text().trim();
      }
  
      var account_name = '';
      var bank_name = '';
      var account_number = '';
      var branch_name = '';
      var branch_code = '';
  
      if ($('#ac_holder_name').val() == undefined) {
        account_name = 'NA';
      } else {
        account_name = $('#ac_holder_name').val();
      }
       
      if ($('#name_of_bank').val() == undefined) {
        bank_name = 'NA';
      } else {
        bank_name = $('#name_of_bank').val();
      }
      
      if ($('#ac_number').val() == undefined) {
        account_number = 'NA';
      } else {
        account_number = $('#ac_number').val();
      }
      
      if ($('#bank_branch').val() == undefined) {
        branch_name = 'NA';
      } else {
        branch_name = $('#bank_branch').val();
      }
  
      if ($('#branch_code').val() == undefined) {
        branch_code = 'NA';
      } else {
        branch_code = $('#branch_code').val();
      }
  
      var post_data = {
        order_id: $('.o2a-order-cancellation').attr('om_order_id'),
        // session_id: drupalSettings.session_id,
        account_name: account_name,
        bank_name: bank_name,
        account_number: account_number,
        branch_name: branch_name,
        branch_code: branch_code,
        contact_number: $('#alt_contact_num').val(),
        cancellation_reason_text: cancellation_reasons,
        cancellation_reason_code: $(selected_reason).val() ,
        cancellation_fee_applicable: $(selected_reason).attr('cancellationsfee'),
        cancellation_fee: $('.order-summary-header .cancellation-fee').text().replace('Rs.', '').trim(),
        refund_amount: $('.order-summary-header .refund-amount').text().replace('Rs.', '').trim(),
      };
  
      $.ajax({
        url: '/api/o2a/cancel-order',
        type: 'POST',
        data: post_data,
        success: function (res) {
          $("#submit_cancel_order").removeClass('d-none');
          $('#loading-s').addClass('d-none');
  
          if(res.success == false) {
            $('.cancel-api-error').text(res.message);
            $('.cancel-error-wrapper').removeClass('d-none').addClass('d-flex');
            console.error(res);
  
          } else {
            $('#confirm-order-cancel-modal').modal({ show: true, backdrop: 'static', keyboard: false });
          }
        },
        fail: function () {
          $("#submit_cancel_order").removeClass('d-none');
          $('#loading-s').addClass('d-none');
          console.error('api error')
        }
      });
    }
  
    // when click on other Radio Button limit the words in textarea
    $(document).on('keyup', '.word_count', function () {
      var words = 0;
  
      if ((this.value.match(/\S+/g)) != null) {
        words = this.value.match(/\S+/g).length;
      }
  
      if (words > 140) {
        // Split the string on first 140 words and rejoin on spaces
        var trimmed = $(this).val().split(/\s+/, 140).join(" ");
        // Add a space at the end to make sure more typing creates new words
        $(this).val(trimmed + " ");
      }else {
        $('#display_count').text(words);
      }
    });
  
    $(document).on('click', '#submit_cancel_order', function () {
  
      // Ignore when button is disabled , when to cancellation reasons are availble
      if($(this).hasClass('disabled')) {
        return false;
      }
  
      var redVal = $("input[name=radio_stacked]:checked").val();
      // Reason Cancel Other - 6
      if (redVal === '6') {
        validateField('other_reason', drupalSettings.error_messages.o2a_cancel_reason, 'hasnot', '', '');
      } else {
        var ele = $('#other_reason');
        // $(ele).parent().find(".text-danger").addClass('d-none');
        removeError(ele);
        form_error_state['other_reason'] = false;
      }
  
      if (!drupalSettings.conditional.bank_details_hide) {
        validateField('ac_holder_name', drupalSettings.error_messages.o2a_account_holder_required, 'has', 'string', drupalSettings.error_messages.o2a_ac_holder_alphabet);
        validateField('name_of_bank', drupalSettings.error_messages.o2a_bank_name_required, 'hasnot', '', '');
        validateField('ac_number', drupalSettings.error_messages.o2a_account_number_required, 'has', 'number', drupalSettings.error_messages.o2a_ac_num_digit);
        validateField('bank_branch', drupalSettings.error_messages.o2a_bank_branch_required, 'has', 'alphanumeric', drupalSettings.error_messages.o2a_branch_alphanumeric);
        validateField('branch_code', drupalSettings.error_messages.o2a_branch_code_required, 'has', 'alphanumeric', drupalSettings.error_messages.o2a_branch_code_alphanumeric);
      }
      validateField('alt_contact_num', drupalSettings.error_messages.o2a_contact_required, 'has', 'number', drupalSettings.error_messages.o2a_contact_digits);
      var termsChek = $('input#agree_tc').is(':checked');
      if (!termsChek) {
        form_error_state['tnc'] = true;
        addError($('.tnc-error'), drupalSettings.error_messages.o2a_tnc_required);
        $('.tnc-error-wrapper .icon').addClass('invalid-icon');
      }
  
      // Check for error and dont submit form
      if(Object.values(form_error_state).indexOf(true) > -1) {
        return false;
      }
  
      $('#confirm-to-order-cancel-modal').modal('show');
    });
  
    $(document).on('click', '#confirm-accepted-btn', function () {
      $('#submit_cancel_order').addClass('d-none');
      $('#loading-s').removeClass('d-none');
      $('.cancel-error-wrapper').removeClass('d-flex').addClass('d-none');
      callCancelOrder();
    });
  
    $(document).on('click', '#confirm-cancel-btn', function () {
      $('#confirm-to-order-cancel-modal').modal('hide');
    });
  
    $(document).on('click keyup','.wrap-input-set input[type="text"]',function() {
      var element_id = '#'+$(this).attr('id');
      // $(element_id).parent().find(".text-danger").addClass('d-none');
      removeError(element_id);
      form_error_state[$(this).attr('id')] = false;
    });
  
    $(document).on('input', '#ac_holder_name', function() {
      $(this).val($(this).val().replace(/([-,.€~!@#0-9$%^&*()_+=/?"`{}\[\]\|\\:;'<>])+/g, ''));
    });
  
    $(document).on('input', '#name_of_bank', function() {
      $(this).val($(this).val().replace(/([-,.€~!@#$%^&*()_+=/?"`{}\[\]\|\\:;'<>])+/g, ''));
    });
    
    $(document).on('input', '#bank_branch', function() {
      $(this).val($(this).val().replace(/([-,.€~!@#$%^&*()_+=/?"`{}\[\]\|\\:;'<>])+/g, ''));
    });
  
    $(document).on('input', '#branch_code', function() {
      $(this).val($(this).val().replace(/([-,.€~!@# $%^&*()_+=`/?"{}\[\]\|\\:;'<>])+/g, ''));
    });
    
    $(document).on('input', '#ac_number', function() {
      $(this).val($(this).val().replace(/([-,.€~!@#A-Za-z $%^/?"&*()_+=`{}\[\]\|\\:;'<>])+/g, ''));
    });
    
    $(document).on('input', '#alt_contact_num', function () {
      $(this).val($(this).val().replace(/([-,.€~!@#A-Za-z $%^&*()_+=`{}\[\]\|\\:;'<>])+/g, ''));
    });
    
    function mobileValidation(mobileNum, mobileRegex, id) {
      mobileNum.val(mobileNum.val().replace(/[^\d]/g, ''));
      let value = mobileNum.val();
      removeError(mobileNum);
      if (mobileRegex.test(value)) {
        removeError(mobileNum);
        // $('#alt_contact_num').siblings('small').addClass('d-none');
        selected_number = mobileNum.val();
      } else {
        addError(mobileNum, drupalSettings.error_messages.o2a_s2_invalid_mob_number);
        // $('#alt_contact_num').siblings('small').removeClass('d-none');
      }
    }
  
  })(jQuery, Drupal)
  