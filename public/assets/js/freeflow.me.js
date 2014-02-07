// events
$(function() {

	$('.download').on('click', function() {
		var postName = $(this).data('name');
		ga('send', 'event', 'button', 'click', 'download wallpaper', postName);
	});

	$('.next a').on('click', function() {
		ga('send', 'event', 'button', 'click', 'next');
	});

	$('.prev a').on('click', function() {
		ga('send', 'event', 'button', 'click', 'prev');
	});

});