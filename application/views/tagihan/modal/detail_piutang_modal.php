<?php if (!empty($piutang_in) || !empty($piutang_out)): ?>

    <?php if (!empty($piutang_in)): ?>
    <h6 class="text-primary mb-2">Daftar Rincian Tagihan Baru</h6>
    <table class="table table-sm table-bordered mb-4">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; 
            $jumlah_tagihan = 0;
            foreach($piutang_in as $row): 
                if($row['stts'] == 'utama') {
                    $jumlah_tagihan += $row['nilai'];
                } else if($row['stts'] == 'penyetaraan' || $row['stts'] == 'subsidi' || $row['stts'] == 'denda') {
                    $jumlah_tagihan -= $row['nilai'];
                } 
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['tgl']; ?></td>
                <td><?= $row['stts']; ?></td>
                <td class="text-right"><?= number_format($row['nilai'], 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Jumlah Tagihan</td>
                <td class="text-right"><?= number_format($jumlah_tagihan, 0, ',', '.'); ?></td>
            </tr>
        </tfoot>
    </table>
    <?php endif; ?>

    <hr>

    <?php if (!empty($piutang_out)) { ?>
    <h6 class="text-danger mb-2">Daftar Rincian Pelunasan</h6>
    <table class="table table-sm table-bordered">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>User Akun</th>\
                <th>Metode</th>
                <th>Nilai</th>
                <th>Dibayar Oleh</th>
                <th>Diterima Oleh</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($piutang_out as $row): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['tgl']; ?></td>
                <td><?= $row['ket']; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['nm_kas']; ?></td>
                <td class="text-right"><?= number_format($row['nilai'], 0, ',', '.'); ?></td>
                <td><?= $row['dibayar']; ?></td>
                <td><?= $row['diterima']; ?></td>
                <td>
                    <a href="<?= base_url(); ?>tagihan/delete_piutang_out/<?= $row['id_piut']; ?>" class="btn btn-sm btn-danger mb-2" onclick="return confirm('Apakah ingin menghapus?');">
                        <i class="fas fa-fw fa-trash"></i>
                        <span class="text">Hapus</span>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php } else { ?>
        <div class="alert alert-info mb-0">Belum ada pelunasan tagihan. </div>
    <?php } ?>

<?php else: ?>
    <div class="alert alert-info mb-0">Tidak ada data tagihan terkait.</div>
<?php endif; ?>
