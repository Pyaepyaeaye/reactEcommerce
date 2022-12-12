import React from "react";
import {createRoot} from "react-dom/client";
import { HashRouter, Routes, Route } from "react-router-dom";
import ProductDetail from "./components/ProductDetail/ProductDetail";

const MainRouter=()=>{
    return(
        <HashRouter>
            <Routes>
                <Route path="/" element={<ProductDetail />} />                
            </Routes>
        </HashRouter>
    )
};

createRoot(document.querySelector("#root")).render(<MainRouter/>);