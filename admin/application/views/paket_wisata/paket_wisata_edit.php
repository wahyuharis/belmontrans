<style>
    ul.destinasi_list {
        list-style: none;
    }

    ul.destinasi_list li:before {
        content: '✓';
    }
</style>

<div class="card">
    <div class="card-body">
        <form id="form_1" enctype="multipart/form-data">
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
                        <label for="nama_wisata"><?= label2('nama_wisata') ?>*</label>
                        <input type="text" class="form-control" id="nama_wisata" name="nama_wisata" value="<?= $nama_wisata ?>">
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
                        <label><?= label2('destinasi') ?>*</label>

                        <div class="row" id="input_destinasi_model">
                            <div class="col-12" style="border: 1px solid #ccc; padding: 5px;">
                                <table>
                                    <tbody data-bind="foreach:destinasi_list">
                                        <tr>
                                            <td style="width: 21px;"><i class="fas fa-check-circle"></i></td>
                                            <td style="width: 150px;" data-bind="text:nama_destinasi"></td>
                                            <td style="width: 50px;"> <span data-bind="click: $root.remove" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></span> </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br><br>
                                <div class="input-group input-group-sm mb-3">
                                    <input data-bind="textInput:destinasi_input" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                    <div class="input-group-prepend">
                                        <button data-bind="click:add_destinasi_list" class="btn btn-secondary" type="button">tambah</button>
                                    </div>
                                </div>
                            </div>
                            <textarea name="destinasi" class="form-control d-none" data-bind="value:ko.toJSON($root.destinasi_list)"></textarea>
                        </div>


                    </div>


                </div>
                <div class="col-md-4 pl-4">
                    <div class="form-group">
                        <label for="harga"><?= label2('harga') ?>*</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                            </div>
                            <input type="text" class="form-control thousand" id="harga" name="harga" value="<?= $harga ?>">
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
<?php require_once 'paket_wisata_edit_script.php' ?>