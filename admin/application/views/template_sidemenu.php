<?php
$segment1 = segment_uri(1);
$segment2 = segment_uri(2);
$segment3 = segment_uri(3);
?>


<?php
$active = "";
if ($segment1 == '' || $segment1 == 'home') {
    $active = ' active ';
}
?>
<li class="nav-item">
    <a href="<?= base_url('home') ?>" class="nav-link <?= $active ?>">
        <!-- <i class="far fa-circle"></i> -->
        <i class="fas fa-home"></i>
        <p>Beranda</p>
    </a>
</li>

<?php
$active = "";
if ($segment1 == 'baner') {
    $active = ' active ';
}
?>
<li class="nav-item">
    <a href="<?=base_url('baner')?>" class="nav-link  <?= $active ?>">
        <!-- <i class="far fa-circle"></i> -->
        <i class="fas fa-tv"></i>
        <p>Baner</p>
    </a>
</li>

<?php
$active = "";
if ($segment1 == 'kendaraan') {
    $active = ' active ';
}
?>
<li class="nav-item">
    <a href="<?=base_url('kendaraan')?>" class="nav-link  <?= $active ?>">
        <!-- <i class="far fa-circle"></i> -->
        <i class="fas fa-car"></i>
        <p>Kendaraan</p>
    </a>
</li>


<?php
$active = "";
if ($segment1 == 'paket_wisata') {
    $active = ' active ';
}
?>
<li class="nav-item">
    <a href="<?=base_url('paket_wisata')?>" class="nav-link  <?= $active ?>">
        <!-- <i class="far fa-circle"></i> -->
        <i class="fas fa-map-marked-alt"></i>
        <p>Paket Wisata</p>
    </a>
</li>


<?php
$active = "";
if ($segment1 == 'kontak') {
    $active = ' active ';
}
?>
<li class="nav-item">
    <a href="<?=base_url('kontak')?>" class="nav-link  <?= $active ?>">
        <!-- <i class="far fa-circle"></i> -->
        <i class="fas fa-address-book"></i>
        <p>Kontak</p>
    </a>
</li>



<?php
$active = "";
if ($segment1 == 'zuser') {
    $active = ' active ';
}
?>
<li class="nav-item">
    <a href="<?= base_url('zuser') ?>" class="nav-link <?= $active ?>">
        <i class="fas fa-users"></i>
        <p>User</p>
    </a>
</li>


<script>
    $('.sidebar').scroll(function() {
        // Code to execute when the element is scrolled
        var scrollYPosition = $('.sidebar').scrollTop();
        //console.log(scrollYPosition);

        localStorage.setItem('sidebarYposition', scrollYPosition);
    });

    $(document).ready(function() {
        var scrollYPosition = localStorage.getItem('sidebarYposition');
        $('.sidebar').scrollTop(scrollYPosition);
    });
</script>