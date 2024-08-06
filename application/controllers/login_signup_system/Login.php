<?php
class Login extends CI_Controller{
  public function __construct(){
    parent::__construct();
    $this->load->model('login_model', 'model');
  }

  /* check login inputs and error handling */
  public function checkLogin(){

    $email = $this->input->post('login-email');
    $password = $this->input->post('login-password');
    $viewPath = $this->input->post('file_path');
    $params = $this->input->post('param');
    $id = ['id' => $params];
    // creating rules
    $this->form_validation->set_rules('login-email', 'Email', 'trim|required|valid_email|callback_checkLoginEmail');
    $this->form_validation->set_rules('login-password', 'Password', 'trim|required|callback_checkPassword');

    if ($this->form_validation->run() == FALSE)
    {
      $this->session->set_flashdata('inputs', ['email' => $email]);
      $this->session->set_flashdata('error_type', 'login');
      $this->load->view($viewPath, $id);
    }
    else
    {

      $data = [
        'name' => $this->model->getName($email),
        'email' => $email,
        'logged_in' => true
      ];
      $this->session->sess_regenerate(TRUE);
      $this->session->set_userdata($data);
      $this->session->set_flashdata('success', 'Logged In Successfully');
      $this->load->view($viewPath, $id);
    }
  } 

  /* Check Email Rule used as a callback rule in form_validation */
  public function checkLoginEmail($email){
    // not registered
    $email = trim($email);
    if(!$this->model->emailExists($email) && !empty($email)){
      $this->form_validation->set_message('checkLoginEmail', 'The {field} is not registered !');
      return FALSE;
    }
    // success
    else{
      return TRUE;
    }
  }

  /* Check password Rule used as a callback rule in form_validation */
  public function checkPassword($password){
    $email = trim($this->input->post('login-email'));

    if(empty($email) || empty($password)){
      return TRUE;
    }
    if (!$this->model->correctPassword($password, $email)){
      $this->form_validation->set_message('checkPassword', 'Incorrect {field}');
      return FALSE;
    }
    else{
      return TRUE;
    }
  }

  /* check sign up inputs and error handling */
  public function checkSignUp(){

    $name = $this->input->post('name');
    $email = $this->input->post('email');
    $password = $this->input->post('password');
    $password2 = $this->input->post('password2');
    $viewPath = $this->input->post('file_path');
    $params = $this->input->post('param');
    $id = ['id' => $params];

    // creating rules
    $this->form_validation->set_rules('name', 'Name', 'trim|required|alpha_numeric_spaces|max_length[35]|min_length[3]');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_checkEmail');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
    $this->form_validation->set_rules('password2', 'Confirm Password', 'trim|required|matches[password]');


    if ($this->form_validation->run() == FALSE)
    {
      $this->session->set_flashdata('inputs', ['name' => $name, 'email' => $email]);
      $this->session->set_flashdata('error_type', 'signup');
      $this->load->view($viewPath, $id);
    }
    else
    {
      $data = [
        'name' => $name,
        'email' => $email,
        'password' => $password
      ];
      if($this->model->create_user($data)){
        $this->session->sess_regenerate(TRUE);
        $this->session->set_userdata(['name' => $name, 'email' => $email, 'logged_in' => true]);
        $this->session->set_flashdata('success', 'Signed Up Successfully');
        $this->load->view($viewPath, $id);
      }
      else{
        $this->session->set_flashdata('failed', 'Something Went Wrong !');
        $this->load->view($viewPath, $id);
      }

    }
  } 

   /* Check Email Rule used as a callback rule in form_validation */
   public function checkEmail($email){
    // not registered
    if($this->model->emailExists($email)){
      $this->form_validation->set_message('checkEmail', 'The {field} is already registered !');
      return FALSE;
    }
    // success
    else{
      return TRUE;
    }
  }

  /* destroy session and unset all its data */
  public function logOut(){
    $this->session->sess_destroy();
    $this->input->set_cookie('ci_session', '', time() - 3600);
    redirect('/');
  }
}