<div class="card">
    <div class="card-body">
        <form id="form_1" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-4">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="form-group">
                        <label for="nama_kontak"><?= label2('nama_kontak') ?>*</label>
                        <input type="text" class="form-control" id="nama_kontak" name="nama_kontak" value="<?= $nama_kontak ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="alamat_kontak"><?= label2('alamat_kontak') ?>*</label>
                        <input type="text" class="form-control" id="alamat_kontak" name="alamat_kontak" value="<?= $alamat_kontak ?>">
                    </div>

                    <div class="form-group">
                        <label for="url"><?= label2('url') ?>*</label>
                        <textarea class="form-control" id="url" name="url"><?= $url ?></textarea>
                    </div>



                </div>
                <div class="col-md-4">



                </div>
                <div class="col-md-4 pl-4">

                </div>
            </div>
            <div style="text-align: end;">

                <button type="submit" class="btn btn-primary">save</button>
                <a class="btn btn-secondary" href="<?= base_url('kontak') ?>">Kembali</a>
            </div>
            <b> (*) Wajib Diisi </b>
        </form>
    </div>
</div>
<?php require_once 'kontak_edit_script.php' ?>