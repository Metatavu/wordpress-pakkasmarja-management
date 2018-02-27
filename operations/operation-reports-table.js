/* global ajaxurl */
(function ($) {
  'use strict';
  
  $(document).on('click', '#doaction', function (event) {
    event.preventDefault();
    
    var button = $(event.target);
    var nav = button.closest('.tablenav');
    var operationType = nav.find('select[name="operation-type"]').val();
    var operationTypeText = nav.find('select[name="operation-type"] option[value="'  + operationType + '"]').text();
    var dialogContent = button.attr('data-dialog-content').replace(/\%s/, operationTypeText);

    $('<div>')
      .attr('title', button.attr('data-dialog-title'))
      .text(dialogContent)
      .dialog({
        resizable: false,
        height: "auto",
        width: 400,
        modal: true,
        buttons : [{
          text: button.attr('data-dialog-confirm'),
          click: function() {
            $.post(ajaxurl + '?action=pakkasmarja_operation_create&type=' + operationType, function () {
              window.location.reload(true);
            })
            .fail(function(jqXHR, message) {
              $("<div>").text(jqXHR.responseText).dialog({
                modal: true,
                buttons: {
                  Ok: function() {
                    $( this ).dialog( "close" );
                  }
                }
              });
            });
          }
        }, {
          text: button.attr('data-dialog-cancel'),
          click: function() {
            $( this ).dialog( "close" );
          }
        }]
      })
      .dialog("open");
  });
  
})(jQuery);