<div class="card">
    <div class="card-body">
        <form id="form_1" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-4">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="form-group">
                        <label for="nama_baner"><?= label2('nama_baner') ?>*</label>
                        <input type="text" class="form-control" id="nama_baner" name="nama_baner" value="<?= $nama_baner ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="title"><?= label2('title') ?>*</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= $title ?>" readonly>
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

                    <div class="form-group">
                        <label for="caption"><?= label2('caption') ?>*</label>
                        <textarea class="form-control" id="caption" name="caption"><?= $caption ?></textarea>
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
                <a class="btn btn-secondary" href="<?= base_url('baner') ?>">Kembali</a>
            </div>
            <b> (*) Wajib Diisi </b>
        </form>
    </div>
</div>
<?php require_once 'baner_edit_script.php' ?>