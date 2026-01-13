<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Harga_tbs_model');
        $this->load->model('Informasi_tambahan_model');
        $this->load->model('Jenis_pupuk_model');
        $this->load->model('Penyakit_model');
    }

    public function harga_tbs()
    {
        $id_kabupaten = $this->input->get('id_kabupaten');

        if ($id_kabupaten) {
            $daftar_harga_tbs = $this->Harga_tbs_model->get_by_kabupaten($id_kabupaten);
        } else {
            $daftar_harga_tbs = $this->Harga_tbs_model->get_harga_hari_ini();

            if (empty($daftar_harga_tbs)) {
                $daftar_harga_tbs = $this->Harga_tbs_model->get_terbaru_per_perusahaan();
            }
        }

        foreach ($daftar_harga_tbs as $harga) {
            $harga_sebelumnya = $this->Harga_tbs_model->get_harga_sebelumnya(
                $harga->id_kabupaten,
                $harga->id_perusahaan,
                $harga->tanggal
            );

            if ($harga_sebelumnya) {
                $selisih = $harga->harga_per_kg - $harga_sebelumnya->harga_per_kg;
                $harga->perubahan = $selisih;
                $harga->status_perubahan = $selisih > 0 ? 'naik' : ($selisih < 0 ? 'turun' : 'tidak_ada');
                $harga->harga_kemarin = $harga_sebelumnya->harga_per_kg;
            } else {
                $harga->perubahan = null;
                $harga->status_perubahan = 'tidak_ada';
                $harga->harga_kemarin = null;
            }
        }

        $data['tbs_prices'] = $daftar_harga_tbs;
        $this->load->view('user/partials/tabel_tbs', $data);
    }

    public function cari()
    {
        $kata_kunci = $this->input->get('q');
        if (empty($kata_kunci)) {
            echo json_encode(['error' => 'Kata kunci wajib diisi']);
            return;
        }

        header('Content-Type: application/json');

        echo json_encode([
            'informasi' => $this->Informasi_tambahan_model->cari($kata_kunci),
            'pupuk' => $this->Jenis_pupuk_model->cari($kata_kunci),
            'penyakit' => $this->Penyakit_model->cari($kata_kunci)
        ]);
    }

    public function get_dosis()
    {
        $id_pupuk = $this->input->get('id_pupuk');
        $id_tanah = $this->input->get('id_tanah');
        $usia_tanaman = $this->input->get('usia_tanaman');

        header('Content-Type: application/json');
        if (!$id_pupuk || !$id_tanah || !$usia_tanaman) {
            echo json_encode(['success' => false, 'message' => 'Parameter tidak lengkap']);
            return;
        }

        $dosis = $this->Jenis_pupuk_model->get_dosis($id_pupuk, $id_tanah, $usia_tanaman);
        echo json_encode(!empty($dosis)
            ? ['success' => true, 'data' => $dosis]
            : ['success' => false, 'message' => 'Data dosis tidak ditemukan']);
    }
}
