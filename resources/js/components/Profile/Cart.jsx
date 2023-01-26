import React, { useEffect, useState } from 'react';
import axios from 'axios';
import Spinner from '../Spinner';

export default function Cart() {
  const [loader, setLoader] = useState(false);
  const [cart, setCart] =useState([]);
  const user_id= window.auth.id;

  useEffect(()=>{
    setLoader(true);
    axios.get('/api/get-cart?user_id=' + user_id)
    .then((res)=> {
      setCart(res.data.data);
      setLoader(false);
    })
    .catch(function(error) {
      console.log(error);
    });
  },[]);

  const updateCart = (id,type)=>{   
    const updatedCart = cart.map(c=> {
      if(id === c.id){
        switch (type) {
          case 'add': 
            c.total_qty +=1;
            break;
          default:
            c.total_qty -=1;
            break;
        }
        return c;
      }
    });
    setCart(updatedCart);

  }

  const updateQty = (id,qty)=> {    
    axios.post('/api/update-cart-qty', {cart_id: id, total_qty: qty})
    .then(d =>{
      if(d.data.message === true){      
        showSuccessToast("Cart Quantity Successfully");
      }
    })
    .catch(function(error) {
      console.log(error);
    });

  }

  const removeCart = (id)=> {
    axios.post('/api/delete-cart',{cart_id: id})
    .then((d)=> {
      if(d.data.message){
        setCart((preCart) => preCart.filter((d) => d.id !== id));        
        showSuccessToast("Cart Remove Successfully");
      }
    })
    .catch(function(error){
      console.log(error)
    });
  }

  const TotalPrice= ()=>{
    var total_price=0;
    cart.map((d)=>{
      total_price +=d.product.sale_price * d.total_qty;
    });
    return <span>{total_price} Ks</span>;
  }

  const checkout = ()=> {
 
    const user_id= window.auth.id;
    axios.post('/api/check-out?user_id=' +user_id)
    .then(d=>{
      if(d.data.message){
        setCart([]);
        window.updateCart(0);
        showSuccessToast("Checkout success")
      }
    });
  }

  return (
   <div className='container-fluid mt-3'>    
      <h4>Cart</h4>
      { loader && <Spinner />} 
      { !loader && cart.length >0 && (       
        <> 
        <div className='card p-3'>       
        <table>
          <thead>
            <th>Image</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Sale Price</th>
            <th>Total Price</th>
            <th>Add/Remove</th>
            <th>Delete</th>

          </thead>
          <tbody>
           {
            cart.map((d) => (
              <tr key={d.id}>
                <td><img src={d.product.image_url} alt={d.product.name} width="100" /></td>
                <td>{d.product.name}</td>
                <td>{d.total_qty}</td>
                <td>{d.product.sale_price}</td>
                <td>{d.product.sale_price * d.total_qty}</td>
                <td>
                  <button className='btn btn-dark btn-sm mr-2' onClick={()=> updateCart(d.id,'reduce')}>-</button>
                  <input type="text" className='btn border-warning' value={d.total_qty} disabled="true"/>
                  <button className='btn btn-dark btn-sm ml-2 ' onClick={()=> updateCart(d.id,'add')}>+</button>
                  <button className='btn btn-primary btn-sm ml-2' onClick={()=> updateQty(d.id, d.total_qty)}>
                    Save
                  </button>                 
                 
                </td>
                <td><button className='btn btn-danger ' onClick={()=> removeCart(d.id)}>< i className='fa fa-trash'></i></button></td>
              </tr>
             
            ))
            
           }
           <tr>
            <td colSpan={6}><span className='float-right'>Total : </span>{" "}</td>
            <td>
              <TotalPrice />
            </td>
           </tr>
          </tbody>
        </table>
        {
          cart.length >0 && (
          <div className=''>
            <button className='btn btn-primary text-center' onClick={()=> checkout()}>Checkout</button>
          </div>
          )
        }
        </div>
        </>        
      )}
      
   </div>
  )
}
