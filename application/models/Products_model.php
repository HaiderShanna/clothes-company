<?php
class Products_model extends CI_Model
{

  /* get clothes  */
  public function get_clothes($category_id, $limit)
  {
    // Get best selling
    if ($category_id == 4) {
      $query = $this->db->query('
      select 
        product.id, 
        product.name, 
        product.price, 
        product.img, 
        product.created_at,
        product.category_id, 
        product.description 
      from order_items

      join variants on order_items.variant_id = variants.id
      join product on product.id = variants.product_id

      where product.status = 1
      group by product_id
      order by count(product.id) desc
      limit ' . $limit . '
      ');
      return $query->result();
    } else {
      $query = $this->db->get_where('product', [
        'category_id' => $category_id,
        'status' => 1
      ], $limit);
      return $query->result();
    }
  }

  /* Get all Clothes */
  public function get_all_clothes($category_id)
  {
    // Get all best selling
    if ($category_id == 4) {
      $query = $this->db->query('
      select 
        product.id, 
        product.name, 
        product.price, 
        product.img, 
        product.created_at,
        product.category_id, 
        product.description 
      from order_items

      join variants on order_items.variant_id = variants.id
      join product on product.id = variants.product_id

      where product.status = 1
      group by product_id
      order by count(product.id) desc
      ');
      return $query->result();
    } else {
      $query = $this->db->get_where('product', [
        'category_id' => $category_id,
        'status' => 1
      ]);
      return $query->result();
    }
  }

  /* Get a specific product and its variants (colors, sizes) using its ID */
  public function get_variants($id)
  {
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
      WHERE product.id = ' . $id . ' and 
            variants.status = 1  
      GROUP BY product.id, variants.color;
    ');

    return $query->result();
  }

  /* Get variants from an array of IDs */
  public function get_variant($variantIds)
  {
    $query = $this->db->where_in('id', $variantIds)
      ->get('variants');

    return $query->result();
  }
  /* Get products from an array of IDs */
  public function get_product_prices($variantIds)
  {
    $query = $this->db->select('product.price')
      ->from('variants')
      ->join('product', 'variants.product_id = product.id')
      ->where_in('variants.id', $variantIds)
      ->where('variants.status', 1)
      ->get();

    return $query->result();
  }

  public function get_variant_id($productId, $color, $size)
  {
    $query = $this->db->select('id')
      ->where('product_id', $productId)
      ->where('color', $color)
      ->where('size', $size)
      ->get('variants');

    return $query->row();
  }

  /* Add a new order */
  public function new_order($data, $user_id)
  {
    $variantIds = [];
    $shipping = 5.00;
    $total = 0 + $shipping;

    foreach ($data as $variant) {
      array_push($variantIds, $variant->id);
    }

    $variants = $this->get_variant($variantIds);
    $product_prices = $this->get_product_prices($variantIds);
    
    foreach ($product_prices as $i => $product) {
      $total += $product->price * $data[$i]->quantity;
    }

    $order = [
      'customer_id' => $user_id,
      'total_price' => $total
    ];

    // Insert a new order
    $query1 = $this->db->insert('orders', $order);
    $insert_id = $this->db->insert_id();

    $items = [];
    foreach ($variants as $i => $variant) {
      array_push($items, [
        'order_id' => $insert_id,
        'variant_id' => $variant->id,
        'quantity' => $data[$i]->quantity,
        'price' => $product_prices[$i]->price
      ]);
    }
    
    // insert order items
    $query2 = $this->db->insert_batch('order_items', $items);

    // decrease purchased items quantities
    $update = [];
    foreach ($variants as $i => $variant) {
      array_push($update, [
        'id' => $data[$i]->id,
        'quantity' => (int)$variant->quantity - (int)$data[$i]->quantity
      ]);
    }

    $query3 = $this->db->update_batch('variants', $update, 'id');

    if($query1 && $query2 && $query3){
      return $total;
    }
  }

  /* Get user orders using his ID */
  public function get_user_orders($user_id){
    $query = $this->db->query("
      select o.id as order_id, 
            o.status as status,
            o.total_price as total,
            p.id as product_id, 
            p.name as name, 
            p.img as img, 
            oi.quantity as quantity, 
            oi.price as price
      FROM order_items as oi
      JOIN orders as o ON oi.order_id = o.id
      JOIN variants as v ON oi.variant_id = v.id
      JOIN product as p ON v.product_id = p.id
      WHERE o.customer_id = $user_id
      ORDER BY o.id DESC   
    ");
    return $query->result();
  }

  /* Search for a specific term and return the data */
  public function search($term){
    $query = $this->db->like('name', $term)
    ->get_where('product', ['status' => 1]);
    return $query->result();
  }
}
