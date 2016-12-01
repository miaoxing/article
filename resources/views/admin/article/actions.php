<script id="table-actions" type="text/html">
  <div class="action-buttons">
    <?php wei()->event->trigger('mediaAction', ['article']); ?>
    <a href="<%= $.url('articles/%s', id) %>" target="_blank" title="查看">
      <i class="fa fa-search-plus bigger-130"></i>
    </a>
    <a href="<%= $.url('admin/article/edit', {id: id}) %>" title="编辑">
      <i class="fa fa-edit bigger-130"></i>
    </a>
    <a class="text-danger delete-record" data-href="<%= $.url('admin/article/destroy', {id: id}) %>"
      href="javascript:;" title="删除">
      <i class="fa fa-trash-o bigger-130"></i>
    </a>
  </div>
</script>
