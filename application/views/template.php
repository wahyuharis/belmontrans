<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Belmontransport</title>
    <!-- Bootstrap 5 -->
    <link href="<?= base_url("node_modules/bootstrap/dist/css/bootstrap.min.css") ?>" rel="stylesheet">
    <!-- Font Awesome (ikon) -->
    <link href="<?= base_url('node_modules/@fortawesome/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('node_modules/aos/dist/aos.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/custom.css') ?>">
</head>

<body>

    <!-- Top Bar -->
    <div class="top-bar text-white py-2 small">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <i class="fa-solid fa-phone me-2"></i> <?= get_kontak('telphone', 'alamat_kontak') ?>
                <span class="mx-3">|</span>
                <i class="fa-solid fa-envelope me-2"></i> <?= get_kontak('email', 'alamat_kontak') ?>
            </div>
            <div>
                <a href="<?= get_kontak('tiktok', 'url') ?>" class="text-white me-2"><i class="fab fa-tiktok"></i></a>
                <a href="<?= get_kontak('instagram', 'url') ?>" class="text-white me-2"><i class="fab fa-instagram"></i></a>
                <a href="<?= get_kontak('whatsapp', 'url') ?>" class="text-white"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="logo-belmon2.png" alt="Belmontransport" height="60">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <?php
            $segment1 = segment_uri(1);
            $segment2 = segment_uri(2);
            $segment3 = segment_uri(3);
            ?>


            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <?php
                    $active = '';
                    if ($segment1 == 'home') {
                        $active = ' text-primary ';
                    }
                    ?>
                    <li class="nav-item"><a class="nav-link <?= $active ?>" href="<?= base_url('home') ?>">Home</a></li>
                    <?php
                    $active = '';
                    if ($segment1 == 'profile') {
                        $active = ' text-primary ';
                    }
                    ?>
                    <li class="nav-item"><a class="nav-link <?= $active ?>" href="<?= base_url('profile') ?>">Profil</a></li>
                    <?php
                    $active = '';
                    if ($segment1 == 'rental-mobil') {
                        $active = ' text-primary ';
                    }
                    ?>
                    <li class="nav-item"><a class="nav-link <?= $active ?>" href="<?= base_url('rental-mobil') ?>">Rental Mobil</a></li>
                    <?php
                    $active = '';
                    if ($segment1 == 'paket-wisata') {
                        $active = ' text-primary ';
                    }
                    ?>
                    <li class="nav-item"><a class="nav-link <?= $active ?>" href="<?= base_url('paket-wisata') ?>">Paket Wisata</a></li>
                    <?php
                    $active = '';
                    if ($segment1 == 'kontak') {
                        $active = ' text-primary ';
                    }
                    ?>
                    <li class="nav-item"><a class="nav-link <?= $active ?>" href="<?= base_url('kontak') ?>">Kontak</a></li>
                </ul>

                <!-- Tombol WhatsApp -->
                <a href="<?= get_kontak('whatsapp', 'url') ?>"
                    target="_blank" class="btn btn-whatsapp-nav ms-lg-3 mt-2 mt-lg-0">
                    <i class="fab fa-whatsapp fa-lg"></i>Hubungi Kami
                </a>
            </div>
        </div>
    </nav>




    <?php echo $content ?>



    <div class="container py-5">
        <h2 class="text-center mb-4 fw-bold text-primary">Tiktok</h2>
        <div class="row g-4">

            <div class="col-md-12">
                <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@belmontrans" data-unique-id="belmontrans"
                    data-embed-type="creator" style="max-width: 780px; min-width: 288px;">
                    <section> <a target="_blank"
                            href="https://www.tiktok.com/@belmontrans?refer=creator_embed">@belmontrans</a>
                    </section>
                </blockquote>

            </div>
        </div>
    </div>


    <section class="text-center py-5"
        style="background: rgba(0,0,0,0.4) url('admin/uploads/dashboard.jpg') center/cover no-repeat; color: white;">
        <div class="container">
            <h2 class="fw-bold mb-4">Pesan & Hubungi Kami Sekarang!</h2>
            <a href="<?= get_kontak('whatsapp', 'url') ?>" target="_blank" class="footer-btn">
                <i class="fa-brands fa-whatsapp me-2"></i>Hubungi Kami
            </a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-md-4 footer-logo mb-4 mb-md-0">
                    <img src="logo-belmon-asli.png" alt="Logo Davi">
                </div>

                <div class="col-md-4 mb-4 mb-md-0 text-md-start text-center">
                    <h6><i class="fa-solid fa-location-dot me-2"></i>Alamat</h6>
                    <p class="mb-0">Jl. Palagan Tentara Pelajar No.113C, Sumberan, Sariharjo, Kec. Ngaglik, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55581</p>
                </div>

                <div class="col-md-4 text-md-start text-center">
                    <h6><i class="fa-solid fa-phone me-2"></i>Kontak</h6>
                    <p class="mb-0">Whatsapp: +6281226464209<br>
                        Email: belmontransportjogja@gmail.com</p>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <p class="mb-0">
                    Copyright © 2026 Belmontransport Yogyakarta. All rights reserved.
                    Developed with <i class="fa-solid fa-heart text-danger mx-1"></i> by <a href="https://www.tiktok.com/@bayu_bayu_">@bayu_bayu_</a>
                </p>
            </div>
        </div>
    </footer>



    <script async src="https://www.tiktok.com/embed.js"></script>

    <a href="<?= get_kontak('whatsapp', 'url') ?>" class="whatsapp-float"
        target="_blank" aria-label="Hubungi kami di WhatsApp">
        <i class="fab fa-whatsapp fa-xl"></i>
    </a>
    <!-- Bootstrap JS -->
    <script src="<?= base_url('node_modules/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?= base_url('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('node_modules/@fortawesome/fontawesome-free/js/all.min.js') ?>"></script>
    <script src="<?= base_url('node_modules/aos/dist/aos.js') ?>"></script>
    <script>
        AOS.init({
            duration: 800, // durasi animasi
            once: true // animasi hanya sekali
        });
    </script>
</body>

</html>