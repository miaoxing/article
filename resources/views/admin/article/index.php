<?php $view->layout() ?>

<?= $block->css() ?>
<link rel="stylesheet" href="<?= $asset('plugins/admin/css/filter.css') ?>"/>
<?= $block->end() ?>

<?php require $view->getFile('article:admin/article/page-header.php'); ?>

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="table-responsive">
      <form class="form-horizontal filter-form" id="search-form" role="form">

        <div class="well form-well m-b">
          <div class="form-group form-group-sm">

            <label class="col-md-1 control-label" for="category-id">栏目：</label>

            <div class="col-md-3">
              <select class="form-control" name="categoryId" id="category-id">
                <option value="">全部栏目</option>
              </select>
            </div>

            <?php wei()->event->trigger('searchForm', ['article']); ?>

            <label class="col-md-1 control-label" for="search">标题：</label>

            <div class="col-md-3">
              <input type="text" class="form-control" id="search" name="search">
            </div>

          </div>
        </div>
      </form>

      <table id="record-table" class="js-record-table record-table table table-bordered table-hover">
        <thead>
        <tr>
          <th class="t-5">栏目名称</th>
          <th>标题</th>
          <th class="t-9">修改时间</th>
          <th class="t-6">作者</th>
          <th class="t-4">顺序</th>
          <th class="t-4">UV/PV</th>
          <?php wei()->event->trigger('tableCol', ['article']); ?>
          <th class="t-10">操作</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    <!-- /.table-responsive -->
    <!-- PAGE CONTENT ENDS -->
  </div>
  <!-- /col -->
</div>
<!-- /row -->

<?php require $view->getFile('article:admin/article/actions.php'); ?>

<?= $block->js() ?>
<script>
  require(['form', 'dataTable',  'jquery-deparam'], function (form) {
    var categoryJson = <?= json_encode(wei()->category()->notDeleted()->withParent('article')->getTreeToArray()); ?>;
    form.toOptions($('#category-id'), categoryJson, 'id', 'name');

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
          data: 'title',
          sClass: 'text-left'
        },
        {
          data: 'updateTime'
        },
        {
          data: 'author'
        },
        {
          data: 'sort'
        },
        {
          data: 'pv',
          render: function (data, type, full) {
            return full.uv + '/' + full.pv;
          }
        },
        <?php wei()->event->trigger('tableData', ['article']); ?>
        {
          data: 'id',
          render: function (data, type, full) {
            return template.render('table-actions', full)
          }
        }
      ]
    });

    recordTable.deletable();
  });
</script>
<?= $block->end() ?>
