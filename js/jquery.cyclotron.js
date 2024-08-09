(function ($) {
	$.fn.cyclotron = function (options) {
		var settings = $.extend({
			dampingFactor: 0.93,
			historySize: 5
		}, options);
		return this.each(function () {
			var container, sx, dx = 0, armed, offset = 0, tick, prev, h = [];
			container = $(this);
			var left = container.offset().left;
			var width = container.width();
			container.mousedown(function (e) {
				 sx = e.pageX - offset;
				 armed = true;
				// e.preventDefault();

			});
			container.mousemove(function (e) {








						var offset = e.pageX - left;
						var percentage = offset / width * 100;

						container.css('background-position', percentage + '% 0');




				// var px;
				// if (armed) {
                //
				// 	px = e.pageX;
				// 	if (prev === undefined) {
				// 		prev = px;
				// 	}
				// 	offset = px - sx;
				// 	if (h.length > settings.historySize) {
				// 		h.shift();
				// 	}
				// 	h.push(prev - px);
                //
                //
                //
				// 	imageSrc =  container.css("background-image")
				// 		.replace(/url\((['"])?(.*?)\1\)/gi, '$2')
				// 		.split(',')[0];
				// 	var image = new Image();
				// 	image.src = imageSrc;
                //
				// 	var width = image.width,
				// 		height = image.height;
				// 	console.log(width +" "+ offset);
				// 	container.css('background-position', offset);
                //
				// 	prev = px;
				// }
			});
			container.bind('mouseleave mouseup', function () {
				if (armed) {
					var i, len = h.length, v = h[len - 1];
					for (i = 0; i < len; i++) {
						v = (v * len + (h[i])) / (len + 1);
					}
					dx = v;
				}
				armed = false;
			});
			tick = function () {

				if (!armed && dx) {
					console.log("tick called");
					dx *= settings.dampingFactor;
					offset -= dx;


						container.css('background-position', offset);
						if (Math.abs(dx) < 0.001) {
							dx = 0;

					}
				}
			};
			setInterval(tick, 16);
		});
	};
}(jQuery));