<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
  </div>

  <div class="row">
    <!-- Info & Billing -->
    <div class="col-lg-6">
      <div class="card shadow mb-4">
        <div class="card-header d-flex align-items-center justify-content-between py-3">
          <div>
            <h6 class="m-0 font-weight-bold text-primary">PDAM Rumah</h6>
            <small class="text-muted">[alamat]</small>
          </div>
          <!-- Bayar Tagihan button -->
          <?php
            // contoh: $hasOutstanding = true/false; $billingPageUrl = site_url('pelanggan/bayar');
            $billingPageUrl = '/pelanggan/bayar'; // ganti sesuai route Anda
            $hasOutstanding = isset($billing) && $billing['amount'] > 0;
          ?>
          <div>
            <?php if($hasOutstanding): ?>
              <a href="<?= $billingPageUrl; ?>" class="btn btn-primary btn-sm">Bayar Tagihan</a>
            <?php else: ?>
              <button class="btn btn-secondary btn-sm" disabled>Tidak Ada Tagihan</button>
            <?php endif; ?>
          </div>
        </div>

        <div class="card-body">
          <p><strong>ID:</strong> <?= htmlspecialchars($customer_id ?? '[ID]'); ?></p>

          <p>
            <strong>Tagihan:</strong>
            <?php if($hasOutstanding): ?>
              Rp. <?= number_format($billing['amount'], 0, ',', '.'); ?>,-
              <span class="text-danger"> (Jatuh tempo: <?= date('d M Y', strtotime($billing['due_date'])); ?>)</span>
            <?php else: ?>
              Rp. Xx.xxx ,- (tidak ada tagihan yang jatuh tempo saat ini)
            <?php endif; ?>
          </p>

          <!-- Tombol bayar mengarahkan ke halaman yang menampilkan pilihan metode Xendit -->
          <p class="mb-0">
            <!-- jika Anda menggunakan route yang akan memanggil Xendit create invoice/billing, arahkan ke situ -->
            <a href="<?= $billingPageUrl; ?>" class="btn btn-success">Bayar Sekarang</a>
          </p>

          <hr>

          <!-- Bagian VA yang sudah terbuat (jika ada) -->
          <?php
            // contoh struktur $vas = [
            //   ['va' => '1234567890', 'bank' => 'BCA', 'expiry' => '2025-05-10 23:59:59', 'amount' => 50000],
            // ];
          ?>
          <?php if(!empty($vas)): ?>
            <h6 class="font-weight-bold text-primary">Virtual Account Aktif</h6>
            <div class="list-group">
              <?php foreach($vas as $v): ?>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                  <div>
                    <div><strong>Kode VA:</strong> <span class="text-monospace"><?= htmlspecialchars($v['va']); ?></span></div>
                    <div><strong>Bank:</strong> <?= htmlspecialchars($v['bank']); ?></div>
                    <div><strong>Batas Pembayaran:</strong> <?= date('d M Y H:i', strtotime($v['expiry'])); ?></div>
                  </div>
                  <div class="text-right">
                    <div class="h5 mb-1">Rp. <?= number_format($v['amount'], 0, ',', '.'); ?>,-</div>
                    <a href="<?= $billingPageUrl . '?va=' . urlencode($v['va']); ?>" class="btn btn-outline-primary btn-sm">Lihat / Bayar</a>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <p class="text-muted">Tidak ada Virtual Account aktif.</p>
          <?php endif; ?>

        </div>
      </div>
    </div>

    <!-- Riwayat Penggunaan & Chart -->
    <div class="col-lg-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Riwayat Penggunaan</h6>
          <small class="text-muted">(*grafik 6 bulan sebelumnya)</small>
        </div>
        <div class="card-body">
          <canvas id="usageChart" height="100"></canvas>

          <!-- Ringkasan tabel kecil bawah (opsional) -->
          <div class="mt-3">
            <table class="table table-sm table-bordered mb-0">
              <thead>
                <tr>
                  <th>Bulan</th>
                  <th>Rupiah</th>
                  <th>Pemakaian (m³)</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  // contoh data baris:
                  $history = [
                    ['month'=>'Apr-25','amount'=>35000,'usage'=>120],
                    ['month'=>'May-25','amount'=>40000,'usage'=>130],
                    ['month'=>'Jun-25','amount'=>45000,'usage'=>135],
                    ['month'=>'Jul-25','amount'=>55000,'usage'=>145],
                  ];
                ?>
                <?php if(!empty($history)): ?>
                  <?php foreach($history as $h): ?>
                    <tr>
                      <td><?= htmlspecialchars($h['month']); ?></td>
                      <td>Rp. <?= number_format($h['amount'],0,',','.'); ?></td>
                      <td><?= htmlspecialchars($h['usage']); ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="3" class="text-center text-muted">Data tidak tersedia</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>

</div>

</div>
<!-- /.container-fluid -->

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
<script>
  const ctx = document.getElementById('usageChart').getContext('2d');
  const usageChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Apr-25', 'May-25', 'Jun-25', 'Jul-25'],
      datasets: [
        {
          label: 'Pemakaian Air (Meter)',
          data: [35000, 40000, 45000, 55000],
          borderColor: 'rgba(78, 115, 223, 1)',
          backgroundColor: 'rgba(78, 115, 223, 0.1)',
          fill: true,
          tension: 0.3,
          pointRadius: 3,
        }
      ]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      },
      plugins: {
        legend: { display: true }
      }
    }
  });
</script>
