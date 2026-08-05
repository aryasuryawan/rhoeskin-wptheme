<?php
/**
 * Single Job Template — Karir Detail
 *
 * @package Alya_Esthetic
 */

get_header();
?>

<?php while (have_posts()) : the_post(); ?>

<?php alya_breadcrumbs(); ?>

<article id="job-<?php the_ID(); ?>" <?php post_class('job-single'); ?>>

    <div class="container">
        <div class="job-single__layout">
            <!-- Main -->
            <div class="job-single__main">

                <!-- Header -->
                <header class="job-single__header">
                    <?php
                    $terms = get_the_terms(get_the_ID(), 'job_type');
                    if ($terms && !is_wp_error($terms)) :
                    ?>
                        <span class="badge badge--primary"><?php echo esc_html($terms[0]->name); ?></span>
                    <?php endif; ?>
                    <h1 class="job-single__title"><?php the_title(); ?></h1>
                    <div class="job-single__meta">
                        <?php if (get_field('alya_location')) : ?>
                            <span class="meta-item">
                                <?php echo alya_icon('pin'); ?>
                                <?php echo esc_html(get_field('alya_location')); ?>
                            </span>
                        <?php endif; ?>
                        <?php if (get_field('alya_salary')) : ?>
                            <span class="meta-item">
                                <?php echo alya_icon('calendar'); ?>
                                <?php echo esc_html(get_field('alya_salary')); ?>
                            </span>
                        <?php endif; ?>
                        <?php if (get_field('alya_deadline')) : ?>
                            <span class="meta-item">
                                <?php echo alya_icon('clock'); ?>
                                Deadline: <?php echo esc_html(date('d M Y', strtotime(get_field('alya_deadline')))); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </header>

                <!-- Responsibilities -->
                <?php if (get_field('alya_responsibilities')) : ?>
                    <section class="job-section">
                        <h2>Tanggung Jawab</h2>
                        <div class="entry-content">
                            <?php the_field('alya_responsibilities'); ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Requirements -->
                <?php if (get_field('alya_requirements')) : ?>
                    <section class="job-section">
                        <h2>Persyaratan</h2>
                        <div class="entry-content">
                            <?php the_field('alya_requirements'); ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Benefits -->
                <?php if (get_field('alya_job_benefits')) : ?>
                    <section class="job-section">
                        <h2>Benefits</h2>
                        <div class="entry-content">
                            <?php the_field('alya_job_benefits'); ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Description -->
                <section class="job-section">
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </section>

                <?php alya_social_share(); ?>
            </div>

            <!-- Sidebar -->
            <aside class="job-single__sidebar">
                <div class="sidebar-sticky">
                    <!-- Apply Card -->
                    <div class="sidebar-card">
                        <h3 class="sidebar-card__title">Lamar Sekarang</h3>

                        <?php
                        $apply_link = get_field('alya_apply_link');
                        if ($apply_link) :
                        ?>
                            <a href="<?php echo esc_url($apply_link); ?>" class="btn btn--primary btn--full" target="_blank" rel="noopener noreferrer">
                                Lamar Via Link
                                <?php echo alya_icon('arrow-right'); ?>
                            </a>
                        <?php else : ?>
                            <form id="job-apply-form" class="apply-form" enctype="multipart/form-data">
                                <?php wp_nonce_field('alya_nonce', 'nonce'); ?>
                                <input type="hidden" name="action" value="alya_job_apply">
                                <input type="hidden" name="job_id" value="<?php echo esc_attr(get_the_ID()); ?>">

                                <?php alya_form_field(['type' => 'text', 'name' => 'applicant_name', 'label' => 'Nama Lengkap', 'required' => true, 'placeholder' => 'Masukkan nama lengkap']); ?>
                                <?php alya_form_field(['type' => 'email', 'name' => 'applicant_email', 'label' => 'Email', 'required' => true, 'placeholder' => 'email@contoh.com']); ?>
                                <?php alya_form_field(['type' => 'tel', 'name' => 'applicant_phone', 'label' => 'Telepon', 'placeholder' => '+62 812-xxxx-xxxx']); ?>
                                <?php alya_form_field(['type' => 'textarea', 'name' => 'applicant_message', 'label' => 'Pesan (Opsional)', 'placeholder' => 'Ceritakan mengapa Anda cocok untuk posisi ini...']); ?>
                                <?php alya_form_field(['type' => 'file', 'name' => 'applicant_cv', 'label' => 'Upload CV (PDF/DOC)', 'required' => true]); ?>

                                <button type="submit" class="btn btn--primary btn--full">
                                    Kirim Lamaran
                                </button>
                            </form>
                            <div id="apply-response" class="apply-response" style="display:none;"></div>
                        <?php endif; ?>
                    </div>

                    <!-- Share -->
                    <div class="sidebar-card">
                        <h3 class="sidebar-card__title">Bagikan Lowongan</h3>
                        <?php alya_social_share(); ?>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</article>

<?php endwhile; ?>

<?php get_footer();
