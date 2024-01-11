<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['active_del'])): ?>
    <div class="alert alert-success">删除页面成功</div><?php endif ?>
<?php if (isset($_GET['active_hide_n'])): ?>
    <div class="alert alert-success">发布页面成功</div><?php endif ?>
<?php if (isset($_GET['active_hide_y'])): ?>
    <div class="alert alert-success">转为草稿成功</div><?php endif ?>
<?php if (isset($_GET['active_pubpage'])): ?>
    <div class="alert alert-success">页面保存成功</div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">页面</h1>
    <a href="page.php?action=new" class="btn btn-sm btn-success shadow-sm mt-4"><i class="icofont-plus"></i>
        新建页面</a>
</div>
<form action="page.php?action=operate_page" method="post" name="form_page" id="form_page">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover dataTable no-footer">
                    <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll"/></th>
                        <th>标题</th>
                        <th>评论</th>
                        <th>浏览</th>
                        <th>别名</th>
                        <th>模板</th>
                        <th>时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pages as $key => $value):
                        $isHide = '';
                        if ($value['hide'] == 'y') {
                            $isHide = '<span class="text-danger ml-2"> - 草稿</span>';
                        }
                        ?>
                        <tr>
                            <td style="width: 19px;">
                                <input type="checkbox" name="page[]" value="<?= $value['gid'] ?>" class="ids"/></td>
                            <td>
                                <a href="page.php?action=mod&id=<?= $value['gid'] ?>"><?= $value['title'] ?></a>
                                <?= $isHide ?>
                                <?php if ($value['gid'] == Option::get('home_page_id')): ?>
                                    <br>
                                    <span class="text-secondary">
                                        <span class="badge small badge-danger">首页</span> 已设为首页，原默认首页请访问：<a href="<?= BLOG_URL ?>posts" target="_blank"><?= BLOG_URL ?>posts</a>
                                    </span>
                                <?php endif; ?>
                                <?php if ($value['link']): ?><br><span class="small">🔗</span><?php endif ?>
                            </td>
                            <td>
                                <a href="comment.php?gid=<?= $value['gid'] ?>" class="badge badge-info"><?= $value['comnum'] ?></a>
                            </td>
                            <td>
                                <a href="<?= Url::log($value['gid']) ?>" class="badge badge-secondary" target="_blank"><?= $value['views'] ?></a>
                            </td>
                            <td><?= $value['alias'] ?></td>
                            <td><?= $value['template'] ?></td>
                            <td class="small"><?= $value['date'] ?></td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="list_footer">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="javascript:pageact('hide');" class="btn btn-sm btn-primary">转为草稿</a>
                    <a href="javascript:pageact('pub');" class="btn btn-sm btn-success">发布</a>
                    <a href="javascript:pageact('del');" class="btn btn-sm btn-danger">删除</a>
                </div>
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
                <input name="operate" id="operate" value="" type="hidden"/>
            </div>
            <div class="page"><?= $pageurl ?></div>
            <div class="text-center small">(有 <?= $pageNum ?> 个页面 )</div>
        </div>
    </div>
</form>
<script>
    $(function () {
        setTimeout(hideActived, 3600);
        $("#menu_category_view").addClass('active');
        $("#menu_view").addClass('show');
        $("#menu_page").addClass('active');
    });

    function pageact(act) {
        if (getChecked('ids') === false) {
            Swal.fire("", "请选择要操作的页面!", "info");
            return;
        }
        if (act === 'del') {
            Swal.fire({
                title: '确定要删除所选页面吗',
                text: '删除后可能无法恢复',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: ' 取消',
                confirmButtonText: '确定',
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#operate").val(act);
                    $("#form_page").submit();
                }
            });
            return;
        }
        $("#operate").val(act);
        $("#form_page").submit();
    }
</script>
