<main role="main" class="flex-shrink-0">
    <div class="container">
        <h3>Input Data</h3>
        <hr>
        <!-- form tambah barang -->
        <form method="post" action="<?= base_url('pengajuan/tambah_aksi');?>">
        <div class="form-grup">
            <label>Cost element</label>
            <input type="number" name="cost_element" class="form-control">
        </div>
        <div class="form-grup">
            <label>Cost element name</label>
            <input type="text" name="cost_element_name" class="form-control">
        </div>
        <div class="form-grup">
            <label>Cost center</label>
            <input type="text" name="cost_center" class="form-control">
        </div>
        <div class="form-grup">
            <label>Value</label>
            <input type="text" name="value" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Data</button>
        <a href="<?= base_url('user');?>" class="btn btn-danger">Batal/kembali</a>
    </form>
    </div>
</main>