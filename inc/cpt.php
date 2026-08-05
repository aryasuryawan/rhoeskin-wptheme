<?php
/**
 * Custom Post Types
 *
 * @package Alya_Esthetic
 */

defined('ABSPATH') || exit;

function alya_register_cpts() {
    $cpts = [
        'service' => [
            'label'               => 'Layanan',
            'labels'              => [
                'name'               => 'Layanan',
                'singular_name'      => 'Layanan',
                'add_new'            => 'Tambah Layanan',
                'add_new_item'       => 'Tambah Layanan Baru',
                'edit_item'          => 'Edit Layanan',
                'new_item'           => 'Layanan Baru',
                'view_item'          => 'Lihat Layanan',
                'search_items'       => 'Cari Layanan',
                'not_found'          => 'Tidak ada layanan ditemukan',
                'not_found_in_trash' => 'Tidak ada layanan di trash',
                'menu_name'          => 'Layanan',
            ],
            'public'              => true,
            'has_archive'         => true,
            'rewrite'             => ['slug' => 'layanan'],
            'menu_icon'           => 'dashicons-heart',
            'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions'],
            'show_in_rest'        => true,
            'capability_type'     => 'post',
        ],
        'doctor' => [
            'label'               => 'Dokter',
            'labels'              => [
                'name'               => 'Dokter',
                'singular_name'      => 'Dokter',
                'add_new'            => 'Tambah Dokter',
                'add_new_item'       => 'Tambah Dokter Baru',
                'edit_item'          => 'Edit Dokter',
                'new_item'           => 'Dokter Baru',
                'view_item'          => 'Lihat Dokter',
                'search_items'       => 'Cari Dokter',
                'not_found'          => 'Tidak ada dokter ditemukan',
                'not_found_in_trash' => 'Tidak ada dokter di trash',
                'menu_name'          => 'Dokter',
            ],
            'public'              => true,
            'has_archive'         => true,
            'rewrite'             => ['slug' => 'dokter'],
            'menu_icon'           => 'dashicons-groups',
            'supports'            => ['title', 'editor', 'thumbnail', 'revisions'],
            'show_in_rest'        => true,
            'capability_type'     => 'post',
        ],
        'testimonial' => [
            'label'               => 'Testimoni',
            'labels'              => [
                'name'               => 'Testimoni',
                'singular_name'      => 'Testimoni',
                'add_new'            => 'Tambah Testimoni',
                'add_new_item'       => 'Tambah Testimoni Baru',
                'edit_item'          => 'Edit Testimoni',
                'new_item'           => 'Testimoni Baru',
                'view_item'          => 'Lihat Testimoni',
                'search_items'       => 'Cari Testimoni',
                'not_found'          => 'Tidak ada testimoni ditemukan',
                'not_found_in_trash' => 'Tidak ada testimoni di trash',
                'menu_name'          => 'Testimoni',
            ],
            'public'              => true,
            'has_archive'         => true,
            'rewrite'             => ['slug' => 'testimoni'],
            'menu_icon'           => 'dashicons-format-quote',
            'supports'            => ['title', 'editor', 'thumbnail', 'revisions'],
            'show_in_rest'        => true,
            'capability_type'     => 'post',
        ],
        'jobs' => [
            'label'               => 'Karir',
            'labels'              => [
                'name'               => 'Karir',
                'singular_name'      => 'Karir',
                'add_new'            => 'Tambah Lowongan',
                'add_new_item'       => 'Tambah Lowongan Baru',
                'edit_item'          => 'Edit Lowongan',
                'new_item'           => 'Lowongan Baru',
                'view_item'          => 'Lihat Lowongan',
                'search_items'       => 'Cari Lowongan',
                'not_found'          => 'Tidak ada lowongan ditemukan',
                'not_found_in_trash' => 'Tidak ada lowongan di trash',
                'menu_name'          => 'Karir',
            ],
            'public'              => true,
            'has_archive'         => true,
            'rewrite'             => ['slug' => 'karir'],
            'menu_icon'           => 'dashicons-briefcase',
            'supports'            => ['title', 'editor', 'thumbnail', 'revisions'],
            'show_in_rest'        => true,
            'capability_type'     => 'post',
        ],
        'treatment' => [
            'label'               => 'Treatment',
            'labels'              => [
                'name'               => 'Treatment',
                'singular_name'      => 'Treatment',
                'add_new'            => 'Tambah Treatment',
                'add_new_item'       => 'Tambah Treatment Baru',
                'edit_item'          => 'Edit Treatment',
                'new_item'           => 'Treatment Baru',
                'view_item'          => 'Lihat Treatment',
                'search_items'       => 'Cari Treatment',
                'not_found'          => 'Tidak ada treatment ditemukan',
                'not_found_in_trash' => 'Tidak ada treatment di trash',
                'menu_name'          => 'Treatment',
            ],
            'public'              => true,
            'has_archive'         => true,
            'rewrite'             => ['slug' => 'treatment'],
            'menu_icon'           => 'dashicons-analytics',
            'supports'            => ['title', 'editor', 'thumbnail', 'revisions'],
            'show_in_rest'        => true,
            'capability_type'     => 'post',
        ],
    ];

    foreach ($cpts as $type => $args) {
        register_post_type($type, $args);
    }

    // Taxonomy for services
    register_taxonomy('service_category', ['service'], [
        'label'             => 'Kategori Layanan',
        'labels'            => [
            'name'          => 'Kategori Layanan',
            'singular_name' => 'Kategori',
            'search_items'  => 'Cari Kategori',
            'all_items'     => 'Semua Kategori',
            'edit_item'     => 'Edit Kategori',
            'update_item'   => 'Update Kategori',
            'add_new_item'  => 'Tambah Kategori Baru',
            'new_item_name' => 'Nama Kategori Baru',
            'menu_name'     => 'Kategori',
        ],
        'hierarchical'      => true,
        'public'            => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'kategori-layanan'],
    ]);

    // Taxonomy for treatments
    register_taxonomy('treatment_category', ['treatment'], [
        'label'             => 'Kategori Treatment',
        'labels'            => [
            'name'          => 'Kategori Treatment',
            'singular_name' => 'Kategori',
            'search_items'  => 'Cari Kategori',
            'all_items'     => 'Semua Kategori',
            'edit_item'     => 'Edit Kategori',
            'update_item'   => 'Update Kategori',
            'add_new_item'  => 'Tambah Kategori Baru',
            'new_item_name' => 'Nama Kategori Baru',
            'menu_name'     => 'Kategori',
        ],
        'hierarchical'      => true,
        'public'            => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'kategori-treatment'],
    ]);

    // Taxonomy for jobs
    register_taxonomy('job_type', ['jobs'], [
        'label'             => 'Tipe Pekerjaan',
        'labels'            => [
            'name'          => 'Tipe Pekerjaan',
            'singular_name' => 'Tipe',
            'search_items'  => 'Cari Tipe',
            'all_items'     => 'Semua Tipe',
            'edit_item'     => 'Edit Tipe',
            'update_item'   => 'Update Tipe',
            'add_new_item'  => 'Tambah Tipe Baru',
            'new_item_name' => 'Nama Tipe Baru',
            'menu_name'     => 'Tipe',
        ],
        'hierarchical'      => true,
        'public'            => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'tipe-pekerjaan'],
    ]);
}
add_action('init', 'alya_register_cpts');

/**
 * Flush rewrite rules on theme activation
 */
function alya_flush_rewrite() {
    alya_register_cpts();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'alya_flush_rewrite');
