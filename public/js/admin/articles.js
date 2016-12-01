define(['template'], function (template) {
  var Articles = function () {
    // do nothing.
  };

  $.extend(Articles.prototype, {
    data: {},

    // 文章列表
    index: function () {
      $('#search-form').loadParams().update(function () {
        recordTable.reload($(this).serialize(), false);
      });

      var recordTable = $('.js-record-table').dataTable({
        ajax: {
          url: $.queryUrl('admin/article.json')
        },
        columns: [
          {
            data: 'category.name'
          },
          {
            data: 'title'
          },
          {
            data: 'updateTime',
            sClass: 'text-center'
          },
          {
            data: 'sort'
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
    },

    // 编辑文章
    linkTo: {},
    edit: function (options) {
      $.extend(this, options);
      $('.js-article-form')
        .loadJSON(this.data)
        .ajaxForm({
          url: $.url('admin/article/' + (this.data.id ? 'update' : 'create')),
          dataType: 'json',
          beforeSubmit: function (arr, $form) {
            // FIXME jQuery对单个checkbox的处理
            arr.push({
              name: 'showCoverPic',
              value: Number($('#show-cover-pic').prop('checked'))
            });
            return $form.valid();
          },
          success: function (result) {
            $.msg(result);
          }
        })
        .validate();

      // FIXME loadJSON不支持checkbox
      $('#show-cover-pic').prop('checked', this.data.showCoverPic === '1');

      // 初始化链接选择器
      $('#link-to').linkTo({
        name: 'linkTo',
        data: this.data.linkTo,
        hide: {
          keyword: true,
          decorator: true
        }
      });

      $('#source-link-to').linkTo({
        name: 'sourceLinkTo',
        data: this.data.sourceLinkTo,
        hide: {
          keyword: true,
          decorator: true
        }
      });

      // 加载富文本编辑器
      $('#content').ueditor();

      // 点击选择图片
      $('#thumb').imageInput();
    }
  });

  return new Articles();
});
