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

  public function getProductVariants($id = ''){
    $variants['data'] = $this->model->getVariants($id);
    echo json_encode($variants);
    die();
  }

  public function editProduct(){
    $data = $this->input->post();
    if(empty($data)){
      echo json_encode(['error' => 'No Product To Edit !']);
      die();
    }
    
    $updated_row = $this->model->editProduct($data);
    if(!empty($updated_row)){
      echo json_encode(['success' => 'success', 'row' => $updated_row]);
      die();
    }
    else{
      echo json_encode(['error' => 'something went wrong !']);
      die();
    }
  }

  public function addProduct(){
    if(empty($_POST)){
      echo json_encode(['error' => 'no data provided']);
      die();
    }

    $name = $this->input->post('name');
    $price = $this->input->post('price');
    $description = $this->input->post('description');
    $categoryId = $this->input->post('categoryId');
    $color = $this->input->post('color');
    $size = $this->input->post('size');
    $quantity = $this->input->post('quantity');

    $productData = [
      'name' => $name,
      'price' => $price,
      'img' => 'http://localhost/clothes_company/assets/imgs/products/1.jpg',
      'category_id' => $categoryId,
      'description' => $description
    ];

    $variantData = [
      'color' => $color,
      'size' => $size,
      'quantity' => $quantity
    ];

    $insertedRow = $this->model->addProduct($productData, $variantData);
    if(!empty($insertedRow)){
      echo json_encode($insertedRow);
      die();
    }
    else{
      echo json_encode([
        'error' => 'something went wrong !'
      ]);
      die();
    }
  }

  public function deleteProduct(){
    $productId = $this->input->raw_input_stream;

    if($this->model->deleteProduct($productId)){
      echo json_encode(['success' => 'success']);
      die();
    }
    else{
      echo json_encode(['error' => 'something went wrong']);
      die();
    }
  }
}