jQuery(document).ready(function($) {

	$('#mobile-menu').slideUp(0);$('#mobile-toggle').click(function(){$("#mobile-menu").slideToggle(400);});// MOBILE TOGGLE
	$('#mobile-menu .menu-item-has-children').addClass('menu-closed').children('ul').slideUp(0);$('#mobile-menu .menu-item-has-children').click(function(){$(this).toggleClass('menu-closed').children('ul').slideToggle(400);});// MOBILE MENU ACCORDION

});
