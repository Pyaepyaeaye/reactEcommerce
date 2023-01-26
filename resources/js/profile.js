import React from "react";
import {createRoot} from "react-dom/client";
import { HashRouter, Routes, Route, Link } from "react-router-dom";
import Cart from "./components/Profile/Cart";
import Nav from "./components/Profile/Component/Nav";
import Order from "./components/Profile/Order";
import Profile from "./components/Profile/Profile";
import ChangePassword from './components/Profile/ChangePassword';

const MainRouter=()=>{
    return(
        <HashRouter>
           <Nav />
            <Routes>
                <Route path="/" element={<Cart />} /> 
                <Route path="/order" element={<Order />} />  
                <Route path="/profile" element={<Profile />} />     
                <Route path="/change-password" element={<ChangePassword />}   />        
            </Routes>
        </HashRouter>
    )
};

createRoot(document.querySelector("#root")).render(<MainRouter/>);