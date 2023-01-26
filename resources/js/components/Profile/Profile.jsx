import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { json } from 'react-router-dom';

export default function Profile() {

  const [profile, setProfile] = useState({});
  const [name, setName] =useState("");
  const [image, setImage] =useState("");
  const [address, setAddress] =useState("");

  useEffect(()=>{
    axios.get('/api/profile?user_id='+ window.auth.id)
    .then((d)=>{
      console.log(JSON.stringify(d))
      setProfile(d.data.data);
    });
  },{});

  const changePassword = () => {
    axios.post('/api/profile?user_id='+ window.auth.id, {name,image,address})
    .then((d)=>{
      if(d.data.message){
        showToast("Updated Prfile");
      }
    })
  }
  return (
    <div className='container'>
      <div className='card mt-5 p-3'>
        <div className='form-group'>
          <label htmlFor="">Name</label>
          <input type="text" name="name" className='form-control' 
          value={profile.name} onChange={e=> setName(e.target.value)}/>
        </div>
        <div className='form-group'>
          <label htmlFor="">Image</label>
          <input type="file" className='form-control' onChange={e=> setImage(e.target.files[0])} />
          <img src={profile.image_url} alt="" width={100} />
        </div>
        <div className='form-group'>
          <label htmlFor="">Address</label>
          <textarea className='form-control' cols="30" rows="2" value={profile.address} onChange={e=> setAddress(e.target.value)}></textarea>          
        </div>
        <div>
          <button className='btn btn-success' onClick={()=> changePassword()}>Save</button>
        </div>
      </div>
    </div>    
  )
}
