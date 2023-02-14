import React, {useEffect, useState} from 'react';
import store from "../mobx/store";
import url from "../url";
import {useLocation} from "react-router-dom";
import {Col, Row} from "antd";
import Picture from "../components/Picture";
import EditImage from "../components/EditImage";

const Show:React.FC = (props, context)=>{
    const [pictureData,setPictureData] = useState({
        id: undefined,
        name: undefined,
        authority: undefined,
        pictures: []
    })
    const [editImage,setEditImage] = useState(false)
    const location = useLocation()
    store.setPid(location.state.id)
    const updateImages = () => {
        store.axios().get(url.Picture + `?id=${location.state.id}`)
            .then(function (response) {
                if (response.data.code === 200){
                    setPictureData(response.data.data[0])
                }
                if (response.data.code === 500){
                    store.goToLogin()
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    }
    store.setUpdateImages(updateImages)
    useEffect(()=>{
        updateImages()
    },[])
    return (
        <>
            <EditImage status={[editImage,setEditImage]} />
            <div style={{width:"100%",height: "100%",backgroundColor: "#f0f2f5",}}>
                <Row style={{paddingBottom: "30px",flexDirection:"row"}}>
                    {pictureData.pictures.map((item,index)=>(
                        <Col style={{flexDirection:"column"}} key={index} xs={12} sm={8} md={6} lg={4} xl={4}>
                            <Picture obj={item} setEditImage={setEditImage}/>
                        </Col>
                    ))}
                </Row>
            </div>
        </>
    )
}

export default Show