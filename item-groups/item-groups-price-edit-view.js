/* global ajaxurl */
(function ($) {
  'use strict';

  $(document).ready(function() {
    var sampleCells = $('table.prices-table tbody tr:first-child').remove().children().map(function (index, td) {
      return $(td).html();
    }).get();

    var dataTable = $('table.prices-table').DataTable({ });

    $(document).on('click', '.remove-price', function(event) {
      event.preventDefault();
      dataTable.row($(event.target).parents('tr'))
        .remove()
        .draw();

      $('input[name="price-count"]').val(dataTable.rows().count());
    });

    $(document).on('click', '#add-price', function (event) {
      event.preventDefault();
      var index = dataTable.rows().count();

      var newRow = $.map(sampleCells, function (sampleCell) {
        return sampleCell.replace('{{INDEX}}', index);
      });

     dataTable.row.add(newRow).draw();
     $('input[name="price-count"]').val(dataTable.rows().count());
    });
    
  });

})(jQuery);