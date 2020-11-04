function testAnim(x) {
    $('#animationSandbox').removeClass().addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
        $(this).removeClass();
    });
};


$(document).ready(function() {
	testAnim('fadeInUp');
	let max = 0;

	setTimeout(function(){
		$.each($('.img'), function(index, val) {
			let height = $(this).height();
			
			max = (height > max) ? height : max;
		});

		$('.img').height(max);
	}, 500);

});