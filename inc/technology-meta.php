<?php
/**
 * Technology Categories & Devices — Nested Custom Repeater Meta Box
 *
 * Two-level repeater: Categories (parent) → Devices (child)
 * Data format:
 *   CAT::CatID|CatLabel|CatTitle|CatNumber|CatEyebrow|CatBadge|BgAlt
 *   DEV::DeviceTitle|DeviceDesc|ImageID|Features|BrandTag|OriginBadge
 *
 * @package Alya_Esthetic
 */

defined('ABSPATH') || exit;

add_action('add_meta_boxes', function () {
    add_meta_box(
        'alya_tech_categories_box',
        'Technology Categories & Devices',
        'alya_tech_categories_box_render',
        'page',
        'normal',
        'high'
    );
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

    $raw = get_post_meta($post->ID, 'alya_tech_categories', true);
    $categories = [];

    if (is_string($raw) && !empty(trim($raw))) {
        $lines = array_filter(array_map('trim', explode("\n", $raw)));
        $current_cat = null;
        
        foreach ($lines as $line) {
            if (strpos($line, 'CAT::') === 0) {
                // New category
                $parts = array_map('trim', explode('|', substr($line, 5)));
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
                $categories[] = &$current_cat;
            } elseif (strpos($line, 'DEV::') === 0 && $current_cat !== null) {
                // Device under current category
                $parts = array_map('trim', explode('|', substr($line, 5)));
                $current_cat['devices'][] = [
                    'device_title'  => $parts[0] ?? '',
                    'device_desc'   => $parts[1] ?? '',
                    'image_id'      => $parts[2] ?? '',
                    'features'      => $parts[3] ?? '',
                    'brand_tag'     => $parts[4] ?? '',
                    'origin_badge'  => $parts[5] ?? '',
                ];
            }
        }
    }

    if (empty($categories)) {
        $categories[] = alya_tech_empty_category();
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
        .alya-remove-cat { color: #fff; text-decoration: underline; cursor: pointer; }
        .alya-remove-dev { color: #d63638; }
    </style>

    <div id="alya-tech-categories">
        <?php foreach ($categories as $cat_idx => $cat) :
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
        'device_title' => '',
        'device_desc'  => '',
        'image_id'     => '',
        'features'     => '',
        'brand_tag'    => '',
        'origin_badge' => '',
    ];
}

function alya_tech_category_row($cat_idx, $cat) {
    ?>
    <div class="alya-tech-category" data-cat-idx="<?php echo esc_attr($cat_idx); ?>">
        <div class="alya-tech-category-header">
            <h3>📁 Category #<span class="cat-num"><?php echo esc_html($cat_idx + 1); ?></span></h3>
            <button type="button" class="button-link alya-remove-cat">Remove Category</button>
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
            <?php foreach ($cat['devices'] as $dev_idx => $dev) :
                alya_tech_device_row($cat_idx, $dev_idx, $dev);
            endforeach; ?>
        </div>

        <p style="margin-top: 12px;">
            <button type="button" class="button alya-add-device" data-cat-idx="<?php echo esc_attr($cat_idx); ?>">+ Add Device</button>
        </p>
    </div>
    <?php
}

function alya_tech_device_row($cat_idx, $dev_idx, $dev) {
    $image_url = $dev['image_id'] ? wp_get_attachment_image_url(intval($dev['image_id']), 'medium') : '';
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

        <div class="alya-field">
            <label>Features (comma-separated)</label>
            <input type="text" name="tech_cat[<?php echo esc_attr($cat_idx); ?>][devices][<?php echo esc_attr($dev_idx); ?>][features]" value="<?php echo esc_attr($dev['features']); ?>" placeholder="Safe, Effective, FDA Approved">
        </div>

        <button type="button" class="button-link-delete alya-remove-dev">Remove Device</button>
    </div>
    <?php
}

add_action('save_post', function ($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['alya_tech_categories_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['alya_tech_categories_nonce']), 'alya_tech_categories_save')) return;
    if (!isset($_POST['tech_cat'])) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (!alya_is_technology_page($post_id)) return;

    $lines = [];
    
    foreach ((array) $_POST['tech_cat'] as $cat_raw) {
        $cat_id      = isset($cat_raw['cat_id']) ? sanitize_text_field($cat_raw['cat_id']) : '';
        $cat_label   = isset($cat_raw['cat_label']) ? sanitize_text_field($cat_raw['cat_label']) : '';
        $cat_title   = isset($cat_raw['cat_title']) ? sanitize_text_field($cat_raw['cat_title']) : '';
        $cat_number  = isset($cat_raw['cat_number']) ? sanitize_text_field($cat_raw['cat_number']) : '';
        $cat_eyebrow = isset($cat_raw['cat_eyebrow']) ? sanitize_text_field($cat_raw['cat_eyebrow']) : '';
        $cat_badge   = isset($cat_raw['cat_badge']) ? sanitize_text_field($cat_raw['cat_badge']) : '';
        $bg_alt      = isset($cat_raw['bg_alt']) ? '1' : '0';

        if (!$cat_id || !$cat_label || !$cat_title) continue;

        $lines[] = 'CAT::' . implode(' | ', [$cat_id, $cat_label, $cat_title, $cat_number, $cat_eyebrow, $cat_badge, $bg_alt]);

        if (isset($cat_raw['devices']) && is_array($cat_raw['devices'])) {
            foreach ($cat_raw['devices'] as $dev_raw) {
                $dev_title  = isset($dev_raw['device_title']) ? sanitize_text_field($dev_raw['device_title']) : '';
                $dev_desc   = isset($dev_raw['device_desc']) ? sanitize_textarea_field($dev_raw['device_desc']) : '';
                $image_id   = isset($dev_raw['image_id']) ? intval($dev_raw['image_id']) : 0;
                $features   = isset($dev_raw['features']) ? sanitize_text_field($dev_raw['features']) : '';
                $brand_tag  = isset($dev_raw['brand_tag']) ? sanitize_text_field($dev_raw['brand_tag']) : '';
                $origin_badge = isset($dev_raw['origin_badge']) ? sanitize_text_field($dev_raw['origin_badge']) : '';

                if (!$dev_title) continue;

                $lines[] = 'DEV::' . implode(' | ', [$dev_title, $dev_desc, $image_id, $features, $brand_tag, $origin_badge]);
            }
        }
    }

    update_post_meta($post_id, 'alya_tech_categories', implode("\n", $lines));
});

add_action('admin_enqueue_scripts', function ($hook) {
    if (!in_array($hook, ['post.php', 'post-new.php'], true)) return;
    $screen = get_current_screen();
    if (!$screen || $screen->id !== 'page') return;

    $post_id = isset($_GET['post']) ? intval($_GET['post']) : 0;
    if ($post_id && !alya_is_technology_page($post_id)) return;

    wp_enqueue_media();
    wp_add_inline_script('jquery', '
(function($){
  if (typeof wp === "undefined" || !wp.media) return;

  var frame = null;

  function catIndex() { return Date.now(); }
  function devIndex() { return Date.now() + Math.floor(Math.random() * 10000); }

  // Media picker
  $(document).on("click", ".alya-pick", function(e){
    e.preventDefault();
    var $btn = $(this);
    var $row = $btn.closest(".alya-tech-device");
    var field = $btn.data("field");

    if (frame) {
      frame.off("select");
    }

    frame = wp.media({
      title: "Select Device Image",
      button: { text: "Use This Image" },
      multiple: false
    });

    frame.on("select", function(){
      var att = frame.state().get("selection").first().toJSON();
      var url = att.sizes && att.sizes.medium ? att.sizes.medium.url : att.url;
      $row.find("input[data-id=\"" + field + "\"]").val(att.id);
      $row.find(".alya-img[data-field=\"" + field + "\"]").html("<img src=\"" + url + "\" alt=\"\">");
    });

    frame.open();
  });

  // Clear image
  $(document).on("click", ".alya-clear", function(e){
    e.preventDefault();
    var $row = $(this).closest(".alya-tech-device");
    var field = $(this).data("field");
    $row.find("input[data-id=\"" + field + "\"]").val("");
    $row.find(".alya-img[data-field=\"" + field + "\"]").html("<span>No image</span>");
  });

  // Add category
  $(document).on("click", "#alya-add-category", function(e){
    e.preventDefault();
    var tpl = $("#alya-category-tpl").html();
    var idx = catIndex();
    var newCat = tpl.replace(/__CAT_IDX__/g, idx);
    $("#alya-tech-categories").append(newCat);
    updateCategoryNumbers();
  });

  // Remove category
  $(document).on("click", ".alya-remove-cat", function(e){
    e.preventDefault();
    if ($("#alya-tech-categories").children(".alya-tech-category").length <= 1) {
      alert("You must have at least one category.");
      return;
    }
    $(this).closest(".alya-tech-category").remove();
    updateCategoryNumbers();
  });

  // Add device
  $(document).on("click", ".alya-add-device", function(e){
    e.preventDefault();
    var $btn = $(this);
    var catIdx = $btn.data("cat-idx");
    var $container = $btn.siblings(".alya-tech-devices");
    var tpl = $("#alya-device-tpl").html();
    var idx = devIndex();
    var newDev = tpl.replace(/__CAT_IDX__/g, catIdx).replace(/__DEV_IDX__/g, idx);
    $container.append(newDev);
  });

  // Remove device
  $(document).on("click", ".alya-remove-dev", function(e){
    e.preventDefault();
    var $devices = $(this).closest(".alya-tech-devices");
    if ($devices.children(".alya-tech-device").length <= 1) {
      alert("Each category must have at least one device.");
      return;
    }
    $(this).closest(".alya-tech-device").remove();
  });

  function updateCategoryNumbers() {
    $("#alya-tech-categories").children(".alya-tech-category").each(function(i){
      $(this).attr("data-cat-idx", i);
      $(this).find(".cat-num").first().text(i + 1);
      $(this).find(".alya-add-device").attr("data-cat-idx", i);
      $(this).find(".alya-tech-devices").attr("data-cat-idx", i);
    });
  }
})(jQuery);
', 'after');
});
