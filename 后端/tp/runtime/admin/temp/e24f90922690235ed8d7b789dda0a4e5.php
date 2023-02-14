<?php /*a:1:{s:63:"C:\env\phpstudy_pro\WWW\tp\app\admin\view\index\UpdateUser.html";i:1674399920;}*/ ?>
<template id="updateUser">
  <style>
    .updateUser .layui-form-label{
      width: 100px;
      text-align: center;
    }
  </style>
  <div class="updateUser">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
      <legend>{{ d.title }}</legend>
    </fieldset>
    <form class="layui-form">
      <div class="layui-form-item">
        <label class="layui-form-label">{{ d.old }}</label>
        <div class="layui-input-block">
          <input type="text" name="title" required  lay-verify="required" placeholder="请输入{{ d.old }}" autocomplete="off" class="layui-input">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">{{ d.new }}</label>
        <div class="layui-input-block">
          <input type="text" name="title" required  lay-verify="required" placeholder="请输入{{ d.new }}" autocomplete="off" class="layui-input">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">验证码</label>
        <div class="layui-input-inline">
          <input type="text" name="vercode" lay-verify="required" placeholder="请输入验证码" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid" style="padding: 0!important;">
          <img src="<?php echo url('captcha'); ?>" onclick="this.src = '<?php echo url('captcha'); ?>' + '?random=' + (new Date()).getTime() + Math.random()" style="height: 38px"/>
        </div>
      </div>
      <div class="layui-form-item">
        <div class="layui-input-block">
          <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">提交</button>
          <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
      </div>
    </form>
  </div>
  <script>

  </script>
</template>