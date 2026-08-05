<?php
/**
 * Career Strip — Job CTA bar
 *
 * @package Alya_Esthetic
 */

$title = get_theme_mod('alya_v2_career_title', 'Ingin Berkarir Bersama Kami?');
$desc  = get_theme_mod('alya_v2_career_desc', 'Lihat lowongan yang tersedia di Alya Esthetic Center.');
$jobs_url = get_post_type_archive_link('jobs');
?>

<div class="career-strip">
    <div class="container">
        <div>
            <h3><?php echo esc_html($title); ?></h3>
            <p><?php echo esc_html($desc); ?></p>
        </div>
        <a class="btn" href="<?php echo esc_url($jobs_url); ?>">Lihat Lowongan</a>
    </div>
</div>
