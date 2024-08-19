const errorDiv = document.querySelector('div.error');
const loginErr = document.querySelector('.login-err').value;

if(loginErr !== ''){
  errorDiv.classList.add('active');
  errorDiv.innerHTML = loginErr;
}