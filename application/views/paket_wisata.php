         <section class="hero-parallax d-flex align-items-center text-center text-white" style="background-image: url('<?= base_url() ?>/admin/uploads/<?= get_baner('paket_wisata_parallax', 'foto') ?>');">
             <div class="container" data-aos="fade-up">
                 <h1 class="fw-bold mb-3"><?= get_baner('paket_wisata_parallax', 'title') ?></h1>
                 <p class="lead mb-4"><?= get_baner('paket_wisata_parallax', 'caption') ?></p>
                 <!-- <a href="https://wa.me/6281234567890?text=Halo%20Belmontransport,%20saya%20ingin%20bertanya."
                class="btn btn-whatsapp-nav">
                <i class="fab fa-whatsapp me-2"></i>Hubungi Kami
            </a> -->
             </div>
         </section>

         <div class="container py-5">
             <h2 class="text-center mb-4 fw-bold text-primary">Paket Wisata</h2>
             <div class="row g-4">

                 <?php foreach ($paket_wisata as $row) { ?>
                     <?php $destinasi = json_decode($row['destinasi'], true) ?>
                     <div class="col-md-3" data-aos="fade-up">
                         <div class="card wisata-card border-0 shadow-sm h-100">
                             <div class="position-relative">
                                 <img src="<?= base_url('admin/uploads/' . $row['foto']) ?>" class="card-img-top rounded-top">
                                 <span
                                     class="badge bg-warning text-dark position-absolute top-0 end-0 m-2 px-3 py-2 rounded-pill fw-semibold">
                                     <?= count($destinasi) ?> DESTINASI
                                 </span>
                             </div>
                             <div class="card-body">
                                 <h5 class="fw-bold mb-3"><?= $row['nama_wisata'] ?></h5>
                                 <ul class="list-unstyled mb-4">
                                     <?php foreach ($destinasi as $row2) { ?>
                                         <li><i class="fa-solid fa-check text-warning me-2"></i><?= $row2['nama_destinasi'] ?></li>
                                     <?php } ?>
                                 </ul>
                                 <div class="text-center border-top pt-3">
                                     <a href="https://wa.me/<?= get_kontak('whatsapp_url', 'alamat_kontak') ?>?text=<?= urlencode('Halo Belmon Saya Mau Booking Wisata ' . $row['nama_wisata']) ?>" class="btn btn-whatsapp">
                                         <i class="fab fa-whatsapp fa-lg"></i>Pesan
                                     </a>
                                     <p class="mt-2 mb-0 small text-muted">Include Driver & BBM</p>
                                     <p class="fw-bold text-primary mb-0">Rp. 600.000 <small class="text-muted">/12 Jam</small>
                                     </p>
                                 </div>
                             </div>
                         </div>
                     </div>
                 <?php } ?>

             </div>
         </div>