!function(t){"use strict";function e(){var e,s,o=(e=t("#vp-post-formats-ui-tabs a"),s="",t("body").hasClass("gutenberg-editor-page")||e.length<1?t('select[name="jnews_single_post[format]"]').val():(e.each((function(){t(this).hasClass("current")&&(s=t(this).attr("href").replace("#post-format-",""))})),s));t("#normal-sortables > div").each((function(){t(this).is("#wpb_visual_composer")||t(this).is("jnews_video_option_metabox")&&t(this).attr("style"," ")})),"video"===o?t("#jnews_video_option_metabox").show():t("#jnews_video_option_metabox").hide()}t(window).load((function(){!function(){e();var s=t("#vp-post-formats-ui-tabs a");t("body").hasClass("gutenberg-editor-page")||s.length<1?t('select[name="jnews_single_post[format]"]').on("change",e):s.live("click",e)}()}))}(jQuery);