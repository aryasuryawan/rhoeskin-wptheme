<?php
/**
 * 404 Page Template
 *
 * @package Alya_Esthetic
 */

get_header();
?>

<section class="error-404">
    <div class="container">
        <div class="error-404__content">
            <h1 class="error-404__title">404</h1>
            <h2 class="error-404__subtitle">Halaman Tidak Ditemukan</h2>
            <p class="error-404__desc">Sepertinya halaman yang Anda cari sudah tidak tersedia atau dipindahkan.</p>
            <div class="error-404__actions">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary">
                    Kembali ke Beranda
                    <?php echo alya_icon('arrow-right'); ?>
                </a>
                <a href="<?php echo esc_url(alya_wa_link('Halo, saya kesulitan menemukan halaman di website Anda.')); ?>" class="btn btn--wa" target="_blank" rel="noopener noreferrer">
                    <?php echo alya_icon('whatsapp'); ?>
                    Hubungi Kami
                </a>
            </div>

            <!-- Search Form -->
            <div class="error-404__search">
                <h3>Atau Coba Cari:</h3>
                <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="search-form__row">
                        <input type="search" name="s" placeholder="Ketik kata kunci..." class="search-form__input">
                        <button type="submit" class="btn btn--primary">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php get_footer();
