import React, { useState } from 'react';
import axios from 'axios';
import Spinner from '../Spinner';
export default function ChangePassword() {
  const[currentPassword, setCurrentPassword]= useState("");
  const[newPassword, setNewPassword]= useState("");
  const[confirmPassword, setConfirmPassword]= useState("");
  const [loader, setLoader] = useState(false);

  const changePassword =() => {
    setLoader(true);
    if(newPassword !== confirmPassword){
      showToast("Not same confirm password",'error');
      setLoader(false);
      return;
    }
    axios.post('/api/change-password?user_id=' +window.auth.id, {currentPassword, newPassword})
    .then((d)=>{
      const {data}= d;
      setLoader(false);
      if(data.message){
        showToast("chang password success");
      }
      else{
        showToast("wrong password", 'error');
      }
    })

  }
  return (
   <div className='container'>
      <div className='card p-5 mt-3'>
        <div className='form-group'>
          <label htmlFor=""> Enter Current Password</label>
          <input type="password" className='form-control' 
          onChange={e=> setCurrentPassword(e.target.value)}/>
        </div>
        <div className='form-group'>
          <label htmlFor=""> Enter New Password</label>
          <input type="password" className='form-control' 
           onChange={e=> setNewPassword(e.target.value)}/>
        </div>
        <div className='form-group'>
          <label htmlFor=""> Enter Confirm Password</label>
          <input type="password" className='form-control' 
          onChange={e=> setConfirmPassword(e.target.value)}/>
        </div>
        <div>
          {loader && <Spinner />}
          {
            !loader && (
              <button className='btn btn-dark' onClick={()=> changePassword()}>Change</button>
            )
          }
       
        </div>
        
      </div>
   </div>
  )
}
