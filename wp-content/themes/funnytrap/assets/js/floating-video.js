!function(t){"use strict";window.jnews.floating_video=window.jnews.floating_video||{},window.jnews.floating_video={container:null,element:null,wrapper:null,videoBottom:null,closeButton:null,closed:!1,ww:null,following:!1,position:"bottom_right",sidebar:null,offset:null,width:null,left:null,init:function(i){this.container=void 0!==i?i:t("body"),this.element=t(this.container).find(".jeg_featured.featured_video"),this.element.length&&(this.following=this.element.attr("data-following"),this.position=this.element.attr("data-position"),"1"===this.following&&(this.wrapper=t(this.element).find(".jeg_featured_video_wrapper"),this.closeButton=t(this.element).find(".floating_close"),this.resize(),t(window).on("scroll",this.scroll.bind(this)),t(window).on("ready resize",this.resize.bind(this)),t(this.closeButton).on("click",this.close.bind(this))))},unbind:function(){t(window).off("scroll",this.scroll.bind(this)),t(window).off("ready resize",this.resize.bind(this)),t(this.closeButton).off("click",this.close.bind(this))},close:function(){this.closed=!0,this.element.removeClass("floating")},resize:function(){this.element.length&&(this.videoBottom=this.element.outerHeight()+this.element.offset().top,this.ww=t(window).width(),this.sidebar=t(".jeg_sidebar")),this.sidebar.length>0&&(this.offset=this.sidebar.offset(),this.width=this.sidebar.width(),this.left=parseInt(this.sidebar.css("padding-left"))+parseInt(this.sidebar.css("margin-left")))},scroll:function(){this.closed||"1"!==this.following||(t(window).scrollTop()>this.videoBottom?(this.element.addClass("floating"),"sidebar"===this.position&&this.sidebar.length>0&&this.wrapper.width(this.width+20).css({top:100,left:this.offset.left+this.left-10})):(this.element.removeClass("floating"),this.wrapper.removeAttr("style")))}},t(document).bind("jnews-ajax-load",(function(t,i){jnews.floating_video.init(i)})),t(document).ready((function(){jnews.floating_video.init()}))}(jQuery);