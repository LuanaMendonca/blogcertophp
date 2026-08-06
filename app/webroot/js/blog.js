$(function () {
	$('.message, .flash-message')
		.delay(7000)
		.fadeOut(500);

	$('#filtro-postagens').on('submit', function () {
		$(this).find('input, select').each(function () {
			if ($.trim($(this).val()) === '') {
				$(this).prop('disabled', true);
			}
		});
	});
});
