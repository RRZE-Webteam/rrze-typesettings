<?php

namespace RRZE\Typesettings;

defined('ABSPATH') || exit;

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
        add_action('init', [$this, 'code_highlighter_init']);

        add_action('enqueue_block_editor_assets', [$this, 'enqueueScripts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueScripts']);

        $this->settings = new Settings();
        $shortcode = new Shortcode($this->pluginFile);

    }


    /**
     * Enqueue der globale Skripte.
     */
    public function enqueueScripts()
    {
        wp_enqueue_script('wp-i18n');
        wp_enqueue_script('rrze-typesettings', plugins_url('assets/js/rrze-typesettings.min.js', plugin_basename($this->pluginFile)), [], filemtime(plugin_dir_path($this->pluginFile) . 'assets/js/rrze-typesettings.min.js'), true);
        wp_enqueue_style('rrze-typesettings-css', plugins_url('assets/css/rrze-typesettings.min.css', plugin_basename($this->pluginFile)), [], filemtime(plugin_dir_path($this->pluginFile) . 'assets/css/rrze-typesettings.min.css'));
        $this->code_highlighter_frontend_assets();
    }

    public function code_highlighter_init()
    {
        remove_filter('the_content', 'wpautop');
        wp_register_script('code-highlighter-block', plugins_url('build/index.js', plugin_basename($this->pluginFile)), ['wp-blocks', 'wp-element', 'wp-editor'], filemtime(plugin_dir_path($this->pluginFile) . 'build/index.js'), true);
    }

    public function code_highlighter_frontend_assets()
    {
        wp_enqueue_script('highlightjs-init', plugins_url('build/frontend.js', plugin_basename($this->pluginFile)), [], filemtime(plugin_dir_path($this->pluginFile) . 'build/frontend.js'), true);
    }

}
