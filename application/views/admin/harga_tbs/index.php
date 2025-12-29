<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header. (Page Header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $page_title ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active"><?= $page_title ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"></h5>
                            <p class="card-text">
                                <?php if ($this->session->flashdata('message')): ?>
                                    <div class="alert alert-<?= $this->session->flashdata('message_type') ?: 'info' ?> alert-dismissible fade show" role="alert">
                                        <?= $this->session->flashdata('message') ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif; ?>
                                
                                <a href="<?= base_url('admin/harga_tbs/tambah') ?>" class="btn btn-labeled btn-primary">
                                    <span class="btn-label"><i class="fa fa-plus"></i></span> Tambah Data
                                </a>
                                
                                <!-- Filters -->
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <form method="get" action="<?= base_url('admin/harga_tbs') ?>" class="row g-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Kabupaten</label>
                                                <select name="kabupaten" class="form-control">
                                                    <option value="">Semua Kabupaten</option>
                                                    <?php foreach ($kabupaten_list as $kab): ?>
                                                        <option value="<?= $kab->id_kabupaten ?>" <?= ($filters['kabupaten'] == $kab->id_kabupaten) ? 'selected' : '' ?>><?= $kab->nama_kabupaten ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Perusahaan</label>
                                                <select name="perusahaan" class="form-control">
                                                    <option value="">Semua Perusahaan</option>
                                                    <?php foreach ($perusahaan_list as $pt): ?>
                                                        <option value="<?= $pt->id_perusahaan ?>" <?= ($filters['perusahaan'] == $pt->id_perusahaan) ? 'selected' : '' ?>><?= $pt->nama_perusahaan ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Dari Tanggal</label>
                                                <input type="date" name="date_from" class="form-control" value="<?= $filters['date_from'] ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Sampai Tanggal</label>
                                                <input type="date" name="date_to" class="form-control" value="<?= $filters['date_to'] ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">&nbsp;</label>
                                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Tanggal</th>
                                            <th scope="col">Kabupaten</th>
                                            <th scope="col">Perusahaan</th>
                                            <th scope="col">Harga/Kg</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($prices)): ?>
                                            <?php $i = 1; foreach ($prices as $price): ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= date('d M Y', strtotime($price->tanggal)) ?></td>
                                                    <td><?= $price->nama_kabupaten ?: '-' ?></td>
                                                    <td><?= $price->nama_perusahaan ?: '-' ?></td>
                                                    <td><strong>Rp <?= number_format($price->harga_per_kg, 0, ',', '.') ?></strong></td>
                                                    <td>
                                                        <a href="<?= base_url('admin/harga_tbs/ubah/' . $price->id_harga) ?>" class="badge badge-success">edit</a>
                                                        <a href="<?= base_url('admin/harga_tbs/hapus/' . $price->id_harga) ?>" class="badge badge-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">delete</a>
                                                    </td>
                                                </tr>
                                            <?php $i++; endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center">Tidak ada data</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                
                                <?php if (isset($pagination_links)): ?>
                                    <div class="mt-3">
                                        <?= $pagination_links ?>
                                    </div>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
