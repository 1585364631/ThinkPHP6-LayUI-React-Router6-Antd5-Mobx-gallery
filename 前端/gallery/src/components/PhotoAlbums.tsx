import React, {useState} from "react";
import {Button, Card, Popconfirm, Space, Form, Input, Radio, Modal} from "antd";
import {
    EditOutlined,DeleteOutlined
} from '@ant-design/icons';
import store from "../mobx/store";
import axios from "axios";
import url from "../url";

interface PhotoAlbumsProps {
    obj: any
}

const deletePA = (obj: any) => {
    axios.create({
        headers: {'jwtToken': localStorage.getItem("jwtToken")}
    }).delete(url.PhotoAlbums, {
        data: {
            id: obj.id
        }
    })
        .then(function (response) {
            if (response.data.code === 200){
                store.publicMessage.success(response.data.msg)
                store.updatePAS()
                setTimeout(()=>{
                    store.dataUpdate()
                },100)
            }else if (response.data.code === 500){
                store.publicMessage.error(response.data.msg)
                store.goToLogin()
            }
            else {
                store.publicMessage.error(response.data.msg)
            }
        })
        .catch(function (error) {
            console.log(error);
        });
}

const PhotoAlbums:React.FC<PhotoAlbumsProps> = ({obj}: PhotoAlbumsProps)=> {
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [formModalOpen] = Form.useForm();
    return <>
        <div onClick={store.goToShow.bind(this,obj.id)}>
        <Card
            style={{margin:"5px"}}
            title={
            obj.name
        } bordered={false}>
            <p>{obj.authority?"私有":"公开"}</p>
            <Space wrap onClick={(e)=>e.stopPropagation()}>
                <Button onClick={()=>{
                    formModalOpen.setFieldValue("name",obj.name)
                    formModalOpen.setFieldValue("id",obj.id)
                    formModalOpen.setFieldValue("authority",obj.authority)
                    setIsModalOpen(true)
                }

                }><EditOutlined /></Button>
                <Popconfirm
                    title="删除提醒"
                    description={`是否确认删除名为"${obj.name}"的相册？`}
                    okText="确认"
                    cancelText="取消"
                    onConfirm={deletePA.bind(this,obj)}
                >
                    <Button><DeleteOutlined /></Button>
                </Popconfirm>
            </Space>
        </Card>
        <div onClick={(e)=>e.stopPropagation()}>
        <Modal style={{maxWidth: "300px"}} okText="确定" cancelText="取消" title="编辑相册" open={isModalOpen} onOk={()=>{
            formModalOpen.submit()
        }} onCancel={()=>setIsModalOpen(false)}>
            <Form
                layout="horizontal"
                form={formModalOpen}
                onFinish={
                    (e)=>{
                        store.axios().put(url.PhotoAlbums, {
                            "id": e.id,
                            "name": e.name,
                            "authority": e.authority||0,
                        })
                            .then(function (response) {
                                if (response.data.code === 200){
                                    setIsModalOpen(false)
                                    store.publicMessage.success(response.data.msg)
                                    store.updatePAS()
                                    setTimeout(()=>{
                                        store.dataUpdate()
                                    },1000)

                                }else if (response.data.code === 500){
                                    store.publicMessage.error(response.data.msg)
                                    setIsModalOpen(false)
                                    store.goToLogin()
                                }
                                else {
                                    store.publicMessage.error(response.data.msg)
                                }
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    }
                }
            >
                <Form.Item name="id" style={{display: "none"}}>
                    <input type="hidden"/>
                </Form.Item>

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

        </Modal></div>
        </div>
    </>
}

export default PhotoAlbums