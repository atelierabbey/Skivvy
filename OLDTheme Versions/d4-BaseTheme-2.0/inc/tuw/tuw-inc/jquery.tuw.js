//
// Developed by Crevità Studios
// 16.08.2010
//
(function($) {
	$.fn.tuw = function(options) {
	
	// Converting URLs, mentions and hashtags to links
	$.fn.tuw.addLinks = function(text) {
		// URL to link
		var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
		var ret = text.replace(exp,"<a href='$1'>$1</a>");
		// Mention to link
		exp = /\@([A-Za-z0-9_]+)/ig;
		ret = ret.replace(exp,"<a href='http://twitter.com/$1'>@$1</a>");
		// Hashtag to link
		exp = /\#([A-Za-z0-9_]+)/ig;
		ret = ret.replace(exp,"<a href='http://twitter.com/search?q=%23$1'>#$1</a>");
		
		return ret;
	}

	// Helping dates and times look better for humans
	$.fn.tuw.time = function(time) {
		var date = new Date(time);
		var now = new Date();
		var dateDiff = (now.getTime() - date.getTime()) / 1000;
		if(isNaN(date.getTime())) {
			// Some browsers don't support our pretty times
			return time.substr(0,16);
		} else if(dateDiff < 60) {
			return "less than a minute ago";
		} else if(dateDiff < 120) {
			return "about 1 minute ago";
		} else if(dateDiff < 3600) {
			return "about " + Math.floor(dateDiff / 60) + " minutes ago";
		} else if(dateDiff < 7200) {
			return "about 1 hour ago";
		} else if(dateDiff < 86400) {
			return "about " + Math.floor(dateDiff / 3600) + " hours ago";
		} else if(dateDiff < 172800) {
			return "about 1 day ago";
		} else {
			return "about " + Math.floor(dateDiff / 86400) + " days ago";
		}
	};
	
	// Template parser function
	$.fn.tuw.templateParser = function(template, arguments) {
		var tem = $.fn.tuw.structureSimple[template];
		$.each(arguments, function(key,value) {
			tem = tem.replace(new RegExp("{"+key+"}", 'g'),value);
		});
		return tem;
	}

	// Default Options
	$.fn.tuw.defaults = {
		'username' : ['ebuyukkaya'],		// [string] Username of the tweep. Write multiple accounts in this format : ['username_1','username_2','username_3']
		'simpletheme' : false, 				// [boolean] For a simpler, static theme
		'updates' : 5, 						// [integer] Number of statuses you want to get
		'list' : null,						// [string] Name of a list which belongs to the username
		'query' : null,						// [string] If you want to list a search's results, write the query
		'color' : 'blue', 					// [string] [advanced theme] The color scheme - Default 'blue'
		'openbox' : true,	 				// [boolean] [advanced theme] The box is open on page load - Default 'true'
		'icon' : '1', 						// [boolean] [advanced theme] You can change icons from 1 to 4 - Default '1'
		// (experimental) 'rounded' : false,
		'autonext' : false,					// [boolean] [advanced theme] Move to other updates automatically
		'duration' : 5000,					// [integer] [advanced theme] The time between moves if autonext is true
		'linksinnewpage' : false,			// [boolean] Do you want the links opened in blank window or tab - Default 'false'
		'showavatar' : true,				// [boolean] Display user's avatar - Default 'true'
		'showusername' : true,				// [boolean] [advanced theme] Display username (only with single account) - Default 'true'
		'showdate' : true,					// [boolean] Display the time of tweet - Default 'true'
		'singlepostmode' : false,			// [boolean] In this mode, only the last update will be displayed
		'effect' : 'slide',					// [string] [advanced theme] May be 'slide', 'fade' or 'none' - Default 'none'
		'defaultPicture' : 'http://s.twimg.com/a/1281028705/images/default_profile_6_normal.png',
		'loadingText' : "Loading tweets..."	// [string] [advanced theme] The text displayed while loading
	};
	
	// HTML Structure for advanced box model.
	$.fn.tuw.structureAdvanced = '<div class="tuw_twi"><div class="tuw_head"><a class="but_toggle" href="javascript:;">&nbsp;<div class="tuw_logo">&nbsp;</div><span class="tuw_text tuw_username">updates</span><span class="tuw_toggle">&nbsp;</span></a></div><div class="tuw_contentbox"><div class="tuw_content"><div class="tuw_t"><div class="tuw_av tuw_l"><a class="tuw_av_a"><img /></a></div><div class="tuw_r tuw_updatetext"></div><div class="tuw_clear"></div></div><div class="tuw_b"><div class="tuw_l tuw_timetext"></div><div class="tuw_r tuw_buttons"><a href="javascript:;" class="tuw_next tuw_dis"></a><a href="javascript:;" class="tuw_prev tuw_dis"></a></div><div class="tuw_clear"></div></div></div></div></div>';
	// HTML Structure for simple list version. You can edit
	$.fn.tuw.structureSimple = {
		'container' : '<div class="tuw_simple"><ul class="tuw_container"></ul></div>', // Tweets are loaded into "tuw_container" class
		'tweetContainer' : '<li></li>',
		'avatarTemplate' : '<a title="@{username}" href="http://twitter.com/{username}"><img src="{avatar}" /></a>',
		'timeTemplate' : '<div class="tuw_date"><a title="@{username}" href="http://twitter.com/{username}/statuses/{id}">{time}</a></span>',
		'textTemplate' : '<div class="tuw_tweet">{text}</span>'
	};
	
	// Creating the final setting list
	var o = $.extend({}, $.fn.tuw.defaults, options);
	// If singlepostmode is on, update number should be '1' in any ways
	o.updates = (o.singlepostmode) ? 1 : o.updates;
	// Convert '#'s to '%23'
	o.query = (o.query) ? o.query.replace('#','%23') : null;
	
	// For multiple selections
	return this.each(function() {
		var $t = $(this);
		var total, current;
		
		// -------------
		// Create the box and customize
		// -------------
		if(o.simpletheme) {
			// Simple theme
			// Add container
			$t.html($.fn.tuw.structureSimple.container);
		} else {
			// Advanced theme
			// Add the html structure
			$t.html($.fn.tuw.structureAdvanced);
			// Loading text and image
			$('.tuw_updatetext', $t).text(o.loadingText);
			$('.tuw_av_a > img', $t).attr('src',o.defaultPicture);
			// Color scheme
			$('.tuw_twi', $t).addClass(o.color);
			// Rounded corners (experimental)
			// if(o.rounded) $('.tuw_twi', $t).addClass("rounded");
			// Open Box
			if(!o.openbox) { $('.tuw_toggle', $t).addClass("close");$('.tuw_contentbox', $t).hide(); }
			// Icon
			$('.tuw_logo', $t).addClass("tw"+o.icon);
			// If icon is a big one then add some top-padding to the box
			if(o.icon != 1) $('.tuw_twi').css("padding-top","40px");
			// Show Avatar
			if(!o.showavatar) $('.tuw_av', $t).hide();
			// Show Dates
			if(!o.showdate) $('.tuw_timetext', $t).hide();
			// Show Username
			if(o.showusername && o.username.length == 1 && !o.query) $('.tuw_username', $t).text("@"+o.username);
			// Single-post mode
			if(o.singlepostmode) $('.tuw_buttons', $t).hide();
			// Setting the width
			var boxWidth = $('.tuw_twi', $t).width();
			var width = (o.showavatar) ? (boxWidth - 85) : (boxWidth - 20);
			$('.tuw_updatetext', $t).width(width);
		}
		
		// -------------
		// Fetch data from server
		// -------------
		// Using ajax, getting data from twitter's servers
		$.getJSON(feedUrl(), function(data){	
			// Clean old and add new,fetched data to our html
			$('.tuw_updatetext', $t).html('<div class="tuw_updateslide"></div>');
			$('.tuw_timetext', $t).html('<div class="tuw_dateslide"></div>');
			
			$.each((data.results || data), function(i,item){
				// Create sliding element and insert data
				var author = item.from_user || item.user.screen_name;
				var formattedTime = $.fn.tuw.time(item.created_at);
				var formattedTweet = $.fn.tuw.addLinks(item.text);
				var avatarUrl = item.profile_image_url || item.user.profile_image_url;
				if(o.simpletheme) {
					// Simple Theme
					$('.tuw_container', $t).append($.fn.tuw.structureSimple.tweetContainer);
					var newTweet = $('.tuw_container li:last-child', $t);
					if(o.showavatar) newTweet.append($.fn.tuw.templateParser('avatarTemplate',{'avatar':avatarUrl,'username':author}));
					newTweet.append($.fn.tuw.templateParser('textTemplate',{'text':formattedTweet,'username':author}));
					if(o.showdate) newTweet.append($.fn.tuw.templateParser('timeTemplate',{'time':formattedTime,'username':author,'id':item.id}));
				} else {
					// Advanced Theme
					// Insert tweet
					$('.tuw_updateslide', $t).append('<div class="tuw_upbox_'+i+'"></div>');
					$('.tuw_upbox_'+i, $t).addClass('tuw_updatebox')
									.width(width)
									.attr('avatar_url','')
									.html(formattedTweet);
					// Insert date
					$('.tuw_dateslide', $t).append('<div class="tuw_dtbox_'+i+'"></div>');
					$('.tuw_dtbox_'+i, $t).addClass('tuw_datebox')
									.html('<a href="http://twitter.com/'+author+'/statuses/'+item.id+'">'+formattedTime+'</a>');
								
					// Save avatar
					$.data($t,'tweet_'+i,{'username':author,'avatar':avatarUrl});
				}
			});
			if(!o.simpletheme) {
				// Finishing
				total = (typeof data.results != "undefined") ? data.results.length : data.length;
				$('.tuw_updatetext', $t).height($('.tuw_upbox_0', $t).height()).scrollLeft(0);
				change(current = 1);
			
				// Open buttons
				buttonClasses();
			
				// Link targets
				if(o.linksinnewpage) $('a', $t).attr('target','_blank');
			
				// -------------
				// Timed actions
				// -------------
				if(o.autonext) var timed = setInterval(next,o.duration);
				// Stop timed event if mouse is moving over the box
				$('.tuw_twi', $t).hover(function(){
					if(o.autonext) clearInterval(timed);
				},function(){
					if(o.autonext) timed = setInterval(next,o.duration);
				});
				// -------------
				// Functional buttons and event bindings
				// -------------
				// Open/Close button
				$('.but_toggle', $t).click(function(event){
					$('.tuw_toggle', $t).toggleClass("close");

					// Open/Close the box according to the chosen effect
					switch(o.effect) {
						case "slide": $('.tuw_contentbox', $t).slideToggle();break;
						case "fade": $('.tuw_contentbox', $t).animate({'opacity':'toggle'});break;
						default: $('.tuw_content', $t).toggle();break;
					}

					change(current);
					event.preventDefault();
				});
				// Next button
				$('.tuw_next', $t).click(function(event) {
					next();
					event.preventDefault();
				});
				// Previous button
				$('.tuw_prev', $t).click(function(event) {
					previous();
					event.preventDefault();
				});
			}
		});

		// -------------
		// Functions
		// -------------
		//URL generator function
		function feedUrl() {
			var protocol = (document.location.protocol == 'https:' ? 'https:' : 'http:');
			if (o.list) {
				// Lists
				var url =  protocol+"//api.twitter.com/1/"+o.username[0]+"/lists/"+o.list+"/statuses.json?per_page="+o.updates+"&callback=?";
			} else if (o.query == null && o.username.length == 1) {
				// Single user
				var url =  protocol+'//twitter.com/status/user_timeline/'+o.username[0]+'.json?count='+o.updates+'&callback=?';
			} else {
				// Search query or multipe accounts
				var query = (o.query || 'from:'+o.username.join('%20OR%20from:'));
				var url = protocol+'//search.twitter.com/search.json?&rpp='+o.updates+'&q='+query+'&callback=?';
			}
			
			return url;
		}
		// Sliding the box for the given index
		function change(n) {
			// Change the current index
			current = n;
			
			n--;
			var scrLeft = n * width;
			var dateScrLeft = n * 130;
			var height = $('.tuw_upbox_'+n, $t).height();
			var tweet = $.data($t,'tweet_'+n);
			
			// Scroll text
			$('.tuw_updatetext', $t).animate({"height":height+"px","scrollLeft":scrLeft+"px"},500);
			// Change date
			$('.tuw_timetext', $t).scrollLeft(dateScrLeft);
			// Change avatar
			$('.tuw_av_a', $t).attr('href','http://twitter.com/'+tweet.username);
			$('.tuw_av_a > img', $t).attr('src',tweet.avatar);
			// Manage buttons' classes
			buttonClasses();
		}
		// Passing to the next tweet
		function next() {
			// Get the current index of tweets
			if(total > 1 && current != total) {
				// Increase it
				current++;
			
				// Scroll the bitch
				change(current);
			}
		}
		// Passing to the previos tweet
		function previous() {
			// Get the current index of tweets
			if(total > 1 && current != 1) {
				// Decrease it
				current--;
			
				// Scroll the bitch
				change(current);
			}
		}
		// Disabling/Enabling buttons
		function buttonClasses() {
			if(current != total) { $('.tuw_next', $t).removeClass('tuw_dis'); } else { $('.tuw_next', $t).addClass('tuw_dis'); }
			if(current == 1) { $('.tuw_prev', $t).addClass('tuw_dis') } else { $('.tuw_prev', $t).removeClass('tuw_dis'); };
		}
	});
	};
	
	// Time to sleep
})(jQuery);