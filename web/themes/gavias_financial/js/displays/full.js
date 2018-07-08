(function ($, Drupal) {
  'use strict';

  Drupal.behaviors.fullInit = {
    attach: function (content, settings) {
      console.log('full initialized');
    }
  };

})(jQuery, Drupal);