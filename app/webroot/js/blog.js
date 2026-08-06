$(function () {
	$('.message, .flash-message')
		.delay(7000)
		.fadeOut(500);

	$('.campo-data').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,
		todayHighlight: true,
		enableOnReadonly: true
	});

	$('.campo-data').on('keydown paste', function (event) {
		event.preventDefault();
	});
});
