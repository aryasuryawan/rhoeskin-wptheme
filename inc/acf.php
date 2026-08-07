<?php
/**
 * ACF Field Groups — ACF Free compatible (no repeater/gallery)
 *
 * Repeater fields replaced with textarea (pipe-delimited):
 *   Title | Description
 *   Title | Description
 *
 * Gallery fields replaced with relationship (attachments).
 *
 * @package Alya_Esthetic
 */

defined('ABSPATH') || exit;

if (!function_exists('acf_add_local_field_group')) {
    return;
}

/* ================================================================
 * FIELD GROUP: Homepage
 * ================================================================ */
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
            'label' => 'Statistics (one per line: Number | Suffix | Label)',
            'name'  => 'alya_home_stats',
            'type'  => 'textarea',
            'rows'  => 4,
            'instructions' => 'Format: 10+ | Tahun Pengalaman — one stat per line.',
        ],
        [
            'key'   => 'field_alya_home_doctors_title',
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

/* ================================================================
 * FIELD GROUP: Service
 * ================================================================ */
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
            'key'          => 'field_alya_svc_benefits',
            'label'        => 'Benefits (one per line: Title | Description)',
            'name'         => 'alya_benefits',
            'type'         => 'repeater',
            'instructions' => 'Tambah satu manfaat per baris.',
            'button_label' => '+ Tambah Manfaat',
            'layout'       => 'table',
            'min'          => 0,
            'max'          => 10,
            'sub_fields'   => [
                [
                    'key'          => 'field_alya_svc_benefit_title',
                    'label'        => 'Judul Manfaat',
                    'name'         => 'title',
                    'type'         => 'text',
                    'placeholder'  => 'Contoh: Cerah Seketika',
                    'column_width' => '30',
                ],
                [
                    'key'          => 'field_alya_svc_benefit_desc',
                    'label'        => 'Deskripsi',
                    'name'         => 'description',
                    'type'         => 'textarea',
                    'rows'         => 2,
                    'placeholder'  => 'Contoh: Kulit tampak lebih cerah dan halus setelah satu sesi.',
                    'column_width' => '70',
                ],
            ],
        ],
        [
            'key'          => 'field_alya_svc_process',
            'label'        => 'Treatment Process (one per line: Step# | Title | Description)',
            'name'         => 'alya_process',
            'type'         => 'repeater',
            'instructions' => 'Tambah langkah proses per baris.',
            'button_label' => '+ Tambah Langkah',
            'layout'       => 'table',
            'min'          => 0,
            'max'          => 20,
            'sub_fields'   => [
                [
                    'key'          => 'field_alya_svc_process_step',
                    'label'        => 'Langkah #',
                    'name'         => 'step',
                    'type'         => 'number',
                    'placeholder'  => 'Contoh: 1',
                    'column_width' => '10',
                ],
                [
                    'key'          => 'field_alya_svc_process_title',
                    'label'        => 'Judul Langkah',
                    'name'         => 'title',
                    'type'         => 'text',
                    'placeholder'  => 'Contoh: Konsultasi',
                    'column_width' => '30',
                ],
                [
                    'key'          => 'field_alya_svc_process_desc',
                    'label'        => 'Deskripsi',
                    'name'         => 'description',
                    'type'         => 'textarea',
                    'rows'         => 2,
                    'placeholder'  => 'Contoh: Dokter memeriksa kondisi kulit...',
                    'column_width' => '60',
                ],
            ],
        ],
        [
            'key'          => 'field_alya_svc_gallery',
            'label'        => 'Gallery',
            'name'         => 'alya_gallery',
            'type'         => 'relationship',
            'post_type'    => ['attachment'],
            'filters'      => ['search'],
            'min'          => 1,
            'max'          => 12,
            'return_format' => 'array',
        ],
        [
            'key'   => 'field_alya_svc_faqs',
            'label' => 'FAQs (one per line: Question | Answer)',
            'name'  => 'alya_faqs',
            'type'  => 'textarea',
            'rows'  => 6,
            'instructions' => 'Format: Apakah treatment ini sakit? | Tidak, treatment ini nyaman — one FAQ per line.',
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

/* ================================================================
 * FIELD GROUP: Doctor
 * ================================================================ */
acf_add_local_field_group([
    'key'    => 'group_alya_doctor',
    'title'  => 'Doctor Details',
    'fields' => [
        [
            'key'           => 'field_alya_doc_position',
            'label'         => 'Position / Specialty',
            'name'          => 'alya_position',
            'type'          => 'taxonomy',
            'taxonomy'      => 'doctor_category',
            'field_type'    => 'checkbox',
            'allow_null'    => 1,
            'add_term'      => 1,
            'save_terms'    => 1,
            'load_terms'    => 1,
            'return_format' => 'object',
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
            'key'   => 'field_alya_doc_about',
            'label' => 'About / Bio',
            'name'  => 'alya_about',
            'type'  => 'wysiwyg',
            'tabs'  => 'visual',
            'toolbar' => 'basic',
            'instructions' => 'Short biography of the doctor.',
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

/* ================================================================
 * FIELD GROUP: Testimonial
 * ================================================================ */
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

/* ================================================================
 * FIELD GROUP: Pages (Galeri, Teknologi, Tentang)
 * ================================================================ */
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
    ],
    'location' => [
        [
            ['param' => 'page_template', 'operator' => '==', 'value' => 'templates/page-gallery.php'],
        ],
        [
            ['param' => 'page_template', 'operator' => '==', 'value' => 'templates/page-technology.php'],
        ],
        [
            ['param' => 'page_template', 'operator' => '==', 'value' => 'templates/page-about.php'],
        ],
    ],
    'position'        => 'normal',
    'style'           => 'default',
    'label_placement' => 'top',
    'active'          => true,
]);

/* ================================================================
 * FIELD GROUP: Technology page only
 * ================================================================ */
acf_add_local_field_group([
    'key'    => 'group_alya_technology',
    'title'  => 'Technology Settings',
    'fields' => [
        [
            'key'   => 'field_alya_tech_items',
            'label' => 'Technology Items (one per line: Title | Description)',
            'name'  => 'alya_tech_items',
            'type'  => 'textarea',
            'rows'  => 6,
            'instructions' => 'Format: Nd:YAG Laser | Perawatan pigmentasi dan vaskular — one item per line.',
        ],
    ],
    'location' => [
        [
            ['param' => 'page_template', 'operator' => '==', 'value' => 'templates/page-technology.php'],
        ],
    ],
    'position'        => 'normal',
    'style'           => 'default',
    'label_placement' => 'top',
    'active'          => true,
]);

/* ================================================================
 * FIELD GROUP: Gallery page only
 * ================================================================ */
acf_add_local_field_group([
    'key'    => 'group_alya_gallery',
    'title'  => 'Gallery Settings',
    'fields' => [
        [
            'key'   => 'field_alya_gallery_disclaimer',
            'label' => 'Disclaimer (Catatan Penting)',
            'name'  => 'alya_gallery_disclaimer',
            'type'  => 'textarea',
            'rows'  => 4,
            'instructions' => 'Teks catatan penting yang tampil di bagian atas halaman galeri.',
        ],
    ],
    'location' => [
        [
            ['param' => 'page_template', 'operator' => '==', 'value' => 'templates/page-gallery.php'],
        ],
    ],
    'position'        => 'normal',
    'style'           => 'default',
    'label_placement' => 'top',
    'active'          => true,
]);

/* ================================================================
 * Admin Script — Image previews for gallery relationship fields
 * ================================================================ */
add_action('admin_enqueue_scripts', function ($hook) {
    if (!in_array($hook, ['post.php', 'post-new.php', 'edit.php'])) return;
    if (!function_exists('acf_get_field')) return;

    $script = <<<'JS'
(function($){
  if (typeof acf === 'undefined') return;

  var galleryFields = ['field_alya_svc_gallery','field_alya_tr_gallery'];

  function findAcfField($el) {
    var $field = $el.closest('.acf-field');
    if (!$field.length) $field = $el.find('.acf-field').first();
    return $field;
  }

  function addPreview($field) {
    var key = $field.attr('data-key') || $field.data('key');
    if (!key || galleryFields.indexOf(key) === -1) return;

    var $wrap = $field.find('.acf-input');
    if (!$wrap.length) return;

    var previewId = 'alya-preview-' + key;
    if (!$wrap.find('#' + previewId).length) {
      $wrap.append('<div id="' + previewId + '" class="alya-gallery-preview" style="display:flex;flex-wrap:wrap;gap:8px;margin-top:12px;padding:12px;background:#f6f6f6;border:1px dashed #ccc;border-radius:8px;min-height:60px"><span style="color:#999;font-size:13px;width:100%">Preview gambar akan muncul di sini...</span></div>');
    }
    refreshPreview($field, $wrap.find('#' + previewId));
  }

  function refreshPreview($field, $preview) {
    var $input = $field.find('.acf-input');
    var $selected = $input.find('.values .cloned, .values .ui-sortable-handle, .acf_relationship .values li');
    var $list = $input.find('input[type="hidden"]');
    var ids = [];

    $list.each(function() {
      var v = $(this).val();
      if (v && v !== '' && ids.indexOf(v) === -1) ids.push(v);
    });

    // fallback: check selected li values
    if (!ids.length) {
      $input.find('.acf_relationship .selected li, .acf_relationship .values li').each(function() {
        var v = $(this).data('id');
        if (v) ids.push(String(v));
      });
    }

    if (!ids.length) {
      $preview.html('<span style="color:#999;font-size:13px;width:100%">Belum ada gambar dipilih.</span>');
      return;
    }

    $preview.html('');
    ids.forEach(function(id) {
      wp.ajax.post('alya_get_attachment_preview', { id: id }).done(function(res) {
        if (res.success && res.data.url) {
          $preview.append(
            '<div style="position:relative;width:120px;height:90px;border-radius:8px;overflow:hidden;border:1px solid #ddd;background:#fff">' +
            '<img src="' + res.data.url + '" style="width:100%;height:100%;object-fit:cover" />' +
            '</div>'
          );
        }
      });
    });
  }

  // Initialize on existing fields
  $(document).ready(function() {
    setTimeout(function() {
      $('.acf-field').each(function() { addPreview($(this)); });
    }, 500);
  });

  // Re-initialize when ACF fields load (tab switch, repeat, etc.)
  acf.add_action('ready_field', function($el) { addPreview($el); });
  acf.add_action('append_field', function($el) { addPreview($el); });

  // Update on relationship selection change
  $(document).on('click', '.acf_relationship .values li, .acf_relationship .list li', function() {
    var $field = $(this).closest('.acf-field');
    setTimeout(function() { addPreview($field); }, 300);
  });

  // Also listen for remove
  $(document).on('click', '.acf_relationship .values .acf-icon', function() {
    var $field = $(this).closest('.acf-field');
    setTimeout(function() { addPreview($field); }, 300);
  });

})(jQuery);
JS;

    wp_register_script('alya-acf-gallery-preview', '', ['jquery'], '1.0', true);
    wp_enqueue_script('alya-acf-gallery-preview');
    wp_add_inline_script('alya-acf-gallery-preview', $script);
});

/* ================================================================
 * AJAX handler for attachment preview thumbnail
 * ================================================================ */
add_action('wp_ajax_alya_get_attachment_preview', function () {
    $id = intval($_POST['id'] ?? 0);
    $url = wp_get_attachment_image_url($id, 'thumbnail');

    if ($url) {
        wp_send_json_success(['url' => $url, 'id' => $id]);
    } else {
        wp_send_json_error(['message' => 'No image']);
    }
});

/* ================================================================
 * FIELD GROUP: Jobs
 * ================================================================ */
acf_add_local_field_group([
    'key'    => 'group_alya_jobs',
    'title'  => 'Job Details',
    'fields' => [
        [
            'key'     => 'field_alya_job_category',
            'label'   => 'Kategori / Departemen',
            'name'    => 'alya_job_category',
            'type'    => 'select',
            'choices' => [
                'medis'       => 'Medis',
                'non-medis'   => 'Non-Medis',
                'operasional' => 'Operasional',
                'marketing'   => 'Marketing',
                'teknologi'   => 'Teknologi',
                'keuangan'    => 'Keuangan',
                'hr'          => 'HR & Rekrutmen',
            ],
            'default_value' => 'medis',
            'allow_null'    => 0,
            'return_format' => 'value',
            'ui'            => 0,
        ],
        [
            'key'     => 'field_alya_job_type',
            'label'   => 'Tipe Pekerjaan',
            'name'    => 'alya_job_type',
            'type'    => 'select',
            'choices' => [
                'Full-time' => 'Full-time',
                'Part-time' => 'Part-time',
                'Kontrak'   => 'Kontrak',
                'Freelance' => 'Freelance',
                'Magang'    => 'Magang / Internship',
            ],
            'default_value' => 'Full-time',
            'allow_null'    => 0,
            'return_format' => 'value',
            'ui'            => 0,
        ],
        [
            'key'     => 'field_alya_job_location',
            'label'   => 'Lokasi Kerja',
            'name'    => 'alya_location',
            'type'    => 'select',
            'choices' => [
                'Jakarta Selatan'   => 'Jakarta Selatan',
                'Jakarta Pusat'     => 'Jakarta Pusat',
                'Jakarta Barat'     => 'Jakarta Barat',
                'Jakarta Timur'     => 'Jakarta Timur',
                'Jakarta Utara'     => 'Jakarta Utara',
                'Tangerang'         => 'Tangerang',
                'Tangerang Selatan' => 'Tangerang Selatan',
                'Bekasi'            => 'Bekasi',
                'Depok'             => 'Depok',
                'Bogor'             => 'Bogor',
                'Remote'            => 'Remote / WFH',
            ],
            'default_value' => 'Jakarta Selatan',
            'allow_null'    => 0,
            'return_format' => 'value',
            'ui'            => 0,
        ],
        [
            'key'     => 'field_alya_job_experience',
            'label'   => 'Pengalaman yang Dibutuhkan',
            'name'    => 'alya_experience',
            'type'    => 'select',
            'choices' => [
                'Fresh Graduate' => 'Fresh Graduate (0 Tahun)',
                '0-1 Tahun'      => '0–1 Tahun',
                '1-3 Tahun'      => '1–3 Tahun',
                '3-5 Tahun'      => '3–5 Tahun',
                '5-10 Tahun'     => '5–10 Tahun',
                '10+ Tahun'      => '10+ Tahun',
            ],
            'default_value' => '1-3 Tahun',
            'allow_null'    => 0,
            'return_format' => 'value',
            'ui'            => 0,
        ],
        [
            'key'         => 'field_alya_job_salary',
            'label'       => 'Rentang Gaji',
            'name'        => 'alya_salary',
            'type'        => 'text',
            'placeholder' => 'Contoh: Rp 5.000.000 – Rp 8.000.000 / Kompetitif',
        ],
        [
            'key'     => 'field_alya_job_requirements',
            'label'   => 'Kualifikasi & Persyaratan',
            'name'    => 'alya_requirements',
            'type'    => 'wysiwyg',
            'tabs'    => 'visual',
            'toolbar' => 'basic',
        ],
        [
            'key'     => 'field_alya_job_responsibilities',
            'label'   => 'Tanggung Jawab Pekerjaan',
            'name'    => 'alya_responsibilities',
            'type'    => 'wysiwyg',
            'tabs'    => 'visual',
            'toolbar' => 'basic',
        ],
        [
            'key'     => 'field_alya_job_benefits',
            'label'   => 'Benefit & Fasilitas',
            'name'    => 'alya_job_benefits',
            'type'    => 'wysiwyg',
            'tabs'    => 'visual',
            'toolbar' => 'basic',
        ],
        [
            'key'            => 'field_alya_job_deadline',
            'label'          => 'Batas Akhir Lamaran',
            'name'           => 'alya_deadline',
            'type'           => 'date_picker',
            'display_format' => 'd F Y',
            'return_format'  => 'd F Y',
            'first_day'      => 1,
        ],
        [
            'key'         => 'field_alya_job_apply_link',
            'label'       => 'Link Lamaran Eksternal',
            'name'        => 'alya_apply_link',
            'type'        => 'url',
            'description' => 'Jika diisi, tombol Lamar Sekarang akan mengarah ke URL ini.',
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

/* ================================================================
 * FIELD GROUP: Treatment
 * ================================================================ */
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
            'key'         => 'field_alya_tr_price',
            'label'       => 'Harga Mulai',
            'name'        => 'alya_price',
            'type'        => 'text',
            'placeholder' => 'Contoh: Rp 500.000',
        ],
        [
            'key'         => 'field_alya_tr_duration',
            'label'       => 'Durasi Treatment',
            'name'        => 'alya_duration',
            'type'        => 'text',
            'placeholder' => 'Contoh: 60 menit',
        ],
        [
            'key'           => 'field_alya_tr_skin_type',
            'label'         => 'Jenis Kulit yang Cocok',
            'name'          => 'alya_skin_type',
            'type'          => 'select',
            'choices'       => [
                'Semua jenis kulit' => 'Semua jenis kulit',
                'Kulit berminyak'   => 'Kulit berminyak',
                'Kulit kering'      => 'Kulit kering',
                'Kulit sensitif'    => 'Kulit sensitif',
                'Kulit kombinasi'   => 'Kulit kombinasi',
                'Kulit berjerawat'  => 'Kulit berjerawat',
                'Kulit normal'      => 'Kulit normal',
            ],
            'default_value' => 'Semua jenis kulit',
            'allow_null'    => 0,
            'return_format' => 'value',
            'ui'            => 0,
        ],
        [
            'key'           => 'field_alya_tr_downtime',
            'label'         => 'Downtime',
            'name'          => 'alya_downtime',
            'type'          => 'select',
            'choices'       => [
                'Tanpa downtime' => 'Tanpa downtime',
                '1-2 hari'       => '1–2 hari',
                '3-5 hari'       => '3–5 hari',
                '1 minggu'       => '1 minggu',
                '2 minggu'       => '2 minggu',
            ],
            'default_value' => 'Tanpa downtime',
            'allow_null'    => 0,
            'return_format' => 'value',
            'ui'            => 0,
        ],

        /* --- GALLERY --- */
        [
            'key'           => 'field_alya_tr_gallery',
            'label'         => '🖼️ Galeri Foto',
            'name'          => 'alya_gallery',
            'type'          => 'relationship',
            'post_type'     => ['attachment'],
            'filters'       => ['search'],
            'min'           => 1,
            'max'           => 12,
            'return_format' => 'array',
        ],

        /* --- RELATED TREATMENTS --- */
        [
            'key'           => 'field_alya_tr_related',
            'label'         => '🔗 Treatment Terkait',
            'name'          => 'alya_related',
            'type'          => 'relationship',
            'post_type'     => ['treatment'],
            'filters'       => ['search'],
            'max'           => 3,
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

/* ================================================================
 * DOCTOR REPEATER META BOXES
 * — Education, Experience, Practice Schedule, Stats, Certifications
 * ================================================================ */

/**
 * Shared helper: render a repeater table for doctor CPT.
 *
 * @param string $meta_key  Post meta key where JSON is stored.
 * @param array  $columns   [ 'key' => 'Label', ... ]
 * @param array  $defaults  Default rows when meta is empty.
 * @param string $nonce_action
 * @param string $nonce_field
 * @param int    $post_id
 */
function alya_render_doctor_repeater($meta_key, $columns, $defaults, $nonce_action, $nonce_field, $post_id) {
    $raw   = get_post_meta($post_id, $meta_key, true);
    $items = [];
    if ($raw) {
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) {
            $items = $decoded;
        } elseif (is_string($raw)) {
            $col_keys = array_keys($columns);
            foreach (array_filter(array_map('trim', explode("\n", $raw))) as $line) {
                $parts = array_map('trim', explode('|', $line));
                $entry = [];
                foreach ($col_keys as $i => $key) {
                    $entry[$key] = $parts[$i] ?? '';
                }
                if (array_filter(array_values($entry))) $items[] = $entry;
            }
        }
    }
    if (empty($items)) $items = $defaults;

    wp_nonce_field($nonce_action, $nonce_field);
    $table_id = 'alya_' . $meta_key . '_table';
    ?>
    <style>
        .alya-rep-table{width:100%;border-collapse:collapse;margin-top:6px}
        .alya-rep-table th,.alya-rep-table td{padding:7px 9px;border:1px solid #ddd;vertical-align:middle}
        .alya-rep-table th{background:#f5f5f5;font-weight:600;font-size:12px;text-align:left}
        .alya-rep-table input{width:100%;box-sizing:border-box}
        .alya-rep-table td.alya-del-col{width:40px;text-align:center}
        .alya-rep-del{background:#dc3232;color:#fff;border:none;padding:4px 9px;border-radius:3px;cursor:pointer;font-size:14px;line-height:1}
        .alya-rep-del:hover{background:#a32323}
        .alya-rep-add-btn{margin-top:10px}
        .alya-rep-hint{color:#666;font-size:12px;margin-top:6px;font-style:italic}
    </style>
    <table class="alya-rep-table" id="<?php echo esc_attr($table_id); ?>">
        <thead>
            <tr>
                <?php foreach ($columns as $col_label): ?>
                    <th><?php echo esc_html($col_label); ?></th>
                <?php endforeach; ?>
                <th class="alya-del-col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $idx => $row): ?>
            <tr>
                <?php foreach ($columns as $col_key => $col_label): ?>
                <td><input type="text"
                    name="<?php echo esc_attr($meta_key . '[' . $idx . '][' . $col_key . ']'); ?>"
                    value="<?php echo esc_attr($row[$col_key] ?? ''); ?>"
                    placeholder="<?php echo esc_attr($col_label); ?>"></td>
                <?php endforeach; ?>
                <td class="alya-del-col">
                    <button type="button" class="alya-rep-del" title="Hapus baris">&times;</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p class="alya-rep-add-btn">
        <button type="button" class="button"
            data-table="<?php echo esc_attr($table_id); ?>"
            data-meta="<?php echo esc_attr($meta_key); ?>"
            data-cols="<?php echo esc_attr(json_encode(array_keys($columns))); ?>"
            onclick="alyaRepAddRow(this)">+ Tambah Baris</button>
    </p>
    <script>
    (function(){
        document.getElementById(<?php echo json_encode($table_id); ?>)
            .addEventListener('click', function(e){
                if (e.target.classList.contains('alya-rep-del')) {
                    e.target.closest('tr').remove();
                }
            });
    })();
    </script>
    <?php
}

/** Print shared JS once per page load */
function alya_rep_scripts_once() {
    static $done = false;
    if ($done) return;
    $done = true;
    ?>
    <script>
    function alyaRepAddRow(btn) {
        var tableId = btn.getAttribute('data-table');
        var meta    = btn.getAttribute('data-meta');
        var cols    = JSON.parse(btn.getAttribute('data-cols'));
        var tbody   = document.querySelector('#' + tableId + ' tbody');
        var idx     = tbody.querySelectorAll('tr').length;
        var tr      = document.createElement('tr');
        cols.forEach(function(col){
            var td  = document.createElement('td');
            var inp = document.createElement('input');
            inp.type = 'text'; inp.name = meta + '[' + idx + '][' + col + ']'; inp.placeholder = col;
            td.appendChild(inp); tr.appendChild(td);
        });
        var tdDel  = document.createElement('td'); tdDel.className = 'alya-del-col';
        var btnDel = document.createElement('button'); btnDel.type = 'button';
        btnDel.className = 'alya-rep-del'; btnDel.title = 'Hapus'; btnDel.textContent = '\u00d7';
        tdDel.appendChild(btnDel); tr.appendChild(tdDel);
        tbody.appendChild(tr);
    }
    </script>
    <?php
}

/**
 * Shared save handler for doctor repeater meta boxes.
 */
function alya_save_doctor_repeater($post_id, $meta_key, $nonce_field, $nonce_action, $columns) {
    if (!isset($_POST[$nonce_field]) || !wp_verify_nonce($_POST[$nonce_field], $nonce_action)) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $raw  = $_POST[$meta_key] ?? [];
    $data = [];
    if (is_array($raw)) {
        foreach ($raw as $row) {
            if (!is_array($row)) continue;
            $entry = [];
            foreach (array_keys($columns) as $col_key) {
                $entry[$col_key] = sanitize_text_field($row[$col_key] ?? '');
            }
            if (array_filter(array_values($entry))) {
                $data[] = $entry;
            }
        }
    }
    update_post_meta($post_id, $meta_key, wp_json_encode($data));
}

/* ── Register meta boxes ─────────────────────────────────────── */
add_action('add_meta_boxes', function () {
    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'doctor') return;

    $boxes = [
        ['alya_doc_education_mb',      '🎓 Education',                  'alya_render_education_mb',      'normal', 'default'],
        ['alya_doc_experience_mb',     '💼 Experience',                  'alya_render_experience_mb',     'normal', 'default'],
        ['alya_doc_schedule_mb',       '🗓️ Practice Schedule',           'alya_render_schedule_mb',       'normal', 'default'],
        ['alya_doc_stats_mb',          '📊 Stats',                       'alya_render_stats_mb',          'side',   'default'],
        ['alya_doc_certifications_mb', '🏅 Certifications &amp; Training', 'alya_render_certifications_mb', 'normal', 'default'],
    ];
    foreach ($boxes as $b) {
        add_meta_box($b[0], $b[1], $b[2], 'doctor', $b[3], $b[4]);
    }
}, 20);

/* ── Render callbacks ────────────────────────────────────────── */

function alya_render_education_mb($post) {
    alya_rep_scripts_once();
    alya_render_doctor_repeater(
        'alya_education',
        ['degree' => 'Gelar / Degree', 'school' => 'Universitas / School', 'year' => 'Tahun'],
        [['degree' => 'Sp.KK', 'school' => 'Universitas Indonesia', 'year' => '2015']],
        'alya_save_education', 'alya_education_nonce', $post->ID
    );
    echo '<p class="alya-rep-hint">Contoh: Sp.KK | Universitas Indonesia | 2015</p>';
}

function alya_render_experience_mb($post) {
    alya_rep_scripts_once();
    alya_render_doctor_repeater(
        'alya_experience',
        ['role' => 'Jabatan / Role', 'place' => 'Tempat / Hospital', 'year' => 'Tahun'],
        [['role' => 'Senior Dermatologist', 'place' => 'RS Pondok Indah', 'year' => '2018–2022']],
        'alya_save_experience', 'alya_experience_nonce', $post->ID
    );
    echo '<p class="alya-rep-hint">Contoh: Senior Dermatologist | RS Pondok Indah | 2018–2022</p>';
}

function alya_render_schedule_mb($post) {
    alya_rep_scripts_once();
    alya_render_doctor_repeater(
        'alya_schedule',
        ['day' => 'Hari', 'hours' => 'Jam Praktik', 'location' => 'Lokasi / Cabang'],
        [['day' => 'Senin', 'hours' => '09:00–12:00', 'location' => 'Cabang Utama']],
        'alya_save_schedule', 'alya_schedule_nonce', $post->ID
    );
    echo '<p class="alya-rep-hint">Contoh: Senin | 09:00–12:00 | Cabang Utama</p>';
}

function alya_render_stats_mb($post) {
    alya_rep_scripts_once();
    alya_render_doctor_repeater(
        'alya_stats',
        ['number' => 'Angka / Number', 'label' => 'Label'],
        [
            ['number' => '10+',  'label' => 'Tahun Pengalaman'],
            ['number' => '500+', 'label' => 'Pasien Ditangani'],
            ['number' => '4.9',  'label' => 'Rating Pasien'],
        ],
        'alya_save_stats', 'alya_stats_nonce', $post->ID
    );
    echo '<p class="alya-rep-hint">Contoh: 10+ | Tahun Pengalaman</p>';
}

function alya_render_certifications_mb($post) {
    alya_rep_scripts_once();
    alya_render_doctor_repeater(
        'alya_certifications',
        ['title' => 'Judul Sertifikasi', 'institution' => 'Institusi, Tahun'],
        [
            ['title' => 'Certified Botox Injector', 'institution' => 'Allergan Academy, 2019'],
            ['title' => 'Thread Lift Certification', 'institution' => 'PDO Max Training, 2022'],
        ],
        'alya_save_certifications', 'alya_certifications_nonce', $post->ID
    );
    echo '<p class="alya-rep-hint">Contoh: Certified Botox Injector | Allergan Academy, 2019</p>';
}

/* ── Save all repeaters on doctor post save ──────────────────── */
add_action('save_post_doctor', function ($post_id) {
    alya_save_doctor_repeater($post_id, 'alya_education',
        'alya_education_nonce',      'alya_save_education',
        ['degree' => '', 'school' => '', 'year' => '']);

    alya_save_doctor_repeater($post_id, 'alya_experience',
        'alya_experience_nonce',     'alya_save_experience',
        ['role' => '', 'place' => '', 'year' => '']);

    alya_save_doctor_repeater($post_id, 'alya_schedule',
        'alya_schedule_nonce',       'alya_save_schedule',
        ['day' => '', 'hours' => '', 'location' => '']);

    alya_save_doctor_repeater($post_id, 'alya_stats',
        'alya_stats_nonce',          'alya_save_stats',
        ['number' => '', 'label' => '']);

    alya_save_doctor_repeater($post_id, 'alya_certifications',
        'alya_certifications_nonce', 'alya_save_certifications',
        ['title' => '', 'institution' => '']);
});

/* ================================================================
 * TREATMENT REPEATER META BOXES
 * — Benefits, Process, FAQ (ACF Free compatible)
 * ================================================================ */

/* ── Register meta boxes ─────────────────────────────────────── */
add_action('add_meta_boxes', function () {
    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'treatment') return;

    $boxes = [
        ['alya_tr_benefits_mb',      '✅ Manfaat / Benefits',               'alya_render_treatment_benefits_mb', 'normal'],
        ['alya_tr_process_mb',       '📋 Tahapan Treatment / Process',      'alya_render_treatment_process_mb',  'normal'],
        ['alya_tr_faqs_mb',          '❓ FAQ — Pertanyaan Umum',            'alya_render_treatment_faqs_mb',     'normal'],
    ];
    foreach ($boxes as $b) {
        add_meta_box($b[0], $b[1], $b[2], 'treatment', $b[3], 'default');
    }
}, 20);

/* ── Render callbacks ────────────────────────────────────────── */

function alya_render_treatment_benefits_mb($post) {
    alya_rep_scripts_once();
    alya_render_doctor_repeater(
        'alya_benefits',
        ['title' => 'Judul Manfaat', 'description' => 'Deskripsi'],
        [['title' => 'Cerah Seketika', 'description' => 'Kulit tampak lebih cerah dan halus setelah satu sesi.']],
        'alya_save_tr_benefits', 'alya_tr_benefits_nonce', $post->ID
    );
    echo '<p class="alya-rep-hint">Contoh: Cerah Seketika | Kulit tampak lebih cerah dan halus</p>';
}

function alya_render_treatment_process_mb($post) {
    alya_rep_scripts_once();
    alya_render_doctor_repeater(
        'alya_process',
        ['title' => 'Judul Langkah', 'description' => 'Penjelasan'],
        [['title' => 'Konsultasi', 'description' => 'Dokter memeriksa kondisi kulit dan menentukan treatment yang sesuai.']],
        'alya_save_tr_process', 'alya_tr_process_nonce', $post->ID
    );
    echo '<p class="alya-rep-hint">Contoh: Konsultasi | Dokter memeriksa kondisi kulit</p>';
}

function alya_render_treatment_faqs_mb($post) {
    alya_rep_scripts_once();
    alya_render_doctor_repeater(
        'alya_faqs',
        ['question' => '❓ Pertanyaan', 'answer' => '💬 Jawaban'],
        [['question' => 'Apakah treatment ini sakit?', 'answer' => 'Tidak, treatment ini tidak menyebabkan rasa sakit.']],
        'alya_save_tr_faqs', 'alya_tr_faqs_nonce', $post->ID
    );
    echo '<p class="alya-rep-hint">Contoh: Apakah treatment ini sakit? | Tidak, treatment ini nyaman</p>';
}

/* ── Save all repeaters on treatment post save ───────────────── */
add_action('save_post_treatment', function ($post_id) {
    alya_save_doctor_repeater($post_id, 'alya_benefits',
        'alya_tr_benefits_nonce', 'alya_save_tr_benefits',
        ['title' => '', 'description' => '']);

    alya_save_doctor_repeater($post_id, 'alya_process',
        'alya_tr_process_nonce', 'alya_save_tr_process',
        ['title' => '', 'description' => '']);

    alya_save_doctor_repeater($post_id, 'alya_faqs',
        'alya_tr_faqs_nonce', 'alya_save_tr_faqs',
        ['question' => '', 'answer' => '']);
});


