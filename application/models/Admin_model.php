<?php
class Admin_model extends CI_Model
{

  /* get Admin Details using his email */
  public function getUser($email)
  {
    $query = $this->db->get_where('admin', ['email' => $email]);
    return $query->row();
  }

  /* Get the products to the admin to print it to the data table */
  public function getProducts()
  {
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
      ->where('status', 1)
      ->get();
    return $query->result();
  }

  /* Get a product's variants using its ID */
  public function getVariants($id)
  {
    $query = $this->db->get_where('variants', ['product_id' => $id, 'status' => 1]);
    return $query->result();
  }

  /* Edit Product */
  public function editProduct($data)
  {
    $data2 = [
      'name' => $data['name'],
      'price' => $data['price'],
      'description' => $data['description'],
      'category_id' => $data['categoryId']
    ];
    $query = $this->db->set($data2)
      ->where('id', $data['id'])
      ->update('product');

    if ($query) {
      $query2 = $this->db->select([
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
        ->where('product.id', $data['id'])
        ->get_where();
      return $query2->row();
    } else {
      return $query;
    }
  }

  /* Add a new product and its default variant to the database */
  public function addProduct($productData, $variantData)
  {
    // insert the product
    $this->db->insert('product', $productData);

    // get the inserted id
    $productId = $this->db->insert_id();
    $variantData['product_id'] = $productId;

    // insert the variant
    $this->db->insert('variants', $variantData);

    $query = $this->db->get_where('product', ['id' => $productId]);

    // return the inserted row
    return $query->row();
  }

  /* change the status of the product to (0) which means deleted */
  public function deleteProduct($productId)
  {
    $this->db->where('id', $productId);
    if ($this->db->update('product', ['status' => 0])) {
      $this->db->where('product_id', $productId);
      return $this->db->update('variants', ['status' => 0]);
    } else {
      return FALSE;
    }
  }
}
