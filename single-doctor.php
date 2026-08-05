<?php
/**
 * Single Doctor Template
 *
 * @package Alya_Esthetic
 */

get_header();
?>

<?php while (have_posts()) : the_post(); ?>

<?php alya_breadcrumbs(); ?>

<article id="doctor-<?php the_ID(); ?>" <?php post_class('doctor-single'); ?>>

    <div class="container">
        <div class="doctor-single__layout">
            <!-- Profile Card -->
            <div class="doctor-single__profile">
                <div class="doctor-card">
                    <?php
                    $avatar = get_field('alya_avatar');
                    ?>
                    <div class="doctor-card__image">
                        <?php if ($avatar && is_array($avatar)) : ?>
                            <img src="<?php echo esc_url($avatar['url']); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" width="400" height="400" loading="eager">
                        <?php else : ?>
                            <?php echo get_the_post_thumbnail(get_the_ID(), 'full'); ?>
                        <?php endif; ?>
                    </div>
                    <div class="doctor-card__body">
                        <h1 class="doctor-card__name"><?php the_title(); ?></h1>
                        <?php if (get_field('alya_position')) : ?>
                            <p class="doctor-card__position"><?php echo esc_html(get_field('alya_position')); ?></p>
                        <?php endif; ?>
                        <?php if (get_field('alya_credentials')) : ?>
                            <p class="doctor-card__credentials"><?php echo esc_html(get_field('alya_credentials')); ?></p>
                        <?php endif; ?>

                        <div class="doctor-card__actions">
                            <a href="<?php echo esc_url(alya_wa_link('Halo, saya ingin appointment dengan ' . get_the_title())); ?>" class="btn btn--wa btn--full" target="_blank" rel="noopener noreferrer">
                                <?php echo alya_icon('whatsapp'); ?>
                                Buat Janji
                            </a>
                            <a href="tel:<?php echo esc_attr(get_theme_mod('alya_phone_link', '6281290000000')); ?>" class="btn btn--primary btn--full">
                                <?php echo alya_icon('phone'); ?>
                                Telepon
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details -->
            <div class="doctor-single__details">

                <!-- About -->
                <section class="detail-section">
                    <h2>Tentang Dokter</h2>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </section>

                <!-- Education -->
                <?php
                $education = get_field('alya_education');
                if ($education) :
                ?>
                    <section class="detail-section">
                        <h2>Pendidikan</h2>
                        <div class="timeline">
                            <?php foreach ($education as $edu) : ?>
                                <div class="timeline__item">
                                    <div class="timeline__marker"></div>
                                    <div class="timeline__content">
                                        <h3><?php echo esc_html($edu['degree']); ?></h3>
                                        <p><?php echo esc_html($edu['school']); ?></p>
                                        <span class="timeline__year"><?php echo esc_html($edu['year']); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Experience -->
                <?php
                $experience = get_field('alya_experience');
                if ($experience) :
                ?>
                    <section class="detail-section">
                        <h2>Pengalaman</h2>
                        <div class="timeline">
                            <?php foreach ($experience as $exp) : ?>
                                <div class="timeline__item">
                                    <div class="timeline__marker"></div>
                                    <div class="timeline__content">
                                        <h3><?php echo esc_html($exp['role']); ?></h3>
                                        <p><?php echo esc_html($exp['place']); ?></p>
                                        <span class="timeline__year"><?php echo esc_html($exp['year']); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Services -->
                <?php
                $services = get_field('alya_services');
                if ($services) :
                ?>
                    <section class="detail-section">
                        <h2>Layanan</h2>
                        <div class="cards-grid cards-grid--2">
                            <?php foreach ($services as $svc) : ?>
                                <?php alya_card([
                                    'title' => $svc->post_title,
                                    'desc'  => wp_trim_words($svc->post_excerpt ?: $svc->post_content, 15),
                                    'link'  => get_permalink($svc->ID),
                                    'class' => 'card--compact',
                                ]); ?>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Schedule -->
                <?php
                $schedule = get_field('alya_schedule');
                if ($schedule) :
                ?>
                    <section class="detail-section">
                        <h2>Jadwal Praktik</h2>
                        <div class="schedule-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Hari</th>
                                        <th>Jam</th>
                                        <th>Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($schedule as $sched) : ?>
                                        <tr>
                                            <td><?php echo esc_html($sched['day']); ?></td>
                                            <td><?php echo esc_html($sched['hours']); ?></td>
                                            <td><?php echo esc_html($sched['location']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Share -->
                <?php alya_social_share(); ?>
            </div>
        </div>
    </div>
</article>

<?php endwhile; ?>

<?php get_footer();
