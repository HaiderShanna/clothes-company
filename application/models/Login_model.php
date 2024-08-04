<?php
class Login_model extends CI_Model{

  /* Check if a specific Email is registered or not in the users table */
  public function emailExists($email){
    $query = $this->db->get_where('user', ['email'=>$email]);
    return $query->row()? TRUE: FALSE;
  }

    /* Checks if the password is correct or not */
  public function correctPassword($password, $email){
    $query = $this->db
          ->select('password')
          ->where('email', $email)
          ->get('user');
    if(empty($query->row())){
      return FALSE;
    }else{
      if(password_verify($password, $query->row()->password)){
        return TRUE;
      }
      else{
        return FALSE;
      }
    }
  }

  /* Create a new user */
  public function create_user($data){
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

    return $query = $this->db->insert('user', $data);
  }

  /* Get the name of the user using his email */
  public function getName($email){
    $query = $this->db->get_where('user', ['email' => $email]);
    return $query->row()->name;
  }
}