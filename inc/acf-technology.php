<?php
/**
 * ACF Technology Page Fields (Simple Textarea Format - Gallery Style)
 *
 * @package Alya_Esthetic
 */

defined('ABSPATH') || exit;

/**
 * Register ACF field for Technology page using simple textarea format
 * Similar to Gallery page format for guaranteed compatibility
 */
acf_add_local_field_group([
    'key'    => 'group_alya_technology_simple',
    'title'  => 'Technology Content',
    'fields' => [
        [
            'key'          => 'field_alya_tech_items_textarea',
            'label'        => 'Technology Items',
            'name'         => 'alya_tech_items',
            'type'         => 'textarea',
            'rows'         => 20,
            'instructions' => '<strong>Format (one device per line):</strong><br>' .
                              'CategoryID | CategoryLabel | DeviceName | Description | ImageID | Features (comma-separated)<br><br>' .
                              '<strong>Example:</strong><br>' .
                              'laser | Laser Devices | Nd:YAG Laser | Advanced pigmentation treatment | 123 | Safe,Effective,FDA Approved<br>' .
                              'laser | Laser Devices | CO2 Fractional | Skin resurfacing | 124 | Non-invasive,Quick Recovery<br><br>' .
                              '<strong>Tips:</strong><br>' .
                              '- Use same CategoryID for devices in same category<br>' .
                              '- ImageID can be found in Media Library (attachment ID)<br>' .
                              '- Leave ImageID empty (or use 0) for fallback image',
            'placeholder'  => "laser | Laser Devices | Device Name | Description | 123 | Feature1,Feature2,Feature3\ninjection | Injectable | Another Device | Description | 124 | Feature1,Feature2",
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
    'hide_on_screen'  => ['the_content'],
]);
