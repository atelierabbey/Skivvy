jQuery(document).ready(function($) {

	$('#mobile-nav').slideUp(0);$('#mobile-toggle').click(function(){$("#mobile-nav").slideToggle(400);});// MOBILE TOGGLE
	$('#mobile-nav .menu-item-has-children').addClass('menu-closed').children('ul').slideUp(0);$('#mobile-nav .menu-item-has-children').click(function(){$(this).toggleClass('menu-closed').children('ul').slideToggle(400);});// MOBILE MENU ACCORDION

});