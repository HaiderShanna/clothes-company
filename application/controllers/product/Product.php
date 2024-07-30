<?php
class Product extends CI_Controller{
  public function __construct(){
    parent::__construct();
    $this->load->model('products_model', 'model');
  }

  /* loads product details view */
  public function index($id){
    $data = ['id' => $id];
    $this->load->view('product_views/product_details', $data);
  }

  public function getProduct($id){
    $product = $this->model->get_product($id);
    echo json_encode($product);
  }
}