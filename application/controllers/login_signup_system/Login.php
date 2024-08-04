<?php
class Login extends CI_Controller{
  public function __construct(){
    parent::__construct();
    $this->load->model('login_model', 'model');
    $this->load->library('session');
  }

  /* check login inputs and error handling */
  public function checkLogin(){

    $email = $this->input->post('email');
    $password = $this->input->post('password');

    // creating rules
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');

    $checkEmail = $this->checkEmail($email);
    $checkPassword = $this->checkPassword($password, $email);
    if ($this->form_validation->run() == FALSE)
    {
      $this->session->set_flashdata('login-errors', $this->form_validation->error_array());
      $this->load->view('home_views/home');
    }
    else if( 
      ($checkEmail !== NULL) || 
      ($checkPassword !== NULL)
      ){
        $this->session->set_flashdata('login-errors', [
          'email'=> $checkEmail, 
          'password' => $checkPassword
        ]);
        $this->load->view('home_views/home');
      }
    else
    {

      $data = [
        'name' => $this->model->getName($email),
        'email' => $email
      ];
      $this->session->set_userdata($data);
      $this->session->set_flashdata('success', 'Logged In Successfully');
      $this->load->view('home_views/home');
    }
  } 

  /* Check Email Rule used as a callback rule in form_validation */
  public function checkEmail($email){
    // not registered
    if(!$this->model->emailExists($email)){
      return 'Email is not registered !';
    }
    // success
    else{
      return NULL;
    }
  }

    /* Check Email Rule used as a callback rule in form_validation */
  public function checkPassword($password, $email){

    // check password
    if (!$this->model->correctPassword($password, $email)){
      return 'Incorrect Password !';
    }
    // success
    else{
      return NULL;
    }
  }

  /* check sign up inputs and error handling */
  public function checkSignUp(){

    $name = $this->input->post('name');
    $email = $this->input->post('email');
    $password = $this->input->post('password');
    $password2 = $this->input->post('password2');

    // creating rules
    $this->form_validation->set_rules('name', 'Name', 'trim|required|alpha_numeric_spaces|max_length[35]|min_length[3]');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
    $this->form_validation->set_rules('password2', 'Confirm Password', 'trim|required|matches[password]');


    if ($this->form_validation->run() == FALSE)
    {
      $this->session->set_flashdata('signup-errors', $this->form_validation->error_array());
      $this->session->set_flashdata('inputs', ['name' => $name, 'email' => $email]);
      $this->load->view('home_views/home');
    }
    else if( 
      ($this->checkEmail($email) === NULL)
      ){
        $this->session->set_flashdata('signup-errors', [
          'email'=> 'Email is already registered !'
        ]);
        $this->session->set_flashdata('inputs', ['name' => $name, 'email' => $email]);
        $this->load->view('home_views/home');
      }
    else
    {
      $data = [
        'name' => $name,
        'email' => $email,
        'password' => $password
      ];
      if($this->model->create_user($data)){
        $this->session->set_userdata(['name' => $name, 'email' => $email]);
        $this->session->set_flashdata('success', 'Signed Up Successfully');
        $this->load->view('home_views/home');
      }
      else{
        $this->session->set_flashdata('failed', 'Something Went Wrong !');
        $this->load->view('home_views/home');
      }

    }
  } 
}