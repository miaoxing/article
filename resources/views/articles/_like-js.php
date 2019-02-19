<?php

$wei->page->addCss('//at.alicdn.com/t/font_872953_xjymyq0bg4o.css');
?>
<style>
  .article-list-like {
    bottom: 0;
  }
</style>

<?= $block->js() ?>
<script>
  $('.js-article-like').click(function (e) {
    e.preventDefault();

    var $that = $(this);
    var $num = $that.find('.js-article-num');
    var $icon = $that.find('i');
    var num = parseInt($num.html(), 10);
    $.ajax({
      url: $.url('article-likes/toggle', {articleId: $that.data('id')}),
      dataType: 'json',
    }).then(function (ret) {
      if (ret.code !== 1) {
        $.msg(ret);
        return;
      }

      if ($that.hasClass('text-body')) {
        $that.removeClass('text-body').addClass('text-danger');
        $icon.removeClass('icon-heart').addClass('icon-heart-fill');
        $num.html(num + 1);
      } else {
        $that.removeClass('text-danger').addClass('text-body');
        $icon.removeClass('icon-heart-fill').addClass('icon-heart');
        $num.html(num - 1);
      }
    });
  });
</script>
<?= $block->end() ?>
