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
  public function get_variants($id){
    $query = $this->db->query('
      SELECT 
        product.id, 
        name, 
        price, 
        img, 
        description,  
        variants.color, 
        GROUP_CONCAT(variants.size) as sizes, 
        GROUP_CONCAT(variants.quantity) as quantity
      FROM `product`
      JOIN variants ON product.id = variants.product_id
      WHERE product.id = ' . $id . '
      GROUP BY product.id, variants.color;
    ');

    return $query->result();
  }
}