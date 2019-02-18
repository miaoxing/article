<div class="form-group d-none js-link-to-article">
  <div class="col-8 offset-3">
    <table class="record-table table table-bordered table-hover">
      <thead>
      <tr>
        <th>标题</th>
      </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    <input type="hidden" class="js-link-to-input-article">
  </div>
</div>

<?= $block->js() ?>
<script>
$(document)
  .on('linkToChangeType', function (e) {
    // 选择了图文,才加载表格
    if (e.curType != 'article') {
      return;
    }

    var $el = e.$el;
    var $table = $el.find('.js-link-to-article table');
    var $input = $el.find('.js-link-to-input-article');

    require(['dataTable'], function () {
      if ($.fn.dataTable.fnIsDataTable($table[0])) {
        $table.dataTable().reload();
        return;
      }

      // 重新赋值,获得dataTable API
      $table = $table.dataTable({
        dom: "t<'row'<'col-sm-6'ir><'col-sm-6'p>>",
        ajax: {
          url: $.url('admin/article.json')
        },
        columns: [
          {
            data: 'title',
            sClass: 'text-left',
            render: function (data, option, full) {
              full.selectedId = $input.val() || e.value;
              return template.render('articleLinkToTpl', full);
            }
          }
        ]
      });
    });

    $el.on('click', '.js-link-to-article-id', function () {
      $input.val($(this).val());
    });
  })
  .on('linkToGetName', function (e, result) {
    if (e.linkTo.type != 'article') {
      return;
    }
    var ret = $.ajax({
      url: $.url('admin/article/show', {id: e.linkTo.value}),
      dataType: 'json',
      async: false,
      global: false, // 如果文章已经被删除等情况,不展示提示
      success: function () {
        // 留空屏蔽默认提示信息
      }
    });
    if (typeof ret.responseJSON != 'undefined') {
      result.name = ret.responseJSON.data.title;
    } else {
      result.name = '(不存在)';
    }
  });
</script>
<script id="articleLinkToTpl" type="text/html">
  <label class="radio-inline">
    <input class="js-link-to-article-id" type="radio" style="margin-top: 1px" name="linkToArticleId" value="<%= id %>" <%= id == selectedId ? 'checked' : '' %>>
    <%= title %>
  </label>
</script>
<?= $block->end() ?>
