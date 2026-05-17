(function ($, Drupal) {

  /**
   * EBT Tabs behavior.
   */
  Drupal.behaviors.ebtTabs = {
    attach: function (context, settings) {
      $.each(drupalSettings.ebtTabs, function(i, value){
        // Initialize jQuery UI tabs.
        var blockClass = drupalSettings.ebtTabs[i].blockClass;
        if ($('.' + blockClass).length == 0) {
          return;
        }
        var $blockTabs = $('.' + blockClass);
        if ($blockTabs.hasClass('tabs-added')) {
          return;
        }
        $blockTabs.append('<div id="ebt-tabs-' + blockClass + '" class="ebt-container"></div>');
        $('#ebt-tabs-' + blockClass).prepend('<ul class="tabs-' + blockClass + '"></ul>');

        let tabElement = '.' + blockClass + ' > .ebt-container > .field--name-field-ebt-tabs > .field__item > .paragraph--type--ebt-tab';
        const $elements =  $(once('reorderBlocks', tabElement));

        $elements.each(function(index) {
          $(this)
            .find('.ebt-tab-title')
            .first()
            .appendTo($('.tabs-' + blockClass))
            .wrap('<li><a href="#ebt-tabs-' + blockClass + '-' + index + '"></a></li>');
          $(this)
            .find('.ebt-tab-content')
            .first()
            .appendTo($('#ebt-tabs-' + blockClass))
            .wrap('<div id="ebt-tabs-' + blockClass + '-' + index + '"></div>');
        });

        var options = {};
        drupalBlockSettings = drupalSettings.ebtTabs[i].options;
        if (drupalBlockSettings.active != undefined && drupalBlockSettings.active != '') {
          options['active'] = parseInt(drupalBlockSettings.active);
        }

        if (drupalBlockSettings.collapsible != undefined) {
          if (drupalBlockSettings.collapsible == 1) {
            options['collapsible'] = true;
          }
          else {
            options['collapsible'] = false;
          }
        }

        if (drupalBlockSettings.closed != undefined && drupalBlockSettings.closed == 1) {
          options['active'] = false;
        }

        if (drupalBlockSettings.disable != undefined) {
          if (drupalBlockSettings.disable == 1) {
            options['disable'] = true;
          }
          else {
            options['disable'] = false;
          }
        }

        if (drupalBlockSettings.heightStyle != undefined) {
          options['heightStyle'] = Drupal.checkPlain(drupalBlockSettings.heightStyle);
        }

        $('#ebt-tabs-' + blockClass).tabs(options);
        $blockTabs.addClass('tabs-added');
      });
    }
  };

})(jQuery, Drupal);
