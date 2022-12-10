import React from "react";
import {createRoot} from "react-dom/client";
import { HashRouter, Routes, Route } from "react-router-dom";
import Home from "./components/Home/Home";


const MainRouter=()=>{
    return(
        <HashRouter>
            <Routes>
                <Route path="/" element={<Home />} />                
            </Routes>
        </HashRouter>
    )
};

createRoot(document.querySelector("#root")).render(<MainRouter/>);