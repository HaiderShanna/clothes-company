<?php

/* Home Controller : controls Anything related to the Home Page */
class Home extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this->load->model('products_model', 'model');
  }

  /* Loads the home page */
  public function index(){
    $this->load->view('home_views/home');
  }

  /*
  Get clothes from a specific category and limit
  */
  public function getClothes($category = '', $limit = 8){

    // Check limit value
    if($limit < 1){
      echo json_encode(['error' => 'invalid limit value !']);
      die();
    }

    // check category and set category id
    switch ($category) {
      case 'men':
        $category_id = 1;
        break;
      case 'women':
        $category_id = 2;
        break;
      case 'children':
        $category_id = 3;
        break;
      case 'best-selling':
        $category_id = '';
        break;
      /*
        If the user entered invalid category in the url or didn't even entered a category name 
      */
      default:
        echo json_encode(['error' => 'invalid category !']);
        die();
        break;
    }

    // get data from the database
    $data = $this->model->get_clothes($category_id, $limit);
    echo json_encode($data);
  }

  /* Loads the About page */
  public function about(){
    $this->load->view('about_views/about_page');
  }

  /* Get all clothes from a specific category */
  public function getAllClothes($category = 1) {

    // check category and set category id
    switch ($category) {
      case 'men':
        $category_id = 1;
        break;
      case 'women':
        $category_id = 2;
        break;
      case 'children':
        $category_id = 3;
        break;
      case 'best-selling':
        $category_id = '';
        break;
      /*
        If the user entered invalid category in the url or didn't even entered a category name 
      */
      default:
        echo json_encode(['error' => 'invalid category !']);
        die();
        break;
    }

    // get data from the database
    $data = $this->model->get_all_clothes($category_id);
    echo json_encode($data);
  }
  
}