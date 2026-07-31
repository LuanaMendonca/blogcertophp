$(function () {
	var $message = $('.message');

	if ($message.length) {
		setTimeout(function () {
			$message.fadeOut(500);
		}, 4000);
	}
});
