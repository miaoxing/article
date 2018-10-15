define(['template', 'assets/apps/admin/category'], function (template, categoryUtil) {
  var Categories = function () {
    // do nothing.
  };

  $.extend(Categories.prototype, {
    index: function () {
      var recordTable = $('#category-table').dataTable({
        ajax: {
          url: $.url('admin/articleCategory.json', {parentId: 'article'})
        },
        columns: [
          {
            data: 'name',
            render: function (data, type, full) {
              return categoryUtil.generatePrefix(full.level) + data;
            }
          },
          {
            data: 'description',
            render: function (data) {
              return data || '-';
            }
          },
          {
            data: 'pv',
            sClass: 'text-center',
            render: function (data, type, full) {
              return full.uv + '/' + full.pv;
            }
          },
          {
            data: 'sort',
            sClass: 'text-center'
          },
          {
            data: 'id',
            sClass: 'text-center',
            render: function (data, type, full) {
              return template.render('table-actions', full);
            }
          }
        ]
      });

      recordTable.deletable();

      $('#search-form').update(function () {
        recordTable.reload($(this).serialize(), false);
      });
    }
  });

  return new Categories();
});
