<div class="card">
    <div class="card-body">
        <form id="form_1"  enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-4">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="form-group">
                        <label for="no_urut"><?= label2('no_urut') ?>*</label>
                        <input type="text" class="form-control number" id="no_urut" name="no_urut" value="<?= $no_urut ?>">
                    </div>
                    <div class="form-group">
                        <label for="show_at_home"><?= label2('tampilkan di home') ?>*</label>
                        <?= form_dropdown('show_at_home', array('0' => 'jangan tampilkan', '1' => 'tampilkan'), $show_at_home, 'class="form-control" id="show_at_home"') ?>
                    </div>





                </div>
                <div class="col-md-4">

                    <div class="form-group">
                        <label for="nama_kendaraan"><?= label2('nama_kendaraan') ?>*</label>
                        <input type="text" class="form-control" id="nama_kendaraan" name="nama_kendaraan" value="<?= $nama_kendaraan ?>">
                    </div>

                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control" onchange="loadFile(event)">
                        <img id="output" style="max-width: 150px;max-height: 150px;" src="<?= base_url('uploads/' . $foto) ?>">
                        <script>
                            var loadFile = function(event) {
                                var output = document.getElementById('output');
                                output.src = URL.createObjectURL(event.target.files[0]);
                                output.onload = function() {
                                    URL.revokeObjectURL(output.src) // free memory
                                }
                            };
                        </script>
                    </div>


                </div>
                <div class="col-md-4 pl-4">
                    <div class="form-group">
                        <label for="lepas_kunci"><?= label2('harga lepas_kunci') ?>*</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                            </div>
                            <input type="text" class="form-control thousand" id="lepas_kunci" name="lepas_kunci" value="<?= $lepas_kunci ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="with_driver"><?= label2('harga include driver') ?>*</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                            </div>
                            <input type="text" class="form-control thousand" id="with_driver" name="with_driver" value="<?= $with_driver ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div style="text-align: end;">

                <button type="submit" class="btn btn-primary">save</button>
                <a class="btn btn-secondary" href="<?= base_url('kendaraan') ?>">Kembali</a>
            </div>
            <b> (*) Wajib Diisi </b>
        </form>
    </div>
</div>
<?php require_once 'kendaraan_edit_script.php' ?>