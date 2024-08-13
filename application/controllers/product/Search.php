<?php
class Search extends CI_Controller{
  public function __construct(){
    parent::__construct();
    $this->load->model('products_model', 'model');
  }

  public function index(){
    $term = $this->input->raw_input_stream;
    $term = json_decode($term)->term;

    if(empty($term)){
      echo json_encode(['error' => 'No results Found !']);
      die();
    }

    $term = html_escape($term);

    $data = $this->model->search($term);
  if(empty($data)){
    echo json_encode(['error' => 'No results Found !']);
    die();
  }
    echo json_encode($data);
    die();
  }
     
}