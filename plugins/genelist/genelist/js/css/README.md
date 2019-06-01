# wHumanMsg.js

A jQuery humanized message plugin is a way to neatly overlay alerts and message for users using your app.  You can position your messages on any part of the screen and they will neatly fade in and out with any color and time delay you like.

* [View the wHumanMsg demo](http://whumanmsg.websanova.com)
* [Download the lastest version of wHumanMsg](https://github.com/websanova/wHumanMsg/tags)


## Related Plugins

* [wTooltip](http://wtooltip.websanova.com) - Simple sleek looking tooltips.
* [wModal](http://wmodal.websanova.com) - Clean looking and easy to use modals.


## Settings

Available options with notes, the values here are the defaults.

```javascript
$('#elem').wHumanMsg({
    theme           : 'black',      // set theme (color)
    opacity         : 0.8,          // set background opacity
    fadeIn          : 1000,         // set fade in speed in milliseconds
    fadeOut         : 1000,         // set fade out speed in milliseconds
    displayLength   : 5000,         // set length of time message will stay before fadeOut in milliseconds
    html            : true,         // set html flag to true/false
    fixed           : true,         // set fixed positioning to keep message at top of screen even when scrolling
    offsetTop       : 0,            // set offset from top
    showCloseButton : true          // toggle message close button
});
```

## Examples

Include and init the plugin:

```js
<script type="text/javascript" src="./wHumanMsg.js"></script>
<link rel="Stylesheet" type="text/css" href="./wHumanMsg.css" />
$("body").wHumanMsg();
```

### messages

```html
$("body").wHumanMsg('Hello World');
```

### colors

```js
$('body').wHumanMsg('Hello World!', {theme: 'red'});
```


## Resources

* [More jQuery plugins by Websanova](http://websanova.com/plugins)
* [jQuery Plugin Development Boilerplate](http://www.websanova.com/tutorials/jquery/jquery-plugin-development-boilerplate)
* [The Ultimate Guide to Writing jQuery Plugins](http://www.websanova.com/tutorials/jquery/the-ultimate-guide-to-writing-jquery-plugins)


## License

MIT licensed

Copyright (C) 2011-2012 Websanova http://www.websanova.com