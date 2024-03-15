"use strict";
var moller_magnifier_vars;
var yith_magnifier_options = {
		sliderOptions: {
			responsive: moller_magnifier_vars.responsive,
			circular: moller_magnifier_vars.circular,
			infinite: moller_magnifier_vars.infinite,
			direction: 'left',
			debug: false,
			auto: false,
			align: 'left',
			height: 'auto',
			prev    : {
				button  : "#slider-prev",
				key     : "left"
			},
			next    : {
				button  : "#slider-next",
				key     : "right"
			},
			scroll : {
				items     : 1,
				pauseOnHover: true
			},
			items   : {
				visible: Number(moller_magnifier_vars.visible),
			},
			swipe : {
				onTouch:    true,
				onMouse:    true
			},
			mousewheel : {
				items: 1
			}
		},
		showTitle: false,
		zoomWidth: moller_magnifier_vars.zoomWidth,
		zoomHeight: moller_magnifier_vars.zoomHeight,
		position: moller_magnifier_vars.position,
		lensOpacity: moller_magnifier_vars.lensOpacity,
		softFocus: moller_magnifier_vars.softFocus,
		adjustY: 0,
		disableRightClick: false,
		phoneBehavior: moller_magnifier_vars.phoneBehavior,
		loadingLabel: moller_magnifier_vars.loadingLabel,
	};