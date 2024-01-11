<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">设置</h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./setting.php">基础设置</a></li>
        <li class="nav-item"><a class="nav-link active" href="./setting.php?action=user">用户设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=mail">邮件通知</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=seo">SEO设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=api">API</a></li>
        <li class="nav-item"><a class="nav-link" href="./blogger.php">个人信息</a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="setting.php?action=user_save" method="post" name="user_setting_form" id="user_setting_form">
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="is_signup" id="is_signup" <?= $conf_is_signup ?> />
                <label class="form-check-label">开启用户注册</label>
            </div>
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="login_code" id="login_code" <?= $conf_login_code ?> >
                <label class="form-check-label">开启登录注册图形验证码</label>
            </div>
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="email_code" id="email_code" <?= $conf_email_code ?> >
                <label class="form-check-label">开启注册邮件验证码（开启需配置邮件通知服务）</label>
            </div>
            <hr>
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="ischkarticle" id="ischkarticle" <?= $conf_ischkarticle ?> />
                <label class="form-check-label">注册用户发布文章需要审核</label>
            </div>
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="article_uneditable" id="article_uneditable" <?= $conf_article_uneditable ?> />
                <label>审核通过的文章用户不可编辑、删除</label>
            </div>
            <div class="form-group form-inline">
                <label>注册用户限制24小时发文数量（包括草稿）：</label>
                <input class="form-control mx-sm-3" style="width:60px;" value="<?= $conf_posts_per_day ?>" type="number" min="0" name="posts_per_day"/> （为0同时禁止上传图文资源）
            </div>
            <div class="form-group form-inline">
                <label>用户中心文章别名：</label>
                <input class="form-control mx-sm-3" style="width:80px;" value="<?= $conf_posts_name ?>" name="posts_name"/> 如：帖子、投稿、资源等
            </div>
            <div class="form-group">
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
                <input type="submit" value="保存设置" class="btn btn-sm btn-success"/>
            </div>
        </form>
        <div class="alert alert-warning">
            <b>用户组</b><br>
            注册用户：可以发文投稿、管理自己的文章、图文资源<br>
            内容编辑：负责全站文章、资源、评论等内容的管理<br>
            管理员：拥有站点全部管理权限，可以管理用户、进行系统设置等<br>
        </div>
    </div>
</div>
<script>
    $(function () {
        $("#menu_category_sys").addClass('active');
        $("#menu_sys").addClass('show');
        $("#menu_setting").addClass('active');
        setTimeout(hideActived, 3600);

        // 提交表单
        $("#user_setting_form").submit(function (event) {
            event.preventDefault();
            submitForm("#user_setting_form");
        });
    });
</script>
