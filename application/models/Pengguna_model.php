<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna_model extends CI_Model {
    private $_table = 'users';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_by_email($email) {
        $this->db->where('email', $email);
        return $this->db->get($this->_table)->row();
    }

    public function get_by_username($username) {
        $this->db->where('username', $username);
        return $this->db->get($this->_table)->row();
    }

    public function get_by_id($id) {
        $this->db->where('id_user', $id);
        return $this->db->get($this->_table)->row();
    }

    public function create($data) {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data): bool {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        $this->db->where('id_user', $id);
        return $this->db->update($this->_table, $data);
    }

    public function login($username_or_email, $password) {
        if (filter_var($username_or_email, FILTER_VALIDATE_EMAIL)) {
            $user = $this->get_by_email($username_or_email);
        } else {
            $user = $this->get_by_username($username_or_email);
        }

        if ($user && !empty($user->password)) {
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        return false;
    }

    public function email_exists($email): bool {
        $this->db->where('email', $email);
        return $this->db->count_all_results($this->_table) > 0;
    }

    public function username_exists($username): bool {
        $this->db->where('username', $username);
        return $this->db->count_all_results($this->_table) > 0;
    }

    public function count_all(): int {
        return $this->db->count_all_results($this->_table);
    }
}
