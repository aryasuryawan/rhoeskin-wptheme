<?php
/**
 * Gallery Items — Custom Repeater Meta Box (ACF Free compatible)
 *
 * Replaces the pipe-delimited textarea for `alya_gallery_items` with a
 * friendly repeatable UI. Data is still stored as one line per item:
 *   Before_ID | After_ID | category | tag | title | desc | duration | patient
 *
 * @package Alya_Esthetic
 */

defined('ABSPATH') || exit;

add_action('add_meta_boxes', function () {
    add_meta_box(
        'alya_gallery_items_box',
        'Galeri Item (Before & After)',
        'alya_gallery_items_box_render',
        'page',
        'normal',
        'high'
    );
});

function alya_is_gallery_page($post_id = 0) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return $post_id && get_page_template_slug($post_id) === 'templates/page-gallery.php';
}

function alya_gallery_items_box_render($post) {
    if (!alya_is_gallery_page($post->ID)) {
        echo '<p>Meta box ini hanya aktif pada halaman dengan template "Before & After Gallery".</p>';
        return;
    }

    wp_nonce_field('alya_gallery_items_save', 'alya_gallery_items_nonce');

    $raw = get_post_meta($post->ID, 'alya_gallery_items', true);
    $items = [];

    if (is_string($raw) && !empty(trim($raw))) {
        foreach (array_filter(array_map('trim', explode("\n", $raw))) as $line) {
            $parts = array_map('trim', explode('|', $line));
            $items[] = [
                'before'   => $parts[0] ?? '',
                'after'    => $parts[1] ?? '',
                'cat'      => $parts[2] ?? '',
                'tag'      => $parts[3] ?? '',
                'title'    => $parts[4] ?? '',
                'desc'     => $parts[5] ?? '',
                'duration' => $parts[6] ?? '',
                'patient'  => $parts[7] ?? '',
            ];
        }
    }

    if (empty($items)) {
        $items[] = alya_gallery_empty_item();
    }

    $cats = alya_gallery_categories();
    ?>
    <style>
        #alya-gallery-rows .alya-gallery-row {
            border: 1px solid #ccd0d4;
            border-radius: 6px;
            padding: 14px;
            margin-bottom: 12px;
            background: #fafafa;
        }
        #alya-gallery-rows .alya-img {
            width: 140px;
            height: 100px;
            border: 1px dashed #999;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-top: 4px;
        }
        #alya-gallery-rows .alya-img img { max-width: 100%; height: auto; display: block; }
        #alya-gallery-rows .alya-img span { color: #999; font-size: 12px; padding: 4px; text-align: center; }
        #alya-gallery-rows .alya-field { margin-bottom: 8px; }
        #alya-gallery-rows .alya-field label { display: block; font-weight: 600; margin-bottom: 3px; }
        #alya-gallery-rows .alya-field input[type=text],
        #alya-gallery-rows .alya-field textarea,
        #alya-gallery-rows .alya-field select { width: 100%; }
        #alya-gallery-rows .alya-grid { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 10px; }
        #alya-gallery-rows .alya-img-col { flex: 0 0 140px; }
        #alya-gallery-rows .alya-remove { color: #a00; }
    </style>

    <div id="alya-gallery-rows">
        <?php foreach ($items as $i => $item) :
            alya_gallery_item_row(esc_attr($i), $item, $cats);
        endforeach; ?>
    </div>

    <p>
        <button type="button" class="button button-primary" id="alya-gallery-add">+ Tambah Item</button>
    </p>
    <p class="description">Pilih gambar Before &amp; After dari Media Library untuk setiap item. Kategori dipakai untuk filter tab di halaman galeri.</p>

    <script type="text/html" id="alya-gallery-tpl">
        <?php alya_gallery_item_row('__IDX__', alya_gallery_empty_item(), $cats); ?>
    </script>
    <?php
}

function alya_gallery_categories() {
    return [
        'acne'        => 'Acne & Bekas Jerawat',
        'laser'       => 'Laser Treatment',
        'slimming'    => 'Slimming',
        'rejuvenation' => 'Rejuvenasi',
        'filler'      => 'Filler & Botox',
    ];
}

function alya_gallery_empty_item() {
    return [
        'before'   => '',
        'after'    => '',
        'cat'      => '',
        'tag'      => '',
        'title'    => '',
        'desc'     => '',
        'duration' => '',
        'patient'  => '',
    ];
}

function alya_gallery_item_row($i, $item, $cats) {
    $cats  = alya_gallery_categories();
    $before_url = $item['before'] ? wp_get_attachment_image_url(intval($item['before']), 'medium') : '';
    $after_url  = $item['after']  ? wp_get_attachment_image_url(intval($item['after']), 'medium') : '';
    ?>
    <div class="alya-gallery-row">
        <div class="alya-grid">
            <div class="alya-img-col">
                <label>Gambar Before</label>
                <div class="alya-img" data-field="before">
                    <?php if ($before_url) : ?>
                        <img src="<?php echo esc_url($before_url); ?>" alt="">
                    <?php else : ?>
                        <span>Belum ada gambar</span>
                    <?php endif; ?>
                </div>
                <input type="hidden" name="alya_gallery[<?php echo esc_attr($i); ?>][before]" data-id="before" value="<?php echo esc_attr($item['before']); ?>">
                <p>
                    <button type="button" class="button button-small alya-pick" data-field="before">Pilih</button>
                    <button type="button" class="button button-small alya-clear" data-field="before">Hapus</button>
                </p>
            </div>
            <div class="alya-img-col">
                <label>Gambar After</label>
                <div class="alya-img" data-field="after">
                    <?php if ($after_url) : ?>
                        <img src="<?php echo esc_url($after_url); ?>" alt="">
                    <?php else : ?>
                        <span>Belum ada gambar</span>
                    <?php endif; ?>
                </div>
                <input type="hidden" name="alya_gallery[<?php echo esc_attr($i); ?>][after]" data-id="after" value="<?php echo esc_attr($item['after']); ?>">
                <p>
                    <button type="button" class="button button-small alya-pick" data-field="after">Pilih</button>
                    <button type="button" class="button button-small alya-clear" data-field="after">Hapus</button>
                </p>
            </div>
        </div>

        <div class="alya-grid">
            <div class="alya-field" style="flex:1 1 220px">
                <label>Kategori</label>
                <select name="alya_gallery[<?php echo esc_attr($i); ?>][cat]">
                    <option value="">— Pilih Kategori —</option>
                    <?php foreach ($cats as $val => $label) : ?>
                        <option value="<?php echo esc_attr($val); ?>" <?php selected($item['cat'], $val); ?>><?php echo esc_html($label); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="alya-field" style="flex:1 1 220px">
                <label>Tag / Treatment</label>
                <input type="text" name="alya_gallery[<?php echo esc_attr($i); ?>][tag]" value="<?php echo esc_attr($item['tag']); ?>" placeholder="Contoh: Facial Treatment">
            </div>
            <div class="alya-field" style="flex:1 1 220px">
                <label>Judul</label>
                <input type="text" name="alya_gallery[<?php echo esc_attr($i); ?>][title]" value="<?php echo esc_attr($item['title']); ?>" placeholder="Contoh: Hydra Facial Glow Up">
            </div>
        </div>

        <div class="alya-grid">
            <div class="alya-field" style="flex:1 1 220px">
                <label>Durasi</label>
                <input type="text" name="alya_gallery[<?php echo esc_attr($i); ?>][duration]" value="<?php echo esc_attr($item['duration']); ?>" placeholder="Contoh: 60 menit">
            </div>
            <div class="alya-field" style="flex:1 1 220px">
                <label>Info Pasien</label>
                <input type="text" name="alya_gallery[<?php echo esc_attr($i); ?>][patient]" value="<?php echo esc_attr($item['patient']); ?>" placeholder="Contoh: Wanita, 28 tahun">
            </div>
        </div>

        <div class="alya-field">
            <label>Deskripsi</label>
            <textarea name="alya_gallery[<?php echo esc_attr($i); ?>][desc]" rows="2"><?php echo esc_textarea($item['desc']); ?></textarea>
        </div>

        <div>
            <button type="button" class="button-link-delete alya-remove">Hapus Item Ini</button>
        </div>
    </div>
    <?php
}

add_action('save_post', function ($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['alya_gallery_items_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['alya_gallery_items_nonce']), 'alya_gallery_items_save')) return;
    if (!isset($_POST['alya_gallery'])) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (!alya_is_gallery_page($post_id)) return;

    $rows = [];
    foreach ((array) $_POST['alya_gallery'] as $raw) {
        $before = isset($raw['before']) ? intval($raw['before']) : 0;
        $after  = isset($raw['after']) ? intval($raw['after']) : 0;
        $title  = isset($raw['title']) ? sanitize_text_field($raw['title']) : '';
        $tag    = isset($raw['tag']) ? sanitize_text_field($raw['tag']) : '';
        $desc   = isset($raw['desc']) ? sanitize_textarea_field($raw['desc']) : '';
        $cat    = isset($raw['cat']) ? sanitize_text_field($raw['cat']) : '';
        $dur    = isset($raw['duration']) ? sanitize_text_field($raw['duration']) : '';
        $pat    = isset($raw['patient']) ? sanitize_text_field($raw['patient']) : '';

        if (!$before && !$after && !$title && !$desc) continue;

        $rows[] = implode(' | ', [$before, $after, $cat, $tag, $title, $desc, $dur, $pat]);
    }

    update_post_meta($post_id, 'alya_gallery_items', implode("\n", $rows));
});

add_action('admin_enqueue_scripts', function ($hook) {
    if (!in_array($hook, ['post.php', 'post-new.php'], true)) return;
    $screen = get_current_screen();
    if (!$screen || $screen->id !== 'page') return;

    $post_id = isset($_GET['post']) ? intval($_GET['post']) : 0;
    if ($post_id && !alya_is_gallery_page($post_id)) return;

    wp_enqueue_media();
    wp_add_inline_script('jquery', '
(function($){
  if (typeof wp === "undefined" || !wp.media) return;

  var frame = null, targetRow = null, targetField = null;

  function rowIndex() { return Date.now() + Math.floor(Math.random() * 1000); }

  $("#alya-gallery-rows").on("click", ".alya-pick", function(e){
    e.preventDefault();
    targetRow = $(this).closest(".alya-gallery-row");
    targetField = $(this).data("field");

    if (frame) { frame.open(); return; }

    frame = wp.media({
      title: "Pilih Gambar",
      button: { text: "Gunakan Gambar Ini" },
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

  $("#alya-gallery-rows").on("click", ".alya-clear", function(e){
    e.preventDefault();
    var $row = $(this).closest(".alya-gallery-row");
    var field = $(this).data("field");
    $row.find("input[data-id=\"" + field + "\"]").val("");
    $row.find(".alya-img[data-field=\"" + field + "\"]").html("<span>Belum ada gambar</span>");
  });

  $("#alya-gallery-add").on("click", function(e){
    e.preventDefault();
    var tpl = $("#alya-gallery-tpl").html();
    $("#alya-gallery-rows").append(tpl.replace(/__IDX__/g, rowIndex()));
  });

  $("#alya-gallery-rows").on("click", ".alya-remove", function(e){
    e.preventDefault();
    var $rows = $("#alya-gallery-rows").children(".alya-gallery-row");
    if ($rows.length <= 1) {
      var tpl = $("#alya-gallery-tpl").html();
      $("#alya-gallery-rows").empty().append(tpl.replace(/__IDX__/g, rowIndex()));
    } else {
      $(this).closest(".alya-gallery-row").remove();
    }
  });
})(jQuery);
', 'after');
});
