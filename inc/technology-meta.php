<?php
/**
 * Technology Categories & Devices — Custom Repeater Meta Box (JSON-based)
 *
 * Storage format: JSON in alya_tech_categories_json meta field
 * 
 * @package Alya_Esthetic
 */

defined('ABSPATH') || exit;

/* ================================================================
 * HELPER FUNCTIONS
 * ================================================================ */

/**
 * Parse legacy text format for backward compatibility
 */
function alya_parse_legacy_tech_format($raw) {
    $categories = [];
    $lines = array_filter(array_map('trim', explode("\n", $raw)));
    $current_cat = null;
    
    foreach ($lines as $line) {
        if (strpos($line, 'CAT::') === 0) {
            $delimiter = (strpos($line, ' | ') !== false) ? ' | ' : '|';
            $parts = array_map('trim', explode($delimiter, substr($line, 5)));
            
            $current_cat = [
                'cat_id'       => $parts[0] ?? '',
                'cat_label'    => $parts[1] ?? '',
                'cat_title'    => $parts[2] ?? '',
                'cat_number'   => $parts[3] ?? '',
                'cat_eyebrow'  => $parts[4] ?? '',
                'cat_badge'    => $parts[5] ?? '',
                'bg_alt'       => ($parts[6] ?? '0') === '1',
                'devices'      => [],
            ];
            $categories[] = $current_cat;
            $current_cat = &$categories[count($categories) - 1];
        } elseif (strpos($line, 'DEV::') === 0 && $current_cat !== null) {
            $delimiter = (strpos($line, ' | ') !== false) ? ' | ' : '|';
            $parts = array_map('trim', explode($delimiter, substr($line, 5)));
            $current_cat['devices'][] = [
                'device_title'    => $parts[0] ?? '',
                'device_desc'     => $parts[1] ?? '',
                'image_id'        => intval($parts[2] ?? 0),
                'features'        => $parts[3] ?? '',
                'brand_tag'       => $parts[4] ?? '',
                'origin_badge'    => $parts[5] ?? '',
                'certifications'  => $parts[6] ?? '',
            ];
        }
    }
    
    return $categories;
}

add_action('add_meta_boxes', function () {
    add_meta_box(
        'alya_tech_categories_box',
        'Technology Categories & Devices',
        'alya_tech_categories_box_render',
        'page',
        'normal',
        'high'
    );
    add_meta_box(
        'alya_tech_hero_stats_box',
        'Hero Statistics',
        'alya_tech_hero_stats_box_render',
        'page',
        'normal',
        'high'
    );
    add_meta_box(
        'alya_tech_cert_logos_box',
        'Certification Logos',
        'alya_tech_cert_logos_box_render',
        'page',
        'normal',
        'default'
    );
    
    // Hide Galeri Item meta box on Technology page
    remove_meta_box('alya_gallery_items_box', 'page', 'normal');
});

function alya_is_technology_page($post_id = 0) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return $post_id && get_page_template_slug($post_id) === 'templates/page-technology.php';
}

function alya_tech_categories_box_render($post) {
    if (!alya_is_technology_page($post->ID)) {
        echo '<p>Meta box ini hanya aktif pada halaman dengan template "Technology Page".</p>';
        return;
    }

    wp_nonce_field('alya_tech_categories_save', 'alya_tech_categories_nonce');

    // Load from JSON (new format)
    wp_cache_delete($post->ID, 'post_meta');
    $raw = get_post_meta($post->ID, 'alya_tech_categories_json', true);
    
    $categories = [];
    
    if (!empty($raw)) {
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) {
            $categories = $decoded;
        }
    }
    
    // Fallback to old text format for backward compatibility
    if (empty($categories)) {
        $old_raw = get_post_meta($post->ID, 'alya_tech_categories', true);
        if (is_string($old_raw) && !empty(trim($old_raw))) {
            $categories = alya_parse_legacy_tech_format($old_raw);
        }
    }

    if (empty($categories)) {
        $categories[] = alya_tech_empty_category();
    }
    
    // Ensure each category has at least one device
    foreach ($categories as $idx => $cat) {
        if (empty($cat['devices'])) {
            $categories[$idx]['devices'] = [alya_tech_empty_device()];
        }
    }

    ?>
    <style>
        .alya-tech-category {
            border: 2px solid #2271b1;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
            background: #f0f6fc;
        }
        .alya-tech-category-header {
            background: #2271b1;
            color: #fff;
            padding: 12px 16px;
            margin: -16px -16px 16px -16px;
            border-radius: 6px 6px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .alya-tech-category-header h3 { margin: 0; font-size: 16px; font-weight: 600; }
        .alya-tech-category-header .alya-remove-cat {
            color: #fff;
            text-decoration: underline;
            cursor: pointer;
            background: none;
            border: none;
            font-size: 13px;
        }
        .alya-tech-category-header .alya-remove-cat:hover { color: #ffc; }
        .alya-tech-devices {
            margin-top: 16px;
            padding-left: 20px;
            border-left: 3px solid #2271b1;
        }
        .alya-tech-device {
            border: 1px solid #c3c4c7;
            border-radius: 6px;
            padding: 14px;
            margin-bottom: 12px;
            background: #fff;
        }
        .alya-img {
            width: 160px;
            height: 120px;
            border: 1px dashed #999;
            background: #f9f9f9;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-top: 4px;
        }
        .alya-img img { max-width: 100%; height: auto; display: block; }
        .alya-img span { color: #999; font-size: 12px; }
        .alya-field { margin-bottom: 10px; }
        .alya-field label { display: block; font-weight: 600; margin-bottom: 3px; font-size: 13px; }
        .alya-field input[type=text],
        .alya-field textarea { width: 100%; }
        .alya-grid { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 10px; }
    </style>

    <div id="alya-tech-categories">
        <?php 
        // Always use sequential 0,1,2... indexes for consistent form submission
        $categories = array_values($categories); 
        foreach ($categories as $cat_idx => $cat) :
            alya_tech_category_row($cat_idx, $cat);
        endforeach; ?>
    </div>

    <p>
        <button type="button" class="button button-primary button-large" id="alya-add-category">+ Add Category</button>
    </p>

    <script type="text/html" id="alya-category-tpl">
        <?php alya_tech_category_row('__CAT_IDX__', alya_tech_empty_category()); ?>
    </script>

    <script type="text/html" id="alya-device-tpl">
        <?php alya_tech_device_row('__CAT_IDX__', '__DEV_IDX__', alya_tech_empty_device()); ?>
    </script>
    <?php
}

function alya_tech_empty_category() {
    return [
        'cat_id'      => '',
        'cat_label'   => '',
        'cat_title'   => '',
        'cat_number'  => '',
        'cat_eyebrow' => '',
        'cat_badge'   => '',
        'bg_alt'      => false,
        'devices'     => [alya_tech_empty_device()],
    ];
}

function alya_tech_empty_device() {
    return [
        'device_title'    => '',
        'device_desc'     => '',
        'image_id'        => '',
        'features'        => '',
        'brand_tag'       => '',
        'origin_badge'    => '',
        'certifications'  => '',
    ];
}

function alya_tech_category_row($cat_idx, $cat) {
    $is_template = $cat_idx === '__CAT_IDX__';
    $display_num = $is_template ? 'X' : ($cat_idx + 1);
    
    ?>
    <div class="alya-tech-category" data-cat-idx="<?php echo esc_attr($cat_idx); ?>">
        <div class="alya-tech-category-header">
            <h3>📁 Category #<span class="cat-num"><?php echo esc_html($display_num); ?></span></h3>
            <button type="button" class="alya-remove-cat">✕ Remove Category</button>
        </div>

        <div class="alya-grid">
            <div class="alya-field" style="flex:1 1 200px">
                <label>Category ID (for anchor) <span style="color:#d63638">*</span></label>
                <input type="text" name="tech_cat[<?php echo esc_attr($cat_idx); ?>][cat_id]" value="<?php echo esc_attr($cat['cat_id']); ?>" placeholder="e.g., laser-devices" required>
            </div>
            <div class="alya-field" style="flex:1 1 200px">
                <label>Category Label <span style="color:#d63638">*</span></label>
                <input type="text" name="tech_cat[<?php echo esc_attr($cat_idx); ?>][cat_label]" value="<?php echo esc_attr($cat['cat_label']); ?>" placeholder="e.g., Laser Devices" required>
            </div>
            <div class="alya-field" style="flex:1 1 150px">
                <label>Number</label>
                <input type="text" name="tech_cat[<?php echo esc_attr($cat_idx); ?>][cat_number]" value="<?php echo esc_attr($cat['cat_number']); ?>" placeholder="e.g., 01">
            </div>
        </div>

        <div class="alya-grid">
            <div class="alya-field" style="flex:1 1 300px">
                <label>Category Title <span style="color:#d63638">*</span></label>
                <input type="text" name="tech_cat[<?php echo esc_attr($cat_idx); ?>][cat_title]" value="<?php echo esc_attr($cat['cat_title']); ?>" placeholder="e.g., Advanced Laser Technology" required>
            </div>
            <div class="alya-field" style="flex:1 1 200px">
                <label>Eyebrow</label>
                <input type="text" name="tech_cat[<?php echo esc_attr($cat_idx); ?>][cat_eyebrow]" value="<?php echo esc_attr($cat['cat_eyebrow']); ?>" placeholder="e.g., ADVANCED LASER">
            </div>
            <div class="alya-field" style="flex:1 1 150px">
                <label>Badge</label>
                <input type="text" name="tech_cat[<?php echo esc_attr($cat_idx); ?>][cat_badge]" value="<?php echo esc_attr($cat['cat_badge']); ?>" placeholder="e.g., FDA Approved">
            </div>
        </div>

        <div class="alya-field">
            <label>
                <input type="checkbox" name="tech_cat[<?php echo esc_attr($cat_idx); ?>][bg_alt]" value="1" <?php checked($cat['bg_alt'], true); ?>>
                Alternate Background Color
            </label>
        </div>

        <hr style="margin: 20px 0; border-color: #2271b1;">

        <h4 style="margin-bottom: 12px;">🔧 Devices in this Category</h4>
        <div class="alya-tech-devices" data-cat-idx="<?php echo esc_attr($cat_idx); ?>">
            <?php if (!$is_template) : ?>
                <?php 
                // Always use sequential 0,1,2... indexes for devices
                $cat['devices'] = array_values($cat['devices']);
                foreach ($cat['devices'] as $dev_idx => $dev) :
                    alya_tech_device_row($cat_idx, $dev_idx, $dev);
                endforeach; ?>
            <?php else : ?>
                <?php alya_tech_device_row('__CAT_IDX__', '__DEV_IDX__', alya_tech_empty_device()); ?>
            <?php endif; ?>
        </div>

        <p style="margin-top: 12px;">
            <button type="button" class="button alya-add-device" data-cat-idx="<?php echo esc_attr($cat_idx); ?>">+ Add Device</button>
        </p>
    </div>
    <?php
}

function alya_tech_device_row($cat_idx, $dev_idx, $dev) {
    $image_url = $dev['image_id'] ? wp_get_attachment_image_url(intval($dev['image_id']), 'medium') : '';
    
    // Parse features - handle both array (new JSON format) and string (old text format)
    $features = [];
    if (!empty($dev['features'])) {
        if (is_array($dev['features'])) {
            // New JSON format: already an array
            $features = $dev['features'];
        } elseif (strpos($dev['features'], 'FEATURES>>') === 0) {
            // Old text format: FEATURES>>feat1>>feat2
            $features = array_filter(explode('>>', substr($dev['features'], 10)));
        } else {
            // Fallback: comma-separated
            $features = array_filter(array_map('trim', explode(',', $dev['features'])));
        }
    }
    if (empty($features)) {
        $features = [''];
    }
    
    // Parse certifications - handle both array (new JSON format) and string (old text format)
    $certifications = [];
    if (!empty($dev['certifications'])) {
        if (is_array($dev['certifications'])) {
            // New JSON format: already an array
            $certifications = $dev['certifications'];
        } elseif (strpos($dev['certifications'], 'CERTS>>') === 0) {
            // Old text format: CERTS>>cert1>>cert2
            $certifications = array_filter(explode('>>', substr($dev['certifications'], 7)));
        } else {
            // Fallback: comma-separated
            $certifications = array_filter(array_map('trim', explode(',', $dev['certifications'])));
        }
    }
    if (empty($certifications)) {
        $certifications = [''];
    }
    
    ?>
    <div class="alya-tech-device" data-dev-idx="<?php echo esc_attr($dev_idx); ?>">
        <div class="alya-grid">
            <div style="flex: 0 0 160px;">
                <label>Device Image</label>
                <div class="alya-img" data-field="image">
                    <?php if ($image_url) : ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="">
                    <?php else : ?>
                        <span>No image</span>
                    <?php endif; ?>
                </div>
                <input type="hidden" name="tech_cat[<?php echo esc_attr($cat_idx); ?>][devices][<?php echo esc_attr($dev_idx); ?>][image_id]" data-id="image" value="<?php echo esc_attr($dev['image_id']); ?>">
                <p>
                    <button type="button" class="button button-small alya-pick" data-field="image">Select</button>
                    <button type="button" class="button button-small alya-clear" data-field="image">Remove</button>
                </p>
            </div>

            <div style="flex: 1;">
                <div class="alya-field">
                    <label>Device Name <span style="color:#d63638">*</span></label>
                    <input type="text" name="tech_cat[<?php echo esc_attr($cat_idx); ?>][devices][<?php echo esc_attr($dev_idx); ?>][device_title]" value="<?php echo esc_attr($dev['device_title']); ?>" placeholder="e.g., Nd:YAG Laser" required>
                </div>

                <div class="alya-grid">
                    <div class="alya-field" style="flex:1 1 180px">
                        <label>Brand Tag</label>
                        <input type="text" name="tech_cat[<?php echo esc_attr($cat_idx); ?>][devices][<?php echo esc_attr($dev_idx); ?>][brand_tag]" value="<?php echo esc_attr($dev['brand_tag']); ?>" placeholder="e.g., Lutronic™">
                    </div>
                    <div class="alya-field" style="flex:1 1 180px">
                        <label>Origin Badge</label>
                        <input type="text" name="tech_cat[<?php echo esc_attr($cat_idx); ?>][devices][<?php echo esc_attr($dev_idx); ?>][origin_badge]" value="<?php echo esc_attr($dev['origin_badge']); ?>" placeholder="e.g., Made in Korea">
                    </div>
                </div>
            </div>
        </div>

        <div class="alya-field">
            <label>Description</label>
            <textarea name="tech_cat[<?php echo esc_attr($cat_idx); ?>][devices][<?php echo esc_attr($dev_idx); ?>][device_desc]" rows="2"><?php echo esc_textarea($dev['device_desc']); ?></textarea>
        </div>

        <!-- Features Repeatable -->
        <div class="alya-field">
            <label>Features</label>
            <div class="alya-device-features" data-cat="<?php echo esc_attr($cat_idx); ?>" data-dev="<?php echo esc_attr($dev_idx); ?>">
                <?php foreach ($features as $feat_idx => $feat) : ?>
                    <div class="alya-feature-row" style="display: flex; gap: 8px; margin-bottom: 6px;">
                        <input type="text" name="tech_cat[<?php echo esc_attr($cat_idx); ?>][devices][<?php echo esc_attr($dev_idx); ?>][features][]" value="<?php echo esc_attr($feat); ?>" placeholder="e.g., Safe & Effective" style="flex: 1;">
                        <button type="button" class="button button-small alya-remove-feature">✕</button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button button-small alya-add-feature" data-cat="<?php echo esc_attr($cat_idx); ?>" data-dev="<?php echo esc_attr($dev_idx); ?>">+ Add Feature</button>
        </div>

        <!-- Certifications Repeatable -->
        <div class="alya-field">
            <label>Certifications</label>
            <div class="alya-device-certs" data-cat="<?php echo esc_attr($cat_idx); ?>" data-dev="<?php echo esc_attr($dev_idx); ?>">
                <?php foreach ($certifications as $cert_idx => $cert) : ?>
                    <div class="alya-cert-row" style="display: flex; gap: 8px; margin-bottom: 6px;">
                        <input type="text" name="tech_cat[<?php echo esc_attr($cat_idx); ?>][devices][<?php echo esc_attr($dev_idx); ?>][certifications][]" value="<?php echo esc_attr($cert); ?>" placeholder="e.g., FDA Cleared" style="flex: 1;">
                        <button type="button" class="button button-small alya-remove-cert">✕</button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button button-small alya-add-cert" data-cat="<?php echo esc_attr($cat_idx); ?>" data-dev="<?php echo esc_attr($dev_idx); ?>">+ Add Certification</button>
        </div>

        <button type="button" class="button-link-delete alya-remove-dev">Remove Device</button>
    </div>
    <?php
}

/* ================================================================
 * HERO STATISTICS META BOX
 * ================================================================ */
function alya_tech_hero_stats_box_render($post) {
    if (!alya_is_technology_page($post->ID)) {
        echo '<p>Meta box ini hanya aktif pada halaman dengan template "Technology Page".</p>';
        return;
    }

    wp_nonce_field('alya_tech_hero_stats_save', 'alya_tech_hero_stats_nonce');

    // Load from JSON (new format)
    $raw = get_post_meta($post->ID, 'alya_hero_stats_json', true);
    $stats = [];

    if (!empty($raw)) {
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) {
            $stats = $decoded;
        }
    }
    
    // Fallback to old text format
    if (empty($stats)) {
        $old_raw = get_post_meta($post->ID, 'alya_hero_stats', true);
        if (is_string($old_raw) && !empty(trim($old_raw))) {
            $lines = array_filter(array_map('trim', explode("\n", $old_raw)));
            foreach ($lines as $line) {
                $delimiter = (strpos($line, ' | ') !== false) ? ' | ' : '|';
                $parts = array_map('trim', explode($delimiter, $line));
                if (count($parts) >= 2) {
                    $stats[] = [
                        'value' => $parts[0],
                        'label' => $parts[1],
                    ];
                }
            }
        }
    }

    if (empty($stats)) {
        $stats[] = ['value' => '', 'label' => ''];
    }

    ?>
    <style>
        .alya-stats-container { max-width: 800px; }
        .alya-stat-row {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
            padding: 12px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            align-items: flex-start;
        }
        .alya-stat-field { flex: 1; }
        .alya-stat-field label { display: block; font-weight: 600; margin-bottom: 4px; font-size: 13px; }
        .alya-stat-field input { width: 100%; }
        .alya-stat-remove { flex: 0 0 auto; padding-top: 24px; }
    </style>

    <div class="alya-stats-container">
        <div id="alya-hero-stats">
            <?php foreach ($stats as $idx => $stat) : ?>
                <div class="alya-stat-row" data-stat-idx="<?php echo esc_attr($idx); ?>">
                    <div class="alya-stat-field">
                        <label>Value <span style="color:#d63638">*</span></label>
                        <input type="text" name="hero_stat[<?php echo esc_attr($idx); ?>][value]" value="<?php echo esc_attr($stat['value']); ?>" placeholder="e.g., 20+" required>
                    </div>
                    <div class="alya-stat-field">
                        <label>Label <span style="color:#d63638">*</span></label>
                        <input type="text" name="hero_stat[<?php echo esc_attr($idx); ?>][label]" value="<?php echo esc_attr($stat['label']); ?>" placeholder="e.g., Perangkat Medis" required>
                    </div>
                    <div class="alya-stat-remove">
                        <button type="button" class="button button-small alya-remove-stat">Remove</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <p>
            <button type="button" class="button button-secondary" id="alya-add-stat">+ Add Statistic</button>
        </p>
    </div>

    <script type="text/html" id="alya-stat-tpl">
        <div class="alya-stat-row" data-stat-idx="__STAT_IDX__">
            <div class="alya-stat-field">
                <label>Value <span style="color:#d63638">*</span></label>
                <input type="text" name="hero_stat[__STAT_IDX__][value]" value="" placeholder="e.g., 20+" required>
            </div>
            <div class="alya-stat-field">
                <label>Label <span style="color:#d63638">*</span></label>
                <input type="text" name="hero_stat[__STAT_IDX__][label]" value="" placeholder="e.g., Perangkat Medis" required>
            </div>
            <div class="alya-stat-remove">
                <button type="button" class="button button-small alya-remove-stat">Remove</button>
            </div>
        </div>
    </script>
    <?php
}

/* ================================================================
 * CERTIFICATION LOGOS META BOX
 * ================================================================ */
function alya_tech_cert_logos_box_render($post) {
    if (!alya_is_technology_page($post->ID)) {
        echo '<p>Meta box ini hanya aktif pada halaman dengan template "Technology Page".</p>';
        return;
    }

    wp_nonce_field('alya_tech_cert_logos_save', 'alya_tech_cert_logos_nonce');

    // Load from JSON (new format)
    $raw = get_post_meta($post->ID, 'alya_cert_logos_json', true);
    $logos = [];

    if (!empty($raw)) {
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) {
            $logos = $decoded;
        }
    }
    
    // Fallback to old text format
    if (empty($logos)) {
        $old_raw = get_post_meta($post->ID, 'alya_cert_logos', true);
        if (is_string($old_raw) && !empty(trim($old_raw))) {
            $lines = array_filter(array_map('trim', explode("\n", $old_raw)));
            foreach ($lines as $line) {
                $delimiter = (strpos($line, ' | ') !== false) ? ' | ' : '|';
                $parts = array_map('trim', explode($delimiter, $line));
                if (count($parts) >= 1) {
                    $logos[] = [
                        'image_id'  => intval($parts[0] ?? 0),
                        'cert_name' => $parts[1] ?? '',
                        'cert_desc' => $parts[2] ?? '',
                    ];
                }
            }
        }
    }

    if (empty($logos)) {
        $logos[] = ['image_id' => '', 'cert_name' => '', 'cert_desc' => ''];
    }

    ?>
    <style>
        .alya-cert-logos-container { max-width: 900px; }
        .alya-cert-logo-row {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
            padding: 14px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            align-items: flex-start;
        }
        .alya-cert-logo-img-wrap {
            flex: 0 0 100px;
        }
        .alya-cert-logo-img-preview {
            width: 100px;
            height: 100px;
            border: 1px dashed #999;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-bottom: 6px;
        }
        .alya-cert-logo-img-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .alya-cert-logo-img-preview span {
            color: #999;
            font-size: 11px;
        }
        .alya-cert-logo-fields {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .alya-cert-logo-field { }
        .alya-cert-logo-field label { display: block; font-weight: 600; margin-bottom: 4px; font-size: 13px; }
        .alya-cert-logo-field input { width: 100%; }
        .alya-cert-logo-remove { flex: 0 0 auto; padding-top: 6px; }
    </style>

    <div class="alya-cert-logos-container">
        <p style="margin-bottom: 16px; color: #646970;">Upload certification logos (FDA, CE Mark, BPOM, etc.) with name and description.</p>
        <div id="alya-cert-logos">
            <?php foreach ($logos as $idx => $logo) :
                $image_url = $logo['image_id'] ? wp_get_attachment_image_url(intval($logo['image_id']), 'thumbnail') : '';
            ?>
                <div class="alya-cert-logo-row" data-logo-idx="<?php echo esc_attr($idx); ?>">
                    <div class="alya-cert-logo-img-wrap">
                        <div class="alya-cert-logo-img-preview" data-field="cert-logo">
                            <?php if ($image_url) : ?>
                                <img src="<?php echo esc_url($image_url); ?>" alt="">
                            <?php else : ?>
                                <span>No logo</span>
                            <?php endif; ?>
                        </div>
                        <input type="hidden" name="cert_logo[<?php echo esc_attr($idx); ?>][image_id]" data-id="cert-logo" value="<?php echo esc_attr($logo['image_id']); ?>">
                        <p style="margin: 0;">
                            <button type="button" class="button button-small alya-pick-cert-logo" data-field="cert-logo">Select</button>
                            <button type="button" class="button button-small alya-clear-cert-logo" data-field="cert-logo">Remove</button>
                        </p>
                    </div>

                    <div class="alya-cert-logo-fields">
                        <div class="alya-cert-logo-field">
                            <label>Certification Name <span style="color:#d63638">*</span></label>
                            <input type="text" name="cert_logo[<?php echo esc_attr($idx); ?>][cert_name]" value="<?php echo esc_attr($logo['cert_name']); ?>" placeholder="e.g., FDA" required>
                        </div>
                        <div class="alya-cert-logo-field">
                            <label>Description</label>
                            <input type="text" name="cert_logo[<?php echo esc_attr($idx); ?>][cert_desc]" value="<?php echo esc_attr($logo['cert_desc']); ?>" placeholder="e.g., U.S. Food & Drug Administration">
                        </div>
                    </div>

                    <div class="alya-cert-logo-remove">
                        <button type="button" class="button button-small alya-remove-cert-logo">Remove</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <p>
            <button type="button" class="button button-secondary" id="alya-add-cert-logo">+ Add Certification</button>
        </p>
    </div>

    <script type="text/html" id="alya-cert-logo-tpl">
        <div class="alya-cert-logo-row" data-logo-idx="__LOGO_IDX__">
            <div class="alya-cert-logo-img-wrap">
                <div class="alya-cert-logo-img-preview" data-field="cert-logo">
                    <span>No logo</span>
                </div>
                <input type="hidden" name="cert_logo[__LOGO_IDX__][image_id]" data-id="cert-logo" value="">
                <p style="margin: 0;">
                    <button type="button" class="button button-small alya-pick-cert-logo" data-field="cert-logo">Select</button>
                    <button type="button" class="button button-small alya-clear-cert-logo" data-field="cert-logo">Remove</button>
                </p>
            </div>

            <div class="alya-cert-logo-fields">
                <div class="alya-cert-logo-field">
                    <label>Certification Name <span style="color:#d63638">*</span></label>
                    <input type="text" name="cert_logo[__LOGO_IDX__][cert_name]" value="" placeholder="e.g., FDA" required>
                </div>
                <div class="alya-cert-logo-field">
                    <label>Description</label>
                    <input type="text" name="cert_logo[__LOGO_IDX__][cert_desc]" value="" placeholder="e.g., U.S. Food & Drug Administration">
                </div>
            </div>

            <div class="alya-cert-logo-remove">
                <button type="button" class="button button-small alya-remove-cert-logo">Remove</button>
            </div>
        </div>
    </script>
    <?php
}

/* ================================================================
 * SAVE HANDLERS - JSON FORMAT
 * ================================================================ */

/**
 * Save Technology Categories & Devices as JSON
 */
add_action('save_post', function ($post_id) {
    // Standard WordPress checks
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['alya_tech_categories_nonce'])) return;
    if (!wp_verify_nonce(sanitize_text_field($_POST['alya_tech_categories_nonce']), 'alya_tech_categories_save')) return;
    if (!isset($_POST['tech_cat'])) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (!alya_is_technology_page($post_id)) return;

    $categories = [];
    
    // Process each category from POST data
    foreach ((array) $_POST['tech_cat'] as $idx => $cat_raw) {
        // Skip template placeholders from JavaScript
        if ($idx === '__CAT_IDX__' || strpos((string)$idx, '__') === 0) {
            continue;
        }
        
        // Sanitize category fields
        $cat_id      = isset($cat_raw['cat_id']) ? sanitize_text_field($cat_raw['cat_id']) : '';
        $cat_label   = isset($cat_raw['cat_label']) ? sanitize_text_field($cat_raw['cat_label']) : '';
        $cat_title   = isset($cat_raw['cat_title']) ? sanitize_text_field($cat_raw['cat_title']) : '';
        $cat_number  = isset($cat_raw['cat_number']) ? sanitize_text_field($cat_raw['cat_number']) : '';
        $cat_eyebrow = isset($cat_raw['cat_eyebrow']) ? sanitize_text_field($cat_raw['cat_eyebrow']) : '';
        $cat_badge   = isset($cat_raw['cat_badge']) ? sanitize_text_field($cat_raw['cat_badge']) : '';
        $bg_alt      = isset($cat_raw['bg_alt']) && $cat_raw['bg_alt'] === '1';

        // Skip if required fields are missing
        if (!$cat_id || !$cat_label || !$cat_title) {
            continue;
        }

        $category = [
            'cat_id'      => $cat_id,
            'cat_label'   => $cat_label,
            'cat_title'   => $cat_title,
            'cat_number'  => $cat_number,
            'cat_eyebrow' => $cat_eyebrow,
            'cat_badge'   => $cat_badge,
            'bg_alt'      => $bg_alt,
            'devices'     => [],
        ];

        // Process devices for this category
        if (isset($cat_raw['devices']) && is_array($cat_raw['devices'])) {
            foreach ($cat_raw['devices'] as $dev_idx => $dev_raw) {
                // Skip template placeholders
                if ($dev_idx === '__DEV_IDX__' || strpos((string)$dev_idx, '__') === 0) {
                    continue;
                }
                
                $dev_title    = isset($dev_raw['device_title']) ? sanitize_text_field($dev_raw['device_title']) : '';
                $dev_desc     = isset($dev_raw['device_desc']) ? sanitize_textarea_field($dev_raw['device_desc']) : '';
                $image_id     = isset($dev_raw['image_id']) ? intval($dev_raw['image_id']) : 0;
                $brand_tag    = isset($dev_raw['brand_tag']) ? sanitize_text_field($dev_raw['brand_tag']) : '';
                $origin_badge = isset($dev_raw['origin_badge']) ? sanitize_text_field($dev_raw['origin_badge']) : '';

                // Skip if no device title
                if (!$dev_title) {
                    continue;
                }

                // Process features array - convert to simple array
                $features = [];
                if (isset($dev_raw['features']) && is_array($dev_raw['features'])) {
                    $features = array_values(array_filter(array_map('sanitize_text_field', $dev_raw['features'])));
                }

                // Process certifications array - convert to simple array
                $certifications = [];
                if (isset($dev_raw['certifications']) && is_array($dev_raw['certifications'])) {
                    $certifications = array_values(array_filter(array_map('sanitize_text_field', $dev_raw['certifications'])));
                }

                $category['devices'][] = [
                    'device_title'    => $dev_title,
                    'device_desc'     => $dev_desc,
                    'image_id'        => $image_id,
                    'features'        => $features,
                    'brand_tag'       => $brand_tag,
                    'origin_badge'    => $origin_badge,
                    'certifications'  => $certifications,
                ];
            }
        }

        $categories[] = $category;
    }

    // Save as JSON
    $json = wp_json_encode($categories, JSON_UNESCAPED_UNICODE);
    update_post_meta($post_id, 'alya_tech_categories_json', $json);
}, 10, 1);

/**
 * Save Hero Statistics as JSON
 */
add_action('save_post', function ($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['alya_tech_hero_stats_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['alya_tech_hero_stats_nonce']), 'alya_tech_hero_stats_save')) return;
    if (!isset($_POST['hero_stat'])) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (!alya_is_technology_page($post_id)) return;

    $stats = [];
    
    foreach ((array) $_POST['hero_stat'] as $idx => $stat_raw) {
        // Skip template placeholders
        if ($idx === '__STAT_IDX__' || strpos((string)$idx, '__') === 0) {
            continue;
        }
        
        $value = isset($stat_raw['value']) ? sanitize_text_field($stat_raw['value']) : '';
        $label = isset($stat_raw['label']) ? sanitize_text_field($stat_raw['label']) : '';

        if (!$value || !$label) continue;

        $stats[] = [
            'value' => $value,
            'label' => $label,
        ];
    }

    // Save as JSON
    $json = wp_json_encode($stats, JSON_UNESCAPED_UNICODE);
    update_post_meta($post_id, 'alya_hero_stats_json', $json);
});

/**
 * Save Certification Logos as JSON
 */
add_action('save_post', function ($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['alya_tech_cert_logos_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['alya_tech_cert_logos_nonce']), 'alya_tech_cert_logos_save')) return;
    if (!isset($_POST['cert_logo'])) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (!alya_is_technology_page($post_id)) return;

    $logos = [];
    
    foreach ((array) $_POST['cert_logo'] as $idx => $logo_raw) {
        // Skip template placeholders
        if ($idx === '__LOGO_IDX__' || strpos((string)$idx, '__') === 0) {
            continue;
        }
        
        $image_id  = isset($logo_raw['image_id']) ? intval($logo_raw['image_id']) : 0;
        $cert_name = isset($logo_raw['cert_name']) ? sanitize_text_field($logo_raw['cert_name']) : '';
        $cert_desc = isset($logo_raw['cert_desc']) ? sanitize_text_field($logo_raw['cert_desc']) : '';

        if (!$cert_name) continue;

        $logos[] = [
            'image_id'  => $image_id,
            'cert_name' => $cert_name,
            'cert_desc' => $cert_desc,
        ];
    }

    // Save as JSON
    $json = wp_json_encode($logos, JSON_UNESCAPED_UNICODE);
    update_post_meta($post_id, 'alya_cert_logos_json', $json);
});

/* ================================================================
 * JAVASCRIPT - EXTERNAL FILE UNTUK LEBIH AMAN
 * ================================================================ */
add_action('admin_enqueue_scripts', function ($hook) {
    if (!in_array($hook, ['post.php', 'post-new.php'], true)) return;
    $screen = get_current_screen();
    if (!$screen || $screen->id !== 'page') return;

    $post_id = isset($_GET['post']) ? intval($_GET['post']) : 0;
    if ($post_id && !alya_is_technology_page($post_id)) return;

    wp_enqueue_media();
    wp_enqueue_script(
        'alya-technology-meta',
        get_template_directory_uri() . '/assets/js/technology-meta.js',
        ['jquery', 'wp-util'],
        time(), // Always fresh, no cache
        true
    );
});
