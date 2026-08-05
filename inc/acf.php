<?php
/**
 * ACF Field Groups
 *
 * @package Alya_Esthetic
 */

defined('ABSPATH') || exit;

if (!function_exists('acf_add_local_field_group')) {
    return;
}

/**
 * Field Group: Homepage
 */
acf_add_local_field_group([
    'key'      => 'group_alya_homepage',
    'title'    => 'Homepage Settings',
    'fields'   => [
        [
            'key'          => 'field_alya_home_hero_bg',
            'label'        => 'Hero Background Image',
            'name'         => 'alya_hero_bg',
            'type'         => 'image',
            'return_format' => 'array',
            'preview_size'  => 'medium',
            'mime_types'    => 'jpg,jpeg,png,webp',
        ],
        [
            'key'   => 'field_alya_home_hero_title',
            'label' => 'Hero Title',
            'name'  => 'alya_hero_title',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_alya_home_hero_subtitle',
            'label' => 'Hero Subtitle',
            'name'  => 'alya_hero_subtitle',
            'type'  => 'textarea',
            'rows'  => 3,
        ],
        [
            'key'          => 'field_alya_home_hero_cta',
            'label'        => 'Hero CTA Button',
            'name'         => 'alya_hero_cta',
            'type'         => 'link',
            'return_format' => 'array',
        ],
        [
            'key'   => 'field_alya_home_services_title',
            'label' => 'Layanan Section Title',
            'name'  => 'alya_services_title',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_alya_home_services_subtitle',
            'label' => 'Layanan Section Subtitle',
            'name'  => 'alya_services_subtitle',
            'type'  => 'textarea',
            'rows'  => 2,
        ],
        [
            'key'          => 'field_alya_home_services',
            'label'        => 'Layanan Highlight',
            'name'         => 'alya_home_services',
            'type'         => 'relationship',
            'post_type'    => ['service'],
            'filters'      => ['search'],
            'max'          => 6,
            'return_format' => 'object',
        ],
        [
            'key'   => 'field_alya_home_about_title',
            'label' => 'About Section Title',
            'name'  => 'alya_about_title',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_alya_home_about_desc',
            'label' => 'About Description',
            'name'  => 'alya_about_desc',
            'type'  => 'wysiwyg',
            'tabs'  => 'visual',
            'toolbar' => 'basic',
        ],
        [
            'key'          => 'field_alya_home_about_image',
            'label'        => 'About Image',
            'name'         => 'alya_about_image',
            'type'         => 'image',
            'return_format' => 'array',
        ],
        [
            'key'   => 'field_alya_home_stats',
            'label' => 'Statistics',
            'name'  => 'alya_home_stats',
            'type'  => 'repeater',
            'layout' => 'table',
            'button_label' => 'Tambah Statistik',
            'sub_fields'   => [
                ['key' => 'field_alya_stat_number', 'label' => 'Number', 'name' => 'number', 'type' => 'text', 'wrapper' => ['width' => 30]],
                ['key' => 'field_alya_stat_suffix', 'label' => 'Suffix', 'name' => 'suffix', 'type' => 'text', 'wrapper' => ['width' => 30]],
                ['key' => 'field_alya_stat_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text', 'wrapper' => ['width' => 40]],
            ],
        ],
        [
            'key'          => 'field_alya_home_doctors_title',
            'label' => 'Doctors Section Title',
            'name'  => 'alya_doctors_title',
            'type'  => 'text',
        ],
        [
            'key'          => 'field_alya_home_doctors',
            'label'        => 'Doctors Highlight',
            'name'         => 'alya_home_doctors',
            'type'         => 'relationship',
            'post_type'    => ['doctor'],
            'filters'      => ['search'],
            'max'          => 4,
            'return_format' => 'object',
        ],
        [
            'key'   => 'field_alya_home_testimonials_title',
            'label' => 'Testimonials Section Title',
            'name'  => 'alya_testimonials_title',
            'type'  => 'text',
        ],
        [
            'key'          => 'field_alya_home_testimonials',
            'label'        => 'Testimonials Highlight',
            'name'         => 'alya_home_testimonials',
            'type'         => 'relationship',
            'post_type'    => ['testimonial'],
            'filters'      => ['search'],
            'max'          => 6,
            'return_format' => 'object',
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'page_type',
                'operator' => '==',
                'value'    => 'front_page',
            ],
        ],
    ],
    'position'        => 'normal',
    'style'           => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'active'          => true,
]);

/**
 * Field Group: Services
 */
acf_add_local_field_group([
    'key'    => 'group_alya_service',
    'title'  => 'Service Details',
    'fields' => [
        [
            'key'   => 'field_alya_svc_subtitle',
            'label' => 'Subtitle',
            'name'  => 'alya_subtitle',
            'type'  => 'text',
        ],
        [
            'key'          => 'field_alya_svc_icon',
            'label'        => 'Icon',
            'name'         => 'alya_icon',
            'type'         => 'image',
            'return_format' => 'array',
            'preview_size'  => 'thumbnail',
        ],
        [
            'key'   => 'field_alya_svc_benefits',
            'label' => 'Benefits',
            'name'  => 'alya_benefits',
            'type'  => 'repeater',
            'layout' => 'block',
            'button_label' => 'Tambah Benefit',
            'sub_fields'   => [
                ['key' => 'field_alya_benefit_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                ['key' => 'field_alya_benefit_desc', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 3],
            ],
        ],
        [
            'key'   => 'field_alya_svc_process',
            'label' => 'Treatment Process',
            'name'  => 'alya_process',
            'type'  => 'repeater',
            'layout' => 'block',
            'button_label' => 'Tambah Langkah',
            'sub_fields'   => [
                ['key' => 'field_alya_process_step', 'label' => 'Step Number', 'name' => 'step', 'type' => 'number', 'wrapper' => ['width' => 20]],
                ['key' => 'field_alya_process_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text', 'wrapper' => ['width' => 80]],
                ['key' => 'field_alya_process_desc', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 2],
            ],
        ],
        [
            'key'   => 'field_alya_svc_gallery',
            'label' => 'Gallery',
            'name'  => 'alya_gallery',
            'type'  => 'gallery',
            'return_format' => 'array',
            'preview_size'  => 'thumbnail',
            'library'       => 'all',
            'min'           => 1,
            'max'           => 12,
        ],
        [
            'key'   => 'field_alya_svc_faqs',
            'label' => 'FAQs',
            'name'  => 'alya_faqs',
            'type'  => 'repeater',
            'layout' => 'block',
            'button_label' => 'Tambah FAQ',
            'sub_fields'   => [
                ['key' => 'field_alya_faq_q', 'label' => 'Question', 'name' => 'question', 'type' => 'text'],
                ['key' => 'field_alya_faq_a', 'label' => 'Answer', 'name' => 'answer', 'type' => 'textarea', 'rows' => 3],
            ],
        ],
        [
            'key'          => 'field_alya_svc_related',
            'label'        => 'Related Services',
            'name'         => 'alya_related',
            'type'         => 'relationship',
            'post_type'    => ['service'],
            'filters'      => ['search'],
            'max'          => 3,
            'return_format' => 'object',
        ],
    ],
    'location' => [
        [
            ['param' => 'post_type', 'operator' => '==', 'value' => 'service'],
        ],
    ],
    'position'        => 'normal',
    'style'           => 'default',
    'label_placement' => 'top',
    'active'          => true,
]);

/**
 * Field Group: Doctor
 */
acf_add_local_field_group([
    'key'    => 'group_alya_doctor',
    'title'  => 'Doctor Details',
    'fields' => [
        [
            'key'   => 'field_alya_doc_position',
            'label' => 'Position / Specialty',
            'name'  => 'alya_position',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_alya_doc_credentials',
            'label' => 'Credentials',
            'name'  => 'alya_credentials',
            'type'  => 'textarea',
            'rows'  => 3,
            'description' => 'Contoh: MD, FAAD, Spesialis Kulit dan Kelamin',
        ],
        [
            'key'   => 'field_alya_doc_education',
            'label' => 'Education',
            'name'  => 'alya_education',
            'type'  => 'repeater',
            'layout' => 'table',
            'button_label' => 'Tambah Pendidikan',
            'sub_fields'   => [
                ['key' => 'field_alya_edu_degree', 'label' => 'Degree', 'name' => 'degree', 'type' => 'text', 'wrapper' => ['width' => 40]],
                ['key' => 'field_alya_edu_school', 'label' => 'School', 'name' => 'school', 'type' => 'text', 'wrapper' => ['width' => 40]],
                ['key' => 'field_alya_edu_year', 'label' => 'Year', 'name' => 'year', 'type' => 'text', 'wrapper' => ['width' => 20]],
            ],
        ],
        [
            'key'   => 'field_alya_doc_experience',
            'label' => 'Experience',
            'name'  => 'alya_experience',
            'type'  => 'repeater',
            'layout' => 'table',
            'button_label' => 'Tambah Pengalaman',
            'sub_fields'   => [
                ['key' => 'field_alya_exp_role', 'label' => 'Role', 'name' => 'role', 'type' => 'text', 'wrapper' => ['width' => 40]],
                ['key' => 'field_alya_exp_place', 'label' => 'Place', 'name' => 'place', 'type' => 'text', 'wrapper' => ['width' => 40]],
                ['key' => 'field_alya_exp_year', 'label' => 'Year', 'name' => 'year', 'type' => 'text', 'wrapper' => ['width' => 20]],
            ],
        ],
        [
            'key'          => 'field_alya_doc_services',
            'label'        => 'Services Offered',
            'name'         => 'alya_services',
            'type'         => 'relationship',
            'post_type'    => ['service'],
            'filters'      => ['search'],
            'return_format' => 'object',
        ],
        [
            'key'   => 'field_alya_doc_schedule',
            'label' => 'Practice Schedule',
            'name'  => 'alya_schedule',
            'type'  => 'repeater',
            'layout' => 'table',
            'button_label' => 'Tambah Jadwal',
            'sub_fields'   => [
                ['key' => 'field_alya_sched_day', 'label' => 'Day', 'name' => 'day', 'type' => 'text', 'wrapper' => ['width' => 30]],
                ['key' => 'field_alya_sched_hours', 'label' => 'Hours', 'name' => 'hours', 'type' => 'text', 'wrapper' => ['width' => 30]],
                ['key' => 'field_alya_sched_location', 'label' => 'Location', 'name' => 'location', 'type' => 'text', 'wrapper' => ['width' => 40]],
            ],
        ],
        [
            'key'          => 'field_alya_doc_avatar',
            'label'        => 'Avatar (Square)',
            'name'         => 'alya_avatar',
            'type'         => 'image',
            'return_format' => 'array',
            'preview_size'  => 'thumbnail',
        ],
    ],
    'location' => [
        [
            ['param' => 'post_type', 'operator' => '==', 'value' => 'doctor'],
        ],
    ],
    'position'        => 'normal',
    'style'           => 'default',
    'label_placement' => 'top',
    'active'          => true,
]);

/**
 * Field Group: Testimonial
 */
acf_add_local_field_group([
    'key'    => 'group_alya_testimonial',
    'title'  => 'Testimonial Details',
    'fields' => [
        [
            'key'   => 'field_alya_test_role',
            'label' => 'Role / Profession',
            'name'  => 'alya_role',
            'type'  => 'text',
        ],
        [
            'key'     => 'field_alya_test_rating',
            'label'   => 'Rating (1-5)',
            'name'    => 'alya_rating',
            'type'    => 'range',
            'min'     => 1,
            'max'     => 5,
            'step'    => 1,
            'default_value' => 5,
        ],
        [
            'key'   => 'field_alya_test_service',
            'label' => 'Service Used',
            'name'  => 'alya_service_used',
            'type'  => 'text',
        ],
        [
            'key'          => 'field_alya_test_before',
            'label'        => 'Before Photo',
            'name'         => 'alya_before',
            'type'         => 'image',
            'return_format' => 'array',
            'preview_size'  => 'thumbnail',
        ],
        [
            'key'          => 'field_alya_test_after',
            'label'        => 'After Photo',
            'name'         => 'alya_after',
            'type'         => 'image',
            'return_format' => 'array',
            'preview_size'  => 'thumbnail',
        ],
    ],
    'location' => [
        [
            ['param' => 'post_type', 'operator' => '==', 'value' => 'testimonial'],
        ],
    ],
    'position'        => 'normal',
    'style'           => 'default',
    'label_placement' => 'top',
    'active'          => true,
]);

/**
 * Field Group: Jobs
 */
acf_add_local_field_group([
    'key'    => 'group_alya_jobs',
    'title'  => 'Job Details',
    'fields' => [
        [
            'key'   => 'field_alya_job_location',
            'label' => 'Location',
            'name'  => 'alya_location',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_alya_job_salary',
            'label' => 'Salary Range',
            'name'  => 'alya_salary',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_alya_job_requirements',
            'label' => 'Requirements',
            'name'  => 'alya_requirements',
            'type'  => 'wysiwyg',
            'tabs'  => 'visual',
            'toolbar' => 'basic',
        ],
        [
            'key'   => 'field_alya_job_responsibilities',
            'label' => 'Responsibilities',
            'name'  => 'alya_responsibilities',
            'type'  => 'wysiwyg',
            'tabs'  => 'visual',
            'toolbar' => 'basic',
        ],
        [
            'key'   => 'field_alya_job_benefits',
            'label' => 'Benefits',
            'name'  => 'alya_job_benefits',
            'type'  => 'wysiwyg',
            'tabs'  => 'visual',
            'toolbar' => 'basic',
        ],
        [
            'key'     => 'field_alya_job_deadline',
            'label'   => 'Application Deadline',
            'name'    => 'alya_deadline',
            'type'    => 'date_picker',
            'display_format' => 'd/m/Y',
            'return_format'  => 'Y-m-d',
        ],
        [
            'key'          => 'field_alya_job_apply_link',
            'label'        => 'External Apply Link',
            'name'         => 'alya_apply_link',
            'type'         => 'url',
            'description'  => 'If set, CTA goes to external URL instead of internal form.',
        ],
    ],
    'location' => [
        [
            ['param' => 'post_type', 'operator' => '==', 'value' => 'jobs'],
        ],
    ],
    'position'        => 'normal',
    'style'           => 'default',
    'label_placement' => 'top',
    'active'          => true,
]);

/**
 * Field Group: Treatment
 */
acf_add_local_field_group([
    'key'    => 'group_alya_treatment',
    'title'  => 'Treatment Details',
    'fields' => [
        [
            'key'   => 'field_alya_tr_subtitle',
            'label' => 'Subtitle',
            'name'  => 'alya_subtitle',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_alya_tr_price',
            'label' => 'Starting Price',
            'name'  => 'alya_price',
            'type'  => 'text',
            'description' => 'Contoh: Rp 500.000',
        ],
        [
            'key'   => 'field_alya_tr_duration',
            'label' => 'Duration',
            'name'  => 'alya_duration',
            'type'  => 'text',
            'description' => 'Contoh: 60 menit',
        ],
        [
            'key'   => 'field_alya_tr_benefits',
            'label' => 'Benefits',
            'name'  => 'alya_benefits',
            'type'  => 'repeater',
            'layout' => 'block',
            'button_label' => 'Tambah Benefit',
            'sub_fields'   => [
                ['key' => 'field_alya_trb_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                ['key' => 'field_alya_trb_desc', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 3],
            ],
        ],
        [
            'key'   => 'field_alya_tr_process',
            'label' => 'Treatment Process',
            'name'  => 'alya_process',
            'type'  => 'repeater',
            'layout' => 'block',
            'button_label' => 'Tambah Langkah',
            'sub_fields'   => [
                ['key' => 'field_alya_trp_step', 'label' => 'Step Number', 'name' => 'step', 'type' => 'number', 'wrapper' => ['width' => 20]],
                ['key' => 'field_alya_trp_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text', 'wrapper' => ['width' => 80]],
                ['key' => 'field_alya_trp_desc', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 2],
            ],
        ],
        [
            'key'   => 'field_alya_tr_gallery',
            'label' => 'Gallery',
            'name'  => 'alya_gallery',
            'type'  => 'gallery',
            'return_format' => 'array',
            'preview_size'  => 'thumbnail',
            'min'           => 1,
            'max'           => 12,
        ],
        [
            'key'   => 'field_alya_tr_faqs',
            'label' => 'FAQs',
            'name'  => 'alya_faqs',
            'type'  => 'repeater',
            'layout' => 'block',
            'button_label' => 'Tambah FAQ',
            'sub_fields'   => [
                ['key' => 'field_alya_trfq_q', 'label' => 'Question', 'name' => 'question', 'type' => 'text'],
                ['key' => 'field_alya_trfq_a', 'label' => 'Answer', 'name' => 'answer', 'type' => 'textarea', 'rows' => 3],
            ],
        ],
        [
            'key'          => 'field_alya_tr_related',
            'label'        => 'Related Treatments',
            'name'         => 'alya_related',
            'type'         => 'relationship',
            'post_type'    => ['treatment'],
            'filters'      => ['search'],
            'max'          => 3,
            'return_format' => 'object',
        ],
    ],
    'location' => [
        [
            ['param' => 'post_type', 'operator' => '==', 'value' => 'treatment'],
        ],
    ],
    'position'        => 'normal',
    'style'           => 'default',
    'label_placement' => 'top',
    'active'          => true,
]);

/**
 * Field Group: Pages (Galeri, Teknologi, Tentang)
 */
acf_add_local_field_group([
    'key'    => 'group_alya_pages',
    'title'  => 'Page Settings',
    'fields' => [
        [
            'key'   => 'field_alya_page_hero_bg',
            'label' => 'Hero Background Image',
            'name'  => 'alya_hero_bg',
            'type'  => 'image',
            'return_format' => 'array',
        ],
        [
            'key'   => 'field_alya_page_hero_title',
            'label' => 'Hero Title',
            'name'  => 'alya_hero_title',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_alya_page_hero_subtitle',
            'label' => 'Hero Subtitle',
            'name'  => 'alya_hero_subtitle',
            'type'  => 'textarea',
            'rows'  => 3,
        ],
        [
            'key'   => 'field_alya_gallery_images',
            'label' => 'Gallery Images',
            'name'  => 'alya_gallery_images',
            'type'  => 'gallery',
            'return_format' => 'array',
            'preview_size'  => 'thumbnail',
            'library'       => 'all',
        ],
        [
            'key'   => 'field_alya_tech_items',
            'label' => 'Technology Items',
            'name'  => 'alya_tech_items',
            'type'  => 'repeater',
            'layout' => 'block',
            'button_label' => 'Tambah Technology',
            'sub_fields'   => [
                ['key' => 'field_alya_techi_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                ['key' => 'field_alya_techi_desc', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 3],
                ['key' => 'field_alya_techi_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array'],
                ['key' => 'field_alya_techi_icon', 'label' => 'Icon', 'name' => 'icon', 'type' => 'text'],
            ],
        ],
    ],
    'location' => [
        [
            ['param' => 'page_template', 'operator' => '==', 'value' => 'page-gallery.php'],
        ],
        [
            ['param' => 'page_template', 'operator' => '==', 'value' => 'page-technology.php'],
        ],
        [
            ['param' => 'page_template', 'operator' => '==', 'value' => 'page-about.php'],
        ],
    ],
    'position'        => 'normal',
    'style'           => 'default',
    'label_placement' => 'top',
    'active'          => true,
]);
