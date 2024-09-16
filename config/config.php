<?php

namespace RRZE\Typesettings\Config;

defined('ABSPATH') || exit;

/**
 * Gibt der Name der Option zurück.
 * @return string [description]
 */
function getOptionName()
{
    return 'rrze-typesettings';
}


/**
 * Gibt die Einstellungen des Menus zurück.
 * @return array [description]
 */
function getMenuSettings()
{
    return [
        'page_title' => __('RRZE Typesettings', 'rrze-typesettings'),
        'menu_title' => __('RRZE Typesettings', 'rrze-typesettings'),
        'capability' => 'manage_options',
        'menu_slug' => 'rrze-typesettings',
        'title' => __('RRZE Typesettings Settings', 'rrze-typesettings'),
    ];
}

/**
 * Gibt die Einstellungen der Inhaltshilfe zurück.
 * @return array [description]
 */
function getHelpTab()
{
    return [
        [
            'id' => 'rrze-typesettings-help',
            'content' => [
                '<p>' . __('Here comes the Context Help content.', 'rrze-typesettings') . '</p>'
            ],
            'title' => __('Overview', 'rrze-typesettings'),
            'sidebar' => sprintf('<p><strong>%1$s:</strong></p><p><a href="https://blogs.fau.de/webworking">RRZE Webworking</a></p><p><a href="https://github.com/RRZE Webteam">%2$s</a></p>', __('For more information', 'rrze-typesettings'), __('RRZE Webteam on Github', 'rrze-typesettings'))
        ]
    ];
}

/**
 * Gibt die Einstellungen der Optionsbereiche zurück.
 * @return array [description]
 */

function getSections()
{
    return [
        [
            'id' => 'designsystemlog',
            'title' => __('Logfile', 'rrze-typesettings')
        ]
    ];
}


function getShortcodeSettings(){
	$ret = [
		'highlight-code' => [
			'linenumber' => [
				'field_type' => 'toggle',
				'label' => __( 'Show line numbers', 'rrze-typesettings' ),
				'type' => 'boolean',
				'default' => true,
				'checked' => true,
			],
			'theme' => [
				'values' => [
					[
						'id' => 'default',
						'val' => __( 'Default', 'rrze-typesettings' )
					],
					[
						'id' => 'light',
						'val' => __( 'Light', 'rrze-typesettings' )
					],
					[
						'id' => 'dark',
						'val' => __( 'Dark', 'rrze-typesettings' )
					],
				],
				'default' => 'default',
				'field_type' => 'select',
				'label' => __( 'Theme', 'rrze-typesettings' ),
				'type' => 'string'
			]
		]
	];
	
	return $ret;
}




