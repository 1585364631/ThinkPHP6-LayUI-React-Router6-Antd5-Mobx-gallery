# ThinkPHP6-LayUI-React-Router6-Antd5-Mobx-gallery
基于ThinkPHP6的多应用模式，前端后台使用Layui和ThinkPHP6视图搭建，前端前台使用React+Mobx+Router6+Antd5搭建，前端前后台均支持响应式，由于前台使用了Antd5，所以请使用新一代浏览器访问（如：edge）

# 项目演示
前台：http://gallery.000081.xyz/  
测试账号：testtest  
测试密码： testtest   
（也可以自行注册一个，前台只能使用新一代浏览器访问，如edge等）  
  
后台：http://admingallery.000081.xyz/   
测试账号：admin    
测试密码：123456    
  
# 项目部署 
## 后端
1.上传源代码到支持thinkphp6的web服务器  
2.给予整个项目文件777或者755权限  
3.新建数据库，并且修改项目文件下.env文件  
4.导入sql文件  

## 前端
1.使用npm instal 安装需要的文件  
2.修改src/url/index.tsx的两个地址  
3.使用npm run build 打包项目  
4.上传到web服务器
