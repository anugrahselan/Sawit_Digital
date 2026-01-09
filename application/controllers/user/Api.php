<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Harga_tbs_model');
        $this->load->model('Informasi_tambahan_model');
        $this->load->model('Jenis_pupuk_model');
        $this->load->model('Penyakit_model');
    }

    public function tbs_prices(): void {
        $id_kabupaten = $this->input->get('id_kabupaten');

        if ($id_kabupaten) {
            $tbs_prices = $this->Harga_tbs_model->get_by_kabupaten($id_kabupaten);
        } else {
            $tbs_prices = $this->Harga_tbs_model->get_today_prices();

            if (empty($tbs_prices)) {
                $tbs_prices = $this->Harga_tbs_model->get_latest_per_company();
            }
        }

        foreach ($tbs_prices as $price) {
            $previous = $this->Harga_tbs_model->get_previous_price(
                $price->id_kabupaten,
                $price->id_perusahaan,
                $price->tanggal
            );

            if ($previous) {
                $change = $price->harga_per_kg - $previous->harga_per_kg;
                $price->perubahan = $change;
                $price->status_perubahan = $change > 0 ? 'naik' : ($change < 0 ? 'turun' : 'tidak_ada');
                $price->harga_kemarin = $previous->harga_per_kg;
            } else {
                $price->perubahan = null;
                $price->status_perubahan = 'tidak_ada';
                $price->harga_kemarin = null;
            }
        }

        $data['tbs_prices'] = $tbs_prices;
        $this->load->view('user/partials/tabel_tbs', $data);
    }

    public function search(): void {
        $keyword = $this->input->get('q');
        if (empty($keyword)) {
            echo json_encode(['error' => 'Keyword required']);
            return;
        }

        header('Content-Type: application/json');

        echo json_encode([
            'articles' => $this->Informasi_tambahan_model->search($keyword),
            'fertilizers' => $this->Jenis_pupuk_model->search($keyword),
            'penyakit' => $this->Penyakit_model->search($keyword)
        ]);
    }

    public function get_dosis(): void {
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
