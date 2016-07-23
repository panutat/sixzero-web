!function(){function getStyles(config){ return "<meta name='sharer'><link rel='stylesheet' href='http://weloveiconfonts.com/api/?family=entypo'><style>"+config.selector+"{width:110px;height:34px}"+config.selector+" [class*='entypo-']:before{font-family:'entypo', sans-serif}"+config.selector+" label{cursor:pointer;margin:0;padding:10px 25px;-webkit-border-radius:3px;-moz-border-radius:3px;-o-border-radius:3px;-ms-border-radius:3px;border-radius:3px;background:"+config.button_background+";color:"+config.button_color+";-webkit-transition:all .3s ease;-moz-transition:all .3s ease;-o-transition:all .3s ease;-ms-transition:all .3s ease;transition:all .3s ease}"+config.selector+" label:hover{background:#0079a1}"+config.selector+" label span{padding-left:8px}"+config.selector+" .social{-webkit-transform-origin:50% 0%;-moz-transform-origin:50% 0%;-o-transform-origin:50% 0%;-ms-transform-origin:50% 0%;transform-origin:50% 0%;-webkit-transform:scale(0) translateY(-190px);-moz-transform:scale(0) translateY(-190px);-o-transform:scale(0) translateY(-190px);-ms-transform:scale(0) translateY(-190px);transform:scale(0) translateY(-190px);-webkit-filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=0);-moz-filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=0);-o-filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=0);-ms-filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=0);filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=0);opacity:0;-webkit-transition:all 0.4s ease;-moz-transition:all 0.4s ease;-o-transition:all 0.4s ease;-ms-transition:all 0.4s ease;transition:all 0.4s ease;margin-left:-15px}"+config.selector+" .social.active{-webkit-filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=100);-moz-filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=100);-o-filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=100);-ms-filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=100);filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=100);opacity:1;-webkit-transform:scale(1) translateY(-90px);-moz-transform:scale(1) translateY(-90px);-o-transform:scale(1) translateY(-90px);-ms-transform:scale(1) translateY(-90px);transform:scale(1) translateY(-90px);-webkit-transition:all 0.4s ease;-moz-transition:all 0.4s ease;-o-transition:all 0.4s ease;-ms-transition:all 0.4s ease;transition:all 0.4s ease;margin-left:-35px}"+config.selector+" ul{position:relative;left:0;right:0;width:180px;height:46px;color:#fff;background:#3b5998;margin:auto;padding:0;list-style:none}"+config.selector+" ul li{color:#eeeeee;font-size:20px;cursor:pointer;width:60px;margin:0;padding:8px 0;text-align:center;float:left;display:block;height:46px;position:relative;z-index:2;-webkit-transition:all .3s ease;-moz-transition:all .3s ease;-o-transition:all .3s ease;-ms-transition:all .3s ease;transition:all .3s ease}"+config.selector+" ul li:hover{color:#ffffff;}"+config.selector+" ul:after{content:'';display:block;width:0px;height:0px;position:absolute;left:0;right:0;margin:35px auto;border-left:20px solid transparent;border-right:20px solid transparent;border-top:20px solid #3b5998}"+config.selector+" li[class*='twitter']{background:#6cdfea;padding:8px 0}"+config.selector+" li[class*='gplus']{background:#e34429;padding:8px 0}</style>"};$.fn.share = function(opts) {
    var bubble, click_link, close, config, open, paths, set_opt, toggle,
        _this = this;
    $(this).hide();
    if (opts == null) {
        opts = {};
    }
    config = {};
    config.url = opts.url || window.location.href;
    config.text = opts.text || $('meta[name=description]').attr('content') || '';
    config.app_id = opts.app_id;
    config.title = opts.title;
    config.image = opts.image;
    config.button_color = opts.color || '#ffffff';
    config.button_background = opts.background || '#008cba';
    config.button_icon = opts.icon || 'export';
    config.button_text = opts.button_text || 'Share';
    set_opt = function(base, ext) {
        if (opts[base]) {
            return opts[base][ext] || config[ext];
        } else {
            return config[ext];
        }
    };
    config.twitter_url = set_opt('twitter', 'url');
    config.twitter_text = set_opt('twitter', 'text');
    config.fb_url = set_opt('facebook', 'url');
    config.fb_title = set_opt('facebook', 'title');
    config.fb_caption = set_opt('facebook', 'caption');
    config.fb_text = set_opt('facebook', 'text');
    config.fb_image = set_opt('facebook', 'image');
    config.gplus_url = set_opt('gplus', 'url');
    config.selector = "." + ($(this).attr('class'));
    config.twitter_text = encodeURIComponent(config.twitter_text);
    if (typeof config.app_id === 'integer') {
        config.app_id = config.app_id.toString();
    }
    if (!$('meta[name=sharer]').length) {
        $('head').append(getStyles(config));
    }
    $(this).html("<label class='entypo-" + config.button_icon + "'><span>" + config.button_text + "</span></label><div class='social'><ul><li class='entypo-twitter' data-network='twitter'></li><li class='entypo-facebook' data-network='facebook'></li><li class='entypo-gplus' data-network='gplus'></li></ul></div>");
    if (!window.FB && config.app_id) {
        $('body').append("<div id='fb-root'></div><script>(function(a,b,c){var d,e=a.getElementsByTagName(b)[0];a.getElementById(c)||(d=a.createElement(b),d.id=c,d.src='//connect.facebook.net/en_US/all.js#xfbml=1&appId=" + config.app_id + "',e.parentNode.insertBefore(d,e))})(document,'script','facebook-jssdk');</script>");
    }
    paths = {
        twitter: "http://twitter.com/intent/tweet?text=" + config.twitter_text + "&url=" + config.twitter_url,
        facebook: "https://www.facebook.com/sharer/sharer.php?u=" + config.fb_url,
        gplus: "https://plus.google.com/share?url=" + config.gplus_url
    };
    bubble = $(this).parent().find('.social');
    toggle = function(e) {
        e.stopPropagation();
        return bubble.toggleClass('active');
    };
    open = function() {
        return bubble.addClass('active');
    };
    close = function() {
        return bubble.removeClass('active');
    };
    click_link = function() {
        var link;
        link = paths[$(this).data('network')];
        if (($(this).data('network') === 'facebook') && config.app_id) {
            window.FB.ui({
                method: 'feed',
                name: config.fb_title,
                link: config.fb_url,
                picture: config.fb_image,
                caption: config.fb_caption,
                description: config.fb_text
            });
        } else {
            window.open(link, 'targetWindow', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=500,height=350');
        }
        return false;
    };
    $(this).find('label').on('click', toggle);
    $(this).find('li').on('click', click_link);
    $('body').on('click', function() {
        if (bubble.hasClass('active')) {
            return bubble.removeClass('active');
        }
    });
    setTimeout((function() {
        return $(_this).show();
    }), 250);
    return {
        toggle: toggle.bind(this),
        open: open.bind(this),
        close: close.bind(this),
        options: config,
        self: this
    };
};
}.call(this)