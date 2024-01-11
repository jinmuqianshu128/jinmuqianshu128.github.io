<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (User::isAdmin()): ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">设置</h1>
    </div>
<?php endif; ?>
<div class="panel-heading">
    <?php if (User::isAdmin()): ?>
        <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link" href="./setting.php">基础设置</a></li>
            <li class="nav-item"><a class="nav-link" href="./setting.php?action=user">用户设置</a></li>
            <li class="nav-item"><a class="nav-link" href="./setting.php?action=mail">邮件通知</a></li>
            <li class="nav-item"><a class="nav-link" href="./setting.php?action=seo">SEO设置</a></li>
            <li class="nav-item"><a class="nav-link" href="./setting.php?action=api">API</a></li>
            <li class="nav-item"><a class="nav-link active" href="./blogger.php">个人信息</a></li>
        </ul>
    <?php endif; ?>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <div class="row m-5">
            <div class="col-md-4">
                <label for="upload_image">
                    <img src="<?= $icon ?>" width="120" id="avatar_image" class="rounded-circle"/>
                    <input type="file" name="image" class="image" id="upload_image" style="display:none"/>
                </label>
            </div>
        </div>

        <form action="blogger.php?action=update" method="post" name="profile_setting_form" id="profile_setting_form" enctype="multipart/form-data">
            <div class="form-group">
                <div class="form-group">
                    <label>昵称</label>
                    <input class="form-control" value="<?= $nickname ?>" name="name" maxlength="20" required>
                </div>
                <div class="form-group">
                    <label>邮箱</label>
                    <input type="email" name="email" class="form-control" value="<?= $email ?>" required>
                </div>
                <div class="form-group">
                    <label>个人描述</label>
                    <textarea name="description" class="form-control"><?= $description ?></textarea>
                </div>

                <h4 class="mt-4 mb-3">账号密码</h4>
                <div class="form-group">
                    <label>登录用户名（为空则使用邮箱登录）</label>
                    <input class="form-control" value="<?= $username ?>" name="username">
                </div>
                <div class="form-group">
                    <label>新密码（不小于6位，不修改请留空）</label>
                    <input type="password" class="form-control" value="" autocomplete="new-password" name="newpass">
                </div>
                <div class="form-group">
                    <label>再次输入新密码</label>
                    <input type="password" class="form-control" value="" name="repeatpass">
                </div>
                <div class="form-group">
                    <?php doAction('blogger_ext') ?>
                </div>
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
                <input type="submit" value="保存资料" name="submit_form" id="submit_form" class="btn btn-sm btn-success"/>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">裁剪并上传</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-11">
                            <img src="" id="sample_image"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">取消</button>
                <button type="button" id="crop" class="btn btn-sm btn-success">保存</button>
            </div>
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
        $("#profile_setting_form").submit(function (event) {
            event.preventDefault();
            submitForm("#profile_setting_form");
        });

        // 裁剪上传头像
        var $modal = $('#modal');
        var image = document.getElementById('sample_image');
        var cropper;
        $('#upload_image').change(function (event) {
            var files = event.target.files;
            var done = function (url) {
                image.src = url;
                $modal.modal('show');
            };
            if (files && files.length > 0) {
                reader = new FileReader();
                reader.onload = function (event) {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });
        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 1,
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });
        $('#crop').click(function () {
            canvas = cropper.getCroppedCanvas({
                width: 160,
                height: 160
            });

            canvas.toBlob(function (blob) {
                var formData = new FormData();
                formData.append('image', blob, 'avatar.jpg');
                $.ajax('./blogger.php?action=update_avatar', {
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $modal.modal('hide');
                        if (data.code == 0) {
                            $('#avatar_image').attr('src', data.data);
                        } else {
                            alert(data.msg);
                        }
                    },
                    error: function (xhr) {
                        var data = xhr.responseJSON;
                        if (data && typeof data === "object") {
                            alert(data.msg);
                        } else {
                            alert("An error occurred during the file upload.");
                        }
                    }
                });
            });

        });
    });
</script>
