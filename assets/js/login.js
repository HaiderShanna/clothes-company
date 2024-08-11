/*  Login and sign up Form  */
let baseUrl = document.getElementById('base-url').value;
let dialog = document.querySelector('dialog');
let dialogContainer = document.querySelector('.dialog-container');
let openFormBtn = document.querySelector('.open-form');
let closeBtn = document.querySelector('.close-btn');
let loginForm = document.querySelector('.login-form');
let signupForm = document.querySelector('.signup-form');
let loggedIn = document.querySelector('.logged-in');
let loggedInSession = document.getElementById('logged-in-session');
let logOutBtn = document.querySelector('.log-out-btn');

/* logout button onclick */
logOutBtn.addEventListener('click', () => {
  localStorage.removeItem('cart');
  window.location.href = `${baseUrl}logout`;
})


/* Show error alert if something went wrong with login or signup */
let failed = document.getElementById('failed');
if(failed.value){
  Swal.fire({
    position: "center",
    icon: "error",
    title: failed.value,
    showConfirmButton: false,
    timer: 1500
  });
}

/* Show success alert if logged in or signed up successfully */
let success = document.getElementById('success');
if(success.value){
  Swal.fire({
    icon: "success",
    title: success.value,
    showConfirmButton: false,
    timer: 1000
  });
}

/* Open and close the login dialog */
openFormBtn.addEventListener('click', ()=>{
  dialog.showModal();
});
closeBtn.addEventListener('click', ()=>{
  dialog.close();
});

/* check if the user logged in or not */
if(loggedInSession.value){
  loginForm.classList.add('hide');
  signupForm.classList.add('hide');
  loggedIn.classList.remove('hide');
}

/* show and hide login and signup forms */
let createBtn = document.querySelector('.dialog-container span.create');
createBtn.addEventListener('click', () => {
  loginForm.classList.add('hide');
  signupForm.classList.remove('hide');
});
let loginBtn = document.querySelector('.dialog-container span.login');
loginBtn.addEventListener('click', ()=>{
  signupForm.classList.add('hide');
  loginForm.classList.remove('hide');
});

/* check if there is a login error or not  */
let errorType = document.getElementById('error-type');

if(errorType.value == 'signup'){
  signupForm.classList.remove('hide');
  loginForm.classList.add('hide');
  dialog.showModal();
}
else if(errorType.value == 'login'){
  signupForm.classList.add('hide');
  loginForm.classList.remove('hide');
  dialog.showModal();
}
