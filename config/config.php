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


function getShortcodeSettings() {
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
                        'id' => 'prism',
                        'val' => __( 'Default', 'rrze-typesettings' )
                    ],
                    [
                        'id' => 'prism-solarizedlight.min',
                        'val' => __( 'Light', 'rrze-typesettings' )
                    ],
                    [
                        'id' => 'dark',
                        'val' => __( 'Dark', 'rrze-typesettings' )
                    ],
                    [
                        'id' => 'okaidia',
                        'val' => __( 'Okaidia', 'rrze-typesettings' )
                    ],
                ],
                'default' => 'default',
                'field_type' => 'select',
                'label' => __( 'Theme', 'rrze-typesettings' ),
                'type' => 'string',
            ],
            'lang' => [
                'values' => [
                    [ 'val' => 'C', 'id' => 'c' ],
                    [ 'val' => 'C++', 'id' => 'cpp' ],
                    [ 'val' => 'C#', 'id' => 'csharp' ],
                    [ 'val' => 'CSS', 'id' => 'css' ],
                    [ 'val' => 'HTML', 'id' => 'markup' ],
                    [ 'val' => 'Java', 'id' => 'java' ],
                    [ 'val' => 'JavaScript', 'id' => 'javascript' ],
                    [ 'val' => 'JSON', 'id' => 'json' ],
                    [ 'val' => 'Perl', 'id' => 'perl' ],
                    [ 'val' => 'PHP', 'id' => 'php' ],
                    [ 'val' => 'Python', 'id' => 'python' ],
                    [ 'val' => 'React', 'id' => 'jsx' ],
                    [ 'val' => 'Regex', 'id' => 'regex' ],
                    [ 'val' => 'SASS', 'id' => 'sass' ],
                    [ 'val' => 'SQL', 'id' => 'sql' ],
                    [ 'val' => 'XML', 'id' => 'markup' ],
                ],
                'default' => 'javascript',
                'field_type' => 'select',
                'label' => __( 'Language', 'rrze-typesettings' ),
                'type' => 'string',
            ]
        ]
    ];
    
    return $ret;
}




