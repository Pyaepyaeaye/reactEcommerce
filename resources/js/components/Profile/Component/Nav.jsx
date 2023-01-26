import React from 'react';
import { Link ,useLocation} from 'react-router-dom';

export default function Nav() {
  const { pathname } = useLocation();
  console.log(pathname)
  return (
    <div className="container-fluid">
    <div className="card p-3 bg-dark">
      <div className="d-flex justify-content-center">                              
      <Link to={"/"} className={`btn btn${pathname === '/' ? "":"-outline" }-warning mr-3`}> Cart List</Link>
      <Link to={"/order"} className={`btn btn${pathname === '/order' ? "":"-outline" }-warning mr-3`}> Order </Link>
      <Link to={"/profile"} className={`btn btn${pathname === '/profile' ? "":"-outline" }-warning mr-3`}> Profile </Link>
      <Link to={"/change-password"} className={`btn btn${pathname === '/change-password' ? "":"-outline" }-warning mr-3`}> Change Passwrod </Link>
      </div>
    </div>
   </div>
  )
}
