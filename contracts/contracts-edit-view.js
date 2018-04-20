/* global ajaxurl */
(function ($) {
  'use strict';

  $(document).ready(function () {
    $('input[name="contact-id-ac"]').autocomplete({
      source: function( request, response ) {
        $.post(ajaxurl, {
          'action': 'pakkasmarja_search_contacts',
          'search': request.term
        }, function (data) {
          response(JSON.parse(data));
        })
        .fail(function (response) {
          alert(response.responseText || response.statusText);
        });
      },
      select: function(event, ui) {
        $('input[name="contact-id"]').val(ui.item.id);
      }
    });
  });
  
})(jQuery);