import axios from 'axios';
import React,{ useEffect, useState } from 'react';
import Spinner from '../Spinner';
import CartSpinner from '../CartSpinner';
import StarRatings from 'react-star-ratings';

export default function ProductDetail() {

  const [product, setProduct] = useState({});
  const [loader, setLoader] = useState(true);
  const [reviewList, setReviewList] = useState([]);
  const [comment, setComment] = useState('');
  const [rating, setRating] = useState(0);
  const disabledReview = rating && comment !== ""? false : true;
  const [reviewLoader, setReviewLoader] = useState(false);
  const [cartLoader, setCartLoader] = useState(false);

  const makeReview= ()=>{
    setReviewLoader(true);    
    const user_id= window.auth.id;
    const slug  = window.product_slug;
    const data = { comment, user_id, slug, rating };
    
    axios.post('/api/review/'+slug,data).then(({data})=>{
        console.log(data);
        if(data.message === false){
            showToast("Product Not Found");
        }
        else{
            setReviewList([...reviewList, data.data]);
            setReviewLoader(false);
            setComment("");
            setRating(0);
        }
       
    })
    .catch(function(error) {
        console.log(error);
    });
   
  }

  const product_slug = window.product_slug;
  const fetchData= ()=>{
    axios.get('/api/product/'+ product_slug)
    .then(({data}) =>{        
        setProduct(data.data);  
        setReviewList(data.data.review);    
        setLoader(false);
      })    
      .catch(function(error) {
        //console.log(error);
      });

  }
  useEffect(()=>{
    fetchData();
  },[]);

  //Add to Cart
  const addToCart= ()=> {   
    setCartLoader(true);
    const user_id = window.auth.id;
    axios.post("/api/add-tocart/" + product_slug, {user_id}).then((d)=>{
        setCartLoader(false);
        const { data } = d;        
        if(data.message == false){
            showSuccessToast('Product Not Found');
        }
        else{
            window.updateCart(data.data);
            showSuccessToast('Product Add To Cart');
            
            
        }
    });
    
  }

  return (
    <React.Fragment>
     {loader && <Spinner />}
     { 
          !loader && 
          <React.Fragment>           
            {/* Breadcrumb Start */}
            <div className="container-fluid">
            <div className="row px-xl-5">
                <div className="col-12">
                <nav className="breadcrumb bg-light mb-30">
                    <a className="breadcrumb-item text-dark" href="#">Home</a>
                    <a className="breadcrumb-item text-dark" href="#">Shop</a>
                    <span className="breadcrumb-item active">Shop Detail</span>
                </nav>
                </div>
            </div>
            </div>
            {/* Breadcrumb End */}
            {/* Shop Detail Start */}
            <div className="container-fluid pb-5">
            <div className="row px-xl-5">
                <div className="col-lg-5 mb-30">
                <div id="product-carousel" className="carousel slide" data-ride="carousel">
                    <div className="carousel-inner bg-light">
                    <div className="carousel-item active">
                        <img className="w-100 h-100" src={product.image_url} alt="Image" />
                    </div>
                    {/* <div className="carousel-item">
                        <img className="w-100 h-100" src="img/product-2.jpg" alt="Image" />
                    </div>
                    <div className="carousel-item">
                        <img className="w-100 h-100" src="img/product-3.jpg" alt="Image" />
                    </div>
                    <div className="carousel-item">
                        <img className="w-100 h-100" src="img/product-4.jpg" alt="Image" />
                    </div> */}
                    </div>
                    <a className="carousel-control-prev" href="#product-carousel" data-slide="prev">
                    <i className="fa fa-2x fa-angle-left text-dark" />
                    </a>
                    <a className="carousel-control-next" href="#product-carousel" data-slide="next">
                    <i className="fa fa-2x fa-angle-right text-dark" />
                    </a>
                </div>
                </div>
                <div className="col-lg-7 h-auto mb-30">
                <div className="h-100 bg-light p-30">              
                    <h3>{product.name}</h3>
                    <div className="d-flex">
                        <h6 className="text-muted mr-1">Brand: {product.brand.name}</h6>
                        <span style={{border: '2px solid #000', background: '#000',height: '20px'}}></span>
                        <h6 className="ml-1 text-muted">Category: {product.category.name}</h6>
                    </div>                    
                    <div className="d-flex mb-3">
                    <div className="text-primary mr-2">
                        <small className="fas fa-star" />
                        <small className="fas fa-star" />
                        <small className="fas fa-star" />
                        <small className="fas fa-star-half-alt" />
                        <small className="far fa-star" />
                    </div>
                    <small className="pt-1">(99 Reviews)</small>
                    </div>
                    <div className='d-flex'>
                    <h3 className="font-weight-semi-bold mb-4">Ks { product.discount_price }</h3><h5 className="text-muted ml-2 mt-1"><del>Ks { product.sale_price }</del></h5>
                    </div>                  
                    <div className='d-flex'>
                        <h6 className='text-success font-weight-bold'>InStock: {product.total_qty}</h6>
                    </div>
                    {
                        product.size.length >0 && (
                        <div className="d-flex mb-3">
                        <strong className="text-dark mr-3">Sizes:</strong>               
                            {
                                product.size.map((s)=>(
                                    <div className="custom-control custom-radio custom-control-inline" key={s.id}>
                                    <input type="radio" className="custom-control-input" id={`size-${s.id}`} name="size" />
                                    <label className="custom-control-label" htmlFor={`size-${s.id}`}>{s.name}</label>
                                    </div>
                                ))
                            }                       
                    
                        </div>
                        )
                    }
                    
                    <div className="d-flex mb-4">
                    <strong className="text-dark mr-3">Colors:</strong>
                    {
                        product.color.map((color)=>(
                            <div className="custom-control custom-radio custom-control-inline">
                            <input type="radio" className="custom-control-input" id={`color-${color.id}`} name="color" />
                            <label className="custom-control-label" htmlFor={`color-${color.id}`}>{color.name}</label>
                            </div>
                        ))
                    }                  
                    </div>
                    <div className="d-flex align-items-center mb-4 pt-2">
                    <div className="input-group quantity mr-3" style={{width: '130px'}}>
                        <div className="input-group-btn">
                        <button className="btn btn-primary btn-minus">
                            <i className="fa fa-minus" />
                        </button>
                        </div>
                        <input type="text" className="form-control bg-secondary border-0 text-center" defaultValue={1} />
                        <div className="input-group-btn">
                        <button className="btn btn-primary btn-plus">
                            <i className="fa fa-plus" />
                        </button>
                        </div>
                    </div>
                    { cartLoader && (
                        <CartSpinner />
                    )}  
                    {
                        !cartLoader && (
                            <button className="btn btn-primary px-3 mr-3" id="cartCount" onClick={()=> addToCart()} ><i className="fa fa-shopping-cart mr-1" /> Add To
                            Cart</button>
                        )
                    }                    
                   
                    <button className="btn btn-success px-3"><i className="fa fa-shopping-cart mr-1" /> Buy Now </button>        
                    </div>
                    
                    <div className="d-flex pt-2">
                    <strong className="text-dark mr-2">Share on:</strong>
                    <div className="d-inline-flex">
                        <a className="text-dark px-2" href>
                        <i className="fab fa-facebook-f" />
                        </a>
                        <a className="text-dark px-2" href>
                        <i className="fab fa-twitter" />
                        </a>
                        <a className="text-dark px-2" href>
                        <i className="fab fa-linkedin-in" />
                        </a>
                        <a className="text-dark px-2" href>
                        <i className="fab fa-pinterest" />
                        </a>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div className="row px-xl-5">
                <div className="col">
                <div className="bg-light p-30">
                    <div className="nav nav-tabs mb-4">
                    <a className="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Description</a>
                    <a className="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-2">Information</a>
                    <a className="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Reviews ({reviewList.length})</a>
                    </div>
                    <div className="tab-content">
                    <div className="tab-pane fade show active" id="tab-pane-1">
                        <h4 className="mb-3">Product Description</h4>
                        <p dangerouslySetInnerHTML={{ __html:product.description }}></p>
                    </div>
                    <div className="tab-pane fade" id="tab-pane-2">
                        <h4 className="mb-3">Additional Information</h4>
                        <p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam invidunt duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod consetetur invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum diam. Dolore diam stet rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing, eos dolores sit no ut diam consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod nonumy rebum dolor accusam, ipsum kasd eos consetetur at sit rebum, diam kasd invidunt tempor lorem, ipsum lorem elitr sanctus eirmod takimata dolor ea invidunt.</p>
                        <div className="row">
                        <div className="col-md-6">
                            <ul className="list-group list-group-flush">
                            <li className="list-group-item px-0">
                                Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                            </li>
                            <li className="list-group-item px-0">
                                Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                            </li>
                            <li className="list-group-item px-0">
                                Duo amet accusam eirmod nonumy stet et et stet eirmod.
                            </li>
                            <li className="list-group-item px-0">
                                Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                            </li>
                            </ul> 
                        </div>
                        <div className="col-md-6">
                            <ul className="list-group list-group-flush">
                            <li className="list-group-item px-0">
                                Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                            </li>
                            <li className="list-group-item px-0">
                                Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                            </li>
                            <li className="list-group-item px-0">
                                Duo amet accusam eirmod nonumy stet et et stet eirmod.
                            </li>
                            <li className="list-group-item px-0">
                                Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                            </li>
                            </ul> 
                        </div>
                        </div>
                    </div>
                    <div className="tab-pane fade" id="tab-pane-3">
                        <div className="row">
                        <div className="col-md-6">
                            <h4 className="mb-4">{reviewList.length} review for "Product Name"</h4>
                            {
                                reviewList.map((r)=>(
                                    <div className="media mb-4">
                                    <img src={r.user.image_url} alt="Image" className="img-fluid mr-3 mt-1" style={{width: '45px'}} />
                                    <div className="media-body">
                                        <h6>{r.user.name}<small> - <i>01 Jan 2045</i></small></h6>
                                        <StarRatings
                                            rating={r.rating}
                                            starRatedColor="rgb(255,211,51)"                                            
                                            numberOfStars={5}
                                            starDimension='15px'
                                            name='rating'
                                            />                                        
                                        <p>{r.review}</p>
                                    </div>
                                    </div>
                                ))
                            }
                            
                        </div>
                        {
                            window.auth && (
                                <div className="col-md-6">
                                <h4 className="mb-4">Leave a review</h4>
                                <small>Your email address will not be published. Required fields are marked *</small>
                                <div className="d-flex my-3">
                                <p className="mb-0 mr-2">Your Rating * :</p>
                                <StarRatings   
                                    rating={rating}   
                                    starHoverColor ="rgb(255,211,51)"  
                                    changeRating={(rateCount)=> setRating(rateCount)}
                                    numberOfStars={5}
                                    starDimension='30px'
                                    name='rating'
                                    />                            
                                </div>
                                <form>
                                <div className="form-group">
                                    <label htmlFor="message">Your Review *</label>
                                    <textarea id="message" cols={30} rows={5} className="form-control" defaultValue={""} 
                                    value={comment}
                                    onChange={(e)=> setComment(e.target.value)} />
                                </div>
                               
                                {
                                    reviewLoader && <Spinner />
                                }
                                {
                                    !reviewLoader && (
                                    <div className="form-group mb-0">
                                        <input type="submit" defaultValue="Leave Your Review" className="btn btn-primary px-3" 
                                        disabled={disabledReview} onClick={()=> makeReview()} />
                                    </div>
                                    )
                                }
                                
                                </form>
                            </div>
                            )
                        }                       
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
            {/* Shop Detail End */}
            {/* Products Start */}
            <div className="container-fluid py-5">
            <h2 className="section-title position-relative text-uppercase mx-xl-5 mb-4"><span className="bg-secondary pr-3">You May Also Like</span></h2>
            <div className="row px-xl-5">
                <div className="col">
                <div className="owl-carousel related-carousel">
                    <div className="product-item bg-light">
                    <div className="product-img position-relative overflow-hidden">
                        <img className="img-fluid w-100" src="img/product-1.jpg" alt="" />
                        <div className="product-action">
                        <a className="btn btn-outline-dark btn-square" href><i className="fa fa-shopping-cart" /></a>
                        <a className="btn btn-outline-dark btn-square" href><i className="far fa-heart" /></a>
                        <a className="btn btn-outline-dark btn-square" href><i className="fa fa-sync-alt" /></a>
                        <a className="btn btn-outline-dark btn-square" href><i className="fa fa-search" /></a>
                        </div>
                    </div>
                    <div className="text-center py-4">
                        <a className="h6 text-decoration-none text-truncate" href>Product Name Goes Here</a>
                        <div className="d-flex align-items-center justify-content-center mt-2">
                        <h5>$123.00</h5><h6 className="text-muted ml-2"><del>$123.00</del></h6>
                        </div>
                        <div className="d-flex align-items-center justify-content-center mb-1">
                        <small className="fa fa-star text-primary mr-1" />
                        <small className="fa fa-star text-primary mr-1" />
                        <small className="fa fa-star text-primary mr-1" />
                        <small className="fa fa-star text-primary mr-1" />
                        <small className="fa fa-star text-primary mr-1" />
                        <small>(99)</small>
                        </div>
                    </div>
                    </div>
                    <div className="product-item bg-light">
                    <div className="product-img position-relative overflow-hidden">
                        <img className="img-fluid w-100" src="img/product-2.jpg" alt="" />
                        <div className="product-action">
                        <a className="btn btn-outline-dark btn-square" href><i className="fa fa-shopping-cart" /></a>
                        <a className="btn btn-outline-dark btn-square" href><i className="far fa-heart" /></a>
                        <a className="btn btn-outline-dark btn-square" href><i className="fa fa-sync-alt" /></a>
                        <a className="btn btn-outline-dark btn-square" href><i className="fa fa-search" /></a>
                        </div>
                    </div>
                    <div className="text-center py-4">
                        <a className="h6 text-decoration-none text-truncate" href>Product Name Goes Here</a>
                        <div className="d-flex align-items-center justify-content-center mt-2">
                        <h5>$123.00</h5><h6 className="text-muted ml-2"><del>$123.00</del></h6>
                        </div>
                        <div className="d-flex align-items-center justify-content-center mb-1">
                        <small className="fa fa-star text-primary mr-1" />
                        <small className="fa fa-star text-primary mr-1" />
                        <small className="fa fa-star text-primary mr-1" />
                        <small className="fa fa-star text-primary mr-1" />
                        <small className="fa fa-star text-primary mr-1" />
                        <small>(99)</small>
                        </div>
                    </div>
                    </div>
                    <div className="product-item bg-light">
                    <div className="product-img position-relative overflow-hidden">
                        <img className="img-fluid w-100" src="img/product-3.jpg" alt="" />
                        <div className="product-action">
                        <a className="btn btn-outline-dark btn-square" href><i className="fa fa-shopping-cart" /></a>
                        <a className="btn btn-outline-dark btn-square" href><i className="far fa-heart" /></a>
                        <a className="btn btn-outline-dark btn-square" href><i className="fa fa-sync-alt" /></a>
                        <a className="btn btn-outline-dark btn-square" href><i className="fa fa-search" /></a>
                        </div>
                    </div>
                    <div className="text-center py-4">
                        <a className="h6 text-decoration-none text-truncate" href>Product Name Goes Here</a>
                        <div className="d-flex align-items-center justify-content-center mt-2">
                        <h5>$123.00</h5><h6 className="text-muted ml-2"><del>$123.00</del></h6>
                        </div>
                        <div className="d-flex align-items-center justify-content-center mb-1">
                        <small className="fa fa-star text-primary mr-1" />
                        <small className="fa fa-star text-primary mr-1" />
                        <small className="fa fa-star text-primary mr-1" />
                        <small className="fa fa-star text-primary mr-1" />
                        <small className="fa fa-star text-primary mr-1" />
                        <small>(99)</small>
                        </div>
                    </div>
                    </div>
                    <div className="product-item bg-light">
                    <div className="product-img position-relative overflow-hidden">
                        <img className="img-fluid w-100" src="img/product-4.jpg" alt="" />
                        <div className="product-action">
                        <a className="btn btn-outline-dark btn-square" href><i className="fa fa-shopping-cart" /></a>
                        <a className="btn btn-outline-dark btn-square" href><i className="far fa-heart" /></a>
                        <a className="btn btn-outline-dark btn-square" href><i className="fa fa-sync-alt" /></a>
                        <a className="btn btn-outline-dark btn-square" href><i className="fa fa-search" /></a>
                        </div>
                    </div>
                    <div className="text-center py-4">
                        <a className="h6 text-decoration-none text-truncate" href>Product Name Goes Here</a>
                        <div className="d-flex align-items-center justify-content-center mt-2">
                        <h5>$123.00</h5><h6 className="text-muted ml-2"><del>$123.00</del></h6>
                        </div>
                        <div className="d-flex align-items-center justify-content-center mb-1">
                        <small className="fa fa-star text-primary mr-1" />
                        <small className="fa fa-star text-primary mr-1" />
                        <small className="fa fa-star text-primary mr-1" />
                        <small className="fa fa-star text-primary mr-1" />
                        <small className="fa fa-star text-primary mr-1" />
                        <small>(99)</small>
                        </div>
                    </div>
                    </div>
                    <div className="product-item bg-light">
                    <div className="product-img position-relative overflow-hidden">
                        <img className="img-fluid w-100" src="img/product-5.jpg" alt="" />
                        <div className="product-action">
                        <a className="btn btn-outline-dark btn-square" href><i className="fa fa-shopping-cart" /></a>
                        <a className="btn btn-outline-dark btn-square" href><i className="far fa-heart" /></a>
                        <a className="btn btn-outline-dark btn-square" href><i className="fa fa-sync-alt" /></a>
                        <a className="btn btn-outline-dark btn-square" href><i className="fa fa-search" /></a>
                        </div>
                    </div>
                    <div className="text-center py-4">
                        <a className="h6 text-decoration-none text-truncate" href>Product Name Goes Here</a>
                        <div className="d-flex align-items-center justify-content-center mt-2">
                        <h5>$123.00</h5><h6 className="text-muted ml-2"><del>$123.00</del></h6>
                        </div>
                        <div className="d-flex align-items-center justify-content-center mb-1">
                        <small className="fa fa-star text-primary mr-1" />
                        <small className="fa fa-star text-primary mr-1" />
                        <small className="fa fa-star text-primary mr-1" />
                        <small className="fa fa-star text-primary mr-1" />
                        <small className="fa fa-star text-primary mr-1" />
                        <small>(99)</small>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
            {/* Products End */}      
          </React.Fragment>
     }
    </React.Fragment>    
  )
}
