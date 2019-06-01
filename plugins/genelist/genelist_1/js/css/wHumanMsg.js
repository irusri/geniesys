/******************************************
 * Websanova.com
 *
 * Resources for web entrepreneurs
 *
 * @author          Websanova
 * @copyright       Copyright (c) 2012 Websanova.
 * @license         This websanova humanized message jQuery plug-in is dual licensed under the MIT and GPL licenses.
 * @link            http://www.websanova.com
 * @github			http://github.com/websanova/wHumanMsg
 * @version         Version 1.1.5
 *
 ******************************************/

(function($)
{
	$.fn.wHumanMsg = function(option, settings)
	{
		if(typeof option === 'object')
		{
			settings = option;
		}
		else if(typeof option === 'string')
		{
			var values = [];

			var elements = this.each(function()
			{
				var data = $(this).data('_wHumanMsg');

				if(data)
				{
					if(option == 'reset') { data.reset(); }
					else if($.fn.wHumanMsg.defaultSettings[option] !== undefined)
					{
						if(option == 'offsetTop'){ data.hm.css('top', settings); }
						else if(settings !== undefined) { data.settings[option] = settings; }
						else { values.push(data.settings[option]); }
					}
					else//NOTE: message cannot be one of the settings options, theme, fadeIn, fadeOut, displayLength
					{
						data.showMessage(option, settings);
					}
				}
			});

			if(values.length === 1) { return values[0]; }
			if(values.length > 0) { return values; }
			else { return elements; }
		}

		settings = $.extend({}, $.fn.wHumanMsg.defaultSettings, settings || {});

		return this.each(function()
		{
			var $elem = $(this);

			var $settings = jQuery.extend(true, {}, settings);

			var hm = new HumanMsg($settings, $elem);

			$elem.append(hm.generate());

			$elem.data('_wHumanMsg', hm);
		});
	}

	$.fn.wHumanMsg.defaultSettings = {
		theme			: 'black',		// set theme (color)
		opacity			: 0.8,			// set background opacity
		fadeIn  		: 1000,         // set fade in speed in milliseconds
		fadeOut 		: 1000,			// set fade out speed in milliseconds
		displayLength	: 5000,			// set length of time message will stay before fadeOut in milliseconds
		html			: true,			// set html flag to true/false
		fixed			: true,			// set fixed positioning to keep message at top of screen even when scrolling
		offsetTop		: 0,			// set offset from top
		showCloseButton	: true			// toggle message close button
	};

	function HumanMsg(settings, elem)
	{
		this.hm = null;
		this.settings = settings;
		this.$elem = elem;

		this.msgObj = null;
		this.colorObj

		this.timer = null;

		return this;
	}

	HumanMsg.prototype = 
	{
		generate: function()
		{
			var $this = this;

			if($this.hm) return $this.hm;

			$this.bgObj = $('<div class="_wHumanMsg_bg"></div>').css('opacity', $this.settings.opacity);
			$this.msgObj = $('<div class="_wHumanMsg_msg">Message</div>')
			
			$this.colorObj = $('<div class="_wHumanMsg_outer _wHumanMsg_color_black">').click(function(){ 
			//$this.hm.fadeOut($this.settings.fadeOut); 
			});
			
			$this.closebtn=$('<div class="_wHumanMsg_close">X</div>').click(function(){ 
			$this.hm.fadeOut($this.settings.fadeOut); 
			});
			
			var messageHolder = $('<div class="_wHumanMsg_msgHolder"></div>').append($this.msgObj);
			
			
			
			if($this.settings.showCloseButton) messageHolder.append($this.closebtn);
			



			$this.hm = 
			$('<div class="_wHumanMsg_holder">')
			.css({top: $this.settings.offsetTop})
			.append( 
				$this.colorObj
				.append( $this.bgObj )
				.append( messageHolder )
			);
			
			if($this.settings.fixed) $this.hm.css('position', 'fixed');
			
			return $this.hm;
		},
		
		updateColor: function(color)
		{
			this.colorObj.attr('class', this.colorObj.attr('class').replace(/_wHumanMsg_color_[a-zA-Z0-9_]*/g, '')).addClass('_wHumanMsg_color_' + color);
		},
		
		showMessage: function(msg, settings)
		{
			var $this = this;
			var settings = settings || {};
			
			var color = settings.theme || $this.settings.theme;
			var opacity = settings.opacity || $this.settings.opacity;
			var fadeIn = settings.fadeIn || $this.settings.fadeIn;
			var fadeOut = settings.fadeOut || $this.settings.fadeOut;
			var displayLength = settings.displayLength || $this.settings.displayLength;
			var html = typeof settings.html === 'boolean' ? settings.html : $this.settings.html;
			
			clearTimeout($this.timer);
			
			//always fade out old message first
			$this.hm.fadeOut(fadeOut, function(){
				
				//updte color and message
				$this.updateColor(color);
				$this.bgObj.css('opacity', opacity);
				html ? $this.msgObj.html(msg) : $this.msgObj.text(msg);
				
				//fade the new message back in with the timer
				$this.hm.fadeIn(fadeIn, function()
				{
					$this.timer = setTimeout(function(){ $this.hm.fadeOut(fadeOut); }, displayLength);
				});
			});
		},
		
		reset: function()
		{
			this.settings = $.fn.wHumanMsg.defaultSettings;
		}
	}
})(jQuery);