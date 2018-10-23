/* global ajaxurl */
(function ($) {
  'use strict';

  $(document).ready(function () {
    $("[name=expires-dp]").datepicker($.extend(locales, {
      altField: "[name=expires]",
      altFormat: $.datepicker.ISO_8601
    }));

  });
  
  $(document).on("click", ".expires-clear", function () {
    $("[name=expires-dp]").datepicker("setDate", null);
  });

})(jQuery);