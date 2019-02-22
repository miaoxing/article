<?php $view->layout() ?>

<div class="page-header">
  <a class="btn pull-right btn-success" href="<?= $url('admin/articleCategory/new') ?>">添加栏目</a>
  <h1>
    图文管理
    <small>
      <i class="fa fa-angle-double-right"></i>
      文章栏目管理
    </small>
  </h1>
</div>
<!-- /.page-header -->

<div class="row">
  <div class="col-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="table-responsive">
      <div class="well">
        <form class="form-inline" id="search-form" role="form">
          <div class="form-group">
            <input type="text" class="form-control" name="search" placeholder="请输入名称搜索">
          </div>
        </form>
      </div>
      <table id="category-table" class="table table-bordered table-hover">
        <thead>
        <tr>
          <th>名称</th>
          <th>简介</th>
          <th class="t-4">UV/PV</th>
          <th class="t-5">顺序</th>
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

<script id="table-actions" type="text/html">
  <div class="action-buttons">
    <a href="<%= $.url('articles', {categoryId: id}) %>" title="查看" target="_blank">
      <i class="fa fa-search-plus bigger-130"></i>
    </a>
    <a href="<%= $.url('admin/articleCategory/edit', {id: id}) %>" title="编辑">
      <i class="fa fa-edit bigger-130"></i>
    </a>
    <a class="text-danger delete-record" href="javascript:"
      data-href="<%= $.url('admin/articleCategory/destroy', {id: id}) %>" title="删除">
      <i class="fa fa-trash-o bigger-130"></i>
    </a>
  </div>
</script>

<?= $block->js() ?>
<script>
  require(['plugins/article/js/admin/categories', 'plugins/category/js/admin/categories',
    'plugins/admin/js/data-table', 'plugins/admin/js/form'], function (categories) {
    categories.index();
  });
</script>
<?= $block->end() ?>
