<?php
class Admin_model extends CI_Model {

  /* get Admin Details using his email */
  public function getUser($email){
    $query = $this->db->get_where('admin', ['email' => $email]);
    return $query->row();
  }

  /* Get the products to the admin to print it to the data table */
  public function getProducts(){
    $query = $this->db->select([
      'product.id as id',
      'product.img as img',
      'product.name as name',
      'product.price as price',
      'category.name as category',
      'product.description as description',
      'product.created_at as created_at',
    ])
    ->from('product')
    ->join('category', 'category.id = product.category_id')
    ->get();
    return $query->result();
  }
}