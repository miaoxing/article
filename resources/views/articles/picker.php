<div class="js-article-picker-modal modal fade" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">选择图文</h4>
      </div>

      <div class="modal-body">
        <div class="well form-well">
          <form class="js-article-picker-form form-inline" role="form">
            <div class="form-group">
              <select class="form-control" name="categoryId" id="category-id">
                <option value="">全部栏目</option>
              </select>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="search" placeholder="请输入标题搜索">
            </div>

            <div class="form-group pull-right">
              <a class="js-article-picker-refresh btn btn-default" href="javascript:;">
                <i class="fa fa-refresh"></i>
                刷新列表
              </a>
              <a class="btn btn-success" href="<?= $url('admin/article/new') ?>" target="_blank">
                <i class="fa fa-plus"></i>
                新建图文
              </a>
            </div>
          </form>
        </div>
        <table class="js-article-picker-table article-table table table-bordered table-hover">
          <thead>
          <tr>
            <th class="t-4"></th>
            <th>标题</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<?= $block->js() ?>
<script>
  require(['form'], function (form) {
    form.toOptions($('#category-id'), <?= json_encode(wei()->category()->notDeleted()->withParent('article')->getTreeToArray()) ?>, 'id', 'name');
  });
</script>
<?= $block->end() ?>
