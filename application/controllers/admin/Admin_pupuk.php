<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_pupuk extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->model('Jenis_pupuk_model');
        $this->load->library('form_validation');
        $this->load->library('upload');
    }

    public function index()
    {
        $data['page_title'] = 'Jenis Pupuk';
        $data['page_css'] = 'pupuk.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Jenis Pupuk', 'url' => site_url('admin/pupuk')]
        ];

        $data['pupuk'] = $this->Jenis_pupuk_model->get_all();
        $data['can_edit'] = $this->can_edit();
        $data['can_delete'] = $this->can_delete();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/pupuk/index', $data);
        $this->load->view('admin/templates/footer');
    }

    public function tambah_pupuk()
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/pupuk');
        }

        $data['page_title'] = 'Tambah Jenis Pupuk';
        $data['page_css'] = 'pupuk.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Jenis Pupuk', 'url' => site_url('admin/pupuk')],
            ['label' => 'Tambah', 'url' => site_url('admin/pupuk/tambah_pupuk')]
        ];

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('nama_pupuk', 'Nama Pupuk', 'required');
            $this->form_validation->set_rules('kandungan', 'Kandungan', 'required');
            $this->form_validation->set_rules('fungsi', 'Fungsi', 'required');

            if ($this->form_validation->run() == TRUE) {
                $data_insert = [
                    'nama_pupuk' => $this->input->post('nama_pupuk'),
                    'kandungan' => $this->input->post('kandungan'),
                    'fungsi' => $this->input->post('fungsi'),
                    'waktu_aplikasi' => $this->input->post('waktu_aplikasi'),
                    'catatan_khusus' => $this->input->post('catatan_khusus')
                ];


                if (isset($_FILES['gambar_pupuk']) && !empty($_FILES['gambar_pupuk']['name']) && $_FILES['gambar_pupuk']['error'] === UPLOAD_ERR_OK) {
                    $upload_result = $this->upload_gambar('gambar_pupuk', 'pupuk');
                    if ($upload_result['success']) {
                        $data_insert['gambar_pupuk'] = $upload_result['file_name'];
                    } else {
                        $data['error'] = $upload_result['error'];
                    }
                }

                if (!isset($data['error'])) {
                    if ($this->Jenis_pupuk_model->create($data_insert)) {
                        $this->session->set_flashdata('success', 'Jenis pupuk berhasil ditambahkan');
                        redirect('admin/pupuk');
                    } else {
                        $data['error'] = 'Gagal menambahkan jenis pupuk';
                    }
                }
            }
        }

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/pupuk/Tambah_pupuk', $data);
        $this->load->view('admin/templates/footer');
    }

    public function ubah_pupuk($id)
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/pupuk');
        }

        $pupuk = $this->Jenis_pupuk_model->get_by_id($id);
        if (!$pupuk) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('admin/pupuk');
        }

        $data['page_title'] = 'Edit Jenis Pupuk';
        $data['page_css'] = 'pupuk.css';
        $data['pupuk'] = $pupuk;
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Jenis Pupuk', 'url' => site_url('admin/pupuk')],
            ['label' => 'Edit', 'url' => site_url('admin/pupuk/ubah_pupuk/' . $id)]
        ];

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('nama_pupuk', 'Nama Pupuk', 'required');
            $this->form_validation->set_rules('kandungan', 'Kandungan', 'required');
            $this->form_validation->set_rules('fungsi', 'Fungsi', 'required');

            if ($this->form_validation->run() == TRUE) {
                $data_update = [
                    'nama_pupuk' => $this->input->post('nama_pupuk'),
                    'kandungan' => $this->input->post('kandungan'),
                    'fungsi' => $this->input->post('fungsi'),
                    'waktu_aplikasi' => $this->input->post('waktu_aplikasi') ?: null,
                    'catatan_khusus' => $this->input->post('catatan_khusus') ?: null
                ];

                $has_file = isset($_FILES['gambar_pupuk'])
                    && !empty($_FILES['gambar_pupuk']['name'])
                    && $_FILES['gambar_pupuk']['error'] === UPLOAD_ERR_OK
                    && is_uploaded_file($_FILES['gambar_pupuk']['tmp_name']);

                if ($has_file) {
                    $upload_result = $this->upload_gambar('gambar_pupuk', 'pupuk');
                    if ($upload_result['success']) {
                        if (!empty($pupuk->gambar_pupuk)) {
                            $old_gambar = trim($pupuk->gambar_pupuk);
                            if (strpos($old_gambar, 'assets/img/pupuk/') !== false) {
                                $old_gambar = basename($old_gambar);
                            }
                            $old_file = FCPATH . 'assets/img/pupuk/' . $old_gambar;
                            if (file_exists($old_file)) {
                                unlink($old_file);
                            }
                        }
                        $data_update['gambar_pupuk'] = $upload_result['file_name'];
                    } else {
                        $data['error'] = $upload_result['error'];
                    }
                }

                if (!isset($data['error'])) {
                    if ($this->Jenis_pupuk_model->update($id, $data_update)) {
                        $this->session->set_flashdata('success', 'Jenis pupuk berhasil diupdate');
                        redirect('admin/pupuk');
                    } else {
                        $data['error'] = 'Gagal mengupdate jenis pupuk';
                    }
                }
            } else {
                $data['validation_errors'] = validation_errors();
            }
        }

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/pupuk/ubah_pupuk', $data);
        $this->load->view('admin/templates/footer');
    }

    public function hapus_pupuk($id)
    {
        if (!$this->can_delete()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/pupuk');
        }

        $pupuk = $this->Jenis_pupuk_model->get_by_id($id);
        if ($pupuk && !empty($pupuk->gambar_pupuk)) {
            $file_path = FCPATH . 'assets/img/pupuk/' . $pupuk->gambar_pupuk;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        if ($this->Jenis_pupuk_model->delete($id)) {
            $this->session->set_flashdata('success', 'Jenis pupuk berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus jenis pupuk');
        }

        redirect('admin/pupuk');
    }

    private function upload_gambar($field_name, $folder): array
    {
        if (!isset($_FILES[$field_name])) {
            return ['success' => false, 'error' => 'Field file tidak ditemukan'];
        }

        $file = $_FILES[$field_name];

        if (empty($file['name']) || $file['error'] !== UPLOAD_ERR_OK) {
            if ($file['error'] === UPLOAD_ERR_NO_FILE) {
                return ['success' => false, 'error' => 'Tidak ada file yang diupload'];
            }
            return ['success' => false, 'error' => 'Error saat upload file: ' . $file['error']];
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            return ['success' => false, 'error' => 'File tidak valid atau tidak diupload dengan benar'];
        }

        $upload_path = FCPATH . 'assets/img/' . $folder . '/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array($file_ext, $allowed_extensions)) {
            return ['success' => false, 'error' => 'Format file tidak didukung. Format yang diizinkan: JPG, JPEG, PNG, GIF, WEBP'];
        }


        $image_info = @getimagesize($file['tmp_name']);
        if ($image_info === FALSE) {
            return ['success' => false, 'error' => 'File yang diupload bukan gambar valid. Pastikan file adalah gambar dengan format JPG, JPEG, PNG, GIF, atau WEBP.'];
        }

        $max_size = 2048 * 1024;
        if ($file['size'] > $max_size) {
            return ['success' => false, 'error' => 'Ukuran file terlalu besar. Maksimal 2MB.'];
        }
        $new_filename = uniqid() . '_' . time() . '.' . $file_ext;
        $destination = $upload_path . $new_filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return ['success' => true, 'file_name' => $new_filename];
        } else {
            return ['success' => false, 'error' => 'Gagal mengupload file. Pastikan folder upload memiliki permission yang benar.'];
        }
    }
}
