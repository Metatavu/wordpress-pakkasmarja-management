/* global ajaxurl */
(function ($) {
  'use strict';

  $(document).on("change", ".table-nav-query-select", function (e) {
    var value = $(e.target).val();
    var variable = $(e.target).attr('data-variable');

    var query = {};
    var params = window.location.search.split("&");
    for (var i = 0; i < params.length; i++) {
      var param = params[i].split('=');
      query[param[0]] = param[1];
    }
    query[variable] = value;

    window.location.search = $.map(query, function (value, name) {
      return name + '=' + value;
    }).join('&');
  });

})(jQuery);