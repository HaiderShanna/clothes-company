/*  Login and sign up Form  */
let baseUrl = document.getElementById('base-url').value;
let dialog = document.querySelector('dialog');
let dialogContainer = document.querySelector('.dialog-container');
let openFormBtn = document.querySelector('.open-form');
let closeBtn = document.querySelector('.close-btn');

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

/* Open and close the login dialog */
openFormBtn.addEventListener('click', ()=>{
  dialog.showModal();
  createLoginForm();
});
closeBtn.addEventListener('click', ()=>{
  dialog.close();
});

/* Creates the login form and attach event listener to the elements created */
function createLoginForm(errors = ''){
  dialogContainer.innerHTML = `
    <form action="${baseUrl}login" method="post">
      <h1>Login</h1>
      <label for="email">Email :</label>
      <input type="text" id="email" class="email" name="email">
      <small class="email-err error">${errors.email ? errors.email : ''}</small>

      <label for="password">Password :</label>
      <input type="password" id="password" class="password" name="password">
      <small class="password-err error">${errors.password ? errors.password : ''}</small>

      <p>Don't have an account ? <span>Create One</span></p>
      <button class="login-button">Login</button>
    </form>
  `;
  let createBtn = document.querySelector('.dialog-container span');
  createBtn.addEventListener('click', createSignUpForm);

} 

/* Creates the login form and attach event listener to the elements created */
function createSignUpForm(errors = ''){
  dialogContainer.innerHTML = `
    <form action="${baseUrl}signup" method="post">
      <h1>Sign Up</h1>
      <label for="name">Name :</label>
      <input type="text" id="name" class="name" name="name">
      <small class="name-err error">${errors.name ? errors.name : ''}</small>

      <label for="email">Email :</label>
      <input type="email" id="email" class="email" name="email">
      <small class="email-err error">${errors.email ? errors.email : ''}</small>

      <label for="password">Password :</label>
      <input type="password" id="password" class="password" name="password">
      <small class="password-err error">${errors.password ? errors.password : ''}</small>

      <label for="password2">Confirm Password :</label>
      <input type="password" id="password2" class="password2" name="password2">
      <small class="password2-err error">${errors.password2 ? errors.password2 : ''}</small>

      <p>Already have an account ? <span>Log in</span></p>
      <button class="login-button">Sign Up</button>
    </form>
  `;
  
  let createBtn = document.querySelector('.dialog-container span');
  createBtn.addEventListener('click', createLoginForm);

} 


/* check if there is a login error or not  */
let loginErr = document.getElementById('flashdata').value;

if(loginErr !== 'null'){
  loginErr = JSON.parse(loginErr);
  dialog.showModal();
  createLoginForm(loginErr);

  let email = document.getElementById('email');
  let password = document.getElementById('password');

  if(loginErr.email){
    email.classList.add('border-error')
  }
  else{
    email.classList.remove('border-error')
  }
  if(loginErr.password){
    password.classList.add('border-error')
  }
  else{
    password.classList.remove('borders-error')
  }
}
else{
  let alert = document.getElementById('success');
  if(alert.value){
    Swal.fire({
      position: "center",
      icon: "success",
      title: alert.value,
      showConfirmButton: false,
      timer: 1500
    });
  }
}

/* check if there is a sign up error or not  */
let signUpErr = document.getElementById('signup-errors').value;
let inputs = document.getElementById('inputs').value;

if(signUpErr !== 'null'){
  signUpErr = JSON.parse(signUpErr);
  inputs = JSON.parse(inputs);
  dialog.showModal();
  createSignUpForm(signUpErr);

  let name = document.getElementById('name');
  let email = document.getElementById('email');
  let password = document.getElementById('password');
  let password2 = document.getElementById('password2');

  name.value = inputs.name;
  email.value = inputs.email;

  signUpErr.name ? name.classList.add('border-error')  : name.classList.remove('border-error');
  signUpErr.email ? email.classList.add('border-error')  : email.classList.remove('border-error');
  signUpErr.password ? password.classList.add('border-error')  : password.classList.remove('border-error');
  signUpErr.password2 ? password2.classList.add('border-error')  : password2.classList.remove('border-error');
}
else{
  let alert = document.getElementById('success');
  if(alert.value){
    Swal.fire({
      position: "center",
      icon: "success",
      title: alert.value,
      showConfirmButton: false,
      timer: 1500
    });
  }
}