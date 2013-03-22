/*
	Scripts
*/
$(document).ready(function() {

	$('button#subscribe-btn').click(function() {

		$('#subscribe-form .control-group').removeClass('error');
		$('p.status').hide();

		var emailAddress = $('input[name="emailAddress"]').val();

		if(isEmail(emailAddress)) {

			$.ajax({
				url: 'lib/mailchimp.php',
				type: 'POST',
				data: {
					email: emailAddress
				},
				success: function(data){
					if(data.code === 200) {
						$('.subscribe form').fadeOut();
						$('.subscribe .success').fadeIn();
					} else {
						$('p.status').text(data.error).fadeIn();
					}
				},
				error: function() {
					$('p.status').text('A communication error has occured. Please try again.').fadeIn();
				}
			});

		} else {

			$('#subscribe-form .control-group').addClass('error');

		}

		return false;

	});

});

function isEmail(email) {
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}