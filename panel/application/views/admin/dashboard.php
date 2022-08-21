<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="row">

      <div class="col-lg-5 col-md-5 col-sm-12">
        <div class="card card-statistic-2">
          <div class="card-stats mb-4">
            <div class="card-stats-title">Kesediaan
            </div>
            <div class="card-stats-items">
              <div class="card-stats-item">
                <div class="card-stats-item-count"><?= $mobil_ready ?></div>
                <div class="card-stats-item-label">Ready</div>
              </div>
              <div class="card-stats-item">
                <div class="card-stats-item-count"><?= $mobil_dipakai ?></div>
                <div class="card-stats-item-label">Dipakai</div>
              </div>
              <div class="card-stats-item">
                <div class="card-stats-item-count"><?= $mobil_service ?></div>
                <div class="card-stats-item-label">Service</div>
              </div>
            </div>
          </div>
          <div class="card-icon shadow-primary bg-primary">
            <i class="fas fa-truck-moving"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Mobil Sampah</h4>
            </div>
            <div class="card-body">
              <?= $mobil ?> Unit
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-5 col-md-5 col-sm-12">
        <div class="card card-statistic-2">
          <div class="card-icon shadow-primary bg-primary">
            <i class="fas fa-user"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Petugas</h4>
            </div>
            <div class="card-body">
              <?= $petugas ?> Orang
            </div>
          </div>
        </div>

        <div class="card card-statistic-2">
          <div class="card-icon shadow-primary bg-primary">
            <i class="fas fa-trash-alt"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Tempat Sampah</h4>
            </div>
            <div class="card-body">
              <?= $tempat_sampah ?> Lokasi
            </div>
          </div>
        </div>

      </div>

  </section>
</div>