/* global ajaxurl */
(function ($) {
  'use strict';

  function checkLastEmpty() {
    var lastInput = $("[name='predefined-texts[]']:last-of-type");
    var lastEmpty = !lastInput.val();

    if (!lastEmpty) {
      $("<input>").attr({
        "name": "predefined-texts[]",
        "style": "width: 100%"
      })
      .insertAfter(lastInput);
    }
  }

  $(document).on("change", "[name='predefined-texts[]']", function () {
    checkLastEmpty();
  });

  $(document).ready(function () {
    checkLastEmpty();
  });
  
})(jQuery);