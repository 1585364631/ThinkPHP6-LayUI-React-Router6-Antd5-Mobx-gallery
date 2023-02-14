import React from "react";
import url from "../url";
import {Navigate, useLocation} from "react-router-dom";

interface AuthProps {
    auth: JSX.Element,
    lock: boolean
}

const Auth: React.FC<AuthProps> = ({ auth, lock }: AuthProps) => {
    if (localStorage.getItem("jwtToken")) {
        //得到XMLHttpRequest对象
        const xhr = new XMLHttpRequest();
        // eslint-disable-next-line react-hooks/rules-of-hooks
        const loc = useLocation()
        xhr.open('POST',url.checkLogin,false);
        xhr.setRequestHeader("jwtToken",localStorage.getItem("jwtToken")||"")
        xhr.send("");
        if(xhr.status === 200){
            if (lock&&!loc.state){
                return (<Navigate to="/"/>)
            }
            return (<>{auth}</>)
        }
    }
    return (<Navigate to="login"/>)
};

export default Auth;