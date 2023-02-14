import React, {useEffect, useState} from "react";
import store from "../mobx/store";
import {Col, Form, Input, Modal, Row, Select} from "antd";
import TextArea from "antd/es/input/TextArea";
import url from "../url";


interface EditImageProps {
    status: any[]
}

const EditImage:React.FC<EditImageProps> = ({status}: EditImageProps)=>{
    const [ppAs,setPPAS] = useState([])
    const [form] = Form.useForm()
    const updateData = () => {
        store.axios().get(url.PhotoAlbums)
            .then(function (response) {
                if (response.data.code === 200){
                    setPPAS(response.data.data)
                }
                if (response.data.code === 500){
                    store.goToLogin()
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    useEffect(()=>{
        if (status[0]){
            updateData()
            form.setFieldValue("id",store.Pic.id)
            form.setFieldValue("photoid",store.Pic.photoid||"")
            form.setFieldValue("name",store.Pic.name||"")
            form.setFieldValue("test",store.Pic.test||"")
        }
    },[status[0]])

    return (
        <>
            <Modal title="编辑信息" open={status[0]}
                   forceRender={true}
                   onOk={
                       ()=>{
                           form.submit()
                       }
                   }
                   onCancel={
                       ()=>{
                           form.resetFields()
                           status[1](false)
                       }
                   }
                   cancelText={"取消"}
                   okText={"确定"}
            >
                <Form
                    layout="horizontal"
                    form={form}
                    onFinish={
                        (e)=>{
                            store.axios().put(url.Picture, e)
                                .then(function (response) {
                                    if (response.data.code === 200){
                                        store.publicMessage.success(response.data.msg)
                                        status[1](false)
                                        setTimeout(()=>{
                                            store.updateImages()
                                        },1000)

                                    }else if (response.data.code === 500){
                                        store.publicMessage.error(response.data.msg)
                                        status[1](false)
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
                    <Form.Item
                        name="id"
                        style={{display:"none"}}
                        >
                        <Input/>
                    </Form.Item>
                    <Row>
                        <Col span={4} style={{textAlign:"center",lineHeight:"30px"}}><span style={{color:"red"}}>*</span>相册</Col>
                        <Col span={20}>
                            <Form.Item
                                name="photoid"
                                rules={[{ required: true, message: '请选择相册' }]}
                                style={{marginBottom: "10px"}}
                            >
                                <Select>
                                    {
                                        ppAs.map(({id, name}, index)=>(<Select.Option key={index} value={id}>{name}</Select.Option>))
                                    }
                                </Select>
                            </Form.Item>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={4} style={{textAlign:"center",lineHeight:"30px"}}>标题</Col>
                        <Col span={20}>
                            <Form.Item
                                name="name"
                                style={{marginBottom: "10px"}}
                            >
                                <Input/>
                            </Form.Item>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={4} style={{textAlign:"center",lineHeight:"30px"}}>介绍</Col>
                        <Col span={20}>
                            <Form.Item
                                name="text"
                            >
                                <TextArea />
                            </Form.Item>
                        </Col>
                    </Row>
                </Form>
            </Modal>
        </>
    )
}

export default EditImage