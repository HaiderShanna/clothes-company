<?php
class Login extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this->load->model('admin_model', 'model');
  }

  public function index(){
    $this->load->view('admin_views/login');
  }

  /* Check the login data */
  public function checkLogin(){
    
    // getting the data
    $email = $this->input->post('email');
    $password = $this->input->post('password');
    
    // setting the rules
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');

    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

    if($this->form_validation->run() === FALSE){
      $this->load->view('admin_views/login');
    }
    else{
      if(!$this->correctEmail($email)){
        $this->session->set_flashdata('login_error', 'Email is not registered !');
        $this->load->view('admin_views/login');
      }
      else if(!$this->correctPassword($password, $email)){
        $this->session->set_flashdata('login_error', 'Incorrect Password !');
        $this->load->view('admin_views/login');
      }
      else{
        $user_id = $this->model->getUser($email)->id;
        $this->session->set_userdata([
          'id' => $user_id,
          'email' => $email,
          'admin' => TRUE
        ]);
        redirect('admin/home');
      }
    }
  }

  /* Check if the email is registered */
  public function correctEmail($email){
    if($this->model->getUser($email)){
      return true;
    }
    else{
      return false;
    }
  }

  /* Check if the password is correct */
  public function correctPassword($password, $email){
    $password2 = $this->model->getUser($email)->password;

    if($password === $password2){
      return true;
    }
    else{
      return false;
    }
  }

  /* Log out */
  public function logout(){
    $this->session->sess_destroy();
    redirect('admin');
  }


}