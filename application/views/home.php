    <!-- Carousel -->
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="<?= base_url() ?>/admin/uploads/<?= get_baner('home_carousel_rental_mobil', 'foto') ?>" class="d-block w-100" alt="Slide 1">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="fw-bold"><?= get_baner('home_carousel_rental_mobil', 'title') ?></h2>
                    <p><?= get_baner('home_carousel_rental_mobil', 'caption') ?></p>
                    <p>
                        <a href="<?= get_baner('home_carousel_rental_mobil', 'url') ?>" class="btn btn-whatsapp-nav">
                            Lanjut
                        </a>
                    </p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?= base_url() ?>/admin/uploads/<?= get_baner('home_carousel_paket_wisata', 'foto') ?>" class="d-block w-100" alt="Slide 2">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="fw-bold"><?= get_baner('home_carousel_paket_wisata', 'title') ?></h2>
                    <p><?= get_baner('home_carousel_paket_wisata', 'caption') ?></p>
                    <p>
                        <a href="<?= get_baner('home_carousel_paket_wisata', 'url') ?>" class="btn btn-whatsapp-nav">
                            </i>Lanjut
                        </a>
                    </p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?= base_url() ?>/admin/uploads/<?= get_baner('home_carousel_hubungi_kami', 'foto') ?>" class="d-block w-100" alt="Slide 3">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="fw-bold"><?= get_baner('home_carousel_hubungi_kami', 'title') ?></h2>
                    <p><?= get_baner('home_carousel_hubungi_kami', 'caption') ?></p>
                    <p>
                        <a href="<?= get_baner('home_carousel_hubungi_kami', 'url') ?>" class="btn btn-whatsapp-nav">
                            <i class="fab fa-whatsapp fa-lg"></i>Hubungi Kami
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <div class="container py-5">
        <h2 class="text-center mb-4 fw-bold text-primary" data-aos="fade-up">Selamat Datang</h2>
        <div class="row g-4" data-aos="fade-up">
            Belmontransport adalah agen travel perjalanan wisata dan persewaan mobil yang berada di Yogyakarta, kami
            berfokus pada pelayanan tour dan persewaan kendaraan yang telah disusun untuk mendukung kebutuhan para
            wisatawan dan instansi di Indonesia atau mancanegara yang berkunjung ke daerah wisata Sekitar Jawa khususnya
            Yogyakarta. Untuk mendukung aktivitas perjalanan wisata anda, kami telah membetuk sebuah tim yang solid dan
            sudah sangat profesional dibidangnya. Hal ini kami lakukan demi memberikan pelayanan terbaik untuk anda yang
            berkeinginan untuk melakukan perjalanannya dengan kami
        </div>
    </div>

    <div class="container py-5">
        <h2 class="text-center mb-4 fw-bold text-primary" data-aos="fade-up">Rental Mobil</h2>
        <div class="row g-4">

            <?php foreach ($kendaraan as $row) { ?>
                <!-- Card 1 -->
                <div class="col-md-3" data-aos="fade-up">
                    <div class="card car-card">
                        <img src="<?= base_url('admin/uploads/' . $row['foto']) ?>" class="card-img-top">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold"><?= $row['nama_kendaraan'] ?></h5>
                            <!-- <p class="mb-1">Lepas Kunci, Manual</p> -->
                            <!-- <p class="price mb-0">Rp. 350.000 <small class="text-muted">/24 Jam</small></p> -->
                            <p>Include Driver & BBM
                                <br>
                                <span class="price">Rp <?= format_currency($row['with_driver']) ?></span>/<small class="text-muted">Day</small>
                            </p>
                            <hr>
                            <a href="https://wa.me/<?= get_kontak('whatsapp_url', 'alamat_kontak') ?>?text=<?= urlencode('Halo Belmon Saya Mau Booking ' . $row['nama_kendaraan']) ?>" class="btn btn-whatsapp">
                                <i class="fab fa-whatsapp fa-lg"></i>Pesan
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>

    <div class="container py-5">
        <h2 class="text-center mb-4 fw-bold text-primary">Paket Wisata</h2>
        <div class="row g-4">

            <div class="col-md-3" data-aos="fade-up">
                <div class="card wisata-card border-0 shadow-sm h-100">
                    <div class="position-relative">
                        <img src="paket-wisata-1-69.jpeg.webp" class="card-img-top rounded-top" alt="Paket Wisata 1">
                        <span
                            class="badge bg-warning text-dark position-absolute top-0 end-0 m-2 px-3 py-2 rounded-pill fw-semibold">
                            3 DESTINASI
                        </span>
                    </div>
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Paket Wisata 1</h5>
                        <ul class="list-unstyled mb-4">
                            <li><i class="fa-solid fa-check text-warning me-2"></i>Borobudur</li>
                            <li><i class="fa-solid fa-check text-warning me-2"></i>Merapi Lava Tour</li>
                            <li><i class="fa-solid fa-check text-warning me-2"></i>Prambanan Tebing Breksi</li>
                        </ul>
                        <div class="text-center border-top pt-3">
                            <a href="#" class="btn btn-whatsapp">
                                <i class="fab fa-whatsapp fa-lg"></i>Pesan
                            </a>
                            <p class="mt-2 mb-0 small text-muted">Include Driver & BBM</p>
                            <p class="fw-bold text-primary mb-0">Rp. 600.000 <small class="text-muted">/12 Jam</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3" data-aos="fade-up">
                <div class="card wisata-card border-0 shadow-sm h-100">
                    <div class="position-relative">
                        <img src="paket-wisata-1-69.jpeg.webp" class="card-img-top rounded-top" alt="Paket Wisata 1">
                        <span
                            class="badge bg-warning text-dark position-absolute top-0 end-0 m-2 px-3 py-2 rounded-pill fw-semibold">
                            3 DESTINASI
                        </span>
                    </div>
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Paket Wisata 1</h5>
                        <ul class="list-unstyled mb-4">
                            <li><i class="fa-solid fa-check text-warning me-2"></i>Borobudur</li>
                            <li><i class="fa-solid fa-check text-warning me-2"></i>Merapi Lava Tour</li>
                            <li><i class="fa-solid fa-check text-warning me-2"></i>Prambanan Tebing Breksi</li>
                        </ul>
                        <div class="text-center border-top pt-3">
                            <a href="#" class="btn btn-whatsapp">
                                <i class="fab fa-whatsapp fa-lg"></i>Pesan
                            </a>
                            <p class="mt-2 mb-0 small text-muted">Include Driver & BBM</p>
                            <p class="fw-bold text-primary mb-0">Rp. 600.000 <small class="text-muted">/12 Jam</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3" data-aos="fade-up">
                <div class="card wisata-card border-0 shadow-sm h-100">
                    <div class="position-relative">
                        <img src="paket-wisata-1-69.jpeg.webp" class="card-img-top rounded-top" alt="Paket Wisata 1">
                        <span
                            class="badge bg-warning text-dark position-absolute top-0 end-0 m-2 px-3 py-2 rounded-pill fw-semibold">
                            3 DESTINASI
                        </span>
                    </div>
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Paket Wisata 1</h5>
                        <ul class="list-unstyled mb-4">
                            <li><i class="fa-solid fa-check text-warning me-2"></i>Borobudur</li>
                            <li><i class="fa-solid fa-check text-warning me-2"></i>Merapi Lava Tour</li>
                            <li><i class="fa-solid fa-check text-warning me-2"></i>Prambanan Tebing Breksi</li>
                        </ul>
                        <div class="text-center border-top pt-3">
                            <a href="#" class="btn btn-whatsapp">
                                <i class="fab fa-whatsapp fa-lg"></i>Pesan
                            </a>
                            <p class="mt-2 mb-0 small text-muted">Include Driver & BBM</p>
                            <p class="fw-bold text-primary mb-0">Rp. 600.000 <small class="text-muted">/12 Jam</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3" data-aos="fade-up">
                <div class="card wisata-card border-0 shadow-sm h-100">
                    <div class="position-relative">
                        <img src="paket-wisata-1-69.jpeg.webp" class="card-img-top rounded-top" alt="Paket Wisata 1">
                        <span
                            class="badge bg-warning text-dark position-absolute top-0 end-0 m-2 px-3 py-2 rounded-pill fw-semibold">
                            3 DESTINASI
                        </span>
                    </div>
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Paket Wisata 1</h5>
                        <ul class="list-unstyled mb-4">
                            <li><i class="fa-solid fa-check text-warning me-2"></i>Borobudur</li>
                            <li><i class="fa-solid fa-check text-warning me-2"></i>Merapi Lava Tour</li>
                            <li><i class="fa-solid fa-check text-warning me-2"></i>Prambanan Tebing Breksi</li>
                        </ul>
                        <div class="text-center border-top pt-3">
                            <a href="#" class="btn btn-whatsapp">
                                <i class="fab fa-whatsapp fa-lg"></i>Pesan
                            </a>
                            <p class="mt-2 mb-0 small text-muted">Include Driver & BBM</p>
                            <p class="fw-bold text-primary mb-0">Rp. 600.000 <small class="text-muted">/12 Jam</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>