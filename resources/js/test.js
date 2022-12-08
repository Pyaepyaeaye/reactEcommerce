import React from "react";
import {createRoot} from "react-dom/client";
import { HashRouter, Routes, Route, Link } from "react-router-dom";

const Home=()=>{
    return <h2>Home</h2>
};

const About=()=>{
    return <h2>About</h2>
};

const MainRouter=()=>{
    return(
        <HashRouter>
            <Routes>
                <Route path="/" element={<Home/>} />
                <Route path="/about" element={<About/>} />
            </Routes>
        </HashRouter>
    )
};

createRoot(document.querySelector("#root")).render(<MainRouter/>);