(function ($, Drupal) {
  'use strict';

  Drupal.behaviors.cardInit = {
    attach: function (content, settings) {
      console.log('Card Initialized');
    }
  };

})(jQuery, Drupal);