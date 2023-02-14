import {createBrowserRouter, createMemoryRouter, RouterProvider} from "react-router-dom";
import React from "react";
import Auth from "./Auth";
import Index from "../pages/Index";
import Home from "../pages/Home";
import Show from "../pages/Show";
import Login from "../pages/Login"

const Router = () => (<RouterProvider router={
    createMemoryRouter([
        {
            path: "/",
            element: <Auth auth={<Index />} lock={false}/>,
            children: [
                {
                    path: "/",
                    element: <Auth auth={<Home />} lock={false} />,
                    index: true
                },
                {
                    path: '/show',
                    element: <Auth auth={<Show />} lock={true} />,
                }
            ]
        },
        {
            path: '/login',
            element: <Login />
        },{
            path: "*",
            element: <Login />
        }
    ])
} />)

export default Router