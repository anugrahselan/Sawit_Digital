<table class="tbs-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Kabupaten</th>
            <th>PT / Perusahaan</th>
            <th>Tanggal</th>
            <th>Harga per KG</th>
            <th>Perubahan</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($tbs_prices)): ?>
            <?php $no = 1; foreach($tbs_prices as $price): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= isset($price->nama_kabupaten) ? $price->nama_kabupaten : 'N/A' ?></td>
                <td><?= isset($price->nama_perusahaan) ? $price->nama_perusahaan : 'N/A' ?></td>
                <td><?= date('d/m/Y', strtotime($price->tanggal)) ?></td>
                <td>Rp <?= number_format($price->harga_per_kg, 0, ',', '.') ?></td>
                <td class="perubahan-harga">
                    <?php 

                    if(isset($price->status_perubahan) && $price->status_perubahan != 'tidak_ada' && isset($price->perubahan)):
                        if($price->status_perubahan == 'naik'):
                    ?>
                        <span class="perubahan-naik">
                            <span class="icon-perubahan">📈</span>
                            +Rp <?= number_format(abs($price->perubahan), 0, ',', '.') ?>
                        </span>
                    <?php 
                        elseif($price->status_perubahan == 'turun'):
                    ?>
                        <span class="perubahan-turun">
                            <span class="icon-perubahan">📉</span>
                            -Rp <?= number_format(abs($price->perubahan), 0, ',', '.') ?>
                        </span>
                    <?php 
                        endif;
                    else: 

                    ?>
                        <span class="perubahan-tidak-ada">-</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">Tidak ada data harga TBS</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
