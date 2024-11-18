<?php

namespace RRZE\Typesettings;

defined('ABSPATH') || exit;

use RRZE\Typesettings\CustomException;

use RRZE\Typesettings\Shortcode;

/**
 * Hauptklasse (Main)
 */
class Main
{
    /**
     * Der vollständige Pfad- und Dateiname der Plugin-Datei.
     * @var string
     */
    protected $pluginFile;

    protected $settings;


    /**
     * Variablen Werte zuweisen.
     * @param string $pluginFile Pfad- und Dateiname der Plugin-Datei
     */
    public function __construct($pluginFile)
    {
        $this->pluginFile = $pluginFile;

    }

    /**
     * Es wird ausgeführt, sobald die Klasse instanziiert wird.
     */
    public function onLoaded()
    {
        add_action('init', [$this, 'register_assets']);
        add_action('init', [$this, 'register_blocks']);

        add_action('enqueue_block_assets', [$this, 'enqueue_assets']);
        add_action('enqueue_block_editor_assets', [$this, 'javascript_translations']);

        $this->settings = new Settings();
        $shortcode = new Shortcode($this->pluginFile);
    }


    public function javascript_translations()
    {
        $blocks = [
            'code-highlighter'
        ];

        foreach ($blocks as $block) {
            load_plugin_textdomain('rrze-typesettings', false, plugin_dir_path(__DIR__) . 'languages');

            $script_handle = generate_block_asset_handle('rrze-typesettings/' . $block, 'editorScript');
            wp_set_script_translations($script_handle, 'rrze-typesettings', plugin_dir_path(__DIR__) . 'languages');
        }
    }


    public function register_blocks()
    {
        $blocks = [
            'code-highlighter'
        ];

        foreach ($blocks as $block) {
            register_block_type(plugin_dir_path(__DIR__) . 'build/');
        }

    }


    public function register_assets()
    {
        wp_register_script(
            'rrze-typesettings',
            plugins_url('build/rrze-typesettings.js', plugin_basename($this->pluginFile)),
            ['wp-i18n', 'jquery'],
            filemtime(plugin_dir_path($this->pluginFile) . 'build/rrze-typesettings.js'),
            true
        );
        
        wp_set_script_translations(
            'rrze-typesettings',
            'rrze-typesettings',
            plugin_dir_path(__DIR__) . 'languages'
        );

        wp_register_style(
            'rrze-typesettings',
            plugins_url('build/rrze-typesettings.css', plugin_basename($this->pluginFile)),
            [],
            filemtime(plugin_dir_path($this->pluginFile) . 'build/rrze-typesettings.css')
        );

        wp_register_script(
            'prismjs',
            plugins_url('assets/js/prism.js', plugin_basename($this->pluginFile)),
            [],
            filemtime(plugin_dir_path($this->pluginFile) . 'assets/js/prism.js'),
            true
        );

        wp_register_style(
            'prismjs-default',
            plugins_url('assets/css/prism-default.css', plugin_basename($this->pluginFile)),
            [],
            filemtime(plugin_dir_path($this->pluginFile) . 'assets/css/prism-default.css')
        );

        wp_register_style(
            'prismjs-dark',
            plugins_url('assets/css/prism-dark.css', plugin_basename($this->pluginFile)),
            [],
            filemtime(plugin_dir_path($this->pluginFile) . 'assets/css/prism-dark.css')
        );

        wp_register_style(
            'prismjs-okaidia',
            plugins_url('assets/css/prism-okaidia.css', plugin_basename($this->pluginFile)),
            [],
            filemtime(plugin_dir_path($this->pluginFile) . 'assets/css/prism-okaidia.css')
        );

        wp_register_style(
            'prismjs-solarizedlight',
            plugins_url('assets/css/prism-solarizedlight.css', plugin_basename($this->pluginFile)),
            [],
            filemtime(plugin_dir_path($this->pluginFile) . 'assets/css/prism-solarizedlight.css')
        );


    }

    public function enqueue_assets()
    {
        wp_enqueue_script('rrze-typesettings');
        wp_enqueue_style('rrze-typesettings');
    }

}
