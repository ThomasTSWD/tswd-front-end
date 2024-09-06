jQuery(document).ready(function ($) {
	// jQuery 1.4 with : $ Works!
	var href = window.location.href;
	var index = href.indexOf('/wp-admin');
	var homeUrl = href.substring(0, index);
	var $myDomain = location.hostname;
	//var $myDomain = homeUrl;





	//load content link adminmenu


	/*

	$('#adminmenu li').each(function(){
		$(this).hover(function(){

			var hovLinkMenu = $('a', this).attr('href');
	console.log(hovLinkMenu);

				var hovLinkMenuOk = hovLinkMenu + ' #the-list'
	console.log(hovLinkMenuOk);



			$('#wpbody').append('<div class="admin-info-bloc" style="    width: 100%;    height: 100%;    background: #24292d;    position: absolute;    top: 0;    left: 0;    color: white;"></div>')
			$('.admin-info-bloc').load(hovLinkMenuOk)


	});
			$('#wpadminbar').click(function(){
		$('.admin-info-bloc').remove();


	});
	});
	*/







	//dashboard notes
	if (window.location.href.indexOf("post_type=dsn") > -1) {
		$('head').append('<style>h1{font-weight: bold !important;font-size: 33px !important;position: relative !important;text-shadow: 0px 0px 1px grey !important;font-style: italic !important;}</style>');
		$('head').append('<link rel="icon" href="../wp-content/plugins/tswd-front-end/core/dist/note.png">');
		$("#contextual-help-link-wrap").hide();
		$('link[rel="icon"]').attr('href', '../wp-content/plugins/tswd-front-end/core/dist/note.png');

	}

	//tswd-front-end page
	if (window.location.href.indexOf("page=tswd-front-end-page") > -1) {
		$('head').append('<link rel="icon" href="../wp-content/plugins/tswd-front-end/core/dist/code.png">');
		$("#contextual-help-link-wrap").hide();
		$('link[rel="icon"]').attr('href', '../wp-content/plugins/tswd-front-end/core/dist/code.png');

	}


	//tswd-front-css page
	if (window.location.href.indexOf("tswd-front-css") > -1) {
		$('head').append('<link rel="icon" href="../wp-content/plugins/tswd-front-end/core/dist/css.png">');
		$(document).attr("title", "Css | " + $myDomain + "");
		$("#wpcontent").prepend("<h1 style='padding-top:40px; margin:0;'><span style='font-weight: bold;font-size: 1.5em;position: relative;text-shadow: 0px 0px 1px grey;font-style: italic;'>tswd-front-css</span> " + $myDomain + "</h1>");

		$('link[rel="icon"]').attr('href', '../wp-content/plugins/tswd-front-end/core/dist/css.png');


		$("#adminmenuback").hide();
		$(".wrap > h1").hide();
		$(".fileedit-sub h2").hide();


		$(".fileedit-sub form").hide();

		$("#contextual-help-link-wrap").hide();
	}


	//tswd-front-js page
	if (window.location.href.indexOf("tswd-front-js") > -1) {
		$('head').append('<link rel="icon" href="../wp-content/plugins/tswd-front-end/core/dist/js.png">');
		$(document).attr("title", "Js | " + $myDomain + "");
		$("#wpcontent").prepend("<h1 style='padding-top:40px; margin:0;'><span style='font-weight: bold;font-size: 1.5em;position: relative;text-shadow: 0px 0px 1px grey;font-style: italic;'>tswd-front-js</span> " + $myDomain + "</h1>");

		$('link[rel="icon"]').attr('href', '../wp-content/plugins/tswd-front-end/core/dist/js.png');

		$("#adminmenuback").hide();
		$(".wrap .submit").css("filter", "hue-rotate(220deg)");
		$(".wrap > h1").hide();
		$(".fileedit-sub h2").hide();

		$(".fileedit-sub form").hide();


		$("#contextual-help-link-wrap").hide();
	}


	//tswd-fonts !
	if (window.location.href.indexOf("-front-fonts.css") > -1) {
		$('head').append('<link rel="icon" href="../wp-content/plugins/tswd-front-end/core/dist/font.png">');
		$(document).attr("title", "tswd-fonts | " + $myDomain + "");
		$("#wpcontent").prepend("<h1 style='padding-top:40px; margin:0;'><span style='font-weight: bold;font-size: 1.5em;position: relative;text-shadow: 0px 0px 1px grey;font-style: italic;'>tswd-fonts</span> " + $myDomain + "</h1>");


		$('link[rel="icon"]').attr('href', '../wp-content/plugins/tswd-front-end/core/dist/font.png');

		$("#templateside ul").hide();
		$("#templateside").append('<a target="_blank" style="" href="https://www.fontsquirrel.com/"> <img style="width: 200px;width: 100%;margin-top: 32px;margin-left: 6px;" src="' + homeUrl + '/wp-content/plugins/tswd-front-end/core/dist/font_squirrel.jpg"></a>');
		$("#templateside").append('<a target="_blank" style="" href="https://fonts.google.com/"> <img style="width: 200px;width: 100%;margin-top: 2px;margin-left: 6px;" src="' + homeUrl + '/wp-content/plugins/tswd-front-end/core/dist/google-fonts.png"></a>');



		//$("#templateside").append('<iframe src="'+ homeUrl + '/wp-content/plugins/tswd-front-end/font-uploader.php" style="border:0px #ffffff none; margin-left:10px;" name="myiFrame" scrolling="no" frameborder="1" marginheight="0px" marginwidth="0px" height="720px" width="190px" allowfullscreen></iframe>');
		//$("#plugin-files-label").hide();



		$("#adminmenuback").hide();
		$(".wrap .submit").css("filter", "hue-rotate(72deg)");
		$(".wrap > h1").hide();
		$(".fileedit-sub h2").hide();


		$(".fileedit-sub form").hide();
		$("#contextual-help-link-wrap").hide();
	}


	//---------------------------------------
});

