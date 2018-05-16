/* global ajaxurl */
(function ($) {
  'use strict';

  function getQuery() {
    var query = {};
    var params = window.location.search.split("&");
    for (var i = 0; i < params.length; i++) {
      var param = params[i].split('=');
      query[param[0]] = param[1];
    }
    
    return query;
  }

  function parseQueryString(query) {
     return $.map(query, function (value, name) {
      return name + '=' + value;
    }).join('&');
  }

  $(document).on("change", ".table-nav-query-select", function (e) {
    var value = $(e.target).val();
    var variable = $(e.target).attr('data-variable');

    var query = getQuery();
    query[variable] = value;

    window.location.search = parseQueryString(query);
  });

  $(document).on("click", ".export-contracts-xlsx-btn", function (e) {
    e.preventDefault();
    var query = getQuery();
    query.action = "xlsx";

    window.location.search = parseQueryString(query);
  });


})(jQuery);