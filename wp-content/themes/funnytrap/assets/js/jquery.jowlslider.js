!function(e){"use strict";e.fn.jowlslider=function(a){var l={items:5,responsive:{0:{items:4,nav:!1},768:{items:6,nav:!1},1024:{items:7,nav:!0}},margin:10,nav:!0,autoplay:!0,slideSpeed:500,delay:5e3,rtl:!1,thumbnail:".jeg_slider_thumbnail",theme:"jeg_owlslider",thumbnail_theme:"jeg_owlslider_thumbnail"};return a=a?e.extend(l,a):e.extend(l),e(this).each((function(){var l=e(this).addClass("owl-carousel"),t=!1,o=e(l).parent().find(a.thumbnail).addClass("owl-carousel"),i=!1;function n(e){var a=e.relatedTarget.relative(e.item.index),l=o.find(".owl-stage").children();l.removeClass("current"),l.eq(e.relatedTarget.normalize(a)).toggleClass("current")}a.hover=e(l).data("hover-action"),a.autoplay=e(l).data("autoplay"),a.delay=e(l).data("delay"),e(l).on("initialized.owl.carousel",(function(){l.siblings(".jeg_slider_placeholder").remove(),l.parent().addClass("jeg_slider_wrapper_loaded")})).owlCarousel({items:1,autoplay:a.autoplay,autoplaySpeed:a.slideSpeed,autoplayTimeout:a.delay,nav:a.nav,navText:!1,loop:!0,lazyLoad:!0,callbacks:!0,rtl:a.rtl}),o.on("initialized.owl.carousel",(function(e){n(e),o.addClass("disabled_nav")})).owlCarousel({nav:!1,navText:!1,dots:!1,navRewind:!1,items:a.items,margin:a.margin,rtl:a.rtl,lazyLoad:!0,responsive:a.responsive}),e(l).on("changed.owl.carousel",(function(e){var l=e.relatedTarget.relative(e.property.value,!0);t||(t=!0,o.trigger("to.owl.carousel",[l,a.slideSpeed,!0]),t=!1),n(e)})),o.mousedown((function(e){i=!0})).mouseup((function(e){i=!1})),o.on("changed.owl.carousel",(function(o){t||(t=!0,e(l).trigger("to.owl.carousel",o.item.index,a.slideSpeed,!0),t=!1)})).on("click",".owl-item",(function(t){t.preventDefault(),e(l).trigger("to.owl.carousel",e(this).index(),a.slideSpeed,!0)})).on("hover",".owl-item",(function(t){t.preventDefault(),!0===a.hover&&(i||e(l).trigger("to.owl.carousel",e(this).index(),a.slideSpeed,!0))}))}))}}(jQuery);