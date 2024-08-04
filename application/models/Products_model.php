<?php
class Products_model extends CI_Model{

  /* get clothes  */
  public function get_clothes($category_id, $limit){
    // temporary for best selling
    if(empty($category_id)){
      $query = $this->db->get('product', $limit);
      return $query->result();
    }
    else{
      $query = $this->db->get_where('product', ['category_id' => $category_id], $limit);
      return $query->result();
    }
  }

  /* Get all Clothes */
  public function get_all_clothes($category_id){
    // temporary for best selling
    if(empty($category_id)){
      $query = $this->db->get('product');
      return $query->result();
    }
    else{
      $query = $this->db->get_where('product', ['category_id' => $category_id]);
      return $query->result();
    }
  }

  /* Get a specific product and its variants (colors, sizes) using its ID */
  public function get_product($id){
    $query = $this->db->select(['product.id', 'name', 'price', 'img', 'description', 'size', 'color', 'quantity'])
    ->join('variants', 'product.id = variants.product_id')
    ->where('product.id', $id)
    ->where('quantity !=', 0)
    ->get('product');

    return $query->result();
  }

}