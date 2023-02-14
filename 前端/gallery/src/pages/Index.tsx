import {Outlet, useNavigate} from "react-router-dom";
import store from "../mobx/store"
import {autorun} from "mobx";
import type {MenuProps} from 'antd';
import React, {useState} from "react";
import {Layout, Menu, Space, message, Modal, Form, Input, Radio} from 'antd';
import url from "../url";
import { UserOutlined, DesktopOutlined } from '@ant-design/icons';
import "./Index.css"
import UpdateImage from "../components/UpdateImage";
const { Header, Footer, Content } = Layout;


const contentStyle: React.CSSProperties = {
    textAlign: 'center',
    height: "80%",
    color: '#fff',
    padding: "20px",
    overflow: "scroll"
};

const footerStyle: React.CSSProperties = {
    textAlign: 'center',
    color: '#fff',
    backgroundColor: '#001529',
    height: "10%",
    lineHeight: "100%",
    fontSize: "15px"
};

const items: MenuProps['items'] = [
    {
        label: '首页',
        key: 'index',
        icon: <DesktopOutlined />,
        children: [
            {
                label: '相册列表',
                key: 'indexItem:1',
            },
            {
                label: '创建相册',
                key: 'indexItem:2',
            },
            {
                label: '上传图片',
                key: 'indexItem:3',
            },

        ]
    },
    {
        label: '用户',
        key: 'user',
        icon: <UserOutlined />,
        children: [
            // {
            //     label: '个人中心',
            //     key: 'userItem:1',
            // },
            {
                label: '退出登入',
                key: 'userItem:2',
            },
        ]
    },
];


const Index :React.FC = () => {
    const nav = useNavigate()
    store.setNav(nav)
    const [messageApi, contextHolder] = message.useMessage();
    store.setPublicMessage(messageApi)
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [formModalOpen] = Form.useForm();

    const [updateImg,setUpdateImg] = useState(false)

    const currentClick: MenuProps['onClick'] = (e) => {
        switch (e.key){
            case "userItem:2":
                messageApi.open({
                    type: 'success',
                    content: '退出成功',
                }).then(r => {});
                store.goToLogin()
                break
            case  "indexItem:1":
                nav("/")
                break
            case  "indexItem:2":
                formModalOpen.setFieldValue("name","")
                formModalOpen.setFieldValue("authority",0)
                setIsModalOpen(true)
                break
            case  "indexItem:3":
                setUpdateImg(true)
                break
        }
    };
    autorun(()=>{
        // console.log(store.name)
    })
    return (
        <>
            {contextHolder}
            <UpdateImage status={[updateImg,setUpdateImg]} />
            <Modal style={{maxWidth: "300px"}} okText="确定" cancelText="取消" title="创建相册" open={isModalOpen} onOk={()=>{
                formModalOpen.submit()
            }} onCancel={()=>setIsModalOpen(false)}>
                <Form
                    layout="horizontal"
                    form={formModalOpen}
                    onFinish={
                        (e)=>{
                            store.axios().post(url.PhotoAlbums, {
                                "name": e.name,
                                "authority": e.authority||0,
                            })
                                .then(function (response) {
                                    if (response.data.code === 200){
                                        messageApi.success(response.data.msg)
                                        setIsModalOpen(false)
                                        store.updatePAS()
                                        setTimeout(()=>{
                                            store.dataUpdate()
                                        },1000)
                                    }else if (response.data.code === 500){
                                        messageApi.error(response.data.msg)
                                        setIsModalOpen(false)
                                        store.goToLogin()
                                    }
                                    else {
                                        messageApi.error(response.data.msg)
                                    }
                                })
                                .catch(function (error) {
                                    console.log(error);
                                });
                        }
                    }
                >
                    <Form.Item name="name" rules={[{ required: true }]} style={{marginTop: "30px"}}>
                        <Input
                            placeholder="请输入相册名"
                            prefix="相册名称"
                        />
                    </Form.Item>
                    <Form.Item name="authority">
                        <Radio.Group>
                            <Radio value={0}> 公开 </Radio>
                            <Radio value={1}> 私密 </Radio>
                        </Radio.Group>
                    </Form.Item>

                </Form>
            </Modal>

            <Space  direction="vertical" style={{ width: '100%' }} size={[0, 48]}>
                <Layout style={{height: "100vh"}}>
                    <Header style={{ position: 'sticky', top: 0,left: 0, zIndex: 1, width: '100%'}} onClick={(e)=>e.stopPropagation()}>
                        <Menu
                            theme="dark"
                            mode="horizontal"
                            style={{justifyContent:"center"}}
                            items={items}
                            onClick={currentClick}
                            selectable={false}
                        />
                    </Header>
                    <Content style={contentStyle}>
                        <Outlet/>
                    </Content>
                    <Footer style={footerStyle}>
                        2022 - 2022 ©    粤ICP备2021123456号
                    </Footer>
                </Layout>
            </Space>
        </>
    );
};

export default Index;

