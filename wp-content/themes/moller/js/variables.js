		"use strict";
		var moller_brandnumber = 6,
			moller_brandscrollnumber = 1,
			moller_brandpause = 3000,
			moller_brandanimate = 2000;
		var moller_brandscroll = false;
							moller_brandscroll = true;
					var moller_categoriesnumber = 6,
			moller_categoriesscrollnumber = 2,
			moller_categoriespause = 3000,
			moller_categoriesanimate = 700;
		var moller_categoriesscroll = 'false';
					var moller_blogpause = 3000,
			moller_bloganimate = 700;
		var moller_blogscroll = false;
					var moller_testipause = 3000,
			moller_testianimate = 2000;
		var moller_testiscroll = false;
							moller_testiscroll = false;
					var moller_catenumber = 6,
			moller_catescrollnumber = 2,
			moller_catepause = 3000,
			moller_cateanimate = 700;
		var moller_catescroll = false;
					var moller_menu_number = 11;
		var moller_sticky_header = false;
							moller_sticky_header = true;
					jQuery(document).ready(function(){
			jQuery(".ws").on('focus', function(){
				if(jQuery(this).val()==""){
					jQuery(this).val("");
				}
			});
			jQuery(".ws").on('focusout', function(){
				if(jQuery(this).val()==""){
					jQuery(this).val("");
				}
			});
			jQuery(".wsearchsubmit").on('click', function(){
				if(jQuery("#ws").val()=="" || jQuery("#ws").val()==""){
					jQuery("#ws").focus();
					return false;
				}
			});
			jQuery(".search_input").on('focus', function(){
				if(jQuery(this).val()==""){
					jQuery(this).val("");
				}
			});
			jQuery(".search_input").on('focusout', function(){
				if(jQuery(this).val()==""){
					jQuery(this).val("");
				}
			});
			jQuery(".blogsearchsubmit").on('click', function(){
				if(jQuery("#search_input").val()=="" || jQuery("#search_input").val()==""){
					jQuery("#search_input").focus();
					return false;
				}
			});
		});
		