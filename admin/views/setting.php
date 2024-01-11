<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">设置</h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active" href="./setting.php">基础设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=user">用户设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=mail">邮件通知</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=seo">SEO设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=api">API</a></li>
        <li class="nav-item"><a class="nav-link" href="./blogger.php">个人信息</a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="setting.php?action=save" method="post" name="setting_form" id="setting_form">
            <h4>站点信息</h4>
            <div class="form-group">
                <label>站点标题</label>
                <input class="form-control" value="<?= $blogname ?>" name="blogname">
            </div>
            <div class="form-group">
                <label>站点副标题：</label>
                <textarea name="bloginfo" cols="" rows="3" class="form-control"><?= $bloginfo ?></textarea>
            </div>
            <div class="form-group">
                <label>站点地址</label>
                <input class="form-control" value="<?= $blogurl ?>" name="blogurl" type="url">
            </div>
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="detect_url" id="detect_url" <?= $conf_detect_url ?> />
                <label class="form-check-label" for="exampleCheck1">自动检测站点地址 (如开启后首页样式丢失，请关闭并手动填写站点地址)</label>
            </div>

            <div class="form-group">
                <label>你所在时区</label>
                <select name="timezone" style="width:320px;" class="form-control">
                    <?php foreach ($tzlist as $key => $value):
                        $ex = $key == $timezone ? "selected=\"selected\"" : '' ?>
                        <option value="<?= $key ?>" <?= $ex ?>><?= $value ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group">
                <label>ICP备案号</label>
                <input class="form-control" value="<?= $icp ?>" name="icp"/>
            </div>
            <div class="form-group">
                <label>首页底部信息(支持html，可用于添加流量统计代码)</label>
                <textarea name="footer_info" rows="6" class="form-control"><?= $footer_info ?></textarea>
            </div>

            <hr>

            <h4>评论设置</h4>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="iscomment" id="iscomment" <?= $conf_iscomment ?> />
                <label>开启评论</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="ischkcomment" id="ischkcomment" <?= $conf_ischkcomment ?> />
                <label>评论审核</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="comment_code" id="comment_code" <?= $conf_comment_code ?> />
                <label>评论验证码</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="isgravatar" id="isgravatar" <?= $conf_isgravatar ?> />
                <label>评论人头像</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="login_comment" id="login_comment" <?= $conf_login_comment ?> />
                <label>登录后评论，开启后仅登录用户可评论</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="comment_needchinese" id="comment_needchinese" <?= $conf_comment_needchinese ?> />
                <label>评论内容必须包含中文（防御国外垃圾评论）</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="comment_paging" id="comment_paging" <?= $conf_comment_paging ?> />
                <label>评论分页</label>
            </div>
            <div class="form-group form-inline">
                每页显示评论条数：<input maxlength="5" style="width:80px;" class="form-control" value="<?= $comment_pnum ?>" name="comment_pnum" type="number" min="0"/>
            </div>
            <div class="form-group form-inline">
                评论排序方式：<select name="comment_order" class="form-control" style="width: 120px;">
                    <option value="newer" <?= $ex3 ?>>新的靠前</option>
                    <option value="older" <?= $ex4 ?>>旧的靠前</option>
                </select>
            </div>
            <div class="form-group form-inline">
                发表评论间隔（秒）： <input class="form-control mx-sm-3" value="<?= $comment_interval ?>" name="comment_interval" style="width:80px;" type="number" min="0"/>
            </div>

            <hr>

            <h4>文章设置</h4>
            <div class="form-group form-inline">
                <label>每页显示文章数量</label>
                <input class="form-control mx-sm-3" style="width:80px;" value="<?= $index_lognum ?>" name="index_lognum" type="number" min="0"/>
            </div>

            <div class="form-group form-inline">
                RSS输出 <input maxlength="5" style="width:80px;" value="<?= $rss_output_num ?>" type="number" min="0" class="form-control" name="rss_output_num"/> 篇文章（0为关闭），且输出
                <select name="rss_output_fulltext" class="form-control">
                    <option value="y" <?= $ex1 ?>>全文</option>
                    <option value="n" <?= $ex2 ?>>摘要</option>
                </select>
            </div>
            <div class="alert alert-primary">
                RSS地址(用于RSS阅读器订阅你的站点内容)：<?= $blogurl . 'rss.php' ?>
            </div>

            <hr>

            <h4>上传设置</h4>
            <div class="form-group form-inline">
                文件上传最大限制 <input maxlength="20" style="width:120px;" class="form-control" value="<?= $att_maxsize ?>" name="att_maxsize"/> （单位：KB，1MB=1024KB）
            </div>
            <div class="form-group form-inline">
                允许上传的文件类型 <input maxlength="200" style="width:500px;" class="form-control" value="<?= $att_type ?>" name="att_type"/>（多个用半角逗号分隔）
            </div>
            <div class="form-group form-inline">
                <input type="checkbox" value="y" name="isthumbnail" id="isthumbnail" <?= $conf_isthumbnail ?> />上传图片生成缩略图，最大尺寸：
                <input maxlength="5" style="width:80px;" class="form-control" value="<?= $att_imgmaxw ?>" name="att_imgmaxw"/> x
                <input maxlength="5" style="width:80px;" class="form-control" value="<?= $att_imgmaxh ?>" name="att_imgmaxh"/>（单位：像素）
            </div>
            <hr>

            <h4>其他设置</h4>
            <div class="form-group form-inline">
                <label>后台每页展示条目数量</label>
                <input class="form-control mx-sm-3" style="width:80px;" value="<?= $admin_perpage_num ?>" name="admin_perpage_num" type="number" min="10" max="1000"/> （影响后台文章、评论、用户列表）
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="accept_app_recs" id="accept_app_recs" <?= $conf_accept_app_recs ?> />
                <label>接收来自官方的应用推荐（后台首页应用推荐展示）</label>
            </div>
            <hr>

            <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
            <input type="submit" value="保存设置" class="btn btn-sm btn-success"/>
        </form>
    </div>
</div>
<script>
    $(function () {
        $("#menu_category_sys").addClass('active');
        $("#menu_sys").addClass('show');
        $("#menu_setting").addClass('active');
        setTimeout(hideActived, 3600);

        // 提交表单
        $("#setting_form").submit(function (event) {
            event.preventDefault();
            submitForm("#setting_form");
        });
    });
</script>
