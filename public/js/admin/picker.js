define(['form'], function () {
  var Picker = function (options) {
    options && $.extend(this, options);
    this.initialize.apply(this, arguments);
  };

  Picker.prototype.$el = $('body');

  // 已选的图文列表
  Picker.prototype.articles = [];

  Picker.prototype.initialize = function (options) {

  };

  Picker.prototype.$ = function (selector) {
    return this.$el.find(selector);
  };

  Picker.prototype.init = function (options) {
    options && $.extend(this, options);

    this.$articleTable = this.$('.js-article-picker-table');
    this.$articleList = this.$('.js-article-picker-list');
    this.$articleModal = this.$('.js-article-picker-modal');

    this.renderArticleList(this.articles);
    this.initEvent();
    this.initArticleTable();
  };

  Picker.prototype.initEvent = function () {
    var self = this;

    // 显示Modal
    this.$('.js-article-picker-modal-toggle').click(function () {
      self.$articleModal.modal('show');
    });

    // 移除单个图文
    this.$articleList.on('click', '.js-article-picker-remote', function () {
      self.removeArticleById($(this).data('id'));
      self.renderArticleList(self.articles);
    });

    // 选择文章,更新自动回复的图文
    this.$articleTable.on('change', 'input:checkbox', function () {
      // 将图文加入或移除
      var data = self.$articleTable.fnGetData($(this).parents('tr')[0]);
      if ($(this).is(':checked')) {
        self.articles.push(data);
      } else {
        self.articles.splice(self.articles.indexOf(data), 1);
      }

      // 更新表单中的图文卡片
      self.renderArticleList(self.articles);
    });

    // 刷新表格
    $('.js-article-picker-refresh').click(function (e) {
      self.$articleTable.reload();
      e.preventDefault();
    });

    // 筛选表单
    $('.js-article-picker-form').update(function () {
      self.$articleTable.reload($(this).serialize(), false);
    });
  };

  Picker.prototype.initArticleTable = function () {
    var self = this;
    this.$articleModal.on('show.bs.modal', function () {
      if ($.fn.dataTable.fnIsDataTable(self.$articleTable[0])) {
        self.$articleTable.reload();
      } else {
        self.renderArticleTable();
      }
    });
  };

  Picker.prototype.renderArticleTable = function () {
    var self = this;
    this.$articleTable = this.$articleTable.dataTable({
      dom: "t<'row'<'col-sm-6'ir><'col-sm-6'p>>",
      ajax: {
        url: $.queryUrl('admin/article.json')
      },
      columns: [
        {
          data: 'id',
          sClass: 'text-center',
          render: function (data) {
            var checked = '';
            for (var i in self.articles) {
              if (self.articles[i]['id'] == data) {
                checked = ' checked';
                break;
              }
            }
            return '<label><input type="checkbox" class="ace" value="' + data + '"' + checked + '><span class="lbl"></span></label>'
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
      if (this.articles[i]['id'] == id) {
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
      html = template.render('media-article-tpl', {data: data, template: template});
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
