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
        add_action('init', [$this, 'register_assets']);

        add_action('enqueue_block_assets', [$this, 'enqueue_assets']);

        $this->settings = new Settings();
        $shortcode = new Shortcode($this->pluginFile);
    }


    public function register_assets(){
        wp_register_script('rrze-typesettings', plugins_url('assets/js/rrze-typesettings.min.js', plugin_basename($this->pluginFile)), [], filemtime(plugin_dir_path($this->pluginFile) . 'assets/js/rrze-typesettings.min.js'), true);
        wp_register_style('rrze-typesettings', plugins_url('assets/css/rrze-typesettings.min.css', plugin_basename($this->pluginFile)), [], filemtime(plugin_dir_path($this->pluginFile) . 'assets/css/rrze-typesettings.min.css'));
        wp_register_script('prismjs', plugins_url('assets/js/prism.js', plugin_basename($this->pluginFile)), [], null, true);
    }

    public function enqueue_assets(){
        wp_enqueue_script('rrze-typesettings');
        wp_enqueue_style('rrze-typesettings');        
    }

}
