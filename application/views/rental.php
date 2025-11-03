    <section class="hero-parallax d-flex align-items-center text-center text-white" style="background-image: url('<?= base_url() ?>/admin/uploads/<?= get_baner('rental_mobil_parallax', 'foto') ?>');">
        <div class="container" data-aos="fade-up">
            <h1 class="fw-bold mb-3"><?= get_baner('rental_mobil_parallax', 'title') ?></h1>
            <p class="lead mb-4"><?= get_baner('rental_mobil_parallax', 'caption') ?></p>
            <!-- <a href="https://wa.me/6281234567890?text=Halo%20Belmontransport,%20saya%20ingin%20bertanya."
                class="btn btn-whatsapp-nav">
                <i class="fab fa-whatsapp me-2"></i>Hubungi Kami
            </a> -->
        </div>
    </section>


    <div class="container py-5">
        <h2 class="text-center mb-4 fw-bold text-primary" data-aos="fade-up">Rental Mobil</h2>
        <div class="row g-4">

            <?php foreach ($kendaraan as $row) { ?>
                <!-- Card 1 -->
                <div class="col-md-3" data-aos="fade-up">
                    <div class="card car-card">
                        <img src="<?= base_url('admin/uploads/' . $row['foto']) ?>" class="card-img-top">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold"><?=$row['nama_kendaraan']?></h5>
                            <!-- <p class="mb-1">Lepas Kunci, Manual</p> -->
                            <!-- <p class="price mb-0">Rp. 350.000 <small class="text-muted">/24 Jam</small></p> -->
                            <p>Include Driver & BBM
                            <br>
                            <span class="price">Rp <?= format_currency($row['with_driver'])?></span>/<small class="text-muted">Day</small></p>
                            <hr>
                            <a href="https://wa.me/<?=get_kontak('whatsapp_url','alamat_kontak')?>?text=<?=urlencode('Halo Belmon Saya Mau Booking '.$row['nama_kendaraan'])?>" class="btn btn-whatsapp">
                                <i class="fab fa-whatsapp fa-lg"></i>Pesan
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>


        </div>
    </div>