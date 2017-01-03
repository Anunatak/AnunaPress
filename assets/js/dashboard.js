jQuery(document).ready(function($) {

  $('#contact-anunatak-form').on( 'submit', function(e) {
    var name = $(this).find('#contact_name').val();
    var email = $(this).find('#contact_email').val();
    var text = $(this).find('#contact_text').val();

    var $submit_button = $(this).find('#submit');
    var submit_text = $submit_button.val();

    if(!name || !email || !text) {
      $('#error').html('<strong style="color:red">All fields are required.</span>')
      return false;
    }

    $submit_button.prop('disabled', true);
    $submit_button.val('...');

    $.post(ajaxurl, {
      action: 'anunapress_contact_us',
      name: name,
      email: email,
      text: text
    }, function(response) {
      if(response.success) {
        $('#contact-anunatak-form').html('<p>' + response.data +'</p>');
      } else {
        $('#error').html('<strong style="color:red">'+response.data+'</span>')
        $submit_button.prop('disabled', false);
        $submit_button.val(submit_text);
      }

    })

    return false;
  });

});
