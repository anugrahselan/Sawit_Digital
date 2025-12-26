<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_by_email($email)
    {
        $this->db->where('email', $email);
        return $this->db->get('users')->row();
    }

    public function get_by_username($username)
    {
        $this->db->where('username', $username);
        return $this->db->get('users')->row();
    }

    public function get_by_id($id)
    {
        $this->db->where('id_user', $id);
        return $this->db->get('users')->row();
    }

    public function create($data)
    {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        $this->db->where('id_user', $id);
        return $this->db->update('users', $data);
    }

    public function verify($email, $password)
    {
        $user = $this->get_by_email($email);
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }

    public function email_exists($email)
    {
        $this->db->where('email', $email);
        return $this->db->count_all_results('users') > 0;
    }

    public function username_exists($username)
    {
        $this->db->where('username', $username);
        return $this->db->count_all_results('users') > 0;
    }

    public function count_all()
    {
        return $this->db->count_all_results('users');
    }
}

