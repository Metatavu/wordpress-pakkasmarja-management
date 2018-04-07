/* global ajaxurl */
(function ($) {
  'use strict';

  $(document).ready(function() {
    var sampleCells = $('table.prices-table tbody tr:first-child').remove().children().map(function (index, td) {
      return $(td).html();
    }).get();

    var dataTable = $('table.prices-table').DataTable({
      "paginate": false,
      "language": {
        "url": "https://cdn.metatavu.io/libs/datatables.net/1.10.16/i18n/finnish.json"
      }
    });

    $(document).on('click', '.remove-price', function(event) {
      event.preventDefault();

      var row = $(event.target).parents('tr');
      var id = row.find('input.id').val();
      if (id) {
        var idsText = $('input[name="deleted-prices"]').val();
        var ids = idsText ? idsText.split(',') : [];
        ids.push(id);
        $('input[name="deleted-prices"]').val(ids.join(','));
      }

      dataTable.row(row).remove().draw();
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