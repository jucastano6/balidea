/**
 * Attaches the single_datetime behavior.
 *
 * @type {Drupal~behavior}
 */
(function ($, Drupal, once, drupalSettings) {
    Drupal.behaviors.customButton = {
      attach(context) {
        const elements = once('myfeature', 'body', context);
        if (elements.length){
          const button_title = Drupal.t("Click to see sitename");
          const custom_button = '<button class="click-sitename">'+button_title+'</button>';
          $('body').append(custom_button);
          loadAlert();
        }
      }
    };

    function loadAlert() {
      $('.click-sitename').on('click', function() {
        alert(drupalSettings.site.name);
      });
    }
  }(jQuery, Drupal, once, drupalSettings));