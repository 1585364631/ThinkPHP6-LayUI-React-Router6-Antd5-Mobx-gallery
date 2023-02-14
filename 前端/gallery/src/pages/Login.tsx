import React, {useEffect} from 'react';
import {Col, Form, Input, Button, message} from "antd";
import { UserOutlined } from '@ant-design/icons';
import { Avatar } from 'antd';
import url from "../url";
import axios from "axios";
import { useNavigate} from "react-router-dom";

const boxCss:React.CSSProperties = {
    width:'100vw',
    height:"100vh",
    backgroundImage: "-webkit-gradient(linear, 0 0, 100% 100%, from(rgb(26, 188, 156)), to(rgb(255, 234, 167)))",
    display:"flex",
    justifyContent:"center",
    alignItems:"center"
}

const boxCssDiv: React.CSSProperties = {
    backgroundColor:"#dff2e3",
    borderRadius:"5px",
    textAlign:"center",
    padding: "10px"
}

const Login:React.FC = () => {
    // const [captcha,setCaptcha] = useState(url.captcha)
    const navigate = useNavigate()
    const [messageApi, contextHolder] = message.useMessage();
    const onFinish = (values: any) => {
        axios.post(url.login, {
            "number": values.number,
            "password": values.password,
            "captcha": values.captcha,
        })
            .then(function (response) {
                console.log(response.data)
                if (response.data.code === 200){
                    localStorage.setItem("jwtToken",response.data.token.toString())
                    messageApi.success(response.data.msg)
                    console.log(response.data.token)

                    setTimeout(()=>{
                        navigate("/")
                    },1500)
                }else {
                    messageApi.error(response.data.msg)
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    };

    useEffect(()=>{
        if (localStorage.getItem("jwtToken")) {
            axios.create({
                headers: {'jwtToken': localStorage.getItem("jwtToken")}
            }).post(url.checkLogin, {})
                .then(function (response) {
                    if (response.data.code === 200){
                        messageApi.success(response.data.msg)
                        setTimeout(()=>{
                            navigate("/")
                        },1500)
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    },[])

    return (
        <>{contextHolder}
            <div style={boxCss}>
                <Col xs={20} sm={16} md={14} lg={10} xl={8} style={boxCssDiv}>
                    <Avatar size={50} icon={<UserOutlined />} />
                    <Form
                        name="basic"
                        layout="horizontal"
                        style={{ marginTop: '10px',padding:'20px' }}
                        onFinish={onFinish}
                        autoComplete="off"
                    >
                        <Form.Item
                            name="number"
                            rules={[{ required: true, message: '请输入账号', }]}
                        >
                            <Input placeholder="请输入账号" prefix={
                                <div style={{textAlign:"center"}}>账号</div>
                            } />
                        </Form.Item>
                        <Form.Item
                            name="password"
                            rules={[{ required: true, message: '请输入密码' }]}
                        >
                            <Input.Password placeholder="请输入密码" prefix="密码"/>
                        </Form.Item>
                        {/*<Form.Item*/}
                        {/*    name="captcha"*/}
                        {/*    rules={[{ required: true, message: '请输入验证码' }]}*/}
                        {/*>*/}
                        {/*    <Input placeholder="请输入验证码" prefix="验证码" suffix={*/}
                        {/*        <div>*/}
                        {/*            <img height="31px" width="100px" src={captcha} onClick={()=>{*/}
                        {/*                setCaptcha(url.captcha + '?random=' + (new Date()).getTime() + Math.random())*/}
                        {/*            }*/}
                        {/*            }/>*/}
                        {/*        </div>*/}
                        {/*    } />*/}
                        {/*</Form.Item>*/}
                        <Form.Item wrapperCol={{ span: 24 }}>
                            <Button type="primary" htmlType="submit">
                                注册 | 登入
                            </Button>
                        </Form.Item>
                    </Form>
                </Col>
            </div>
        </>

    );
};

export default Login;