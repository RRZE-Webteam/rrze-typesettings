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

        add_action('enqueue_block_assets', [$this, 'enqueue_assets']);

        $this->settings = new Settings();
        $shortcode = new Shortcode($this->pluginFile);
    }


    public function register_assets()
    {
        wp_localize_script('rrze-typesettings', 'rrzeTypesettings', [
            'codeCopied' => __('Code copied!', 'rrze-typesettings'),
            'lang' => __('Language', 'rrze-typesettings'),
        ]);

        wp_register_script(
            'rrze-typesettings',
            plugins_url('build/rrze-typesettings.min.js', plugin_basename($this->pluginFile)),
            ['wp-i18n', 'jquery'],
            filemtime(plugin_dir_path($this->pluginFile) . 'build/rrze-typesettings.min.js'),
            true
        );

        wp_set_script_translations('rrze-typesettings', 'rrze-typesettings', plugin_dir_path($this->pluginFile) . 'languages'); 

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
            'prismjs',
            plugins_url('assets/css/prism.css', plugin_basename($this->pluginFile)),
            [],
            filemtime(plugin_dir_path($this->pluginFile) . 'assets/css/prism.css')
        );


    }

    public function enqueue_assets()
    {
        wp_enqueue_script('rrze-typesettings');
        wp_enqueue_style('rrze-typesettings');
    }

}
