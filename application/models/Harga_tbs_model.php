<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Harga_tbs_model extends CI_Model
{
    private $_table = 'harga_tbs';

    public function get_all($batas = null, $mulai_dari = null)
    {
        if ($batas !== null && $mulai_dari !== null) {
            $this->db->limit($batas, $mulai_dari);
        }
        $this->db->order_by('tanggal', 'DESC');
        $this->db->select('harga_tbs.*, kabupaten.nama_kabupaten');
        $this->db->join('kabupaten', 'kabupaten.id_kabupaten = harga_tbs.id_kabupaten', 'left');
        $query = $this->db->get($this->_table);
        return $query->result_array();
    }

    public function get_by_kabupaten($id_kabupaten)
    {
        $this->db->where('harga_tbs.id_kabupaten', $id_kabupaten);
        $this->db->order_by('tanggal', 'DESC');
        $this->db->select('harga_tbs.*, kabupaten.nama_kabupaten, perusahaan.nama_perusahaan');
        $this->db->join('kabupaten', 'kabupaten.id_kabupaten = harga_tbs.id_kabupaten', 'left');
        $this->db->join('perusahaan', 'perusahaan.id_perusahaan = harga_tbs.id_perusahaan', 'left');
        return $this->db->get($this->_table)->result();
    }

    public function get_terbaru($batas = 10)
    {
        $this->db->order_by('harga_tbs.tanggal', 'DESC');
        $this->db->order_by('harga_tbs.id_kabupaten', 'ASC');
        $this->db->order_by('harga_tbs.id_perusahaan', 'ASC');
        $this->db->limit($batas);
        $this->db->select('harga_tbs.*, kabupaten.nama_kabupaten, perusahaan.nama_perusahaan');
        $this->db->join('kabupaten', 'kabupaten.id_kabupaten = harga_tbs.id_kabupaten', 'left');
        $this->db->join('perusahaan', 'perusahaan.id_perusahaan = harga_tbs.id_perusahaan', 'left');
        return $this->db->get($this->_table)->result();
    }

    public function get_harga_sebelumnya($id_kabupaten, $id_perusahaan, $tanggal_sekarang)
    {
        $tanggal_sekarang = date('Y-m-d', strtotime($tanggal_sekarang));
        $kemarin = date('Y-m-d', strtotime($tanggal_sekarang . ' -1 day'));

        $sql = "SELECT * FROM " . $this->_table . " 
                WHERE id_kabupaten = ? 
                AND id_perusahaan = ? 
                AND DATE(tanggal) = ? 
                ORDER BY tanggal DESC 
                LIMIT 1";

        $query = $this->db->query($sql, array($id_kabupaten, $id_perusahaan, $kemarin));
        $hasil = $query->row();

        if (!$hasil) {
            $sql2 = "SELECT * FROM " . $this->_table . " 
                     WHERE id_kabupaten = ? 
                     AND id_perusahaan = ? 
                     AND tanggal = ? 
                     ORDER BY tanggal DESC 
                     LIMIT 1";
            $query2 = $this->db->query($sql2, array($id_kabupaten, $id_perusahaan, $kemarin));
            $hasil = $query2->row();
        }

        if (!$hasil && $this->db->table_exists('harga_tbs_backup')) {
            $hasil_backup = $this->get_dari_backup($id_kabupaten, $id_perusahaan, $kemarin);
            if ($hasil_backup) {
                $hasil = (object) [
                    'id_harga' => $hasil_backup->id_harga_original,
                    'id_kabupaten' => $hasil_backup->id_kabupaten,
                    'id_perusahaan' => $hasil_backup->id_perusahaan,
                    'tanggal' => $hasil_backup->tanggal,
                    'harga_per_kg' => $hasil_backup->harga_per_kg
                ];
            }
        }

        if (!$hasil) {
            $sql3 = "SELECT * FROM " . $this->_table . " 
                     WHERE id_kabupaten = ? 
                     AND id_perusahaan = ? 
                     AND DATE(tanggal) < ? 
                     ORDER BY tanggal DESC 
                     LIMIT 1";
            $query3 = $this->db->query($sql3, array($id_kabupaten, $id_perusahaan, $tanggal_sekarang));
            $hasil = $query3->row();

            if (!$hasil) {
                $sql4 = "SELECT * FROM " . $this->_table . " 
                         WHERE id_kabupaten = ? 
                         AND id_perusahaan = ? 
                         AND tanggal < ? 
                         ORDER BY tanggal DESC 
                         LIMIT 1";
                $query4 = $this->db->query($sql4, array($id_kabupaten, $id_perusahaan, $tanggal_sekarang));
                $hasil = $query4->row();
            }
        }

        if (!$hasil && $this->db->table_exists('harga_tbs_backup')) {
            $hasil_backup = $this->get_terakhir_dari_backup($id_kabupaten, $id_perusahaan, $tanggal_sekarang);
            if ($hasil_backup) {
                $hasil = (object) [
                    'id_harga' => $hasil_backup->id_harga_original,
                    'id_kabupaten' => $hasil_backup->id_kabupaten,
                    'id_perusahaan' => $hasil_backup->id_perusahaan,
                    'tanggal' => $hasil_backup->tanggal,
                    'harga_per_kg' => $hasil_backup->harga_per_kg
                ];
            }
        }

        return $hasil;
    }

    public function get_harga_berbeda_terakhir($id_kabupaten, $id_perusahaan, $tanggal_sekarang)
    {
        $tanggal_sekarang = date('Y-m-d', strtotime($tanggal_sekarang));

        $sql = "SELECT * FROM " . $this->_table . " 
                WHERE id_kabupaten = ? 
                AND id_perusahaan = ? 
                AND DATE(tanggal) != ? 
                ORDER BY tanggal DESC 
                LIMIT 1";

        $query = $this->db->query($sql, array($id_kabupaten, $id_perusahaan, $tanggal_sekarang));
        return $query->row();
    }

    public function get_terbaru_per_perusahaan()
    {
        $this->db->select('harga_tbs.*, kabupaten.nama_kabupaten, perusahaan.nama_perusahaan');
        $this->db->from($this->_table);
        $this->db->join('kabupaten', 'kabupaten.id_kabupaten = harga_tbs.id_kabupaten', 'left');
        $this->db->join('perusahaan', 'perusahaan.id_perusahaan = harga_tbs.id_perusahaan', 'left');
        $this->db->order_by('harga_tbs.tanggal', 'DESC');
        $this->db->order_by('harga_tbs.id_perusahaan', 'ASC');
        $semua_harga = $this->db->get()->result();

        $harga_terbaru = [];
        $sudah_lihat = [];

        foreach ($semua_harga as $harga) {
            $kunci = $harga->id_kabupaten . '_' . $harga->id_perusahaan;
            if (!isset($sudah_lihat[$kunci])) {
                $sudah_lihat[$kunci] = true;
                $harga_terbaru[] = $harga;
            }
        }

        return $harga_terbaru;
    }

    public function get_harga_hari_ini()
    {
        $hari_ini = date('Y-m-d');
        $this->db->select('harga_tbs.*, kabupaten.nama_kabupaten, perusahaan.nama_perusahaan');
        $this->db->from($this->_table);
        $this->db->join('kabupaten', 'kabupaten.id_kabupaten = harga_tbs.id_kabupaten', 'left');
        $this->db->join('perusahaan', 'perusahaan.id_perusahaan = harga_tbs.id_perusahaan', 'left');
        $this->db->where("DATE(harga_tbs.tanggal) = '{$hari_ini}'", NULL, FALSE);
        $this->db->order_by('harga_tbs.id_perusahaan', 'ASC');
        $this->db->order_by('harga_tbs.id_kabupaten', 'ASC');
        $this->db->order_by('harga_tbs.tanggal', 'DESC');
        $semua_hari_ini = $this->db->get()->result();

        $harga_terbaru = [];
        $sudah_lihat = [];

        foreach ($semua_hari_ini as $harga) {
            $kunci = $harga->id_kabupaten . '_' . $harga->id_perusahaan;
            if (!isset($sudah_lihat[$kunci])) {
                $sudah_lihat[$kunci] = true;
                $harga_terbaru[] = $harga;
            }
        }

        return $harga_terbaru;
    }

    public function get_by_id($id)
    {
        $this->db->where('id_harga', $id);
        return $this->db->get($this->_table)->row_array();
    }

    public function count_all()
    {
        return $this->db->count_all_results($this->_table);
    }

    public function get_semua_terfilter($filter = [], $batas = null, $mulai_dari = null)
    {
        $this->db->select('harga_tbs.*, kabupaten.nama_kabupaten, perusahaan.nama_perusahaan');
        $this->db->from($this->_table);
        $this->db->join('kabupaten', 'kabupaten.id_kabupaten = harga_tbs.id_kabupaten', 'left');
        $this->db->join('perusahaan', 'perusahaan.id_perusahaan = harga_tbs.id_perusahaan', 'left');

        if (!empty($filter['kabupaten'])) {
            $this->db->where('harga_tbs.id_kabupaten', $filter['kabupaten']);
        }
        if (!empty($filter['perusahaan'])) {
            $this->db->where('harga_tbs.id_perusahaan', $filter['perusahaan']);
        }
        if (!empty($filter['date_from'])) {
            $this->db->where('harga_tbs.tanggal >=', $filter['date_from']);
        }
        if (!empty($filter['date_to'])) {
            $this->db->where('harga_tbs.tanggal <=', $filter['date_to']);
        }

        $this->db->order_by('harga_tbs.tanggal', 'DESC');
        $this->db->order_by('harga_tbs.id_perusahaan', 'ASC');

        if ($batas !== null && $mulai_dari !== null) {
            $this->db->limit($batas, $mulai_dari);
        }

        return $this->db->get()->result();
    }

    public function hitung_semua_terfilter($filter = [])
    {
        $this->db->from($this->_table);

        if (!empty($filter['kabupaten'])) {
            $this->db->where('id_kabupaten', $filter['kabupaten']);
        }
        if (!empty($filter['perusahaan'])) {
            $this->db->where('id_perusahaan', $filter['perusahaan']);
        }
        if (!empty($filter['date_from'])) {
            $this->db->where('tanggal >=', $filter['date_from']);
        }
        if (!empty($filter['date_to'])) {
            $this->db->where('tanggal <=', $filter['date_to']);
        }

        return $this->db->count_all_results();
    }

    public function get_by_tanggal_dan_perusahaan($tanggal, $id_perusahaan, $kecuali_id = null)
    {
        $this->db->where('tanggal', $tanggal);
        $this->db->where('id_perusahaan', $id_perusahaan);
        if ($kecuali_id) {
            $this->db->where('id_harga !=', $kecuali_id);
        }
        return $this->db->get($this->_table)->row();
    }

    public function create($data)
    {
        $this->db->insert($this->_table, $data);
        if ($this->db->affected_rows() != 1) {
            return false;
        }
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id_harga', $id);
        $this->db->update($this->_table, $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function delete($id, $dihapus_oleh = null)
    {
        if ($dihapus_oleh !== null) {
            $this->backup_sebelum_hapus($id, $dihapus_oleh);
        }
        $this->db->delete($this->_table, array('id_harga' => $id));
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function hapus_data_kemarin($id_kabupaten, $id_perusahaan, $tanggal_sekarang, $dihapus_oleh = null)
    {
        $tanggal_sekarang = date('Y-m-d', strtotime($tanggal_sekarang));
        $kemarin = date('Y-m-d', strtotime($tanggal_sekarang . ' -1 day'));

        $this->db->where('id_kabupaten', $id_kabupaten);
        $this->db->where('id_perusahaan', $id_perusahaan);
        $this->db->where("DATE(tanggal) = '{$kemarin}'", NULL, FALSE);
        $data_kemarin = $this->db->get($this->_table)->result();

        $jumlah_dihapus = 0;
        foreach ($data_kemarin as $data) {
            if ($this->delete($data->id_harga, $dihapus_oleh)) {
                $jumlah_dihapus++;
            }
        }

        return $jumlah_dihapus;
    }

    public function backup_sebelum_hapus($id, $dihapus_oleh = null)
    {
        $this->db->where('id_harga', $id);
        $data = $this->db->get($this->_table)->row();

        if ($data) {
            if ($this->db->table_exists('harga_tbs_backup')) {
                $data_backup = array(
                    'id_harga_original' => $data->id_harga,
                    'id_kabupaten' => $data->id_kabupaten,
                    'id_perusahaan' => $data->id_perusahaan,
                    'tanggal' => $data->tanggal,
                    'harga_per_kg' => $data->harga_per_kg,
                    'deleted_at' => date('Y-m-d H:i:s'),
                    'deleted_by' => $dihapus_oleh
                );

                $this->db->insert('harga_tbs_backup', $data_backup);
                return true;
            }
        }
        return false;
    }

    public function get_dari_backup($id_kabupaten, $id_perusahaan, $tanggal)
    {
        if (!$this->db->table_exists('harga_tbs_backup')) {
            return null;
        }

        $tanggal = date('Y-m-d', strtotime($tanggal));

        $this->db->where('id_kabupaten', $id_kabupaten);
        $this->db->where('id_perusahaan', $id_perusahaan);
        $this->db->where('DATE(tanggal)', $tanggal);
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit(1);

        return $this->db->get('harga_tbs_backup')->row();
    }

    public function get_terakhir_dari_backup($id_kabupaten, $id_perusahaan, $tanggal_sekarang)
    {
        if (!$this->db->table_exists('harga_tbs_backup')) {
            return null;
        }

        $tanggal_sekarang = date('Y-m-d', strtotime($tanggal_sekarang));

        $this->db->where('id_kabupaten', $id_kabupaten);
        $this->db->where('id_perusahaan', $id_perusahaan);
        $this->db->where('DATE(tanggal) <', $tanggal_sekarang);
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit(1);

        return $this->db->get('harga_tbs_backup')->row();
    }
}




