<?php /*a:1:{s:58:"C:\env\phpstudy_pro\WWW\tp\app\admin\view\admin\index.html";i:1674129646;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>后台管理系统登陆</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <script src="/static/layui/layui.js"></script>
    <script src="/static/axios/axios.min.js"></script>
</head>

<body>
<style>
    *{
        box-sizing: border-box;
        margin: 0px;
        padding: 0px;
        border: 0px;
    }

    .box{
        position: absolute;
        width: 100%;
        height: 100%;
        background:-webkit-gradient(linear, 0 0, 100% 100%, from(#1abc9c), to(#ffeaa7));
        background:-moz-linear-gradient(top, #1abc9c, #ffeaa7);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .cardBox{
        background-color: white;
        opacity: 0.7;
        border-radius: 5px;
    }

    .formLine{
        padding: 5px 10px;
        text-align: center;
    }

</style>
<div class="box">
    <div class="cardBox layui-col-md4 layui-col-sm6 layui-col-xs11">
        <div class="layui-row" style="text-align: center;padding: 20px">
            <i class="layui-icon layui-icon-username layui-anim layui-anim-scaleSpring" style="font-size: 3rem;color: white;background-color: black;border-radius: 50%;padding: 5px;"></i>
        </div>
        <form class="layui-form" action="<?php echo url('loginApi'); ?>" method="POST">
            <div class="layui-row formLine layui-anim layui-anim-fadein">
                <div class="layui-form-item">
                    <label class="layui-form-label">账号</label>
                    <div class="layui-input-block">
                        <input id="username" type="text" name="username" required lay-verify="required" autocomplete="off" placeholder="请输入账号" class="layui-input">
                    </div>
                </div>
            </div>
            <div class="layui-row formLine layui-anim layui-anim-fadein">
                <div class="layui-form-item">
                    <label class="layui-form-label">密码</label>
                    <div class="layui-input-block">
                        <input id="password" type="password" name="password" required lay-verify="required" autocomplete="off" placeholder="请输入密码" class="layui-input">
                    </div>
                </div>
            </div>
            <div class="layui-row formLine layui-anim layui-anim-fadein">
                <div class="layui-form-item">
                    <label class="layui-form-label">验证码</label>
                    <div class="layui-input-block">
                        <div class="layui-col-xs6 layui-col-sm6 layui-col-md6">
                            <input type="text" name="captcha" id="captchaValue" required lay-verify="required" autocomplete="off" placeholder="请输入验证码" class="layui-input">
                        </div>
                        <div class="layui-col-xs6 layui-col-sm6 layui-col-md6">
                            <div class="layui-input" style="border: 0px;text-align: right">
                                <img id="captcha" src="<?php echo url('captcha'); ?>" alt="captcha" style="height: 100%;max-width: 100%"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-row formLine layui-anim layui-anim-fadein" style="margin-bottom: 1rem">
                <button id="submit" type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">登录</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </form>
    </div>
</div>
</body>
<script>
    const instance = axios.create({
        timeout: 3000,
        headers: {'X-CSRF-TOKEN': "<?php echo token(); ?>"}
    });

    const captcha = document.getElementById('captcha');
    captcha.onclick = () => {
        captcha.src = "<?php echo url('captcha'); ?>" + '?random=' + (new Date()).getTime() + Math.random()
    }
    const submit = document.getElementById('submit')
    submit.onclick = () => {
        const index = layer.load(0, {shade: false});
        instance.post("<?php echo url('loginApi'); ?>", {
            username: document.getElementById('username').value,
            password: document.getElementById('password').value,
            captcha: document.getElementById('captchaValue').value
        })
        .then(function (response) {
            let data = response.data
            if(data.code==200){
                layer.msg(data.msg, {icon: 1});
                setTimeout(()=>{
                    window.location.href = "<?php echo url('index'); ?>"
                },1000)
            }else {
                layer.msg(data.msg, {icon: 5});
            }
        })
        .catch(function (error) {
            layer.msg('请求失败', {icon: 5});
            console.log(error);
        })
        layer.close(index)
        return false
    }
</script>
</html>