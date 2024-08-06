let loader = document.querySelector('.loader');


export function showSpinner(){
  loader.style.display = 'inline-block';
}
export function hideSpinner(){
  loader.style.display = 'none';
}

export function updateCartNumber() {
  let cartNumEl = document.querySelector('.cart-num');
  let data = JSON.parse(localStorage.getItem('cart'));
  if(data){
    cartNumEl.style.display = 'inline';
    cartNumEl.innerHTML = data.length;
  }
}