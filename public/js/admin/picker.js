define([plugins/app/libs/artTemplate/template.min, 'form'], function (template) {
  var Picker = function (options) {
    if (options) {
      $.extend(this, options);
    }
    this.initialize.apply(this, arguments);
  };

  Picker.prototype.$el = $('body');

  // 已选的图文列表
  Picker.prototype.articles = [];

  Picker.prototype.initialize = function () {
    // do nothing.
  };

  Picker.prototype.$ = function (selector) {
    return this.$el.find(selector);
  };

  Picker.prototype.init = function (options) {
    if (options) {
      $.extend(this, options);
    }

    this.$articleTable = this.$('.js-article-picker-table');
    this.$articleList = this.$('.js-article-picker-list');
    this.$articleModal = this.$('.js-article-picker-modal');

    this.renderArticleList(this.articles);
    this.initEvent();
    this.initArticleTable();
  };

  Picker.prototype.initEvent = function () {
    var that = this;

    // 显示Modal
    this.$('.js-article-picker-modal-toggle').click(function () {
      that.$articleModal.modal('show');
    });

    // 移除单个图文
    this.$articleList.on('click', '.js-article-picker-remote', function () {
      that.removeArticleById($(this).data('id'));
      that.renderArticleList(that.articles);
    });

    // 选择文章,更新自动回复的图文
    this.$articleTable.on('change', 'input:checkbox', function () {
      // 将图文加入或移除
      var data = that.$articleTable.fnGetData($(this).parents('tr')[0]);
      if ($(this).is(':checked')) {
        that.articles.push(data);
      } else {
        that.articles.splice(that.articles.indexOf(data), 1);
      }

      // 更新表单中的图文卡片
      that.renderArticleList(that.articles);
    });

    // 刷新表格
    $('.js-article-picker-refresh').click(function (e) {
      that.$articleTable.reload();
      e.preventDefault();
    });

    // 筛选表单
    $('.js-article-picker-form').update(function () {
      that.$articleTable.reload($(this).serialize(), false);
    });
  };

  Picker.prototype.initArticleTable = function () {
    var that = this;
    this.$articleModal.on('show.bs.modal', function () {
      if ($.fn.dataTable.fnIsDataTable(that.$articleTable[0])) {
        that.$articleTable.reload();
      } else {
        that.renderArticleTable();
      }
    });
  };

  Picker.prototype.renderArticleTable = function () {
    var that = this;
    this.$articleTable = this.$articleTable.dataTable({
      dom: 't<\'row\'<\'col-sm-6\'ir><\'col-sm-6\'p>>',
      ajax: {
        url: $.queryUrl('admin/article.json')
      },
      columns: [
        {
          data: 'id',
          sClass: 'text-center',
          render: function (data) {
            var checked = '';
            for (var i in that.articles) {
              if (that.articles[i]['id'] === data) {
                checked = ' checked';
                break;
              }
            }
            return '<label><input type="checkbox" class="ace" value="' + data + '"' + checked + '><span class="lbl"></span></label>';
          }
        },
        {
          data: 'title'
        }
      ]
    });
  };

  // 根据ID删除文章
  Picker.prototype.removeArticleById = function (id) {
    for (var i in this.articles) {
      if (this.articles[i]['id'] === id) {
        this.articles.splice(i, 1);
      }
    }
  };

  // 设置图文内容并渲染
  Picker.prototype.setArticles = function (articles) {
    this.articles = articles;
    this.renderArticleList(articles);
  };

  // 渲染图文卡片
  Picker.prototype.renderArticleList = function (data) {
    var html = '';
    var $unselected = this.$('.js-message-editor-article-unselected');
    var $selected = this.$('.js-message-editor-article-selected');

    if (data.length) {
      html = template.render('media-article-tpl', {
        data: data,
        template: template
      });
      $unselected.hide();
      $selected.show();
    } else {
      $unselected.show();
      $selected.hide();
    }
    this.$articleList.html(html);
  };

  return new Picker();
});
