<?php
class Cart extends CI_Controller{
  public function index(){
    $this->load->view('cart_views/cart');
  }

  /* new order check */
  public function newOrder(){
    $this->load->model('products_model', 'model');


    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      echo json_encode([ 'status' => 'error', 'error' => 'something went wrong !']);
      die();
    }
    if(!isset($_SESSION['logged_in'])){
      echo json_encode([ 'status' => 'error', 'error' => 'You are not Logged in !']);
      die();
    }

    $data = $this->input->raw_input_stream;
    $data = json_decode($data);

    if(empty($data)){
      echo json_encode([ 'status' => 'error', 'error' => 'Cart is Empty !']);
      die();
    }
    
    $variantIds = [];
    foreach ($data as $product) {
      if(is_int($product->id) && is_int($product->quantity)){
        array_push($variantIds, $product->id);
      }
      else{
        echo json_encode([ 'status' => 'error', 'error' => 'Invalid Data !']);
        die();
      }
    }
    
    $variants = $this->model->get_variant($variantIds); 
    if(empty($variants)){
      echo json_encode([ 'status' => 'error', 'error' => 'Not Available !']);
      die();
    }
    else if(count($variants) !== count($variantIds)){
      echo json_encode([ 'status' => 'error', 'error' => 'Not available !']);
      die();
    }
    else{

      /* Sorting the products by id to match it with the products from the database */
      usort($data, function($a, $b){
        return $a->id <=> $b->id;
      });

      /* check the quantity if it's available or not */
      foreach ($variants as $i => $variant) {
        if((int)$variant->quantity < $data[$i]->quantity){
          echo json_encode([ 'status' => 'error', 'error' => 'No Available Quantity !']);
          die();
        }
      }

      /* Success */
      $user_id = $this->session->userdata('user_id');
      $new_order = $this->model->new_order($data, $user_id);
      if(!empty($new_order)){
        echo json_encode(['status' => 'success', 'total' => $new_order]);        
      }
      else{
        echo json_encode(['status' => 'error', 'error' => 'something went wrong']);
      }

    }
  }
}