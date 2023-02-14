import React, {useEffect, useState} from 'react';
import {Col, Row} from 'antd';
import PhotoAlbums from "../components/PhotoAlbums";
import url from "../url";
import store from "../mobx/store"
const Home: React.FC = () => {
    const [data,setData] = useState([])
    const dataUpdate = ()=>{
        store.axios().get(url.PhotoAlbums)
            .then(function (response) {
                if (response.data.code === 200){
                    setData(response.data.data)
                }
                if (response.data.code === 500){
                    store.goToLogin()
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    }
    store.setDataUpdate(dataUpdate)
    useEffect(()=>{
        dataUpdate()
    },[])

    return (
        <div style={{
            width: "100%",
            height: "100%",
            backgroundColor: "#f0f2f5",
        }}>
            <Row style={{paddingBottom: "30px"}}>
                {data.map((item,index)=>(
                    <Col key={index} xs={12} sm={8} md={6} lg={4} xl={4}>
                        <PhotoAlbums key={index} obj={item}/>
                    </Col>
                ))}
            </Row>
        </div>

    )
};

export default Home;