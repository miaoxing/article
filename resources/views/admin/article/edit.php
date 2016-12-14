<?php $view->layout() ?>

<div class="page-header">
  <a class="btn pull-right" href="<?= $url('admin/article/index') ?>">返回列表</a>

  <h1>
    微官网
    <small>
      <i class="fa fa-angle-double-right"></i>
      文章管理
    </small>
  </h1>
</div>
<!-- /.page-header -->

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <form id="article-form" class="js-article-form form-horizontal" method="post" role="form">
      <div class="form-group">
        <label class="col-lg-2 control-label" for="category-id">
          栏目
        </label>

        <div class="col-lg-4">
          <select id="category-id" name="categoryId" class="form-control">
            <option value="">选择栏目</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="title">
          <span class="text-warning">*</span>
          标题
        </label>

        <div class="col-lg-4">
          <input type="text" class="form-control" name="title" id="title" data-rule-required="true">
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="author">
          作者
        </label>

        <div class="col-lg-4">
          <input type="text" class="form-control" name="author" id="author">
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="thumb">
          封面
        </label>

        <div class="col-lg-4">
          <div class="input-group">
            <input type="text" class="form-control" id="thumb" name="thumb">
            <span class="input-group-btn">
                <button id="select-thumb" class="btn btn-white" type="button">
                  <i class="fa fa-picture-o"></i>
                  选择图片
                </button>
            </span>
          </div>
        </div>
        <label class="col-lg-6 help-text" for="no">
          支持JPG、PNG格式，建议大图900像素 * 500像素，小图200像素 * 200像素，小于1M
        </label>
      </div>

      <div class="form-group">
        <div class="col-lg-offset-2 col-lg-4">
          <div class="checkbox">
            <label>
              <input type="checkbox" id="show-cover-pic" value="1"> 封面图片显示在正文中
            </label>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="intro">
          摘要
        </label>

        <div class="col-lg-4">
          <textarea class="form-control" id="intro" name="intro"></textarea>
        </div>

        <label class="col-lg-6 help-text" for="no">
          显示在列表或图文消息中.
        </label>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="content">
          正文
        </label>

        <div class="col-lg-8">
          <textarea id="content" name="content"></textarea>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="source-link-to">
          原文链接
        </label>

        <div class="col-lg-4">
          <p class="form-control-static" id="source-link-to"></p>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="link-to">
          跳转地址
        </label>

        <div class="col-lg-4">
          <p class="form-control-static" id="link-to"></p>
        </div>

        <label class="col-lg-6 help-text" for="no">
          如果设置了跳转地址,进入图文时,将不显示正文,自动跳转到该地址
        </label>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="safe">
          保密
        </label>

        <div class="col-lg-4">
          <label class="radio-inline">
            <input type="radio" name="safe" value="1"> 保密
          </label>
          <label class="radio-inline">
            <input type="radio" name="safe" value="0" checked> 公开
          </label>

        </div>

        <label class="col-lg-6 help-text" for="no">
          如果设置保密则图文不可转发分享(若设置跳转链接会失效)
        </label>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="sort">
          顺序
        </label>

        <div class="col-lg-4">
          <input type="text" class="form-control" name="sort" id="sort">
        </div>

        <label class="col-lg-6 help-text" for="no">
          大的显示在前面,按从大到小排列.
        </label>
      </div>

      <input type="hidden" name="id" id="id"/>

      <div class="clearfix form-actions form-group">
        <div class="col-lg-offset-2">
          <button class="btn btn-primary" type="submit">
            <i class="fa fa-check bigger-110"></i>
            保存
          </button>
          <?php $event->trigger('renderAdminFormActions', ['article']) ?>
          &nbsp; &nbsp; &nbsp;
          <a class="btn btn-white" href="<?= $url('admin/article/index') ?>">
            <i class="fa fa-undo bigger-110"></i>
            返回列表
          </a>
        </div>
      </div>
    </form>
  </div>
  <!-- PAGE CONTENT ENDS -->
</div><!-- /.col -->
<!-- /.row -->

<?= $block('js') ?>
<script>
  require(['plugins/article/js/admin/articles', 'linkTo',
    'form', 'ueditor', 'validator', 'dataTable', 'jquery-deparam'], function (articles, linkTo, form) {
    var categoryJson = <?= json_encode(wei()->category()->notDeleted()->withParent('article')->getTreeToArray()); ?>;
    form.toOptions($('#category-id'), categoryJson, 'id', 'name');

    articles.edit({
      data: <?= $article->toJson() ?>,
      linkTo: linkTo
    });
  });
</script>
<?= $block->end() ?>

<?php require $view->getFile('@link-to/link-to/link-to.php') ?>
