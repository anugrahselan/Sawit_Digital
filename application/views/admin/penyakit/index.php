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
                                
                                <a href="<?= base_url('admin/penyakit/tambah') ?>" class="btn btn-labeled btn-primary">
                                    <span class="btn-label"><i class="fa fa-plus"></i></span> Tambah Data
                                </a>
                                
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Gambar</th>
                                            <th scope="col">Nama Penyakit</th>
                                            <th scope="col">Penyebab</th>
                                            <th scope="col">Gejala</th>
                                            <th scope="col">Cara Pengendalian</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($penyakit)): ?>
                                            <?php $i = 1; foreach ($penyakit as $p): ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td>
                                                        <?php if (!empty($p->gambar_ilustrasi)): 
                                                            $gambar_penyakit = trim($p->gambar_ilustrasi);
                                                            if (strpos($gambar_penyakit, 'assets/img/penyakit/') !== false) {
                                                                $gambar_penyakit = basename($gambar_penyakit);
                                                            }
                                                            $gambar_url = base_url('assets/img/penyakit/' . $gambar_penyakit);
                                                        ?>
                                                            <img src="<?= $gambar_url ?>" alt="<?= htmlspecialchars($p->nama_penyakit) ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;" onerror="this.onerror=null; this.style.display='none'; this.parentElement.innerHTML='<span class=\'text-muted\'>-</span>';">
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><strong><?= $p->nama_penyakit ?></strong></td>
                                                    <td><?= character_limiter($p->penyebab, 50) ?: '-' ?></td>
                                                    <td><?= character_limiter($p->gejala, 50) ?: '-' ?></td>
                                                    <td><?= character_limiter($p->cara_pengendalian, 50) ?: '-' ?></td>
                                                    <td>
                                                        <a href="<?= base_url('admin/penyakit/ubah/' . $p->id_penyakit) ?>" class="badge badge-success">edit</a>
                                                        <a href="<?= base_url('admin/penyakit/hapus/' . $p->id_penyakit) ?>" class="badge badge-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">delete</a>
                                                    </td>
                                                </tr>
                                            <?php $i++; endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="7" class="text-center">Tidak ada data</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
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
