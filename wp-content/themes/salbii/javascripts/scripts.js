(function ($) {
	'use strict';
	//Initialize Foundation
	jQuery(document).foundation();


	var topBar_initHeight = $(".js-site-header__navigation-wrap").outerHeight();
	var wpadminbar = 0;
	if ($("body").hasClass("admin-bar")) {
		wpadminbar = 28;
	}

	// function updateOnScroll(){
	// 	var windowScroll = $(window).scrollTop();
	// }

	// $(window).scroll(function(){
	// 	updateOnScroll();
	// });
	jQuery(document).ready(function ($) {
		
		scrollToTopBtn();
		
		var headerPinned = {_1:0, _2:0};
		var headerHeight = 0;
		var windowScroll = 0;
                
                if (($('header.site-header').hasClass('fixedMobile') && !$('header.site-header').hasClass('headerSticky') && Modernizr.mq('(max-width: 991px)')) || ($('header.site-header').hasClass('fixedDesktop') && !$('header.site-header').hasClass('headerSticky') && Modernizr.mq('(min-width: 992px)'))) {
                    $('header.site-header').before('<div class="site-header__spacer js-site-header__spacer hide-for-small"></div>');

                    $("header.site-header").headroom({
                        "tolerance": 8,
                        "offset": 400,
                        "classes": {                    
                            "pinned": "slideInDown",
                            "unpinned": "slideOutUp"                    
                        }
                    });
                }
                
                if(Modernizr.mq('(min-width: 991px)')){
                
                    var $stickyHeader = $("header.headerSticky");
                    if($stickyHeader.length > 0 && $stickyHeader.children().hasClass('header-layout-1')){                    
                        $("header.headerSticky .header-layout-1").headroom();
                    }
                    if($stickyHeader.length > 0){                    
                        $("header.headerSticky .header-layout-2 section.top-bar-section").headroom();
                        $("header.headerSticky .header-layout-3 section.top-bar-section").headroom();
                    }

                    if($('header.site-header').hasClass('headerSticky')){                                        
                        $('header.site-header .header-layout-1').before('<div class="site-header__spacer js-site-header__spacer hide-for-small"></div>');
                        
                        
                        
                        $(window).scroll(function(){
                           if(typeof window.header_y == 'undefined' && $('.header-layout-1:visible').length > 0) {
                               var header_y = $('header.site-header .header-layout-1').offset().top + 25;
                                if($('body').hasClass('admin-bar')){
                                    header_y  = header_y - 32;                            
                                }
                                window.header_y = header_y;
                           }
                            
                           var $header = $('header.site-header .header-layout-1');

                           if($header.length > 0){

                                var $logo = $header.find('.top-bar img');
                                var window_y = $(window).scrollTop();                                 
                                var header_min_height = 64;
                                var logo_min_height = 35;         
                                
                                var header_height;
                                var logo_height;

                                var logo_height_new

                                if($header.data('height') == undefined){
                                    header_height = $header.height();
                                    $header.data('height', header_height);
                                }else{
                                    header_height = $header.data('height');
                                }                                
                                
                                headerHeight = header_min_height;

                                if($header.data('logo-height') == undefined){
                                    logo_height = $logo.height();
                                    $header.data('logo-height', logo_height);
                                }else{
                                    logo_height = $header.data('logo-height');
                                }

                                if(window_y <= window.header_y){
                                    var diff = header_height - header_min_height;
                                    var header_height_new = header_height - ((diff/window.header_y) * window_y);                                      

                                    var diff2 = logo_height - logo_min_height;
                                    logo_height_new = logo_height - ((diff2/window.header_y) * window_y);
                                }else{
                                    header_height_new = header_min_height;
                                    logo_height_new = logo_min_height;
                                }                       
                                $header.find('.top-bar').css('height', header_height_new);                        
                                $logo.css('height', logo_height_new).css('width','auto');
                            }
                        });
                    }                
                }
                
               
                $("header.site-header .header_layout_1").css('width', $('.global-wrapper').width()+'px');
                $('section.top-bar-section.headroom').css('width', $('.global-wrapper').width()+'px').css('left', 'auto !important').css('right', 'auto');
                $('header.fixedDesktop').css('width', $('.global-wrapper').width()+'px');
                $(window).resize(function(event) {  
                    $("header.site-header .header_layout_1").css('width', $('.global-wrapper').width()+'px');
                    $('section.top-bar-section.headroom').css('width', $('.global-wrapper').width()+'px');                        
                    $('header.fixedDesktop').css('width', $('.global-wrapper').width()+'px');
                });

                
                if (Modernizr.mq('(max-width: 991px)')){
                    //overwrite js_composer vc_waypoints to turn off animations
                    window['vc_waypoints'] = function(){};
                    
                    $('.wpb_animate_when_almost_visible').css('opacity',1);
                    
                }


		function updateOnScroll() {
			windowScroll = $(window).scrollTop();
			

			/**
			* ----------------------------------------------------------------------
			* Fixed navigation bar
			*/
			// firstly check if header is set to by pinned
                        var border = window.header_y || 40;
                        
                        if ( $(".site-header.headroom.fixedDesktop").length ) {
				if ( windowScroll >= (border) && headerPinned._1 == 0 ) {
					$(".site-header").addClass('animated');
					$(".js-site-header__spacer").css('height', headerHeight + 'px');

					headerPinned._1 = 1;
				}else if ( windowScroll < (border) && headerPinned._1 == 1 ) {
					$(".site-header").removeClass('animated');
					$(".js-site-header__spacer").css('height', '0px');

					headerPinned._1 = 0;
				}
			}
                        
			if ( $(".header-layout-1.headroom:visible ").length ) {
				if ( windowScroll >= (border) && headerPinned._1 == 0 ) {
					$(".site-header .header-layout-1").addClass('animated');
					$(".js-site-header__spacer").css('height', headerHeight + 'px');

					headerPinned._1 = 1;
				}else if ( windowScroll < (border) && headerPinned._1 == 1 ) {
					$(".site-header .header-layout-1").removeClass('animated');
					$(".js-site-header__spacer").css('height', '0px');

					headerPinned._1 = 0;
				}
			}
                        
                        /**
			* ----------------------------------------------------------------------
			* Fixed menu bar
			*/
			// firstly check if header is set to by pinned
			if ( $(".top-bar-section.headroom").length ) {
				if ( windowScroll > 171 && headerPinned._2 == 0 ) {
					$(".top-bar-section.headroom").addClass('animated');
//					$(".js-site-header__spacer").css('height', headerHeight + 'px');
					headerPinned._2 = 1;
				}else if ( windowScroll < 172 && headerPinned._2 == 1 ) {
					$(".top-bar-section.headroom").removeClass('animated');
//					$(".js-site-header__spacer").css('height', '0px');
					headerPinned._2 = 0;
				}
			}
		}

		function updateOnResize() {
			headerHeight = $('.site-header').outerHeight();


			

		}


		/**
		 * ----------------------------------------------------------------------
		 * Fix for foundation mobile language selector
		 * Author: Tom Gajewski tom@twindots.com
		*/

		
		function fixMobileLanguageSelector() {                                        
                        //check if .language-switch is found in top-bar 
			if($(".top-bar-section .language-switch").closest('.top-bar').find('.title-area').length == 1)
			{
				$(".top-bar-section .language-switch").closest('.top-bar').find('.title-area').css('height', parseInt($(".language-switch .dropdown").css('height')) - 60 + 'px') ;
			}
                   	
           	if($( window ).width() > 767) 
           	{
           		if($('.top-bar-section .language-switch').first().hasClass('right')){
                	$('.top-bar-section .language-switch > .has-dropdown').first().addClass('left');
                }
            }
            else
            {
            	if($('.top-bar-section .language-switch').first().hasClass('right')){
                	$('.top-bar-section .language-switch > .has-dropdown').first().removeClass('left');
                }
            }
		}
                	


		// run functions once on page loading
		updateOnScroll();
		updateOnResize();
		fixMobileLanguageSelector();


		$(window).scroll(function(){
			updateOnScroll();
		});

		$(window).resize(function(){
			updateOnResize();
			fixMobileLanguageSelector();
		});


		/**
		* ----------------------------------------------------------------------
		* Parallax
		*/

		if (jQuery().parallax) {
			jQuery('.parallax').each(function(){

				if ( $(this).hasClass('parallax-veryslow') ) {
					jQuery(this).parallax("49%", -0.05);
				} else if ( $(this).hasClass('parallax-slow') ) {
					jQuery(this).parallax("49%", -0.1);
				} else if ( $(this).hasClass('parallax-fast') ) {
					jQuery(this).parallax("49%", -0.3);
				} else if ( $(this).hasClass('parallax-veryfast') ) {
					jQuery(this).parallax("49%", -0.4);
				} else {
					jQuery(this).parallax("49%", -0.2);
				}

			});
		}

		/**
		* ----------------------------------------------------------------------
		* Menu icon classes
		*/

		$('.menu-icon').each(function(){
			var iconClass = $(this).attr('class');
			var regClassFilter = /\b(icon-[\w-]*)\b/gi;
			iconClass = iconClass.match(regClassFilter);
			$(this).find('a:first-child').prepend('<i class="submenu-item-icon ' + iconClass + '" arria-hidden="true"></i> ');
		});

		/**
		* ----------------------------------------------------------------------
		* Visual Composer elements tuning
		*/

		// Balance pricing table blocks
		$('.pricingtable-section').each(function(){
			var pricing_table = $(this);
			var pricing_block_maxheight = 0;

			// find the highest price block
			pricing_table.find('.pricingtable-priceblock').each(function(){
				if ( $(this).outerHeight() > pricing_block_maxheight ) {
					pricing_block_maxheight = $(this).outerHeight();
				}
			});

			// change all blocks height to the maximum
			pricing_table.find('.pricingtable-priceblock').each(function(){
				if ( $(this).outerHeight() < pricing_block_maxheight ) {
					$(this).css('min-height', pricing_block_maxheight + 'px');
				}
			});
		});

		// Find .wpb_heading elements that has centered parent
		$('.wpb_heading').parent().filter(function() {
			return $(this).css('text-align') == 'center';
		}).children('.wpb_heading').addClass('centered');

		// Centering buttons with class .center
		$('.button.center, .vc_btn.center').each(function(){
			$(this).parent().css('text-align', 'center');
		});

		// Elements carousel on loading
		$('.vc_elements_carousel').each(function(){
			var max_slide_height = 0;
			$(this).find(".wpb_tab").each(function(){
				$(this).css('opacity', '1');
				var current_height = $(this).outerHeight();
				if ( max_slide_height < current_height ) {
					max_slide_height = current_height;
				}
			});

			$(this).css('min-height', max_slide_height + 'px');
		});



		/**
		 * ----------------------------------------------------------------------
		 * Comment form
		 */

		// when user focus textarea we display allowed tags list
		jQuery('.comment-form textarea#comment').focusin(function() {
			jQuery('#commentform .form-allowed-tags').addClass('show');
		});

		jQuery('.comment-form textarea#comment').focusout(function() {
			jQuery('#commentform .form-allowed-tags').removeClass('show');
		});

		// auto resize comment textarea
		// jQuery('.comment-form textarea#comment').autosize();

		// add class to submit button
		jQuery('#commentform #submit').addClass('button expand radius');

		jQuery('#commentform .form-submit').wrap('<div class="row comment-submit-line" />');
		jQuery('#commentform .form-submit').addClass('large-4 columns').addClass('vc_col-sm-4 wpb_column');
		jQuery('.comment-form .comment-subscription-form').addClass('large-4 columns').addClass('vc_col-sm-4 wpb_column');


		/**
		 * ----------------------------------------------------------------------
		 * Collapsible search field functionality
		 */

		// Prevent search for from sending empty query

		jQuery("form.search-block").bind("submit", function(e) {
			var searchQuery = jQuery(this).find(".search-field").val();
			if( searchQuery === " " ||  searchQuery === "" ) {
				e.preventDefault();
				jQuery(this).find(".search-field").focus();
			}
		});

		// Automatically focus on search field on mouseenter
		/* jQuery("form.search-block").bind("mouseenter", function(e) {
			jQuery(this).find(".search-field").focus();
		}); */
		

		/**
		 * ----------------------------------------------------------------------
		 * Watch for menu not collapse with logo on medium window width
		 */

		jQuery(window).bind("load resize", function(){

			var siteIdentityWidth = 0;
			var mainMenuWidth = 0;
			var siteMenuBarBox = 0;

			if ( jQuery(".headertop").hasClass("header-layout-1") ) {


				siteIdentityWidth = jQuery(".header-logo a img").outerWidth();
				jQuery(".headertop .top-bar-section .large-12 ").children().each(function(){
					mainMenuWidth = mainMenuWidth + $(this).outerWidth();
				});

				siteMenuBarBox = jQuery(".top-bar-section > .row").width();

				// console.log( 'siteIdentityWidth:' + siteIdentityWidth + ' mainMenuWidth:' + mainMenuWidth + ' siteMenuBarBox:' + siteMenuBarBox );

				if ( (siteIdentityWidth + mainMenuWidth + 50) > siteMenuBarBox  ) {
					jQuery(".headertop").addClass("sliped-out-menu-inside");
				} else if ( (siteIdentityWidth + mainMenuWidth + 50) < siteMenuBarBox  ) {
					jQuery(".headertop").removeClass("sliped-out-menu-inside");
				}

			};

		});       
                
                //when the trigger is clicked we check to see if the popout is currently hidden
                //based on the hidden we choose the correct animation
                $('#popout-menu .trigger').click( function() {
                    if ($('#popout-menu').hasClass('hidden')) {
                        $('#popout-menu').removeClass('hidden');
                        showPopout();                        
                        $(this).find('img').attr('src', '/wp-content/themes/salbii/images/close.png');
                    }
                    else {
                        $('#popout-menu').addClass('hidden');
                        hidePopout();
                        $(this).find('img').attr('src', '/wp-content/themes/salbii/images/gear.gif');
                    }
                });

                function showPopout() {
                    $('#popout-menu').animate({
                        left: 0
                    }, 'slow', function () {
                        
                    });
                }

                function hidePopout() {
                    $('#popout-menu').animate({
                        left: -227
                    }, 'slow', function () {

                    });
                }
                
                $("#popout-menu .menu > ul > li > a").click(function(){ 
                    if(false == $(this).next().is(':visible')) {                        
                        $('#popout-menu .menu ul ul').slideUp(300);
                        $('#popout-menu .menu a').removeClass('active');
                    }
                    
                    $(this).toggleClass('active');
                    $(this).next().slideToggle(300);
                });
                $('#accordion ul:eq(0)').show();                
                
                
                $("#popout-menu .menu ul a").not('.no-action').click(function(){
                    var $this = $(this);                    
//                    $('body').attr('class', $('body').data('default-class'));                        
                    
                    if($this.data('add-class')){                        
                        $('body').addClass($this.data('add-class'));
                    }
                    
                    if($this.data('remove-class')){
                        $('body').removeClass($this.data('remove-class'));
                    }                    
                    
                    if($this.hasClass('reset')){
                         $('body').attr('class', $('body').data('default-class'));
                    }
                    eraseCookie('body_class');
                    createCookie('body_class', $('body').attr('class'),1);
                    
                    $('body').resize();
                    return false;
                });
                var body_class = readCookie('body_class');                
                if(body_class){                    
                    $('body').attr('class', body_class);
                    $('body').resize();
                }                
        //Fix Ultimate Video BG
		jQuery.fn.optimizeDisplay = function () {
			var YTPlayer = this.get(0);
			var data = YTPlayer.opt;
			var playerBox = jQuery(YTPlayer.playerEl);
			var win = {};
			var el = YTPlayer.wrapper;

			win.width = el.outerWidth();
			win.height = el.outerHeight();

			var margin = 24;
			var overprint = 200;
			var vid = {};
			vid.width = win.width + ((win.width * margin) / 100);
			vid.height = data.ratio == "16/9" ? Math.ceil((9 * win.width) / 16) : Math.ceil((3 * win.width) / 4);
			vid.marginTop = -((vid.height - win.height) / 2);
			vid.marginLeft = -((win.width * (margin / 2)) / 100);

			if (vid.height < win.height) {
				vid.height = win.height + ((win.height * margin) / 100);
				vid.width = data.ratio == "16/9" ? Math.floor((16 * win.height) / 9) : Math.floor((4 * win.height) / 3);
				vid.marginTop = -((win.height * (margin / 2)) / 100);
				vid.marginLeft = -((vid.width - win.width) / 2);
			}

			vid.width += overprint;
			vid.height += overprint;
			vid.marginTop -= overprint / 2;
			vid.marginLeft -= overprint / 2;

			playerBox.css({width: vid.width, height: vid.height, top: vid.marginTop, left: vid.marginLeft});
		}
	});
	function scrollToTopBtn() {
		$('body').prepend('<a href="" class="scroll-to-top"><i class="icon-arrow-up-4"></i></a>');
		var btn = $('a.scroll-to-top');
		$(window).scroll(function(){
			var viewportHeight = $(window).height();
			var scrollTop = $(window).scrollTop();
			
			if (scrollTop > viewportHeight) {
				btn.addClass('active');
			}
			else{
				btn.removeClass('active');
			}
		})
		
		btn.live('click', function(event){
			event.preventDefault();
			$(this).removeClass('active');
			$('html, body').animate({"scrollTop":0}, "slow");
			return false;
		});
		btn.hover(function(){
			if ($(window).width() > 720) {
				$(this).addClass('brand-bgcolor');
			}
		},
		function(){
			$(this).removeClass('brand-bgcolor');
		});
	}        
        
        function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
        }

        function readCookie(name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for(var i=0;i < ca.length;i++) {
                        var c = ca[i];
                        while (c.charAt(0)==' ') c = c.substring(1,c.length);
                        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
                }
                return null;
        }

        function eraseCookie(name) {
                createCookie(name,"",-1);
        }

})(jQuery);