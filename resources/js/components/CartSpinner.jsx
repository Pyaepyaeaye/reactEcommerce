import React from 'react'

export default function CartSpinner() {
  return (
    <div className='d-flex justify-content-center'>
        <div className="spinner-border spinner-border-sm" role="status">
        <span className="sr-only">Loading...</span>
        </div>
    </div>
  )
}
