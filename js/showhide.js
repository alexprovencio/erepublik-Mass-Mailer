/*

    Copyright (c) 2009 Dana Woodman
    
    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:
    
    The above copyright notice and this permission notice shall be included in
    all copies or substantial portions of the Software.
    
    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
    THE SOFTWARE.
    
*/
(function($) {
    
    $.fn.showhide = function(options) {
        
        // Compile default options and user specified options.
        var opts = $.extend({}, $.fn.showhide.defaults, options);
        
        return $(this).each(function() {
            
            var obj = $(this);
            
            // Build element specific options.
            obj.o = $.meta ? $.extend({}, opts, $this.data()) : opts;
            
            // If there is a custom target object, use that, if not, use ".next()"
            if (obj.o.target_obj) {
                obj.o.target = obj.o.target_obj;
            } else {
                obj.o.target = obj.next();
            };
            
            // Set expiration of cookie, if it exists.
            if (obj.o.cookie_expires) {
                obj.o.cookie_options = {expires: obj.o.cookie_expires};
            }
            
            // Show function.
            show = function(object) {
                object.removeClass(object.o.plus_class);
                object.addClass(object.o.minus_class);
                if (object.o.minus_text) {
                    object.text(object.o.minus_text);
                };
                object.o.target.removeClass(object.o.hide_class);
                object.o.target.addClass(object.o.show_class);
                if (object.o.use_cookie) {
                    $.cookie(object.o.cookie_name, 'visible', object.o.cookie_options);
                };
                if (obj.o.focus_target) {
                    obj.o.focus_target.focus();
                };
            };
            
            // Hide function.
            hide = function(object) {
                object.removeClass(object.o.minus_class);
                object.addClass(object.o.plus_class);
                if (object.o.plus_text) {
                    object.text(object.o.plus_text);
                };
                object.o.target.removeClass(object.o.show_class);
                object.o.target.addClass(object.o.hide_class);
                if (object.o.use_cookie) {
                    $.cookie(object.o.cookie_name, 'hidden', object.o.cookie_options);
                };
            };
            
            // Using cookies.
            if (obj.o.use_cookie) {
                
                // Check for cookie. If set, set default state.
                if ($.cookie(obj.o.cookie_name)) {
                    if ($.cookie(obj.o.cookie_name) == 'visible') {
                        show(obj);
                    }
                    else if ($.cookie(obj.o.cookie_name) == 'hidden') {
                        hide(obj);
                    }
                    
                    // Shouldn't get here. If it does, set value to default.
                    else {
                        $.cookie(obj.o.cookie_name, obj.o.cookie_value);
                        if ($.cookie(obj.o.cookie_name) == 'visible') {
                            show(obj);
                            
                        }
                        else if ($.cookie(obj.o.cookie_name) == 'hidden') {
                            hide(obj);
                            
                        }
                    };
                }
                
                // If no cookie, set default state by setting.
                else {
                    $.cookie(obj.o.cookie_name, obj.o.cookie_value);
                    if (obj.o.default_open) {
                        show(obj);
                    }
                    else {
                        hide(obj);
                    }
                }
                
                // Handle clicks on toggle object.
                obj.click(function() {
                    if ($.cookie(obj.o.cookie_name) == 'visible') {
                        hide(obj);
                        return false;
                    }
                    else {
                        show(obj);
                        return false;
                    };
                });
            }
            
            // Not using cookies.
            else {
                if (obj.o.default_open) { show(obj); }
                else { hide(obj); }
                
                // Handle clicks on toggle object.
                obj.click(function() {
                    if (obj.o.target.hasClass(obj.o.hide_class)) {
                        show(obj);
                        return false;
                    }
                    else if (obj.o.target.hasClass(obj.o.show_class)) {
                        hide(obj);
                        return false;
                    };
                });
            };
            
        });
    };
    
    $.fn.showhide.defaults = {
        target_obj: null, // An optional target jQuery object that will be show/hidden.
        focus_target: null, // An optional target jQuery object to focus text onto when showing the hidden element.
        default_open: true, // If true, the target will be show, if false it will be hidden by default. This is overridden by the cookie, if it is set.
        show_class: 'show', // Class name to get applied to the link that shows the target.
        hide_class: 'hide', // Class name to get applied to the link that hides the target.
        plus_class: 'plus', // Class name to get applied to the link that indicates it is expandable.
        plus_text: null,
        minus_class: 'minus', // Class name to get applied to the link that indicates it is contractable.
        minus_text: null,
        use_cookie: false, // If true, use a cookie to store the last chosen state. If false, do not use a cookie.
        cookie_expires: 365, // Number of days until cookie expires
        cookie_name: 'show_target' // A name for the cookie, this must be unique.
    };
})(jQuery);
