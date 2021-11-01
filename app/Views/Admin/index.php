<?= $this->extend('/layout/template_Admin'); ?>
<?= $this->Section('content'); ?>


<div class="container">
    <div class="d-flex justify-content-center mb-3">
        <h2 class='' id="font-style">DAFTAR BARANG</i></h2>
    </div>
    <div class="row">
        <div class="col">
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>
            <table class="table " id="table">
                <thead class="thead-dark" id="font-style">
                    <tr>
                        <th scope="col">NO</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Harga modal</th>
                        <th scope="col">Harga jual</th>
                        <th scope="col">ukuran</th>
                        <th scope="col">Tipe</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody id="font-style">
                    <?php $i = 1; ?>
                    <?php foreach ($barang as $k) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td>
                                <div class="col sm-2">
                                    <img src="/image/<?= $k['gambar']; ?>" alt="" class="gambar">
                                </div>
                            </td>
                            <td><?= $k['nama']; ?></td>
                            <td>Rp<?= number_format($k['harga_modal'], 0, ',', '.'); ?></td>
                            <td>Rp<?= number_format($k['harga_jual'], 0, ',', '.'); ?></td>
                            <td><a href="">ukuran</a></td>
                            <td><?= $k['tipe']; ?></td>
                            <td><a href="/Admin/update/<?= $k['id']; ?>" class="btn btn-warning">Ubah</a>
                                <a href="/Admin/delete/<?= $k['id']; ?>" class="btn btn-danger" onclick="return confirm('apakah anda yakin?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>

<?= $this->endSection(); ?>