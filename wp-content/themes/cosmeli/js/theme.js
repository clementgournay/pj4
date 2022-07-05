/**
 * @version    1.0
 * @package    GonThemes
 * @author     GonThemes Team <gonthemes@gmail.com>
 * @copyright  Copyright (C) 2017 GonThemes. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://gonthemes.info
 */
 
(function($) {
	"use strict";
	
	jQuery(document).ready(function(){
		
		//Mobile Menu
		var mobileMenuWrapper = jQuery('.mobile-menu-container, .nav-container');
		mobileMenuWrapper.find('.menu-item-has-children, .page_item_has_children').each(function(){
			var linkItem = jQuery(this).find('a').first();
			linkItem.after('<i class="fa fa-plus"></i>');
		});
		
		//calculate the init height of menu
		var totalMenuLevelFirst = jQuery('.mobile-menu-container > ul.nav-menu > li, .nav-container > .nav-menu > ul > li').length;
		var mobileMenuH = totalMenuLevelFirst*50 + 10; //40 is height of one item, 10 is padding-top + padding-bottom;
		
		jQuery('.mbmenu-toggler').on("click", function(){
			if(mobileMenuWrapper.hasClass('open')) {
				mobileMenuWrapper.removeClass('open');
				mobileMenuWrapper.animate({'height': 0}, 'fast');
			} else {
				mobileMenuWrapper.addClass('open');
				mobileMenuWrapper.animate({'height': mobileMenuH}, 'fast');
			}
		});
		
		//set the height of all li.menu-item-has-children items
		jQuery('.mobile-menu-container li.menu-item-has-children, .nav-container li.page_item_has_children').each(function(){
			jQuery(this).css({'height': 50, 'overflow': 'hidden'});
		});
		
		//process the parent items
		jQuery('.mobile-menu-container li.menu-item-has-children, .nav-container li.page_item_has_children').each(function(){
			var parentLi = jQuery(this);
			var dropdownUl = parentLi.find('ul.sub-menu, ul.children').first();
			
			parentLi.find('.fa').first().on('click', function(){
				//set height is auto for all parents dropdown
				parentLi.parents('li.menu-item-has-children, li.page_item_has_children').css('height', 'auto');
				//set height is auto for menu wrapper
				mobileMenuWrapper.css({'height': 'auto'});
				
				var dropdownUlheight = dropdownUl.outerHeight() + 50;
				
				if(parentLi.hasClass('opensubmenu')) {
					parentLi.removeClass('opensubmenu');
					parentLi.animate({'height': 50}, 'fast', function(){
						//calculate new height of menu wrapper
						mobileMenuH = mobileMenuWrapper.outerHeight();
					});
					parentLi.find('.fa').first().removeClass('fa-minus');
					parentLi.find('.fa').first().addClass('fa-plus');
				} else {
					parentLi.addClass('opensubmenu');
					parentLi.animate({'height': dropdownUlheight}, 'fast', function(){
						//calculate new height of menu wrapper
						mobileMenuH = mobileMenuWrapper.outerHeight();
					});
					parentLi.find('.fa').first().addClass('fa-minus');
					parentLi.find('.fa').first().removeClass('fa-plus');
				}
				
			});
		});
		
		var $header3 = $('.header-style-3'),
			header3H = 0 - $header3.outerHeight();
		if ($header3.length) {
			$('.main-container').css('margin-top', header3H);
		}
		
		/* For add to card button */
		jQuery('body').append('<div class="atc-notice-wrapper"><div class="atc-notice"></div><div class="close"><i class="fa fa-times-circle"></i></div></div>');
		
		jQuery('.atc-notice-wrapper .close').on("click", function(){
			jQuery('.atc-notice-wrapper').fadeOut();
			jQuery('.atc-notice').html('');
		});
		
		jQuery('body').on('adding_to_cart', function(event, button, data) {
			var ajaxPId = button.attr('data-product_id');
			var ajaxPQty = button.attr('data-quantity');
			
			//get product info by ajax
			jQuery.post(
				ajaxurl, 
				{
					'action': 'gon_get_productinfo',
					'data':   {'pid': ajaxPId,'quantity': ajaxPQty}
				},
				function(response){
					jQuery('.atc-notice').html(response);
				}
			);
		});
		
		jQuery('body').on('added_to_cart', function(event, fragments, cart_hash) {			
			jQuery('.atc-notice-wrapper').fadeIn();
		});
		
		/*Search Woocommerce*/
		jQuery("#ws").focus(function(){
			var name = $("#ws").attr("data-name");
			if(jQuery(this).val()== name){
				jQuery(this).val("");
			}
		});
		jQuery("#ws").focusout(function(){
			var name = $("#ws").attr("data-name");
			if(jQuery(this).val()==""){
				jQuery(this).val(name);
			}
		});
		jQuery("#wsearchsubmit").click(function(){
			var name = $("#ws").attr("data-name");
			if(jQuery("#ws").val()== name || jQuery("#ws").val()==""){
				jQuery("#ws").focus();
				return false;
			}
		});
		
		/*Search Blog*/
		jQuery("#search_input").focus(function(){
			var name = $("#search_input").attr("data-name");
			if(jQuery(this).val()== name){
				jQuery(this).val("");
			}
		});
		jQuery("#search_input").focusout(function(){
			var name = $("#search_input").attr("data-name");
			if(jQuery(this).val()==""){
				jQuery(this).val(name);
			}
		});
		jQuery("#blogsearchsubmit").click(function(){
			var name = $("#search_input").attr("data-name");
			if(jQuery("#search_input").val()== name || jQuery("#search_input").val()==""){
				jQuery("#search_input").focus();
				return false;
			}
		});
		
		//Testimonials carousel
		jQuery('.testimonials .wpb_wrapper > h3').each(function(){
			var pwidgetTitle = jQuery(this).html();
			jQuery(this).html('<span>'+pwidgetTitle+'</span>');
		});
		
		/* Image Zoom Function */
		jQuery('.zoom_in_marker').on("click", function(){
			jQuery.fancybox({
				href: 			jQuery('.woocommerce-main-image').attr('href'),
				openEffect: 	'elastic',
				closeEffect: 	'elastic'
			});
		});
		
		/* Up Sells - Product carousel on Product Details Page */
		$(".related .shop-products, .upsells .shop-products, .cross-sells .shop-products").addClass('owl-carousel owl-theme');
		$(".related .shop-products, .upsells .shop-products, .cross-sells .shop-products").owlCarousel({
			items: 				4,
			responsive : {
				0 : {
					items: 				1,
				},
				450 : {
					items: 				1,
				},
				650 : {
					items: 				2,
				},
				800 : {
					items: 				3,
				},
				980 : {
					items: 				3,
				},
				1170 : {
					items: 				4,
				},
			},
			nav: 		false,
			dots: 		false,
			navText: 	["Prev", "Next"],
		});
		
		
		/* Category Product View Module */
		jQuery('.view-mode').each(function(){
			/* Grid View */
			jQuery(this).find('.grid').on("click", function(event){
				event.preventDefault();
				
				jQuery('#archive-product .view-mode').find('.grid').addClass('active');
				jQuery('#archive-product .view-mode').find('.list').removeClass('active');
				
				jQuery('#archive-product .shop-products').removeClass('list-view');
				jQuery('#archive-product .shop-products').addClass('grid-view');
				
				jQuery('#archive-product .list-col4').removeClass('col-xs-12 col-sm-4');
				jQuery('#archive-product .list-col8').removeClass('col-xs-12 col-sm-8');
			});
			
			/* List View */
			jQuery(this).find('.list').on("click", function(event){
				event.preventDefault();
			
				jQuery('#archive-product .view-mode').find('.list').addClass('active');
				jQuery('#archive-product .view-mode').find('.grid').removeClass('active');
				
				jQuery('#archive-product .shop-products').addClass('list-view');
				jQuery('#archive-product .shop-products').removeClass('grid-view');
				
				jQuery('#archive-product .list-col4').addClass('col-xs-12 col-sm-4');
				jQuery('#archive-product .list-col8').addClass('col-xs-12 col-sm-8');
			});
		});
		
		
		/* Tooltip Block */
		jQuery('.yith-wcwl-add-to-wishlist a, .compare-button a, .add_to_cart_inline a, .quick-wrapper .quick-view, .sharefriend a').each(function(){
			gontip(jQuery(this), 'html');
		});		
		jQuery('.social-icons a, .link-follow a').each(function(){
			gontip(jQuery(this), 'title');
		});
		
		
		/* Quick View Mode */
		jQuery('.product-wrapper').each(function(){
			jQuery(this).on('mouseover click', function(){
				jQuery(this).addClass('hover');
			});
			jQuery(this).on('mouseleave', function(){
				jQuery(this).removeClass('hover');
			});
		});
		
		
		/* Add quickview box */
		jQuery('body').append('<div class="quickview-wrapper"><div class="quick-modal"><span class="closeqv"><i class="fa fa-times"></i></span><div id="quickview-content"></div><div class="clearfix"></div></div></div>');
		
		/* Show quickview box */
		jQuery('.quickview').each(function(){
			var quickviewLink 	= jQuery(this);
			var productID 		= quickviewLink.attr('data-quick-id');
			
			quickviewLink.on("click", function(event){
				event.preventDefault();
				
				jQuery('#quickview-content').html('');				
				jQuery('body').addClass('quickview');
				
				window.setTimeout(function(){
					jQuery('.quickview-wrapper').addClass('open');
					jQuery('.quick-modal').addClass('loading');
					
					jQuery.post(
						ajaxurl, 
						{
							'action': 'gon_product_quickview',
							'data':   productID
						}, 
						function(response){
							jQuery('#quickview-content').html(response);
							
							jQuery('.quick-modal').removeClass('loading');
							/* variable product form */
							jQuery('.variations_form').wc_variation_form();
							jQuery('.variations_form .variations select').change();
							
							/* thumbnails carousel */
							jQuery(".quick-thumbnails").addClass('owl-carousel owl-theme');
							jQuery('.quick-thumbnails').owlCarousel({
								items: 				3,
								responsive : {
									0 : {
										items: 				1,
									},
									450 : {
										items: 				1,
									},
									650 : {
										items: 				2,
									},
									800 : {
										items: 				3,
									},
									980 : {
										items: 				3,
									},
									1170 : {
										items: 				3,
									},
								},
								nav: 		true,
								dots: 		false,
								navText: 	["Prev", "Next"],
							});
							
							/* thumbnail click */
							jQuery('.quick-thumbnails a').each(function(){
								var quickThumb = jQuery(this);
								var quickImgSrc = quickThumb.attr('href');
								
								quickThumb.on("click", function(event){
									event.preventDefault();
									
									jQuery('.main-image').find('img').attr('src', quickImgSrc);
								});
							});
							
							/*review link click*/							
							jQuery('.woocommerce-review-link').on("click", function(event){
								event.preventDefault();
								var reviewLink = jQuery('.see-all').attr('href');								
								window.location.href = reviewLink + '#reviews';
							});
							
							$('div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)').addClass('buttons_added').append('<span class="plus"><i class="icon-arrow-up icons"></i></span>').prepend('<span class="minus"><i class="icon-arrow-down icons"></i></span>');
						}
					);
				}, 300);
			});
		});
		
		/* Close quickview box */
		jQuery('.closeqv').on("click", function(event){
			jQuery('.quickview-wrapper').removeClass('open');
			
			window.setTimeout(function(){
				jQuery('body').removeClass('quickview');
			}, 500);
		});
		
		
		/* Fancybox for Product */
		jQuery(".fancybox").fancybox({
			openEffect: 'elastic',
			closeEffect: 'fade',
			beforeShow: function() {
				if(this.title) {
					// New line
					this.title += '<div class="fancybox-social">';
					
					// Add tweet button
					this.title += '<a href="https://twitter.com/share" class="twitter-share-button" data-count="none" data-url="' + this.href + '">Tweet</a> ';
					
					// Add FaceBook like button
					this.title += '<iframe src="//www.facebook.com/plugins/like.php?href=' + this.href + '&amp;layout=button_count&amp;show_faces=true&amp;width=500&amp;action=like&amp;font&amp;colorscheme=light&amp;height=23" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:110px; height:23px;" allowTransparency="true"></iframe></div>';
				}
			},
			afterShow: function() {
				// Render tweet button
				twttr.widgets.load();
			},
			helpers:  {
				title : {
					type : 'inside'
				},
				overlay : {
					showEarly : false
				}
			}
		});
		
		
		/* Fancybox for single project */
		jQuery(".prfancybox").fancybox({
			openEffect: 	'fade',
			closeEffect: 	'elastic',
			nextEffect: 	'fade',
			prevEffect: 	'fade',
			beforeShow: function() {
				if(this.title) {
					// New line
					this.title += '<div class="fancybox-social">';
					
					// Add tweet button
					this.title += '<a href="https://twitter.com/share" class="twitter-share-button" data-count="none" data-url="' + this.href + '">Tweet</a> ';
					
					// Add FaceBook like button
					this.title += '<iframe src="//www.facebook.com/plugins/like.php?href=' + this.href + '&amp;layout=button_count&amp;show_faces=true&amp;width=500&amp;action=like&amp;font&amp;colorscheme=light&amp;height=23" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:110px; height:23px;" allowTransparency="true"></iframe></div>';
				}
			},
			afterShow: function() {
				// Render tweet button
				twttr.widgets.load();
			},
			helpers:  {
				title : {
					type : 'inside'
				},
				overlay : {
					showEarly : false
				},
				buttons	: {},
				thumbs	: {
					width	: 100,
					height	: 100
				}
			}
		});
		
		/*  [ Page loader]
		- - - - - - - - - - - - - - - - - - - - */
		setTimeout(function() {
			$( 'body' ).addClass( 'loaded' );
			setTimeout(function () {
				$('#pageloader').remove();
			}, 1500);
		}, 1500);
		
		/* Show/hide NewsLetter Popup */
		gonShowNLPopup();
		
		jQuery('.newsletterpopup .close-popup').click(function(){
			gonHideNLPopup();
		});
		
		jQuery('.popupshadow').click(function(){
			gonHideNLPopup();
		});
		
		/*Countdown*/
		jQuery('.countbox.hastime').each(function(){
			var countTime = jQuery(this).attr('data-time');
			
			jQuery(this).countdown(countTime, function(event) {
				jQuery(this).html(
					'<span class="timebox day"><strong>'+event.strftime('%D')+'</strong>days</span><span class="timebox hour"><strong>'+event.strftime('%H')+'</strong>hrs</span><span class="timebox minute"><strong>'+event.strftime('%M')+'</strong>mins</span><span class="timebox second"><strong>'+event.strftime('%S')+'</strong>secs</span>'
				);
			});
		});
		
		/* Lightbox popup
		-------------------------------------------------------*/
		$('.lightbox-gallery').magnificPopup({
			type: 'image',
			tLoading: 'Loading image #%curr%...',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0,1]
			},
			image: {
				titleSrc: 'title',
				verticalFit: true
			}
		});
	});

	/*To Top*/
	$(".to-top").hide();
	
	/* fade in #back-top */
	$(function() {
		$(window).scroll(function() {
			if($(this).scrollTop() > 100) {
				$('.to-top').fadeIn();
			} else {
				$('.to-top').fadeOut();
			}
		});
		
		// scroll body to 0px on click
		$('.to-top').on("click", function() {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

	if($('.main-container').find('.full-container')) {
		$('.full-container > div').removeClass('row-container');
	}
	
	$.fn.extend({  
         accordion: function() {       
            return this.each(function() {
            	
            	var $jqul = $(this);
            	
				if($jqul.data('accordiated'))
					return false;
													
				$.each($jqul.find('ul, li>div'), function(){
					$(this).data('accordiated', true);
					$(this).hide();
				});
				
				$.each($jqul.find('span.head'), function(){
					$(this).click(function(e){
						activate(this);
						return void(0);
					});
				});
				
				var active = (location.hash)?$(this).find('a[href=' + location.hash + ']')[0]:'';

				if(active){
					activate(active, 'toggle');
					$(active).parents().show();
				}
				
				function activate(el,effect){
					$(el).parent('li').toggleClass('active').siblings().removeClass('active').children('ul, div').slideUp('fast');
					$(el).siblings('ul, div')[(effect || 'slideToggle')]((!effect)?'fast':null);
				}
				
            });
        } 
    }); 
	
	$('.product-categories li a').wrapInner( "<span class='cat-title'></span>");
	$("ul.product-categories li.cat-parent").each(function(){
        $(this).append('<span class="head"><a href="javascript:void(0)"></a></span>');
    });
	
	$('ul.product-categories').accordion();
	
	$("ul.product-categories li.active").each(function(){
		$(this).children().next("ul").css('display', 'block');
	});
	
	var myVideo = document.getElementById("video1"); 
	$(".main-container .video-button i").click(function () { 
		if (myVideo.paused) 
			myVideo.play(); 
		else 
			myVideo.pause(); 
			
		$(this).toggleClass("fa-pause").toggleClass("fa-play");
	});
	
	$('.mobile-button').addClass("active");
    $('.mobile-button').click(function(){
        if($(this).parents('.footer-static-title').next().is(":visible")){
            $(this).addClass("active");
        }else{
            $(this).removeClass("active");
        }
        $(this).parents('.footer-static-title').next().toggle(400);
    });
	$('.top-category .mobile-category').on("click", function(){
        $('.top-category .widget_product_categories').toggleClass('active');
		$('.top-category .top-category-menu').toggle(300);
    });
	$('.mobile-search').on("click", function(){
        $('.widget_product_search').toggle(300);
    });
	$('.cart-info .mobile-cart').on("click", function(){
        $('.mcart-border').toggle(300);
    });
	
})(jQuery);


/* Get Param value */
function gongetParameterByName(name, string) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(string);
	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}


/* Remove item from mini cart by ajax */
function gonMiniCartRemove(url, itemid) {
	jQuery('.mcart-border').addClass('loading');
	jQuery('.cart-form').addClass('loading');
	
	jQuery.get(url, function(data,status){
		if(status=='success'){
			//update mini cart info
			jQuery.post(
				ajaxurl,
				{
					'action': 'gon_get_cartinfo'
				}, 
				function(response){
					var cartinfo = response.split("|");
					var itemAmount = cartinfo[0];
					var cartTotal = cartinfo[1];
					var orderTotal = cartinfo[2];
					var cartQuantity = cartinfo[3];
					
					jQuery('.mcart-number').html(cartQuantity);
					jQuery('.cart-quantity').html(itemAmount);
					jQuery('.cart-total .amount').html(cartTotal);
					jQuery('.total .amount').html(cartTotal);
					
					jQuery('.cart-subtotal .amount').html(cartTotal);
					jQuery('.order-total .amount').html(orderTotal);
				}
			);
			//remove item line from mini cart & cart page
			jQuery('#mcitem-' + itemid).animate({'height': '0', 'margin-bottom': '0', 'padding-bottom': '0', 'padding-top': '0'});
			setTimeout(function(){
				jQuery('#mcitem-' + itemid).remove();
				jQuery('#lcitem-' + itemid).remove();
			}, 1000);
			
			jQuery('.mcart-border').removeClass('loading');
			jQuery('.cart-form').removeClass('loading');
		}
	});
}


/* Tools Tip */
function gontip(element, content) {
	if(content=='html'){
		var tipText = element.html();
	} else {
		var tipText = element.attr('title');
	}
	element.on('mouseover', function(){
		if(jQuery('.gontip').length == 0) {
			element.before('<span class="gontip">'+tipText+'</span>');
			
			var tipWidth = jQuery('.gontip').outerWidth();
			var tipPush = -(tipWidth/2 - element.outerWidth()/2);
			jQuery('.gontip').css('margin-left', tipPush);
		}
	});
	element.on('mouseleave', function(){
		jQuery('.gontip').remove();
	});
}


/* Change Product Quantity */
jQuery(function($) {
	// Quantity buttons
	$('div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)').addClass('buttons_added').append('<span class="plus"><i class="icon-arrow-up icons"></i></span>').prepend('<span class="minus"><i class="icon-arrow-down icons"></i></span>');
	
	$(document).on('click', '.plus, .minus', function() {
		// Get values
		var $qty		= $(this).closest('.quantity').find('.qty'),
			currentVal	= parseFloat($qty.val()),
			max			= '',
			min			= 0,
			step		= 1;

		// Format values
		if(! currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
		if(max === '' || max === 'NaN') max = '';
		if(min === '' || min === 'NaN') min = 0;
		if(step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = 1;

		// Change the value
		if($(this).is('.plus')) {
			if(max &&(max == currentVal || currentVal > max)) {
				$qty.val(max);
			} else {
				$qty.val(currentVal + parseFloat(step));
			}
		} else {
			if(min &&(min == currentVal || currentVal < min)) {
				$qty.val(min);
			} else if(currentVal > 0) {
				$qty.val(currentVal - parseFloat(step));
			}
		}

		// Trigger change event
		$qty.trigger('change');
	});
});


/* Function Show NewsLetter Popup */
function gonShowNLPopup() {
	if(jQuery.cookie('gonnlpopup') != "1") {
		jQuery('.newsletterpopup').fadeIn();
		jQuery('.popupshadow').fadeIn();
	}
}


/* Function Hide NewsLetter Popup when click on button Close */
function gonHideNLPopup(){
	jQuery('.newsletterpopup').fadeOut();
	jQuery('.popupshadow').fadeOut();
	jQuery.cookie('gonnlpopup', 1);
}