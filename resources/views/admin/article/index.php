<?php $view->layout() ?>

<?= $block('css') ?>
<link rel="stylesheet" href="<?= $asset('plugins/admin/assets/filter.css') ?>"/>
<?= $block->end() ?>

<?php require $view->getFile('article:admin/article/page-header.php'); ?>

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="table-responsive">
      <form class="form-horizontal filter-form" id="search-form" role="form">

        <div class="well form-well m-b">
          <div class="form-group form-group-sm">

            <label class="col-md-1 control-label" for="categoryId">栏目：</label>

            <div class="col-md-3">
              <select class="form-control" name="categoryId" id="categoryId">
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
          <th style="width: 120px">栏目名称</th>
          <th>标题</th>
          <th style="width: 200px">修改时间</th>
          <th style="width: 60px">作者</th>
          <th style="width: 60px">顺序</th>
          <?php wei()->event->trigger('tableCol', ['article']); ?>
          <th style="width: 220px">操作</th>
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

<?= $block('js') ?>
<script>
  require(['form', 'dataTable',  'jquery-deparam'], function (form) {
    form.toOptions($('#categoryId'), <?= json_encode(wei()->category()->notDeleted()->withParent('article')->getTreeToArray()) ?>, 'id', 'name');

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
