<?php
/**
 * Leads — Save contact form submissions to database
 *
 * @package Alya_Esthetic
 */

defined('ABSPATH') || exit;

/* ─── Create table on activation ─── */
function alya_leads_create_table() {
    global $wpdb;
    $table = $wpdb->prefix . 'alya_leads';
    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS {$table} (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        name VARCHAR(200) NOT NULL,
        phone VARCHAR(50) NOT NULL DEFAULT '',
        email VARCHAR(200) NOT NULL DEFAULT '',
        service VARCHAR(200) NOT NULL DEFAULT '',
        date_appointment VARCHAR(50) NOT NULL DEFAULT '',
        message TEXT NOT NULL,
        source VARCHAR(100) NOT NULL DEFAULT 'contact_page',
        status VARCHAR(50) NOT NULL DEFAULT 'new',
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY idx_status (status),
        KEY idx_created (created_at)
    ) {$charset};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
add_action('after_switch_theme', 'alya_leads_create_table');

function alya_leads_ensure_table() {
    global $wpdb;
    $table = $wpdb->prefix . 'alya_leads';
    if ($wpdb->get_var("SHOW TABLES LIKE '{$table}'") !== $table) {
        alya_leads_create_table();
    }
}
add_action('init', 'alya_leads_ensure_table');

/* ─── AJAX handler ─── */
add_action('wp_ajax_alya_save_lead', 'alya_save_lead');
add_action('wp_ajax_nopriv_alya_save_lead', 'alya_save_lead');

function alya_save_lead() {
    check_ajax_referer('alya_nonce', 'nonce');

    global $wpdb;
    $table = $wpdb->prefix . 'alya_leads';

    $name    = sanitize_text_field(wp_unslash($_POST['name'] ?? ''));
    $phone   = sanitize_text_field(wp_unslash($_POST['phone'] ?? ''));
    $email   = sanitize_email($_POST['email'] ?? '');
    $service = sanitize_text_field(wp_unslash($_POST['service'] ?? ''));
    $date    = sanitize_text_field(wp_unslash($_POST['date'] ?? ''));
    $message = sanitize_textarea_field(wp_unslash($_POST['message'] ?? ''));

    if (empty($name) || empty($phone)) {
        wp_send_json_error(['message' => 'Nama dan nomor WhatsApp wajib diisi.']);
    }

    $inserted = $wpdb->insert($table, [
        'name'             => $name,
        'phone'            => $phone,
        'email'            => $email,
        'service'          => $service,
        'date_appointment' => $date,
        'message'          => $message,
        'source'           => 'contact_page',
        'status'           => 'new',
        'created_at'       => current_time('mysql'),
    ]);

    if ($inserted) {
        wp_send_json_success(['message' => 'Lead berhasil disimpan.', 'id' => $wpdb->insert_id]);
    } else {
        wp_send_json_error(['message' => 'Gagal menyimpan lead.']);
    }
}

/* ─── Export must run before admin output ─── */
add_action('admin_init', function () {
    if (!isset($_GET['page']) || $_GET['page'] !== 'alya-leads' || !isset($_GET['export_leads'])) return;
    if (!check_admin_referer('alya_export_leads')) return;

    global $wpdb;
    alya_leads_export_xlsx($wpdb->prefix . 'alya_leads');
});

/* ─── Admin menu ─── */
add_action('admin_menu', function () {
    add_menu_page(
        'Leads',
        'Leads',
        'manage_options',
        'alya-leads',
        'alya_leads_admin_page',
        'dashicons-id-alt',
        31
    );
});

/* ─── Build WHERE clause from filters (shared by list & export) ─── */
function alya_leads_build_query($table) {
    global $wpdb;

    $f_status  = isset($_GET['f_status']) ? sanitize_text_field($_GET['f_status']) : '';
    $f_search  = isset($_GET['f_search']) ? sanitize_text_field($_GET['f_search']) : '';
    $f_from    = isset($_GET['f_from']) ? sanitize_text_field($_GET['f_from']) : '';
    $f_to      = isset($_GET['f_to']) ? sanitize_text_field($_GET['f_to']) : '';
    $f_service = isset($_GET['f_service']) ? sanitize_text_field($_GET['f_service']) : '';

    $where  = [];
    $values = [];

    if ($f_status && in_array($f_status, ['new','contacted','converted','archived'])) {
        $where[]  = 'status = %s';
        $values[] = $f_status;
    }
    if ($f_service) {
        $where[]  = 'service = %s';
        $values[] = $f_service;
    }
    if ($f_from) {
        $where[]  = 'created_at >= %s';
        $values[] = $f_from . ' 00:00:00';
    }
    if ($f_to) {
        $where[]  = 'created_at <= %s';
        $values[] = $f_to . ' 23:59:59';
    }
    if ($f_search) {
        $where[]  = '(name LIKE %s OR phone LIKE %s OR email LIKE %s OR message LIKE %s)';
        $like = '%' . $wpdb->esc_like($f_search) . '%';
        $values = array_merge($values, [$like, $like, $like, $like]);
    }

    $where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
    $query     = $values ? $wpdb->prepare("SELECT * FROM {$table} {$where_sql} ORDER BY created_at DESC", ...$values)
                         : "SELECT * FROM {$table} ORDER BY created_at DESC";

    return $wpdb->get_results($query);
}

/* ─── Build current filter args for subsubsub links ─── */
function alya_leads_filter_args($overrides = []) {
    $args = ['page' => 'alya-leads'];
    foreach (['f_search','f_from','f_to','f_service'] as $key) {
        if (!empty($_GET[$key])) {
            $args[$key] = sanitize_text_field($_GET[$key]);
        }
    }
    return array_merge($args, $overrides);
}

function alya_leads_admin_page() {
    global $wpdb;
    $table = $wpdb->prefix . 'alya_leads';

    /* Handle status update */
    if (isset($_POST['alya_lead_status']) && isset($_POST['lead_id']) && check_admin_referer('alya_lead_status')) {
        $new_status = sanitize_text_field($_POST['alya_lead_status']);
        $lead_id    = absint($_POST['lead_id']);
        $wpdb->update($table, ['status' => $new_status], ['id' => $lead_id]);
        echo '<div class="notice notice-success"><p>Status diperbarui.</p></div>';
    }

    /* Handle delete */
    if (isset($_GET['delete_lead']) && check_admin_referer('alya_delete_lead')) {
        $wpdb->delete($table, ['id' => absint($_GET['delete_lead'])]);
        echo '<div class="notice notice-success"><p>Lead dihapus.</p></div>';
    }

    $f_status  = isset($_GET['f_status']) ? sanitize_text_field($_GET['f_status']) : '';
    $f_search  = isset($_GET['f_search']) ? sanitize_text_field($_GET['f_search']) : '';
    $f_from    = isset($_GET['f_from']) ? sanitize_text_field($_GET['f_from']) : '';
    $f_to      = isset($_GET['f_to']) ? sanitize_text_field($_GET['f_to']) : '';
    $f_service = isset($_GET['f_service']) ? sanitize_text_field($_GET['f_service']) : '';

    $leads    = alya_leads_build_query($table);
    $counts   = $wpdb->get_results("SELECT status, COUNT(*) as c FROM {$table} GROUP BY status", OBJECT_K);
    $services = $wpdb->get_col("SELECT DISTINCT service FROM {$table} WHERE service != '' ORDER BY service");
    ?>
    <style>
        .alya-filter-bar{display:flex;flex-wrap:wrap;gap:10px;align-items:flex-end;margin:16px 0;padding:14px 16px;background:#fff;border:1px solid #c3c4c7;border-radius:6px}
        .alya-filter-bar .field{display:flex;flex-direction:column;gap:4px}
        .alya-filter-bar label{font-size:12px;font-weight:600;color:#1d2327}
        .alya-filter-bar input,.alya-filter-bar select{height:32px;padding:0 10px;border:1px solid #8c8f94;border-radius:4px;font-size:13px}
        .alya-filter-bar input[type="date"]{width:150px}
        .alya-filter-bar input[type="text"]{width:200px}
        .alya-filter-bar .btn-filter{height:32px;padding:0 16px;background:#2271b1;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:13px;font-weight:600}
        .alya-filter-bar .btn-filter:hover{background:#135e96}
        .alya-filter-bar .btn-reset{height:32px;padding:0 12px;background:#fff;color:#1d2327;border:1px solid #8c8f94;border-radius:4px;cursor:pointer;font-size:13px;text-decoration:none;line-height:32px}
        .alya-filter-bar .btn-export{height:32px;padding:0 16px;background:#00a32a;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:13px;font-weight:600;text-decoration:none;line-height:32px}
        .alya-filter-bar .btn-export:hover{background:#008a20}
        .alya-count-display{margin:8px 0 0;font-size:13px;color:#646970}
    </style>

    <div class="wrap">
        <h1>Leads</h1>

        <form method="get" class="alya-filter-bar">
            <input type="hidden" name="page" value="alya-leads">
            <div class="field">
                <label for="f_search">Cari</label>
                <input type="text" id="f_search" name="f_search" placeholder="Nama, WA, email..." value="<?php echo esc_attr($f_search); ?>">
            </div>
            <div class="field">
                <label for="f_service">Layanan</label>
                <select id="f_service" name="f_service">
                    <option value="">Semua Layanan</option>
                    <?php foreach ($services as $s) : ?>
                        <option value="<?php echo esc_attr($s); ?>" <?php selected($f_service, $s); ?>><?php echo esc_html($s); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="field">
                <label for="f_from">Dari Tanggal</label>
                <input type="date" id="f_from" name="f_from" value="<?php echo esc_attr($f_from); ?>">
            </div>
            <div class="field">
                <label for="f_to">Sampai Tanggal</label>
                <input type="date" id="f_to" name="f_to" value="<?php echo esc_attr($f_to); ?>">
            </div>
            <div class="field">
                <label for="f_status">Status</label>
                <select id="f_status" name="f_status">
                    <option value="">Semua Status</option>
                    <?php foreach (['new'=>'Baru','contacted'=>'Dihubungi','converted'=>'Konversi','archived'=>'Arsip'] as $k => $v) : ?>
                        <option value="<?php echo $k; ?>" <?php selected($f_status, $k); ?>><?php echo $v; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn-filter">Filter</button>
            <a href="<?php echo esc_url(admin_url(add_query_arg(['page'=>'alya-leads'], 'admin.php'))); ?>" class="btn-reset">Reset</a>
            <a href="<?php echo esc_url(wp_nonce_url(admin_url(add_query_arg(alya_leads_filter_args(['page'=>'alya-leads','export_leads'=>1]), 'admin.php')), 'alya_export_leads')); ?>" class="btn-export">&#8615; Export Excel</a>
        </form>

        <p class="alya-count-display">Menampilkan <?php echo count($leads); ?> lead.</p>

        <table class="widefat striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>WhatsApp</th>
                    <th>Email</th>
                    <th>Layanan</th>
                    <th>Tanggal</th>
                    <th>Pesan</th>
                    <th>Status</th>
                    <th>Tanggal Kirim</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($leads)) : ?>
                <tr><td colspan="10">Tidak ada lead ditemukan.</td></tr>
            <?php else : foreach ($leads as $lead) : ?>
                <tr>
                    <td><?php echo esc_html($lead->id); ?></td>
                    <td><strong><?php echo esc_html($lead->name); ?></strong></td>
                    <td><a href="https://wa.me/<?php echo esc_attr($lead->phone); ?>" target="_blank"><?php echo esc_html($lead->phone); ?></a></td>
                    <td><?php echo esc_html($lead->email ?: '-'); ?></td>
                    <td><?php echo esc_html($lead->service); ?></td>
                    <td><?php echo esc_html($lead->date_appointment ?: '-'); ?></td>
                    <td style="max-width:200px;white-space:pre-line"><?php echo esc_html($lead->message); ?></td>
                    <td>
                        <form method="post" style="display:inline">
                            <?php wp_nonce_field('alya_lead_status'); ?>
                            <input type="hidden" name="lead_id" value="<?php echo esc_attr($lead->id); ?>">
                            <select name="alya_lead_status" onchange="this.form.submit()">
                                <?php foreach (['new'=>'Baru','contacted'=>'Dihubungi','converted'=>'Konversi','archived'=>'Arsip'] as $k => $v) : ?>
                                    <option value="<?php echo $k; ?>" <?php selected($lead->status, $k); ?>><?php echo $v; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </td>
                    <td><?php echo esc_html($lead->created_at); ?></td>
                    <td>
                        <a href="<?php echo wp_nonce_url(admin_url("admin.php?page=alya-leads&delete_lead={$lead->id}"), 'alya_delete_lead'); ?>" onclick="return confirm('Hapus lead ini?')" style="color:#a00">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}

/* ─── Export .xlsx (no external library — pure ZIP + XML) ─── */
function alya_leads_export_xlsx($table) {
    $leads = alya_leads_build_query($table);

    $status_labels = ['new'=>'Baru','contacted'=>'Dihubungi','converted'=>'Konversi','archived'=>'Arsip'];

    $headers = ['ID', 'Nama', 'WhatsApp', 'Email', 'Layanan', 'Tanggal Janji', 'Pesan', 'Status', 'Sumber', 'Tanggal Kirim'];

    $rows = [];
    foreach ($leads as $lead) {
        $rows[] = [
            (int) $lead->id,
            $lead->name,
            $lead->phone,
            $lead->email,
            $lead->service,
            $lead->date_appointment,
            $lead->message,
            $status_labels[$lead->status] ?? $lead->status,
            $lead->source,
            $lead->created_at,
        ];
    }

    $col_count = count($headers);

    /* ── sheet1.xml ── */
    $xml_rows = '';

    /* Header row */
    $xml_rows .= '<row r="1">';
    foreach ($headers as $i => $h) {
        $ref = alya_xlsx_cell($i) . '1';
        $xml_rows .= '<c r="' . $ref . '" t="inlineStr"><is><t>' . alya_xlsx_esc($h) . '</t></is></c>';
    }
    $xml_rows .= '</row>';

    /* Data rows */
    foreach ($rows as $ri => $row) {
        $r = $ri + 2;
        $xml_rows .= '<row r="' . $r . '">';
        foreach ($row as $ci => $val) {
            $ref = alya_xlsx_cell($ci) . $r;
            if (is_int($val)) {
                $xml_rows .= '<c r="' . $ref . '" t="n"><v>' . $val . '</v></c>';
            } else {
                $xml_rows .= '<c r="' . $ref . '" t="inlineStr"><is><t>' . alya_xlsx_esc($val) . '</t></is></c>';
            }
        }
        $xml_rows .= '</row>';
    }

    $last_ref = alya_xlsx_cell($col_count - 1) . (count($rows) + 1);

    $sheet1 = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"
           xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
<sheetData>' . $xml_rows . '</sheetData>
<autoFilter ref="A1:' . $last_ref . '"/>
</worksheet>';

    /* ── sharedStrings.xml (empty but required) ── */
    $shared = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<sst xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" count="0" uniqueCount="0"/>';

    /* ── styles.xml ── */
    $styles = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
<fonts count="1"><font><sz val="11"/><name val="Calibri"/></font></fonts>
<fills count="2"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill></fills>
<borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders>
<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>
<cellXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/></cellXfs>
</styleSheet>';

    /* ── [Content_Types].xml ── */
    $content_types = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
<Default Extension="xml" ContentType="application/xml"/>
<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>
<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>
<Override PartName="/xl/sharedStrings.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStrings+xml"/>
</Types>';

    /* ── workbook.xml ── */
    $workbook = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"
          xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
<sheets><sheet name="Leads" sheetId="1" r:id="rId1"/></sheets>
</workbook>';

    /* ── _rels/workbook.xml.rels ── */
    $wb_rels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>
<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>
<Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings" Target="sharedStrings.xml"/>
</Relationships>';

    /* ── _rels/.rels ── */
    $root_rels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>
</Relationships>';

    /* ── Build ZIP ── */
    $filename = 'leads-' . date('Y-m-d-His') . '.xlsx';

    /* Flush all output buffers */
    while (ob_get_level()) {
        ob_end_clean();
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: public');

    $zip = new ZipArchive();
    $tmp = tempnam(sys_get_temp_dir(), 'alya_xlsx');
    $zip->open($tmp, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    $zip->addFromString('[Content_Types].xml', $content_types);
    $zip->addFromString('_rels/.rels', $root_rels);
    $zip->addFromString('xl/workbook.xml', $workbook);
    $zip->addFromString('xl/_rels/workbook.xml.rels', $wb_rels);
    $zip->addFromString('xl/worksheets/sheet1.xml', $sheet1);
    $zip->addFromString('xl/styles.xml', $styles);
    $zip->addFromString('xl/sharedStrings.xml', $shared);

    $zip->close();

    readfile($tmp);
    @unlink($tmp);
    exit;
}

function alya_xlsx_cell($col) {
    $s = '';
    while ($col >= 0) {
        $s = chr(65 + ($col % 26)) . $s;
        $col = intdiv($col, 26) - 1;
    }
    return $s;
}

function alya_xlsx_esc($str) {
    return htmlspecialchars((string) $str, ENT_XML1, 'UTF-8');
}
