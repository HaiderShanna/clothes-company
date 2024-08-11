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

  public function getVariants($id){
    $product = $this->model->get_variants($id);
    echo json_encode($product);
  }

  public function getVariantId($productId = '', $color = '', $size = ''){
    if(empty($productId) || empty($color) || empty($size)){
      $error = ['error' => 'invalid data'];
      echo json_encode($error);
    }
    else{
      $product = $this->model->get_variant_id($productId, $color, $size);
      echo json_encode($product);
    }
  }
}