<?= $block->js() ?>
<script>
  $('.js-article-like').click(function (e) {
    e.preventDefault();

    var $that = $(this);
    var $num = $that.find('.js-article-num');
    var num = parseInt($num.html(), 10);
    $.ajax({
      url: $.url('article-likes/toggle', {articleId: $that.data('id')}),
      dataType: 'json',
    }).then(function (ret) {
      if (ret.code !== 1) {
        $.msg(ret);
        return;
      }

      if ($that.hasClass('link-dark')) {
        $that.removeClass('link-dark').addClass('text-danger');
        $num.html(num + 1);
      } else {
        $that.removeClass('text-danger').addClass('link-dark');
        $num.html(num - 1);
      }
    });
  });
</script>
<?= $block->end() ?>
