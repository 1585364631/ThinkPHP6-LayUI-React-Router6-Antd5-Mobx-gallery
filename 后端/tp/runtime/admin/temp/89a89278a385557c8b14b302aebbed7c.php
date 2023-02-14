<?php /*a:1:{s:58:"C:\env\phpstudy_pro\WWW\tp\app\admin\view\index\index.html";i:1676377055;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>后台管理系统</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <script src="/static/axios/axios.min.js"></script>
    <script src="/static/layui/layui.js"></script>

    <style>
        *{
            /*box-sizing: border-box;*/
            word-break: break-all;
        }

        @media screen and (max-width: 768px) {
            .layui-layout-admin .layui-layout-left,
            .layui-layout-admin .layui-body,
            .layui-layout-admin .layui-footer{left: 0;}
            .layui-layout-admin .layui-side{left: -300px;}
        }

        .layui-tab-title > li:nth-child(1) > .layui-tab-close{
            display: none !important;
        }
    </style>
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo layui-hide-xs layui-bg-black">后台管理系统</div>
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-header-event="menuLeft">
                <i id="layui-move-button" class="layui-icon layui-icon-spread-left"></i>
            </li>
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:">
                    <i class="layui-icon layui-icon-username"></i>
                    <?php echo htmlentities($user->username); ?>
                    
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:" lay-event="updateUserName">修改账号</a></dd>
                    <dd><a href="javascript:" lay-event="updatePassword">修改密码</a></dd>
                    <dd><a href="<?php echo url('logout'); ?>">退出登入</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item" lay-header-event="menuRight" lay-unselect>
                <a href="javascript:">
                    <i class="layui-icon layui-icon-more-vertical"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="layui-side layui-bg-black" style="transition: all 1s;" id="leftMenu">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree" lay-filter="leftNavMenu">
                <li class="layui-nav-item">
                    <a href="javascript:">基础配置<i class="layui-icon layui-icon-down layui-nav-more"></i></a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:" lay-event="leftNavMenuServer">系统信息</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:">数据管理<i class="layui-icon layui-icon-down layui-nav-more"></i></a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:" lay-event="leftNavMenuUser">用户列表</a></dd>
                        <dd><a href="javascript:" lay-event="leftNavMenuPhotoAlbum">相册列表</a></dd>
                        <dd><a href="javascript:" lay-event="leftNavMenuPicture">图片列表</a></dd>
                    </dl>
                </li>


                <span class="layui-nav-bar" style="top: 175px; height: 0px; opacity: 0;"></span>
            </ul>
        </div>
    </div>

    <div class="layui-body">
        <div style="padding: 15px">
            <div class="layui-tab layui-tab-card" style="position: relative" lay-allowclose="true" lay-filter="demo" id="tab_nav">
                <ul class="layui-tab-title">
                    <li class="layui-this">使用必读</li>
                </ul>
                <div class="layui-tab-content" style="padding: 15px;">
                    <div class="layui-tab-item layui-show layer-anim layui-anim-upbit" style="overflow: auto">
                        中华人民共和国计算机软件保护条例，根据《中华人民共和国著作权法》，为了保护计算机软件著作权人的权益而制定，自2002年1月1日起施行。
                        <br>
                        (2001年12月20日中华人民共和国国务院令第339号公布根据2011年1月8日《国务院关于废止和修改部分行政法规的决定》第一次修订，根据2013年1月30日《国务院关于修改〈计算机软件保护条例〉的决定》第二次修订)
                    </div>
                </div>
            </div>
        </div>
        <div style="height: 44px;width: 100%"></div>
    </div>

    <div class="layui-footer">
        版权信息：2022 - 2023
    </div>
</div>
</body>
<script>
    const instance = axios.create({
        timeout: 3000,
        headers: {'X-CSRF-TOKEN': "<?php echo token(); ?>"}
    });

    layui.use(['element', 'layer', 'util', 'laytpl', 'form', 'table', 'dropdown', 'upload', 'laydate'], function(){
        const element = layui.element
                , layer = layui.layer
                , util = layui.util
                , laytpl = layui.laytpl
                , form = layui.form
                , table = layui.table
                , dropdown = layui.dropdown
                , upload = layui.upload
                , laydate = layui.laydate;
        ;

        util.fixbar({
            top: true //返回顶部
            , css: { right: 15, bottom: 35 }
            , bgcolor: '#f39c12'
            , click: function (type) {}
        });

        //选项卡字典
        const tab_dic = []

        const layuiMoveButton = document.getElementById('layui-move-button')
        let layuiMoveButtonStatus = true

        const leftMenu = document.getElementById('leftMenu')

        //选项卡事件
        element.on('tab(demo)', function(data){

        });

        //选项卡删除触发
        element.on('tabDelete(demo)', function(data){
            tab_dic.splice(data.index-1,1)
        });

        //快速添加选项卡事件
        const addTab = (title,content,id=new Date().getTime()) => {
            if (tab_dic.length>=9){
                layer.msg('选项卡不能超过9个');
                return;
            }

            for (const {key,value} of tab_dic) {
                if (key===title){
                    element.tabChange('demo',value)
                    return;
                }
            }

            element.tabAdd('demo', {
                title: title
                ,content: content
                ,id: id
            });

            tab_dic.push({key: title,value: id})
            element.tabChange('demo',id)
        }

        // 管理员账号密码修改
        const adminUpdate = (index,id) => {
            const cacheData = form.val(id);
            let url = "<?php echo url('resetPassword'); ?>"
            if (index === 0){
                url = "<?php echo url('resetUserName'); ?>"
            }
            const load = layer.load(0, {shade: false});
            instance.post(url,cacheData).
            then(function (response) {
                let data = response.data
                if(data.code==200){
                    layer.msg(data.msg, {icon: 1});
                    setTimeout(function (){
                        window.location.href = "<?php echo url('login'); ?>"
                    },1000)
                }else {
                    layer.msg(data.msg, {icon: 5});
                }
            }).catch(function (error) {
                layer.msg('请求失败', {icon: 5});
                console.log(error);
            })
            layer.close(load)
        }

        //头部事件
        util.event('lay-header-event', {
            //左侧菜单事件
            menuLeft: function(othis){
                layuiMoveButtonStatus = !layuiMoveButtonStatus
                if(layuiMoveButtonStatus){
                    layuiMoveButton.className = "layui-icon layui-icon-spread-left"
                    leftMenu.style.left = '-300px'
                }else {
                    layuiMoveButton.className = "layui-icon layui-icon-shrink-right"
                    leftMenu.style.left = '0px'
                }
            }
            ,menuRight: function(){
                layer.open({
                    type: 1
                    ,content: '<div style="padding: 15px;"><?php echo htmlentities($user->username); ?>，你好<br/>登录时间：<?php echo htmlentities($user->login_time); ?></div>'
                    ,area: ['260px', '100%']
                    ,offset: 'rt' //右上角
                    ,anim: 5
                    ,shadeClose: true
                });
            }
        });

        util.event('lay-event',{
            // 管理员账号密码修改
            'updateUserName': function (othis){
                laytpl(document.getElementById('updateUser').innerHTML).render({
                    title: '修改账号',
                    old: '原始账号',
                    new: '新的账号',
                    formId: 'usernameFrom'
                }, function(html){
                    addTab("修改账号",html)
                });
                document.getElementById(`usernameFromSubmit`).onclick = ()=>{
                    adminUpdate(0,'usernameFrom')
                    return false
                }
            },
            'updatePassword': function (othis){
                laytpl(document.getElementById('updateUser').innerHTML).render({
                    title: '修改密码',
                    old: '原始密码',
                    new: '新的密码',
                    formId: 'passwordFrom'
                }, function(html){
                    addTab("修改密码",html)
                });
                document.getElementById(`passwordFromSubmit`).onclick = ()=>{
                    adminUpdate(1,'passwordFrom')
                    return false
                }
            },
            // 左侧菜单事件
            // 系统信息:
            'leftNavMenuServer': function (othis){
                const index = layer.load(0, {shade: false});
                instance.post("<?php echo url('serverinfo'); ?>").
                then(function (response) {
                    let data = response.data
                    if(data.code==200){
                        const jsonData = data.msg
                        laytpl(document.getElementById('systemInfo').innerHTML).render({
                            title: '系统信息',
                            data: jsonData
                        }, function(html){
                            addTab("系统信息",html)
                        });
                        layer.msg("请求成功", {icon: 1});
                    } else {
                        layer.msg("请求失败", {icon: 5});
                    }
                }).catch(function (error) {
                    layer.msg('请求失败', {icon: 5});
                    console.log(error);
                })
                layer.close(index)
            },
            // 用户列表：
            'leftNavMenuUser': function (){
                let _searchField = "",_searchValue = "",_sortField = "",_sortValue = ""
                const addUser = () => {
                    const view = layer.open({
                        type: 1,
                        title: '添加用户',
                        skin: 'layui-layer-rim',
                        content: userListTableDataAdd.innerHTML,
                    });
                    form.on('submit(userListTableDataAdd)',function (data) {
                        const index = layer.load(0, {shade: false});
                        instance.post('<?php echo url("userApi"); ?>',form.val('userListTableDataAdd')).
                        then(function (response) {
                            let data = response.data
                            if(data.code==200){
                                layer.msg(data.msg, {icon: 1});
                                reloadUserTable()
                                layer.close(view)
                            } else {
                                layer.msg(data.msg, {icon: 5});
                            }
                        }).catch(function (error) {
                            layer.msg('请求失败', {icon: 5});
                            console.log(error);
                        })
                        layer.close(index)
                        return false
                    })
                }
                const editUser = (id) => {
                    const checkStatus = table.checkStatus(id);
                    const data = checkStatus.data;
                    if(data.length !== 1) return layer.msg('请选择一行');
                    let view;
                    laytpl(userListTableDataEdit.innerHTML).render(data[0], function(html){
                        view = layer.open({
                            type: 1,
                            title: '修改用户',
                            skin: 'layui-layer-rim',
                            content: html,
                            maxHeight: 600
                        });
                    });
                    form.render('select','userListTableDataEditTable')
                    laydate.render({
                        elem: '#birthday'
                    });
                    laydate.render({
                        elem: '#register_time'
                        ,type: 'datetime'
                    });
                    laydate.render({
                        elem: '#login_time'
                        ,type: 'datetime'
                    });
                    const userListTableDataEditTableHead = document.getElementById('userListTableDataEditTableHead')
                    const userListTableDataEditTableImg = document.getElementById('userListTableDataEditTableImg')
                    userListTableDataEditTableHead.oninput = ()=>{
                        userListTableDataEditTableImg.src = userListTableDataEditTableHead.value
                    }
                    const uploadInst = upload.render({
                        elem: '#userListTableDataEditTableUpdate' //绑定元素
                        , url: '<?php echo url("updateImage"); ?>'
                        , done: function (res) {
                            if(res.code===200){
                                userListTableDataEditTableHead.value = '/storage/' + res.data.src
                                userListTableDataEditTableImg.src = userListTableDataEditTableHead.value
                            }
                        }
                        , error: function () {

                        }
                    });

                    form.on("submit(userListTableDataEditSubmit)",function () {
                        console.log(form.val('userListTableDataEditTable'))
                        const index = layer.load(0, {shade: false});
                        instance.put('<?php echo url("userApi"); ?>',form.val('userListTableDataEditTable')).
                        then(function (response) {
                            let data = response.data
                            if(data.code===200){
                                layer.msg(data.msg, {icon: 1});
                                reloadUserTable()
                                layer.close(view)
                            } else {
                                layer.msg(data.msg, {icon: 5});
                            }
                        }).catch(function (error) {
                            layer.msg('请求失败', {icon: 5});
                            console.log(error);
                        })
                        layer.close(index)
                        return false
                    })

                }
                const deleteUser = (id) => {
                    const checkStatus = table.checkStatus(id);
                    const data = checkStatus.data;
                    if(data.length === 0)return layer.msg('请选择一行');
                    const index = layer.load(0, {shade: false});
                    let idList = []
                    for (const item of data) {
                        instance.delete('<?php echo url("userApi"); ?>',{
                            data: {
                                id: item.id
                            }
                        }).
                        then(function (response) {
                            let data = response.data
                            if(data.code!==200){
                                idList.push(item)
                            }
                        }).catch(function (error) {
                            idList.push(item)
                        })
                    }
                    reloadUserTable()
                    let userIds = idList.map((user) => {
                        return user.id
                    }).join(',')
                    if (userIds){
                        layer.msg('id为' + userIds + '删除失败', {icon: 5});
                    }else {
                        layer.msg('删除成功', {icon: 1});
                    }
                    layer.close(index)
                    return false
                }
                const reloadUserTable = ()=>{
                    table.reload('userListTable',{
                        page: {
                            curr: 1
                        },where: {
                            searchfield: _searchField,
                            searchvalue: _searchValue,
                            sortfield: _sortField,
                            sortvalue: _sortValue
                        }
                    })
                }
                const reloadUser = () => {
                    _searchField = ""
                    _searchValue = ""
                    _sortField = ""
                    _sortValue = ""
                    reloadUserTable()
                }
                const searchUser = () => {
                    layer.confirm(userListTableSearch.innerHTML, {
                        title: '用户搜索',
                        btn: ['搜索','取消'],
                    }, function(){
                        let searchValue = document.getElementById('userListTableSearchValue').value
                        if (searchValue === ""){
                            return layer.msg('搜索内容为空');
                        }
                        _searchValue = searchValue
                        reloadUserTable()
                        return layer.msg("查询成功")
                    }, function(){
                        // return layer.msg('查询取消', {icon: 1});
                    });
                    form.render('radio');
                    form.on('radio(userListTableFilter)', function(data){
                        _searchField = data.value
                    });
                }
                laytpl(document.getElementById('userList').innerHTML).render({
                    title: '用户列表',
                    id: 'userListTable'
                }, function(html){
                    addTab("用户列表",html)
                });
                table.render({
                    elem: '#userListTable'
                    ,url:'<?php echo url("userApi"); ?>'
                    ,toolbar: '#userListTableHeader'
                    ,defaultToolbar: ['filter', 'exports']
                    ,height: 'full-250'
                    ,cellMinWidth: 80
                    ,autoSort: false
                    ,totalRow: false
                    ,lineStyle: 'height: 95px;'
                    ,page: true
                    ,response: {
                        statusName: 'code' //规定数据状态的字段名称，默认：code
                        ,statusCode: 200 //规定成功的状态码，默认：0
                        ,msgName: 'msg' //规定状态信息的字段名称，默认：msg
                        ,countName: 'total' //规定数据总数的字段名称，默认：count
                        ,dataName: 'data' //规定数据列表的字段名称，默认：data
                    }
                    ,cols: [[
                        {type: 'checkbox', fixed: 'left'}
                        ,{field:'id', fixed: 'left', width: 80, title: 'ID', sort: true}
                        ,{field:'number',width: 120, title: '账号', sort: true}
                        ,{field:'password',width: 150, title: '密码', sort: true}
                        ,{field:'username',width: 120, title: '用户名', sort: true}
                        ,{field:'email',width: 120, title:'邮箱 <i class="layui-icon layui-icon-email"></i>', hide: 0, sort: true}
                        ,{field:'head_img',width:100, title: '头像', templet: function (res){
                                if (res.head_img) return '<img src="' + res.head_img + '" width="80px" height="80px"/>'
                                return '<i style="font-size: 30px" class="layui-icon layui-icon-username"></i>'

                            }, sort: true}
                        ,{field:'sex', title: '性别', templet: function (res) {
                            switch (res.sex) {
                                case 0:
                                    return '未知'
                                case 1:
                                    return '男'
                                case 2:
                                    return '女'
                            }
                            }, sort: true}
                        ,{field:'address',width: 120, title: '地址', sort: true}
                        ,{field:'birthday',width: 120, title: '出生日期', sort: true}
                        ,{field:'resume',width: 150, title: '简介', sort: true}
                        ,{field:'ip',width: 120, title: 'IP', sort: true}
                        ,{field:'register_time',width: 200, title: '注册时间', sort: true}
                        ,{field:'login_time',width: 200, title: '登入时间', sort: true}
                    ]]
                    ,done: function(){
                        const id = this.id;
                        dropdown.render({
                            elem: '#userListTableMoreFunction'
                            ,data: [{
                                id: 'add',
                                title: '添加'
                            },{
                                id: 'update',
                                title: '编辑'
                            },{
                                id: 'delete',
                                title: '删除'
                            },{
                                id: 'reload',
                                title: '重载'
                            },{
                                id: 'search',
                                title: '搜索'
                            }]
                            ,click: function(obj){
                                switch(obj.id){
                                    case 'add':
                                        return addUser()
                                    case 'update':
                                        return editUser(id)
                                    case 'delete':
                                        return deleteUser(id)
                                    case 'reload':
                                        return reloadUser()
                                    case 'search':
                                        return searchUser()
                                }
                            }
                        });
                        util.event('lay-active',{
                            userListTableHeaderAdd: function (othis){
                                return addUser()
                            },
                            userListTableHeaderEdit: function (othis){
                                return editUser(id)
                            },
                            userListTableHeaderDelete: function (othis){
                                return deleteUser(id)
                            },
                            userListTableHeaderReload: function (othis) {
                                return reloadUser()
                            },
                            userListTableHeaderSearch: function (othis) {
                                return searchUser()
                            }
                        })
                    }
                    ,error: function(res, msg){
                        console.log(res, msg)
                    }
                });
                table.on('sort(userListTable)', function(obj){
                    _sortField = obj.field
                    _sortValue = obj.type
                    if (_sortValue===null){
                        _sortField = "id"
                    }
                    reloadUserTable()
                });
            },
            // 图册列表
            'leftNavMenuPhotoAlbum': function (){
                let _searchField = "",_searchValue = "",_sortField = "",_sortValue = ""
                const addPhotoAlbum = () => {
                    const view = layer.open({
                        type: 1,
                        title: '创建相册',
                        skin: 'layui-layer-rim',
                        content: photoAlbumListTableDataAdd.innerHTML,
                    });
                    form.on('submit(photoAlbumTableDataAddSubmit)',function (data) {
                        const index = layer.load(0, {shade: false});
                        instance.post('<?php echo url("photoAlbumApi"); ?>',form.val('photoAlbumListTableDataAdd')).
                        then(function (response) {
                            let data = response.data
                            if(data.code==200){
                                layer.msg(data.msg, {icon: 1});
                                reloadPhotoAlbumTable()
                                layer.close(view)
                            } else {
                                layer.msg(data.msg, {icon: 5});
                            }
                        }).catch(function (error) {
                            layer.msg('请求失败', {icon: 5});
                            console.log(error);
                        })
                        layer.close(index)
                        return false
                    })
                    form.render()
                }
                const editPhotoAlbum = (id) => {
                    const checkStatus = table.checkStatus(id);
                    const data = checkStatus.data;
                    if(data.length !== 1) return layer.msg('请选择一行');
                    let view;
                    laytpl(photoAlbumListTableDataEdit.innerHTML).render(data[0], function(html){
                        view = layer.open({
                            type: 1,
                            title: '修改相册',
                            skin: 'layui-layer-rim',
                            content: html,
                            maxHeight: 600
                        });
                    });
                    form.render()
                    form.on("submit(photoAlbumListTableDataEditSubmit)",function () {
                        const index = layer.load(0, {shade: false});
                        instance.put('<?php echo url("photoAlbumApi"); ?>',form.val('photoAlbumListTableDataEdit')).
                        then(function (response) {
                            let data = response.data
                            if(data.code===200){
                                layer.msg(data.msg, {icon: 1});
                                reloadPhotoAlbumTable()
                                layer.close(view)
                            } else {
                                layer.msg(data.msg, {icon: 5});
                            }
                        }).catch(function (error) {
                            layer.msg('请求失败', {icon: 5});
                            console.log(error);
                        })
                        layer.close(index)
                        return false
                    })


                }
                const deletePhotoAlbum = (id) => {
                    const checkStatus = table.checkStatus(id);
                    const data = checkStatus.data;
                    if(data.length === 0)return layer.msg('请选择一行');
                    const index = layer.load(0, {shade: false});
                    let idList = []
                    for (const item of data) {
                        instance.delete('<?php echo url("photoAlbumApi"); ?>',{
                            data: {
                                id: item.id
                            }
                        }).
                        then(function (response) {
                            let data = response.data
                            if(data.code!==200){
                                idList.push(item)
                            }
                        }).catch(function (error) {
                            idList.push(item)
                        })
                    }
                    reloadPhotoAlbumTable()
                    let photoAlbumIds = idList.map((user) => {
                        return user.id
                    }).join(',')
                    if (photoAlbumIds){
                        layer.msg('id为' + photoAlbumIds + '删除失败', {icon: 5});
                    }else {
                        layer.msg('删除成功', {icon: 1});
                    }
                    layer.close(index)
                    return false
                }
                const reloadPhotoAlbumTable = ()=>{
                    table.reload('photoAlbumListTable',{
                        page: {
                            curr: 1
                        },where: {
                            searchfield: _searchField,
                            searchvalue: _searchValue,
                            sortfield: _sortField,
                            sortvalue: _sortValue
                        }
                    })
                }
                const reloadPhotoAlbum = () => {
                    _searchField = ""
                    _searchValue = ""
                    _sortField = ""
                    _sortValue = ""
                    reloadPhotoAlbumTable()
                }
                const searchPhotoAlbum = () => {
                    layer.confirm(photoAlbumListTableSearch.innerHTML, {
                        title: '相册搜索',
                        btn: ['搜索','取消'],
                    }, function(){
                        let searchValue = document.getElementById('photoAlbumListTableSearchValue').value
                        if (searchValue === ""){
                            return layer.msg('搜索内容为空');
                        }
                        _searchValue = searchValue
                        reloadPhotoAlbumTable()
                        return layer.msg("查询成功")
                    }, function(){
                        // return layer.msg('查询取消', {icon: 1});
                    });
                    form.render('radio');
                    form.on('radio(photoAlbumListTableFilter)', function(data){
                        _searchField = data.value
                    });
                }
                laytpl(document.getElementById('photoAlbumList').innerHTML).render({
                    title: '相册列表',
                    id: 'photoAlbumListTable'
                }, function(html){
                    addTab("相册列表",html)
                });
                table.render({
                    elem: '#photoAlbumListTable'
                    ,url:'<?php echo url("photoAlbumApi"); ?>'
                    ,toolbar: '#photoAlbumListTableHeader'
                    ,defaultToolbar: ['filter', 'exports']
                    ,height: 'full-250'
                    ,cellMinWidth: 80
                    ,autoSort: false
                    ,totalRow: false
                    ,page: true
                    ,response: {
                        statusName: 'code' //规定数据状态的字段名称，默认：code
                        ,statusCode: 200 //规定成功的状态码，默认：0
                        ,msgName: 'msg' //规定状态信息的字段名称，默认：msg
                        ,countName: 'total' //规定数据总数的字段名称，默认：count
                        ,dataName: 'data' //规定数据列表的字段名称，默认：data
                    }
                    ,cols: [[
                        {type: 'checkbox', fixed: 'left'}
                        ,{field:'id', fixed: 'left', width: 80, title: 'ID', sort: true}
                        ,{field:'user_id',width: 120, title: '所属用户id', sort: true}
                        ,{field:'authority',width:100, title: '权限', templet: function (res) {
                                switch (res.authority) {
                                    case 0:
                                        return '公开'
                                    case 1:
                                        return '私密'
                                }
                            }, sort: true}
                        ,{field:'name',minWidth: 150, title: '相册名', sort: true}
                    ]]
                    ,done: function(){
                        const id = this.id;
                        dropdown.render({
                            elem: '#photoAlbumListTableMoreFunction'
                            ,data: [{
                                id: 'add',
                                title: '添加'
                            },{
                                id: 'update',
                                title: '编辑'
                            },{
                                id: 'delete',
                                title: '删除'
                            },{
                                id: 'reload',
                                title: '重载'
                            },{
                                id: 'search',
                                title: '搜索'
                            }]
                            ,click: function(obj){
                                switch(obj.id){
                                    case 'add':
                                        return addPhotoAlbum()
                                    case 'update':
                                        return editPhotoAlbum(id)
                                    case 'delete':
                                        return deletePhotoAlbum(id)
                                    case 'reload':
                                        return reloadPhotoAlbum()
                                    case 'search':
                                        return searchPhotoAlbum()
                                }
                            }
                        });
                        util.event('lay-active',{
                            photoAlbumListTableHeaderAdd: function (othis){
                                return addPhotoAlbum()
                            },
                            photoAlbumListTableHeaderEdit: function (othis){
                                return editPhotoAlbum(id)
                            },
                            photoAlbumListTableHeaderDelete: function (othis){
                                return deletePhotoAlbum(id)
                            },
                            photoAlbumListTableHeaderReload: function (othis) {
                                return reloadPhotoAlbum()
                            },
                            photoAlbumListTableHeaderSearch: function (othis) {
                                return searchPhotoAlbum()
                            }
                        })
                    }
                    ,error: function(res, msg){
                        console.log(res, msg)
                    }
                });
                table.on('sort(photoAlbumListTable)', function(obj){
                    _sortField = obj.field
                    _sortValue = obj.type
                    if (_sortValue===null){
                        _sortField = "id"
                    }
                    reloadPhotoAlbumTable()
                });
            },
            // 图片列表
            'leftNavMenuPicture': function () {
                let _searchField = "",_searchValue = "",_sortField = "",_sortValue = ""
                const addPicture = () => {
                    const view = layer.open({
                        type: 1,
                        title: '添加图片',
                        skin: 'layui-layer-rim',
                        content: pictureListTableDataAdd.innerHTML,
                    });
                    form.on('submit(pictureTableDataAddSubmit)',function (data) {
                        const index = layer.load(0, {shade: false});
                        instance.post('<?php echo url("pictureApi"); ?>',form.val('pictureListTableDataAdd')).
                        then(function (response) {
                            let data = response.data
                            if(data.code==200){
                                layer.msg(data.msg, {icon: 1});
                                reloadPictureTable()
                                layer.close(view)
                            } else {
                                layer.msg(data.msg, {icon: 5});
                            }
                        }).catch(function (error) {
                            layer.msg('请求失败', {icon: 5});
                            console.log(error);
                        })
                        layer.close(index)
                        return false
                    })
                    form.render()
                    const pictureListTableDataAddTableUrl = document.getElementById('pictureListTableDataAddTableUrl')
                    const pictureListTableDataAddTableImg = document.getElementById('pictureListTableDataAddTableImg')
                    const uploadInst = upload.render({
                        elem: '#pictureListTableDataAddTableUpdate' //绑定元素
                        , url: '<?php echo url("updateImage"); ?>'
                        , done: function (res) {
                            if(res.code===200){
                                pictureListTableDataAddTableUrl.value = '/storage/' + res.data.src
                                pictureListTableDataAddTableImg.src = pictureListTableDataAddTableUrl.value
                            }
                        }
                        , error: function () {

                        }
                    });
                    pictureListTableDataAddTableUrl.oninput = ()=>{
                        pictureListTableDataAddTableImg.src = pictureListTableDataAddTableUrl.value
                    }
                }
                const editPicture = (id) => {
                    const checkStatus = table.checkStatus(id);
                    const data = checkStatus.data;
                    if(data.length !== 1) return layer.msg('请选择一行');
                    let view;
                    laytpl(pictureListTableDataEdit.innerHTML).render(data[0], function(html){
                        view = layer.open({
                            type: 1,
                            title: '编辑图片',
                            skin: 'layui-layer-rim',
                            content: html,
                            maxHeight: 600
                        });
                    });
                    form.render()
                    form.on("submit(pictureListTableDataEditSubmit)",function () {
                        const index = layer.load(0, {shade: false});
                        instance.put('<?php echo url("pictureApi"); ?>',form.val('pictureListTableDataEdit')).
                        then(function (response) {
                            let data = response.data
                            if(data.code===200){
                                layer.msg(data.msg, {icon: 1});
                                reloadPictureTable()
                                layer.close(view)
                            } else {
                                layer.msg(data.msg, {icon: 5});
                            }
                        }).catch(function (error) {
                            layer.msg('请求失败', {icon: 5});
                            console.log(error);
                        })
                        layer.close(index)
                        return false
                    })
                    const pictureListTableDataEditTableUrl = document.getElementById('pictureListTableDataEditTableUrl')
                    const pictureListTableDataEditTableImg = document.getElementById('pictureListTableDataEditTableImg')
                    pictureListTableDataEditTableImg.src = pictureListTableDataEditTableUrl.value
                    const uploadInst = upload.render({
                        elem: '#pictureListTableDataEditTableUpdate' //绑定元素
                        , url: '<?php echo url("updateImage"); ?>'
                        , done: function (res) {
                            if(res.code===200){
                                pictureListTableDataEditTableUrl.value = '/storage/' + res.data.src
                                pictureListTableDataEditTableImg.src = pictureListTableDataEditTableUrl.value
                            }
                        }
                        , error: function () {

                        }
                    });
                    pictureListTableDataEditTableUrl.oninput = ()=>{
                        pictureListTableDataEditTableImg.src = pictureListTableDataEditTableImg.value
                    }
                }
                const deletePicture = (id) => {
                    const checkStatus = table.checkStatus(id);
                    const data = checkStatus.data;
                    if(data.length === 0)return layer.msg('请选择一行');
                    const index = layer.load(0, {shade: false});
                    let idList = []
                    for (const item of data) {
                        instance.delete('<?php echo url("pictureApi"); ?>',{
                            data: {
                                id: item.id
                            }
                        }).
                        then(function (response) {
                            let data = response.data
                            if(data.code!==200){
                                idList.push(item)
                            }
                        }).catch(function (error) {
                            idList.push(item)
                        })
                    }
                    reloadPictureTable()
                    let pictureIds = idList.map((user) => {
                        return user.id
                    }).join(',')
                    if (pictureIds){
                        layer.msg('id为' + pictureIds + '删除失败', {icon: 5});
                    }else {
                        layer.msg('删除成功', {icon: 1});
                    }
                    layer.close(index)
                    return false
                }
                const reloadPictureTable = ()=>{
                    table.reload('pictureListTable',{
                        page: {
                            curr: 1
                        },where: {
                            searchfield: _searchField,
                            searchvalue: _searchValue,
                            sortfield: _sortField,
                            sortvalue: _sortValue
                        }
                    })
                }
                const reloadPicture = () => {
                    _searchField = ""
                    _searchValue = ""
                    _sortField = ""
                    _sortValue = ""
                    reloadPictureTable()
                }
                const searchPicture = () => {
                    layer.confirm(pictureListTableSearch.innerHTML, {
                        title: '图片搜索',
                        btn: ['搜索','取消'],
                    }, function(){
                        let searchValue = document.getElementById('pictureListTableSearchValue').value
                        if (searchValue === ""){
                            return layer.msg('搜索内容为空');
                        }
                        _searchValue = searchValue
                        reloadPictureTable()
                        return layer.msg("查询成功")
                    }, function(){
                        // return layer.msg('查询取消', {icon: 1});
                    });
                    form.render('radio');
                    form.on('radio(pictureListTableFilter)', function(data){
                        _searchField = data.value
                    });
                }
                laytpl(document.getElementById('pictureList').innerHTML).render({
                    title: '图片列表',
                    id: 'pictureListTable'
                }, function(html){
                    addTab("图片列表",html)
                });
                table.render({
                    elem: '#pictureListTable'
                    ,url:'<?php echo url("pictureApi"); ?>'
                    ,toolbar: '#pictureListTableHeader'
                    ,defaultToolbar: ['filter', 'exports']
                    ,height: 'full-250'
                    ,cellMinWidth: 80
                    ,autoSort: false
                    ,totalRow: false
                    ,page: true
                    ,lineStyle: 'height: 95px;'
                    ,response: {
                        statusName: 'code' //规定数据状态的字段名称，默认：code
                        ,statusCode: 200 //规定成功的状态码，默认：0
                        ,msgName: 'msg' //规定状态信息的字段名称，默认：msg
                        ,countName: 'total' //规定数据总数的字段名称，默认：count
                        ,dataName: 'data' //规定数据列表的字段名称，默认：data
                    }
                    ,cols: [[
                        {type: 'checkbox', fixed: 'left'}
                        ,{field:'id', fixed: 'left', width: 80, title: 'ID', sort: true}
                        ,{field:'photoid',width: 120, title: '所属相册ID', sort: true}
                        ,{field:'name',width: 150, title: '图片名称', sort: true}
                        ,{field:'url',width: 110, title: '图片地址',templet: function (res){
                                if (res.url) return '<img src="' + res.url + '" width="80px" height="80px"/>'
                                return '<i style="font-size: 30px" class="layui-icon layui-icon-username"></i>'

                            }, sort: true}

                        ,{field:'text',minWidth: 200,title: '图片介绍', sort: true}
                    ]]
                    ,done: function(){
                        const id = this.id;
                        dropdown.render({
                            elem: '#pictureListTableMoreFunction'
                            ,data: [{
                                id: 'add',
                                title: '添加'
                            },{
                                id: 'update',
                                title: '编辑'
                            },{
                                id: 'delete',
                                title: '删除'
                            },{
                                id: 'reload',
                                title: '重载'
                            },{
                                id: 'search',
                                title: '搜索'
                            }]
                            ,click: function(obj){
                                switch(obj.id){
                                    case 'add':
                                        return addPicture()
                                    case 'update':
                                        return editPicture(id)
                                    case 'delete':
                                        return deletePicture(id)
                                    case 'reload':
                                        return reloadPicture()
                                    case 'search':
                                        return searchPicture()
                                }
                            }
                        });
                        util.event('lay-active',{
                            pictureListTableHeaderAdd: function (othis){
                                return addPicture()
                            },
                            pictureListTableHeaderEdit: function (othis){
                                return editPicture(id)
                            },
                            pictureListTableHeaderDelete: function (othis){
                                return deletePicture(id)
                            },
                            pictureListTableHeaderReload: function (othis) {
                                return reloadPicture()
                            },
                            pictureListTableHeaderSearch: function (othis) {
                                return searchPicture()
                            }
                        })
                    }
                    ,error: function(res, msg){
                        console.log(res, msg)
                    }
                });
                table.on('sort(pictureListTable)', function(obj){
                    _sortField = obj.field
                    _sortValue = obj.type
                    if (_sortValue===null){
                        _sortField = "id"
                    }
                    reloadPictureTable()
                });
            }
        })
    });
</script>

<template id="userList" >
    <table id="{{ d.id }}" lay-filter="{{ d.id }}"></table>
</template>
<script type="text/html" id="userListTableHeader">
    <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm layui-hide layui-show-xs-inline-block" id="userListTableMoreFunction">
            功能
            <i class="layui-icon layui-icon-down layui-font-12"></i>
        </button>
        <div class="layui-show layui-hide-xs">
            <button class="layui-btn layui-btn-sm" lay-active="userListTableHeaderAdd">添加</button>
            <button class="layui-btn layui-btn-sm" lay-active="userListTableHeaderEdit">编辑</button>
            <button class="layui-btn layui-btn-sm" lay-active="userListTableHeaderDelete">删除</button>
            <button class="layui-btn layui-btn-sm" lay-active="userListTableHeaderReload">重载</button>
            <button class="layui-btn layui-btn-sm" lay-active="userListTableHeaderSearch">搜索</button>
        </div>
    </div>
</script>
<script type="text/html" id="userListTableRight">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<script type="text/html" id="userListTableSearch">
    <div>
        <form class="layui-form">
            <div class="layui-input">
                <input type="radio" lay-filter="userListTableFilter" name="userListTableCheck" value="id" title="ID" checked>
                <input type="radio" lay-filter="userListTableFilter" name="userListTableCheck" value="number" title="账号">
                <input type="radio" lay-filter="userListTableFilter" name="userListTableCheck" value="password" title="密码">
            </div>
            <div class="layui-input">
                <input type="radio" lay-filter="userListTableFilter" name="userListTableCheck" value="username" title="用户名">
                <input type="radio" lay-filter="userListTableFilter" name="userListTableCheck" value="email" title="邮箱">
                <input type="radio" lay-filter="userListTableFilter" name="userListTableCheck" value="head_img" title="头像">
            </div>
            <div class="layui-input">
                <input type="radio" lay-filter="userListTableFilter" name="userListTableCheck" value="sex" title="性别">
                <input type="radio" lay-filter="userListTableFilter" name="userListTableCheck" value="address" title="地址">
                <input type="radio" lay-filter="userListTableFilter" name="userListTableCheck" value="birthday" title="生日">
            </div>
            <div class="layui-input">
                <input type="radio" lay-filter="userListTableFilter" name="userListTableCheck" value="resume" title="简介">
                <input type="radio" lay-filter="userListTableFilter" name="userListTableCheck" value="ip" title="IP">
                <input type="radio" lay-filter="userListTableFilter" name="userListTableCheck" value="register_time" title="注册时间">
            </div>
            <div class="layui-input">
                <input type="radio" lay-filter="userListTableFilter" name="userListTableCheck" value="login_time" title="登入时间">
            </div>
            <input class="layui-input" name="search" id="userListTableSearchValue" placeholder="请输入搜索内容" autocomplete="off">
        </form>
    </div>
</script>
<script type="text/html" id="userListTableDataAdd">
    <form style="padding: 15px" class="layui-form" action="" lay-filter="userListTableDataAdd">
        <div class="layui-form-item">
            <label class="layui-form-label">账号 <span style="color: red">*</span></label>
            <div class="layui-input-block">
                <input type="text" name="number" lay-verify="required" lay-reqtext="账号为必填项" autocomplete="off" placeholder="请输入账号" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码 <span style="color: red">*</span></label>
            <div class="layui-input-block">
                <input type="text" name="password" lay-verify="required" lay-reqtext="密码为必填项" autocomplete="off" placeholder="请输入密码" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="userListTableDataAddSubmit">提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</script>
<script type="text/html" id="userListTableDataEdit">
    <form class="layui-form" style="padding: 15px;max-height: 70%" action="" lay-filter="userListTableDataEditTable">
        <input type="hidden" value="{{ d.id }}" name="id">
        <div class="layui-form-item">
            <label class="layui-form-label">账号 <span style="color: red">*</span></label>
            <div class="layui-input-block">
                <input type="text" value="{{ d.number }}" name="number" lay-verify="required" lay-reqtext="账号为必填项" autocomplete="off" placeholder="请输入账号" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码 <span style="color: red">*</span></label>
            <div class="layui-input-block">
                <input type="text" value="{{ d.password }}" name="password" lay-verify="required" lay-reqtext="密码为必填项" autocomplete="off" placeholder="请输入密码" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-block">
                <input type="text" value="{{ d.username }}" name="username" autocomplete="off" placeholder="请输入用户名" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">邮箱</label>
            <div class="layui-input-block">
                <input type="text" value="{{ d.email }}" name="email" autocomplete="off" placeholder="请输入邮箱" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">头像</label>
            <div class="layui-input-block">
                <input type="text" id="userListTableDataEditTableHead" value="{{ d.head_img }}" name="head_img" autocomplete="off" placeholder="请输入头像地址" class="layui-input">
                <img class="layui-upload-img" id="userListTableDataEditTableImg" src="{{ d.head_img }}" width="80px" height="80px">
                <button type="button" class="layui-btn" id="userListTableDataEditTableUpdate">
                    <i class="layui-icon">&#xe67c;</i>上传图片
                </button>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">性别</label>
            <div class="layui-input-block">
                <select name="sex" lay-filter="userListTableDataEditTableSelect">
                    <option value="0" {{# if(d.sex===0) { }} selected {{# } }}>未知</option>
                    <option value="1" {{# if(d.sex===1) { }} selected {{# } }}>男</option>
                    <option value="2" {{# if(d.sex===2) { }} selected {{# } }}>女</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">地址</label>
            <div class="layui-input-block">
                <input type="text" value="{{ d.address }}" name="address" autocomplete="off" placeholder="请输入地址" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">出生日期</label>
            <div class="layui-input-block">
                <input type="text" value="{{ d.birthday }}" id="birthday" name="birthday" autocomplete="off" placeholder="请输入出生日期" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">简介</label>
            <div class="layui-input-block">
                <textarea name="resume" placeholder="请输入简介" class="layui-textarea">{{ d.resume }}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">ip</label>
            <div class="layui-input-block">
                <input type="text" value="{{ d.ip }}" name="ip" autocomplete="off" placeholder="请输入ip地址" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">注册时间</label>
            <div class="layui-input-block">
                <input type="text" value="{{ d.register_time }}" name="register_time" id="register_time" autocomplete="off" placeholder="请输入注册时间" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">登入时间</label>
            <div class="layui-input-block">
                <input type="text" value="{{ d.login_time }}" name="login_time" id="login_time" autocomplete="off" placeholder="请输入登入时间" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="userListTableDataEditSubmit">提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</script>


<template id="photoAlbumList" >
    <table id="{{ d.id }}" lay-filter="{{ d.id }}"></table>
</template>
<script type="text/html" id="photoAlbumListTableHeader">
    <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm layui-hide layui-show-xs-inline-block" id="photoAlbumListTableMoreFunction">
            功能
            <i class="layui-icon layui-icon-down layui-font-12"></i>
        </button>
        <div class="layui-show layui-hide-xs">
            <button class="layui-btn layui-btn-sm" lay-active="photoAlbumListTableHeaderAdd">添加</button>
            <button class="layui-btn layui-btn-sm" lay-active="photoAlbumListTableHeaderEdit">编辑</button>
            <button class="layui-btn layui-btn-sm" lay-active="photoAlbumListTableHeaderDelete">删除</button>
            <button class="layui-btn layui-btn-sm" lay-active="photoAlbumListTableHeaderReload">重载</button>
            <button class="layui-btn layui-btn-sm" lay-active="photoAlbumListTableHeaderSearch">搜索</button>
        </div>
    </div>
</script>
<script type="text/html" id="photoAlbumListTableSearch">
    <div>
        <form class="layui-form">
            <div class="layui-input">
                <input type="radio" lay-filter="photoAlbumListTableFilter" name="photoAlbumListTableCheck" value="id" title="ID" checked>
                <input type="radio" lay-filter="photoAlbumListTableFilter" name="photoAlbumListTableCheck" value="user_id" title="所属用户ID">
                <input type="radio" lay-filter="photoAlbumListTableFilter" name="photoAlbumListTableCheck" value="name" title="相册名称">
                <input type="radio" lay-filter="photoAlbumListTableFilter" name="photoAlbumListTableCheck" value="authority" title="权限">
            </div>
            <input class="layui-input" name="search" id="photoAlbumListTableSearchValue" placeholder="请输入搜索内容" autocomplete="off">
        </form>
    </div>
</script>
<script type="text/html" id="photoAlbumListTableDataAdd">
    <form style="padding: 15px" class="layui-form" action="" lay-filter="photoAlbumListTableDataAdd">
        <div class="layui-form-item">
            <label class="layui-form-label">所属用户id <span style="color: red">*</span></label>
            <div class="layui-input-block">
                <input type="text" name="user_id" lay-verify="required" lay-reqtext="所属用户id为必填项" autocomplete="off" placeholder="请输入所属用户id" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">相册名称 <span style="color: red">*</span></label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required" lay-reqtext="相册名称为必填项" autocomplete="off" placeholder="请输入相册名称" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">权限 <span style="color: red">*</span></label>
            <div class="layui-input-block">
                <input type="radio" name="authority" value="0" title="公开" checked>
                <input type="radio" name="authority" value="1" title="私密">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="photoAlbumTableDataAddSubmit">提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</script>
<script type="text/html" id="photoAlbumListTableDataEdit">
    <form style="padding: 15px" class="layui-form" action="" lay-filter="photoAlbumListTableDataEdit">
        <input value="{{ d.id }}" type="hidden" name="id" >
        <div class="layui-form-item">
            <label class="layui-form-label">所属用户id <span style="color: red">*</span></label>
            <div class="layui-input-block">
                <input value="{{ d.user_id }}" type="text" name="user_id" lay-verify="required" lay-reqtext="所属用户id为必填项" autocomplete="off" placeholder="请输入所属用户id" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">相册名称 <span style="color: red">*</span></label>
            <div class="layui-input-block">
                <input value="{{ d.name }}" type="text" name="name" lay-verify="required" lay-reqtext="相册名称为必填项" autocomplete="off" placeholder="请输入相册名称" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">权限 <span style="color: red">*</span></label>
            <div class="layui-input-block">
                <input type="radio" name="authority" value="0" title="公开" checked>
                <input type="radio" name="authority" value="1" title="私密" {{# if(d.authority===1) { }} checked {{# } }}>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="photoAlbumListTableDataEditSubmit">提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</script>


<template id="pictureList" >
    <table id="{{ d.id }}" lay-filter="{{ d.id }}"></table>
</template>
<script type="text/html" id="pictureListTableHeader">
    <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm layui-hide layui-show-xs-inline-block" id="pictureListTableMoreFunction">
            功能
            <i class="layui-icon layui-icon-down layui-font-12"></i>
        </button>
        <div class="layui-show layui-hide-xs">
            <button class="layui-btn layui-btn-sm" lay-active="pictureListTableHeaderAdd">添加</button>
            <button class="layui-btn layui-btn-sm" lay-active="pictureListTableHeaderEdit">编辑</button>
            <button class="layui-btn layui-btn-sm" lay-active="pictureListTableHeaderDelete">删除</button>
            <button class="layui-btn layui-btn-sm" lay-active="pictureListTableHeaderReload">重载</button>
            <button class="layui-btn layui-btn-sm" lay-active="pictureListTableHeaderSearch">搜索</button>
        </div>
    </div>
</script>
<script type="text/html" id="pictureListTableSearch">
    <div>
        <form class="layui-form">
            <div class="layui-input">
                <input type="radio" lay-filter="pictureListTableFilter" name="pictureListTableCheck" value="id" title="ID" checked>
                <input type="radio" lay-filter="pictureListTableFilter" name="pictureListTableCheck" value="photoid" title="所属相册ID">
                <input type="radio" lay-filter="pictureListTableFilter" name="pictureListTableCheck" value="url" title="图片地址">
            </div>
            <div class="layui-input">
                <input type="radio" lay-filter="pictureListTableFilter" name="pictureListTableCheck" value="name" title="图片名称">
                <input type="radio" lay-filter="pictureListTableFilter" name="pictureListTableCheck" value="text" title="图片介绍">
            </div>
            <input class="layui-input" name="search" id="pictureListTableSearchValue" placeholder="请输入搜索内容" autocomplete="off">
        </form>
    </div>
</script>
<script type="text/html" id="pictureListTableDataAdd">
    <form style="padding: 15px" class="layui-form" action="" lay-filter="pictureListTableDataAdd">
        <div class="layui-form-item">
            <label class="layui-form-label">所属相册ID <span style="color: red">*</span></label>
            <div class="layui-input-block">
                <input type="text" name="photoid" lay-verify="required" lay-reqtext="所属相册ID为必填项" autocomplete="off" placeholder="请输入所属相册ID" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图片地址 <span style="color: red">*</span></label>
            <div class="layui-input-block">
                <input type="text" name="url" id="pictureListTableDataAddTableUrl" lay-verify="required" lay-reqtext="图片地址为必填项" autocomplete="off" placeholder="请输入图片地址" class="layui-input">
                <img class="layui-upload-img" id="pictureListTableDataAddTableImg" width="80px" height="80px">
                <button type="button" class="layui-btn" id="pictureListTableDataAddTableUpdate">
                    <i class="layui-icon">&#xe67c;</i>上传图片
                </button>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图片名称 </label>
            <div class="layui-input-block">
                <input type="text" name="name" autocomplete="off" placeholder="请输入图片名称" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图片介绍 </label>
            <div class="layui-input-block">
                <textarea name="text" placeholder="请输入图片介绍" class="layui-textarea"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="pictureTableDataAddSubmit">提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</script>
<script type="text/html" id="pictureListTableDataEdit">
    <form style="padding: 15px" class="layui-form" action="" lay-filter="pictureListTableDataEdit">
        <input value="{{ d.id }}" type="hidden" name="id" >
        <div class="layui-form-item">
            <label class="layui-form-label">所属相册ID <span style="color: red">*</span></label>
            <div class="layui-input-block">
                <input value="{{ d.photoid }}" type="text" name="photoid" lay-verify="required" lay-reqtext="所属相册ID为必填项" autocomplete="off" placeholder="请输入所属相册ID" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图片地址 <span style="color: red">*</span></label>
            <div class="layui-input-block">
                <input value="{{ d.url }}" id="pictureListTableDataEditTableUrl" type="text" name="url" lay-verify="required" lay-reqtext="图片地址为必填项" autocomplete="off" placeholder="请输入图片地址" class="layui-input">
                <img class="layui-upload-img" id="pictureListTableDataEditTableImg" src="{{ d.url }}" width="80px" height="80px">
                <button type="button" class="layui-btn" id="pictureListTableDataEditTableUpdate">
                    <i class="layui-icon">&#xe67c;</i>上传图片
                </button>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图片名称 </label>
            <div class="layui-input-block">
                <input value="{{ d.name }}" type="text" name="name" autocomplete="off" placeholder="请输入图片名称" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图片介绍 </label>
            <div class="layui-input-block">
                <textarea name="text" placeholder="请输入图片介绍" class="layui-textarea">{{ d.text }}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="pictureListTableDataEditSubmit">提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</script>


<template id="systemInfo">
    <div class="layer-anim layui-anim-up">
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
            <legend>{{ d.title }}</legend>
        </fieldset>
        {{#  if(d.data.length !== 0){ }}
            {{- d.data }}
        {{# } else{ }}
        无数据
        {{# } }}
    </div>
</template>


<template id="updateUser">
    <style>
        .updateUser .layui-form-label{
            width: 80px;
            text-align: center;
        }
    </style>
    <div class="updateUser layer-anim layui-anim-up">
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
            <legend>{{ d.title }}</legend>
        </fieldset>
        <form class="layui-form" id="{{ d.formId }}" lay-filter="{{ d.formId }}">
            <div class="layui-form-item">
                <label class="layui-form-label">{{ d.old }}</label>
                <div class="layui-input-block">
                    <input type="text" name="old" required  lay-verify="required" placeholder="请输入{{ d.old }}" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">{{ d.new }}</label>
                <div class="layui-input-block">
                    <input type="text" name="new" required  lay-verify="required" placeholder="请输入{{ d.new }}" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">验证码</label>
                <div class="layui-input-inline">
                    <input type="text" name="captcha" lay-verify="required" placeholder="请输入验证码" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid" style="padding: 0!important;">
                    <img id="{{ d.formId }}captcha" src="<?php echo url('captcha'); ?>'" onclick="this.src = '<?php echo url('captcha'); ?>' + '?random=' + (new Date()).getTime() + Math.random()" style="height: 38px"/>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="submit" class="layui-btn" id="{{ d.formId }}Submit" lay-submit="" lay-filter="{{ d.formId }}Submit">提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        document.getElementById('{{ d.formId }}captcha').src = '<?php echo url('captcha'); ?>' + '?random=' + (new Date()).getTime() + Math.random()
    </script>
</template>
</html>