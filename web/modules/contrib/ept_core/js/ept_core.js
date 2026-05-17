(function ($, Drupal) {

  /**
   * EPT Core behavior.
   */
  Drupal.behaviors.eptCore = {
    attach: function (context, settings) {
      $.each(drupalSettings['eptCore'], function(paragraph_class, value) {
        if (value['eptCoreParallax'] != undefined) {
          $('.' + paragraph_class).parallax({
            imageSrc: Drupal.checkPlain(value['eptCoreParallax']['mediaUrl'])
          });
        }

        if (value['eptCoreBackgroundRemoteVideo'] != undefined) {
          if (value['eptCoreBackgroundRemoteVideo']['mediaProvider'] == 'YouTube') {
            const $elements = $(once('youtube-video', '.' + paragraph_class + ' .bg-inner', context));
            let options = {
              videoURL: Drupal.checkPlain(value['eptCoreBackgroundRemoteVideo']['mediaUrl']),
              containment: '.' + paragraph_class,
              autoPlay: value['eptCoreBackgroundRemoteVideo']['background_video_settings']['autoPlay'],
              showControls: value['eptCoreBackgroundRemoteVideo']['background_video_settings']['showControls'],
              mute: value['eptCoreBackgroundRemoteVideo']['background_video_settings']['mute'],
              startAt: value['eptCoreBackgroundRemoteVideo']['background_video_settings']['startAt'],
              opacity: value['eptCoreBackgroundRemoteVideo']['background_video_settings']['opacity'],
              addRaster: value['eptCoreBackgroundRemoteVideo']['background_video_settings']['addOverlay'],
              useOnMobile: value['eptCoreBackgroundRemoteVideo']['background_video_settings']['useOnMobile'],
              playOnlyIfVisible: value['eptCoreBackgroundRemoteVideo']['background_video_settings']['playOnlyIfVisible'],
              stopMovieOnBlur: value['eptCoreBackgroundRemoteVideo']['background_video_settings']['stopMovieOnBlur'],
              loop: value['eptCoreBackgroundRemoteVideo']['background_video_settings']['loop'],
              quality: 'default',
            }
            if (value['eptCoreBackgroundRemoteVideo']['background_video_settings']['coverImage'].length > 0) {
              options.coverImage = value['eptCoreBackgroundRemoteVideo']['background_video_settings']['coverImage'];
            }
            if (value['eptCoreBackgroundRemoteVideo']['background_video_settings']['mobileFallbackImage'].length > 0) {
              options.coverImage = value['eptCoreBackgroundRemoteVideo']['background_video_settings']['mobileFallbackImage'];
            }
            $elements.YTPlayer(options);
          }
        }


        if (value['eptCoreBackgroundVideo'] != undefined) {
          const $elements = $(once('local-video', '.' + paragraph_class, context));
          if ($elements.length) {
            let options = {
              poster: null,
              overlay: false,
              overlayColor: value['eptCoreBackgroundVideo']['background_video_settings']['overlayColor'],
              overlayAlpha: value['eptCoreBackgroundVideo']['background_video_settings']['overlayAlpha'],
            }

            let attributes = {
              autoplay: value['eptCoreBackgroundVideo']['background_video_settings']['autoPlay'],
              controls: value['eptCoreBackgroundVideo']['background_video_settings']['showControls'],
              loop: value['eptCoreBackgroundVideo']['background_video_settings']['loop'],
              muted: value['eptCoreBackgroundVideo']['background_video_settings']['mute'],
              playsInline: true,
            };

            if (value['eptCoreBackgroundVideo']['background_video_settings']['addOverlay']) {
              options.overlay = true;
            }

            if (value['eptCoreBackgroundVideo']['background_video_settings']['coverImage'].length > 0) {
              options.poster = value['eptCoreBackgroundVideo']['background_video_settings']['coverImage'];
            }

            if (value['eptCoreBackgroundVideo']['mediaUrl'].endsWith('.webm')) {
              options.webm = value['eptCoreBackgroundVideo']['mediaUrl'];
              var instance = new vidbg('.' + paragraph_class, options, attributes);
            }
            else if (value['eptCoreBackgroundVideo']['mediaUrl'].endsWith('.mp4')) {
              options.mp4 = value['eptCoreBackgroundVideo']['mediaUrl'];
              var instance = new vidbg('.' + paragraph_class, options, attributes);
            }
            else {
              console.log('Background video file must be mp4 or webm');
            }
          }

        }

      });
    }
  };

})(jQuery, Drupal);
