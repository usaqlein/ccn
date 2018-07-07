(function ($, Drupal) {
  'use strict';

  Drupal.behaviors.boxInit = {
    attach: function (content, settings) {
      console.log('Box Initialized');
    }
  };

})(jQuery, Drupal);