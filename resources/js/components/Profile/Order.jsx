import axios from 'axios';
import React, { useEffect, useState } from 'react'
import Spinner from '../Spinner';

export default function Order() {
  const [loader, setLoader]= useState(true);
  const [order, setOrder] =useState({});
  const [page, setPage] = useState(1);
  useEffect(() => {
    const user_id= window.auth.id;
    axios.get(`/api/order-list?page=${page}&user_id=${user_id}`)
    .then(({data})=>{   
      // console.log(JSON.stringify(data))   
      setOrder(data);
      setLoader(false);
    })
  },[page]);
  return (
    <div>
    {loader && <Spinner/>}
    {
      !loader && (
        <>
        { order.data.data.length >0 && (
          <>
           <table className='table table-striped'>
          <thead>
            <th>Image</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Status</th>
          </thead>
          <tbody>
            {
            order.data.data.map(d=>(
                <tr key={d.id}>
                  <td><img src={d.product.image_url} alt="" width={100} /></td>
                  <td>{d.product.name}</td>
                  <td>{d.total_qty}</td>
                  <td>{d.product.sale_price} Ks</td>
                  <td>
                    {
                      d.status === 'pending' && (
                        <span className='badge badge-warning px-2 py-2'>Pending</span>
                      )
                    }
                    {
                      d.status === 'denied' && (
                        <span className='badge badge-danger px-2 py-2'>Denied</span>
                      )
                    }
                    {
                      d.status === 'approved' && (
                        <span className='badge badge-success px-2 py-2'>Approved</span>
                      )
                    }
                   
                  </td>
                </tr>
              ))}
          </tbody>
        </table>
        <div className='pt-3 text-center'>
          <button className='btn btn-dark mr-2' 
          disabled={order.data.prev_page_url === null? true : false} 
          onClick={()=> setPage(page - 1)}>
            <i className='fa fa-arrow-left'></i>
           
          </button>
          <button className='btn btn-dark ml-2' disabled={order.data.next_page_url === null? true : false}
          onClick={()=> setPage(page + 1)}>
            <i className='fa fa-arrow-right'></i>
          </button>
        </div>
          </>
        )
        }
       
        
        </>
      )
    }
    
    </div>
    
  )
}
