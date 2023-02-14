import React from "react";
import Router from "./router";
import {createRoot} from "react-dom/client";
import 'antd/dist/reset.css';
import axios from "axios";
axios.defaults.withCredentials=true;

const box = document.getElementById('root')
const root = createRoot(box!);
root.render(
    <Router />
);