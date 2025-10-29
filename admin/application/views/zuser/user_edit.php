<div class="card">
    <div class="card-body">
        <form id="form_1" autocomplete="off">
            <div class="row">
                <div class="col-md-4">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="form-group">
                        <label for="username">Username *</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= $username ?>">
                    </div>
                    <div class="form-group">
                        <?php
                        $placeholder = "Isi Password Untuk Ganti Password";
                        if (empty($id)) $placeholder = "Isikan Password";
                        ?>
                        <label for="password">Password <?php if (empty($id)) echo "*" ?></label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="<?= $placeholder ?>">
                    </div>

                    <div class="form-group">
                        <label for="password2">Ulangi Password <?php if (empty($id)) echo "*" ?></label>
                        <input type="password" class="form-control" id="password2" name="password2" placeholder="Ulangi Password">
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?= $email ?>">
                    </div>
                    <div class="form-group">
                        <label for="id_jabatan">Jabatan *</label>
                        <?= form_dropdown('id_jabatan', $opt_jabatan, $id_jabatan, ' class="form-control" id="id_jabatan" ') ?>
                    </div>


                </div>
                <div class="col-md-4 pl-4">

                </div>
            </div>
            <div style="text-align: end;">

                <button type="submit" class="btn btn-primary">save</button>
                <a class="btn btn-secondary" href="<?= base_url('zuser') ?>">Kembali</a>
            </div>
            (*) Wajib Diisi
        </form>
    </div>
</div>
<?php require_once 'user_edit_script.php' ?>