<?= $this->extend('layout/validator_layout'); ?>
<?= $this->section('content'); ?>

<h4 class="mb-3">Validasi Event</h4>

<table class="table table-bordered">
<thead>
<tr>
    <th>No</th>
    <th>Ormawa</th>
    <th>Event</th>
    <th>Tanggal</th>
    <th>Gedung</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php $no=1; foreach($events as $e): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $e['nama_ormawa'] ?></td>
    <td><?= $e['nama_event'] ?></td>
    <td><?= $e['tanggal'] ?></td>
    <td><?= $e['gedung'] ?></td>
    <td>
        <a href="<?= base_url('validator/approve/'.$e['id_event']) ?>"
           class="btn btn-success btn-sm"
           onclick="return confirm('Setujui event ini?')">
           Terima
        </a>
        <a href="<?= base_url('validator/reject/'.$e['id_event']) ?>"
           class="btn btn-danger btn-sm"
           onclick="return confirm('Tolak event ini?')">
           Tolak
        </a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<?= $this->endSection(); ?>
