/**
 * jCarouselLite - jQuery plugin to navigate images/any content in a carousel style widget.
 * @requires jQuery v1.2 or above
 *
 * http://gmarwaha.com/jquery/jcarousellite/
 *
 * Copyright (c) 2007 Ganeshji Marwaha (gmarwaha.com)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * Version: 1.0.1
 * Note: Requires jquery 1.2 or above from version 1.0.1
 */
(function($) {
$.fn.jCarouselLite = function(o) {
    o = $.extend({
        btnPrev: null,
        btnNext: null,
        btnGo: null,
        mouseWheel: false,
        auto: null,

        speed: 200,
        easing: null,

        vertical: false,
        circular: true,
        visible: 3,
        start: 0,
        scroll: 1,

        beforeStart: null,
        afterEnd: null
    }, o || {});

    return this.each(function() {

        var running = false, animCss=o.vertical?"top":"left", sizeCss=o.vertical?"height":"width";
        var div = $(this), ul = $("ul", div), tLi = $("li", ul), tl = parseInt(tLi.size()), v = o.visible;

		// Nabeel - determine which buttons show on/off
        if(o.circular) 
        {
            ul.prepend(tLi.slice(tl-v-1+1).clone())
              .append(tLi.slice(0,v).clone());
            o.start += v;
        }
		else
		{
			start_pos = parseInt(o.start);
						
			if(start_pos == 0)
			{
				$(o.btnPrev).addClass("disabled");
			}
			
			if(start_pos == tl-1 || tl <= 1)
			{
				$(o.btnNext).addClass("disabled");
			}
		}
		
        var li = $("li", ul), itemLength = li.size(), curr = o.start;
        div.css("visibility", "visible");

        li.css({overflow: "hidden", float: o.vertical ? "none" : "left"});
        ul.css({margin: "0", padding: "0", position: "relative", "list-style-type": "none", "z-index": "1"});
        div.css({overflow: "hidden", position: "relative", "z-index": "2", left: "0px"});

        var liSize = o.vertical ? height(li) : width(li);   // Full li size(incl margin)-Used for animation
        var ulSize = liSize * itemLength;                   // size of full ul(total length, not just for the visible items)
        var divSize = liSize * v;                           // size of entire div(total length for just the visible items)

        li.css({width: li.width(), height: "100%"/*li.height()*/});
        ul.css(sizeCss, ulSize+"px").css(animCss, -(curr*liSize));

        div.css(sizeCss, divSize+"px");                     // Width of the DIV. length of visible images
			
        if(o.btnPrev)
		{
			$(o.btnPrev).unbind("click");
            $(o.btnPrev).click(function() {
                return go(curr-o.scroll);
            });
		}

        if(o.btnNext)
		{
			$(o.btnNext).unbind("click");
            $(o.btnNext).click(function() {
                return go(curr+o.scroll);
            });
		}

        if(o.btnGo)
		{
            $.each(o.btnGo, function(i, val) {
                $(val).click(function() {
                    return go(o.circular ? o.visible+i : i);
                });
            });
		}

        if(o.mouseWheel && div.mousewheel)
		{
            div.mousewheel(function(e, d) {
                return d>0 ? go(curr-o.scroll) : go(curr+o.scroll);
            });
		}

        if(o.auto)
		{
            setInterval(function() {
                go(curr+o.scroll);
            }, o.auto+o.speed);
		}
			
		// Call the 'after end' callback once loaded
		if(o.afterEnd)
			o.afterEnd.call(this, li.slice(curr).slice(0,v));

        function vis() {
            return li.slice(curr).slice(0,v);
        };
	
        function go(to) {
            if(!running) {

                if(o.beforeStart)
                    o.beforeStart.call(this, vis());

                if(o.circular) {            // If circular we are in first or last, then goto the other end
                    if(to<=o.start-v-1) {           // If first, then goto last
                        ul.css(animCss, -((itemLength-(v*2))*liSize)+"px");
                        // If "scroll" > 1, then the "to" might not be equal to the condition; it can be lesser depending on the number of elements.
                        curr = to==o.start-v-1 ? itemLength-(v*2)-1 : itemLength-(v*2)-o.scroll;
                    } else if(to>=itemLength-v+1) { // If last, then goto first
                        ul.css(animCss, -( (v) * liSize ) + "px" );
                        // If "scroll" > 1, then the "to" might not be equal to the condition; it can be greater depending on the number of elements.
                        curr = to==itemLength-v+1 ? v+1 : v+o.scroll;
                    } else curr = to;
                } else {                    // If non-circular and to points to first or last, we just return.
                    if(to<0 || to>itemLength-v) return;
                    else curr = to;
                }                           // If neither overrides it, the curr will still be "to" and we can proceed.

                running = true;

				//curr_pos_size = ul.css("left") - curr*liSize;
				//ul.css("left", curr_pos_size);
                ul.animate(
                    animCss == "left" ? { left: -(curr*liSize) } : { top: -(curr*liSize) } , 1, o.easing,
                    function() {
                        if(o.afterEnd)
                            o.afterEnd.call(this, vis());
                        running = false;
                    }
                );
				
                // Disable buttons when the carousel reaches the last/first, and enable when not
                if(!o.circular) {
                    $(o.btnPrev + "," + o.btnNext).removeClass("disabled");
                    $( (curr-o.scroll<0 && o.btnPrev)
                        ||
                       (curr+o.scroll > itemLength-v && o.btnNext)
                        ||
                       []
                     ).addClass("disabled");
				}
            }
            return false;
        };
    });
};

function css(el, prop) {
    return parseInt($.css(el[0], prop)) || 0;
};
function width(el) {
    return  el[0].offsetWidth + css(el, 'marginLeft') + css(el, 'marginRight');
};
function height(el) {
    return el[0].offsetHeight + css(el, 'marginTop') + css(el, 'marginBottom');
};

})(jQuery);

/*
 * jQuery Easing v1.1 - http://gsgd.co.uk/sandbox/jquery.easing.php
 *
 * Uses the built in easing capabilities added in jQuery 1.1
 * to offer multiple easing options
 *
 * Copyright (c) 2007 George Smith
 * Licensed under the MIT License:
 *   http://www.opensource.org/licenses/mit-license.php
 */

jQuery.easing = {
	easein: function(x, t, b, c, d) {
		return c*(t/=d)*t + b; // in
	},
	easeinout: function(x, t, b, c, d) {
		if (t < d/2) return 2*c*t*t/(d*d) + b;
		var ts = t - d/2;
		return -2*c*ts*ts/(d*d) + 2*c*ts/d + c/2 + b;		
	},
	easeout: function(x, t, b, c, d) {
		return -c*t*t/(d*d) + 2*c*t/d + b;
	},
	expoin: function(x, t, b, c, d) {
		var flip = 1;
		if (c < 0) {
			flip *= -1;
			c *= -1;
		}
		return flip * (Math.exp(Math.log(c)/d * t)) + b;		
	},
	expoout: function(x, t, b, c, d) {
		var flip = 1;
		if (c < 0) {
			flip *= -1;
			c *= -1;
		}
		return flip * (-Math.exp(-Math.log(c)/d * (t-d)) + c + 1) + b;
	},
	expoinout: function(x, t, b, c, d) {
		var flip = 1;
		if (c < 0) {
			flip *= -1;
			c *= -1;
		}
		if (t < d/2) return flip * (Math.exp(Math.log(c/2)/(d/2) * t)) + b;
		return flip * (-Math.exp(-2*Math.log(c/2)/d * (t-d)) + c + 1) + b;
	},
	bouncein: function(x, t, b, c, d) {
		return c - jQuery.easing['bounceout'](x, d-t, 0, c, d) + b;
	},
	bounceout: function(x, t, b, c, d) {
		if ((t/=d) < (1/2.75)) {
			return c*(7.5625*t*t) + b;
		} else if (t < (2/2.75)) {
			return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
		} else if (t < (2.5/2.75)) {
			return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
		} else {
			return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
		}
	},
	bounceinout: function(x, t, b, c, d) {
		if (t < d/2) return jQuery.easing['bouncein'] (x, t*2, 0, c, d) * .5 + b;
		return jQuery.easing['bounceout'] (x, t*2-d,0, c, d) * .5 + c*.5 + b;
	},
	elasin: function(x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
	},
	elasout: function(x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	},
	elasinout: function(x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
	},
	backin: function(x, t, b, c, d) {
		var s=1.70158;
		return c*(t/=d)*t*((s+1)*t - s) + b;
	},
	backout: function(x, t, b, c, d) {
		var s=1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	},
	backinout: function(x, t, b, c, d) {
		var s=1.70158;
		if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
		return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
	},
	linear: function(x, t, b, c, d) {
		return c*t/d + b; //linear
	}
};