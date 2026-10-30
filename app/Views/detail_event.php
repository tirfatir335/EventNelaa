<?= $this->extend('layout/main'); ?>
<?= $this->section('content'); ?>

<div class="container my-5">
    <div class="row justify-content-center">

        <!-- POSTER -->
        <div class="col-md-4 text-center mb-4">
            <div class="border rounded p-2">
                <img src="<?= !empty($event['poster']) 
                    ? base_url('uploads/poster/' . $event['poster']) 
                    : base_url('assets/images/default.png'); ?>"
                    class="img-fluid rounded"
                    style="max-height: 350px; object-fit: cover;">
            </div>
            <p class="mt-2 fw-bold">POSTER</p>
        </div>

        <!-- DETAIL -->
        <div class="col-md-6">
            <h4 class="fw-bold mb-4">Detail Event</h4>
            <table class="table table-borderless fs-5">
                <tr>
                    <td class="fw-bold">Nama Event & Tema</td>
                    <td>: <?= esc($event['nama_event'] ?? '-'); ?></td>
                </tr>
                <tr>
                    <td class="fw-bold">Ormawa</td>
                    <td>: <?= esc($event['nama_ormawa'] ?? '-'); ?></td>
                </tr>
                <tr>
                    <td class="fw-bold">Jadwal</td>
                    <td>: <?= !empty($event['tanggal']) ? date("d M Y", strtotime($event['tanggal'])) : '-'; ?></td>
                </tr>
                <tr>
                    <td class="fw-bold">Waktu</td>
                    <td>: <?= esc($event['waktu'] ?? '-'); ?></td>
                </tr>
                <tr>
                    <td class="fw-bold">Deskripsi</td>
                    <td>: <?= esc($event['deskripsi'] ?? '-'); ?></td>
                </tr>
                <tr>
                    <td class="fw-bold">Gedung</td>
                    <td>: <?= esc($event['gedung'] ?? '-'); ?></td>
                </tr>
            </table>
        </div>

    </div>
</div>
<?= $this->endSection(); ?>

