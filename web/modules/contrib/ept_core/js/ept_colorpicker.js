(function ($, Drupal) {

  /**
   * EPT Core Colorpicker plugin.
   */
  Drupal.behaviors.eptCore = {
    attach: function (context, settings) {
      let colorFields = [
        'input[name="field_ept_settings[0][ept_settings][design_options][other_settings][border_color]"]',
        'input[name="settings[block_form][field_ept_settings][0][ept_settings][design_options][other_settings][border_color]"]',
        'input[name="field_ept_settings[0][ept_settings][design_options][other_settings][background_color]"]',
        'input[name="settings[block_form][field_ept_settings][0][ept_settings][design_options][other_settings][background_color]"]',
        'input[name*="[field_ept_settings][0][ept_settings][design_options][other_settings][background_video_settings][overlayColor]"]',
        'input[name*="[field_ept_settings][0][ept_settings][design_options][other_settings][background_image_settings][overlayColor]"]',
        'input[name*="[field_ept_settings][0][ept_settings][design_options][other_settings][background_color]"]',
        'input[name*="[field_ept_settings][0][ept_settings][design_options][other_settings][border_color]"]',
        'input[name="ept_core_primary_color"]',
        'input[name="ept_core_primary_button_text_color"]',
        'input[name="ept_core_secondary_color"]',
        'input[name="ept_core_secondary_button_text_color"]',
        'input[name="ept_core_background_color"]',
      ];

      colorFields.forEach(colorField => {
        let $elements = $(once('colorpicker', colorField, context));

        $elements.ColorPicker({
          onBeforeShow: function () {
            let color = $(this).val();
            if (color !== undefined && color !== '') {
              color = '#' + color.replace('#', '');
              $(this).ColorPickerSetColor(color);
            }
          },
          onShow: function (colpkr) {
            $(colpkr).fadeIn(300);
            return false;
          },
          onHide: function (colpkr) {
            $(colpkr).fadeOut(300);
            return false;
          },
          onChange: function (hsb, hex, rgb) {
            $(this.data('colorpicker').el).val('#' + hex);
          }
        });
      });
    }
  };

})(jQuery, Drupal);
