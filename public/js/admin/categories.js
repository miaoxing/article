define(['assets/apps/admin/category'], function (categoryUtil) {
  var Categories = function () {

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

  return new Categories;
});
