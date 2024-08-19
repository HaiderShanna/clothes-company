<?php
class Home extends CI_Controller {
  public function __construct(){
    parent::__construct();

    /* Check if the user is signed up as admin */
    if(!$this->session->userdata('admin')){
      $this->session->set_flashdata('login_error', 'You are not logged in');
      redirect('admin/login');
      die();
    }
    $this->load->model('admin_model', 'model');
  }

  public function index(){
    $this->load->view('admin_views/home');
  }

  public function getProducts(){
    $data['data'] = $this->model->getProducts();
    echo json_encode($data);
    die();
  }
}