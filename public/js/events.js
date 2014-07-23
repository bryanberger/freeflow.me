// events
$(function() {

	$('.download').on('click', function() {
		var postName = $(this).data('name');
		ga('send', 'event', 'button', 'download', postName);
	});

	$('.next a').on('click', function() {
		ga('send', 'event', 'button', 'click', 'next');
	});

	$('.prev a').on('click', function() {
		ga('send', 'event', 'button', 'click', 'prev');
	});

	$('.extras a').on('click', function() {
		ga('send', 'event', 'button', 'click', 'extras');
	});

	$('.checkout').on('click', function() {
		ga('send', 'event', 'button', 'click', 'checkout');
	});

	$('.addtocart').on('click', function() {
		ga('send', 'event', 'button', 'addtocart', $(this).data('id')+"_"+$(this).data('size'));
	});

	$('.remove-product').on('click', function() {
		ga('send', 'event', 'button', 'click', 'remove');
	});

})