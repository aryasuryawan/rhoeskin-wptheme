<?php
/**
 * Technology Items — Custom Repeater Meta Box
 *
 * Replaces nested ACF repeater with a friendly repeatable UI.
 * Data is stored as one line per device:
 *   CategoryID | CategoryLabel | DeviceName | Description | ImageID | Features
 *
 * @package Alya_Esthetic
 */

defined('ABSPATH') || exit;

add_action('add_meta_boxes', function () {
    add_meta_box(
        'alya_tech_items_box',
        'Technology Items',
        'alya_tech_items_box_render',
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

function alya_tech_items_box_render($post) {
    if (!alya_is_technology_page($post->ID)) {
        echo '<p>Meta box ini hanya aktif pada halaman dengan template "Technology Page".</p>';
        return;
    }

    wp_nonce_field('alya_tech_items_save', 'alya_tech_items_nonce');

    $raw = get_post_meta($post->ID, 'alya_tech_items', true);
    $items = [];

    if (is_string($raw) && !empty(trim($raw))) {
        foreach (array_filter(array_map('trim', explode("\n", $raw))) as $line) {
            $parts = array_map('trim', explode('|', $line));
            $items[] = [
                'cat_id'    => $parts[0] ?? '',
                'cat_label' => $parts[1] ?? '',
                'device'    => $parts[2] ?? '',
                'desc'      => $parts[3] ?? '',
                'image_id'  => $parts[4] ?? '',
                'features'  => $parts[5] ?? '',
            ];
        }
    }

    if (empty($items)) {
        $items[] = alya_tech_empty_item();
    }

    ?>
    <style>
        #alya-tech-rows .alya-tech-row {
            border: 1px solid #ccd0d4;
            border-radius: 6px;
            padding: 14px;
            margin-bottom: 12px;
            background: #fafafa;
        }
        #alya-tech-rows .alya-img {
            width: 180px;
            height: 140px;
            border: 1px dashed #999;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-top: 4px;
        }
        #alya-tech-rows .alya-img img { max-width: 100%; height: auto; display: block; }
        #alya-tech-rows .alya-img span { color: #999; font-size: 12px; padding: 4px; text-align: center; }
        #alya-tech-rows .alya-field { margin-bottom: 8px; }
        #alya-tech-rows .alya-field label { display: block; font-weight: 600; margin-bottom: 3px; }
        #alya-tech-rows .alya-field input[type=text],
        #alya-tech-rows .alya-field textarea { width: 100%; }
        #alya-tech-rows .alya-grid { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 10px; }
        #alya-tech-rows .alya-img-col { flex: 0 0 180px; }
        #alya-tech-rows .alya-remove { color: #a00; }
    </style>

    <div id="alya-tech-rows">
        <?php foreach ($items as $i => $item) :
            alya_tech_item_row(esc_attr($i), $item);
        endforeach; ?>
    </div>

    <p>
        <button type="button" class="button button-primary" id="alya-tech-add">+ Tambah Device</button>
    </p>
    <p class="description">
        Tambah device/alat teknologi dengan gambar dan fitur-fiturnya. Gunakan <strong>Category ID</strong> yang sama untuk mengelompokkan device dalam satu kategori.
    </p>

    <script type="text/html" id="alya-tech-tpl">
        <?php alya_tech_item_row('__IDX__', alya_tech_empty_item()); ?>
    </script>
    <?php
}

function alya_tech_empty_item() {
    return [
        'cat_id'    => '',
        'cat_label' => '',
        'device'    => '',
        'desc'      => '',
        'image_id'  => '',
        'features'  => '',
    ];
}

function alya_tech_item_row($i, $item) {
    $image_url = $item['image_id'] ? wp_get_attachment_image_url(intval($item['image_id']), 'medium') : '';
    ?>
    <div class="alya-tech-row">
        <div class="alya-grid">
            <div class="alya-img-col">
                <label>Device Image</label>
                <div class="alya-img" data-field="image">
                    <?php if ($image_url) : ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="">
                    <?php else : ?>
                        <span>No image</span>
                    <?php endif; ?>
                </div>
                <input type="hidden" name="alya_tech[<?php echo esc_attr($i); ?>][image_id]" data-id="image" value="<?php echo esc_attr($item['image_id']); ?>">
                <p>
                    <button type="button" class="button button-small alya-pick" data-field="image">Select Image</button>
                    <button type="button" class="button button-small alya-clear" data-field="image">Remove</button>
                </p>
            </div>

            <div style="flex: 1;">
                <div class="alya-grid">
                    <div class="alya-field" style="flex:1 1 200px">
                        <label>Category ID <span style="color:#d63638">*</span></label>
                        <input type="text" name="alya_tech[<?php echo esc_attr($i); ?>][cat_id]" value="<?php echo esc_attr($item['cat_id']); ?>" placeholder="e.g., laser-devices" required>
                        <small>Use same ID to group devices (e.g., laser-devices, injection, slimming)</small>
                    </div>
                    <div class="alya-field" style="flex:1 1 200px">
                        <label>Category Label <span style="color:#d63638">*</span></label>
                        <input type="text" name="alya_tech[<?php echo esc_attr($i); ?>][cat_label]" value="<?php echo esc_attr($item['cat_label']); ?>" placeholder="e.g., Laser Devices" required>
                    </div>
                </div>

                <div class="alya-field">
                    <label>Device Name <span style="color:#d63638">*</span></label>
                    <input type="text" name="alya_tech[<?php echo esc_attr($i); ?>][device]" value="<?php echo esc_attr($item['device']); ?>" placeholder="e.g., Nd:YAG Laser" required>
                </div>
            </div>
        </div>

        <div class="alya-field">
            <label>Description</label>
            <textarea name="alya_tech[<?php echo esc_attr($i); ?>][desc]" rows="2" placeholder="Brief description of the device"><?php echo esc_textarea($item['desc']); ?></textarea>
        </div>

        <div class="alya-field">
            <label>Features (comma-separated)</label>
            <input type="text" name="alya_tech[<?php echo esc_attr($i); ?>][features]" value="<?php echo esc_attr($item['features']); ?>" placeholder="Safe, Effective, FDA Approved, Non-invasive">
            <small>Separate features with commas</small>
        </div>

        <div>
            <button type="button" class="button-link-delete alya-remove">Remove Device</button>
        </div>
    </div>
    <?php
}

add_action('save_post', function ($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['alya_tech_items_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['alya_tech_items_nonce']), 'alya_tech_items_save')) return;
    if (!isset($_POST['alya_tech'])) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (!alya_is_technology_page($post_id)) return;

    $rows = [];
    foreach ((array) $_POST['alya_tech'] as $raw) {
        $cat_id    = isset($raw['cat_id']) ? sanitize_text_field($raw['cat_id']) : '';
        $cat_label = isset($raw['cat_label']) ? sanitize_text_field($raw['cat_label']) : '';
        $device    = isset($raw['device']) ? sanitize_text_field($raw['device']) : '';
        $desc      = isset($raw['desc']) ? sanitize_textarea_field($raw['desc']) : '';
        $image_id  = isset($raw['image_id']) ? intval($raw['image_id']) : 0;
        $features  = isset($raw['features']) ? sanitize_text_field($raw['features']) : '';

        if (!$cat_id || !$cat_label || !$device) continue;

        $rows[] = implode(' | ', [$cat_id, $cat_label, $device, $desc, $image_id, $features]);
    }

    update_post_meta($post_id, 'alya_tech_items', implode("\n", $rows));
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

  var frame = null, targetRow = null, targetField = null;

  function rowIndex() { return Date.now() + Math.floor(Math.random() * 1000); }

  $("#alya-tech-rows").on("click", ".alya-pick", function(e){
    e.preventDefault();
    targetRow = $(this).closest(".alya-tech-row");
    targetField = $(this).data("field");

    if (frame) { frame.open(); return; }

    frame = wp.media({
      title: "Select Device Image",
      button: { text: "Use This Image" },
      multiple: false
    });

    frame.on("select", function(){
      var att = frame.state().get("selection").first().toJSON();
      if (!targetRow || !targetField) return;
      var url = att.sizes && att.sizes.medium ? att.sizes.medium.url : att.url;
      targetRow.find("input[data-id=\"" + targetField + "\"]").val(att.id);
      targetRow.find(".alya-img[data-field=\"" + targetField + "\"]").html("<img src=\"" + url + "\" alt=\"\">");
    });

    frame.open();
  });

  $("#alya-tech-rows").on("click", ".alya-clear", function(e){
    e.preventDefault();
    var $row = $(this).closest(".alya-tech-row");
    var field = $(this).data("field");
    $row.find("input[data-id=\"" + field + "\"]").val("");
    $row.find(".alya-img[data-field=\"" + field + "\"]").html("<span>No image</span>");
  });

  $("#alya-tech-add").on("click", function(e){
    e.preventDefault();
    var tpl = $("#alya-tech-tpl").html();
    $("#alya-tech-rows").append(tpl.replace(/__IDX__/g, rowIndex()));
  });

  $("#alya-tech-rows").on("click", ".alya-remove", function(e){
    e.preventDefault();
    var $rows = $("#alya-tech-rows").children(".alya-tech-row");
    if ($rows.length <= 1) {
      var tpl = $("#alya-tech-tpl").html();
      $("#alya-tech-rows").empty().append(tpl.replace(/__IDX__/g, rowIndex()));
    } else {
      $(this).closest(".alya-tech-row").remove();
    }
  });
})(jQuery);
', 'after');
});
