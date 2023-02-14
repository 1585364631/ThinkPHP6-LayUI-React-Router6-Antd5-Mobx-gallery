import React, {useEffect, useState} from "react";
import {Col, Form, Input, Modal, Row, Select, Upload, UploadFile, UploadProps} from "antd";
import store from "../mobx/store";
import url from "../url";
import TextArea from "antd/es/input/TextArea";
import {RcFile, UploadChangeParam} from "antd/es/upload";


interface UpdateImageProps {
    status: any[]
}

const beforeUpload = (file: RcFile) => {
    const isJpgOrPng = file.type === 'image/jpeg' || file.type === 'image/png';
    if (!isJpgOrPng) {
        store.publicMessage.error('You can only upload JPG/PNG file!');
    }
    const isLt2M = file.size / 1024 / 1024 < 2;
    if (!isLt2M) {
        store.publicMessage.error('Image must smaller than 2MB!');
    }
    return isJpgOrPng && isLt2M;
};

const getBase64 = (img: RcFile, callback: (url: string) => void) => {
    const reader = new FileReader();
    reader.addEventListener('load', () => callback(reader.result as string));
    reader.readAsDataURL(img);
};

const UpdateImage:React.FC<UpdateImageProps> = ({status}: UpdateImageProps) => {
    const [pAs,setPA] = useState([])
    const [imageUrl, setImageUrl] = useState<string>();
    const [form] = Form.useForm()

    const updatePA = ()=>{
        store.axios().get(url.PhotoAlbums)
            .then(function (response) {
                if (response.data.code === 200){
                    setPA(response.data.data)
                }
                if (response.data.code === 500){
                    store.goToLogin()
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    }
    store.setUpdatePAS(updatePA)
    const handleChange: UploadProps['onChange'] = (info: UploadChangeParam<UploadFile>) => {
        if (info.file.status === 'uploading') {
            return;
        }
        if (info.file.status === 'done') {
            if (info.file.response.code===200){
                form.setFieldValue("url",info.file.response.data.src)
            }
            if (info.file.response.code===500){
                store.publicMessage.error("上传失败")
                store.goToLogin()
            }
            getBase64(info.file.originFileObj as RcFile, (url) => {
                setImageUrl(url);
            });
        }
    };
    useEffect(()=>{
        updatePA()
    },[])

    useEffect(()=>{
        if (status[0]){
            form.setFieldValue("photoid",store.pid||"")
            form.setFieldValue("name","")
            form.setFieldValue("text","")
            setImageUrl("")
        }
    },[form, status])

    return (
        <>
            <Modal title="上传图片" open={status[0]} onOk={form.submit} onCancel={()=>{
                status[1](false)
            }} okText={"确认"} cancelText={"取消"} forceRender={true}>
                <Row>
                    <Form
                        name="basic"
                        onFinish={(e)=>{
                            store.axios().post(url.Picture,e)
                                .then(function (response) {
                                    if (response.data.code === 200){
                                        store.publicMessage.success(response.data.msg)
                                        setImageUrl("")
                                        status[1](false)
                                        setTimeout(()=>{
                                            // window.location.reload()
                                            store.updateImages()
                                        },1000)

                                    }
                                    if (response.data.code === 500){
                                        store.publicMessage.error(response.data.msg)
                                        store.goToLogin()
                                    }
                                })
                                .catch(function (error) {
                                    console.log(error);
                                });
                        }}
                        autoComplete="off"
                        form={form}
                        style={{width:"100%"}}
                    >
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
                                            pAs.map(({id, name}, index)=>(<Select.Option key={index} value={id}>{name}</Select.Option>))
                                        }
                                    </Select>
                                </Form.Item>
                            </Col>
                        </Row>
                        <Row>
                            <Col span={4} style={{textAlign:"center",lineHeight:"30px"}}><span style={{color:"red"}}>*</span>地址</Col>
                            <Col span={20}>
                                <Form.Item
                                    name="url"
                                    rules={[{ required: true, message: '请输入地址或者上传图片' }]}
                                    style={{marginBottom: "10px"}}
                                >
                                    <Input onChange={(e)=>{
                                        setImageUrl(e.target.value.startsWith("http")?e.target.value:url.Images + e.target.value)
                                    }}/>
                                </Form.Item>
                            </Col>
                            <Col span={20} offset={4}>
                                <Upload
                                    name="file"
                                    listType="picture-card"
                                    className="avatar-uploader"
                                    showUploadList={false}
                                    action={url.UpdateImage}
                                    headers={{
                                        jwtToken: localStorage.getItem("jwtToken")||""
                                    }}
                                    beforeUpload={beforeUpload}
                                    onChange={handleChange}
                                >
                                    {imageUrl ? <img src={imageUrl} style={{ width: '100%' }} /> : (<div>
                                        <div style={{ marginTop: 8 }}>Upload</div>
                                    </div>)}
                                </Upload>
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
                </Row>
            </Modal>
        </>
    )
}

export default UpdateImage