<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna_model extends CI_Model
{
    private $_table = 'users';

    public function get_by_email($email)
    {
        $this->db->where('email', $email);
        return $this->db->get($this->_table)->row_array();
    }

    public function get_by_username($username)
    {
        $this->db->where('username', $username);
        return $this->db->get($this->_table)->row_array();
    }

    public function get_by_id($id)
    {
        $this->db->where('id_user', $id);
        return $this->db->get($this->_table)->row_array();
    }

    public function create($data)
    {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        $this->db->insert($this->_table, $data);
        if ($this->db->affected_rows() != 1) {
            return false;
        }
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        $this->db->where('id_user', $id);
        $this->db->update($this->_table, $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function login($username_atau_email, $kata_sandi)
    {
        if (filter_var($username_atau_email, FILTER_VALIDATE_EMAIL)) {
            $pengguna = $this->get_by_email($username_atau_email);
        } else {
            $pengguna = $this->get_by_username($username_atau_email);
        }

        if ($pengguna && !empty($pengguna['password'])) {
            if (password_verify($kata_sandi, $pengguna['password'])) {
                return $pengguna;
            }
        }
        return false;
    }

    public function email_ada($email)
    {
        $this->db->where('email', $email);
        return $this->db->count_all_results($this->_table) > 0;
    }

    public function username_ada($username)
    {
        $this->db->where('username', $username);
        return $this->db->count_all_results($this->_table) > 0;
    }

    public function count_all()
    {
        return $this->db->count_all_results($this->_table);
    }
}
