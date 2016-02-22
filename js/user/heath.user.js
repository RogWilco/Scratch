// ==UserScript==
// @name            Heath Ceramics - Overstock Improvements
// @description     Adds color and shape previews to the overstock list for Heath ceramic tile.
// @author          Nick Williams <rogwilco@gmail.com>
// @namespace       http://github.com/rogwilco
//
// @include         http://www.heathceramics.com/home/pages/tile-build/designing-with-heath-tile/overstock-tile
//
// @require         http://code.jquery.com/jquery-1.8.0.min.js
//
// @version         1.0.0
// ==/UserScript==

(function($) {
	// Retrieve Color Image List
	$.get('http://www.heathceramics.com/home/pages/tile-build/designing-with-heath-tile/color-palette', function(data) {
		var colorImages = {};
		var shapeImages = {};

		$(data).find('.tileColor').each(function() {
			var colorCode = $(this).parent().children('strong.forgotPasswordText').html().replace(/ /g,'');
			var colorThumb = $(this).find('img[width=49]').attr('src');
			var colorFull = $(this).find('img[width=90]').attr('src');

			colorImages[colorCode] = {
				thumb: colorThumb,
				full: colorFull
			}
		});
        
        console.log(colorImages);

		// Insert Additional Details
		$('.contenttable td.td-0').each(function() {
			var colorMeta = $(this).html().match(/<strong>.*<\/strong>.*<br>.*<br>(.*)/i);

			var colorCode = colorMeta[1];
			var colorThumb = '';

			if (colorImages[colorCode]) {
				colorThumb = colorImages[colorCode].thumb;
			}

			$(this).prepend('<div style="float: left; margin-right: 2em;"><img src="' + colorThumb + '" width="49" height="49" /></div>');
		});
	});
})(jQuery);
