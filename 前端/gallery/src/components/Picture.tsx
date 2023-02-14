import React from "react";
import {Button, Card, Image, Popconfirm, Space} from "antd";
import url from "../url";
import {DeleteOutlined, EditOutlined} from "@ant-design/icons";
import axios from "axios";
import store from "../mobx/store";
const { Meta } = Card;

interface PictureProps {
    obj: any,
    setEditImage: (value: (((prevState: boolean) => boolean) | boolean)) => void
}

const copy = (val:any) => {
    if (navigator.clipboard && window.isSecureContext) {
        store.publicMessage.success("复制当前图片地址成功")
        return navigator.clipboard.writeText(val)
    } else {
        const textArea = document.createElement('textarea')
        textArea.value = val
        // 使text area不在viewport，同时设置不可见
        document.body.appendChild(textArea)
        textArea.focus()
        textArea.select()
        store.publicMessage.success("复制当前图片地址成功")
        return new Promise<void>((res, rej) => {
            document.execCommand('copy') ? res() : rej()
            textArea.remove()
        })
    }
}

const Picture:React.FC<PictureProps> = ({ obj, setEditImage }: PictureProps) => {
    return (
        <>
            <div style={{padding: "3px"}}>
                <Card
                    hoverable
                    style={{ width: "100%" }}
                    cover={<Image onClick={e => {e.stopPropagation()}} src={obj.url.startsWith("http")?obj.url:url.Images + obj.url} />}
                    onClick={()=>{
                        copy(obj.url.startsWith("http")?obj.url:url.Images + obj.url)
                    }}
                >
                    <Meta title={obj.name} description={obj.text} />
                    <Space wrap onClick={(e)=>e.stopPropagation()} style={{marginTop:"10px"}}>
                        <Button onClick={()=>{
                            store.setPic(obj)
                            setEditImage(true)
                        }
                        }><EditOutlined /></Button>
                        <Popconfirm
                            title="删除提醒"
                            description={`是否确认删除该图片？`}
                            okText="确认"
                            cancelText="取消"
                            onConfirm={()=>{
                                axios.create({
                                    headers: {'jwtToken': localStorage.getItem("jwtToken")}
                                }).delete(url.Picture, {
                                    data: {
                                        id: obj.id
                                    }
                                })
                                    .then(function (response) {
                                        if (response.data.code === 200){
                                            store.publicMessage.success(response.data.msg)
                                            store.updateImages()
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
                            }}
                        >
                            <Button><DeleteOutlined /></Button>
                        </Popconfirm>
                    </Space>
                </Card>
            </div>
        </>
    )
}

export default Picture