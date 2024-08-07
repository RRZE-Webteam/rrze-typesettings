<?php

namespace RRZE\Typesettings;

defined('ABSPATH') || exit;


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
        add_action( 'init', [$this, 'code_highlighter_init']);

        add_action('enqueue_block_editor_assets', [$this, 'enqueueScripts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueScripts']);

        $this->settings = new Settings();
    }


    /**
     * Enqueue der globale Skripte.
     */
    public function enqueueScripts()
    {
        wp_enqueue_script('wp-i18n');
        // wp_enqueue_script('rrze-typesettings', plugins_url('src/rrze-typesettings.js', plugin_basename($this->pluginFile)), array('jquery'), null, true);
        // wp_enqueue_style('rrze-typesettings-css', plugins_url('src/rrze-typesettings.scss', plugin_basename($this->pluginFile)));

        $this->code_highlighter_frontend_assets();
    }

    public function code_highlighter_init() {
        wp_register_script('code-highlighter-block', plugins_url( 'build/index.js', plugin_basename($this->pluginFile) ), array( 'wp-blocks', 'wp-element', 'wp-editor' ));
        wp_enqueue_style('highlightjs-style', plugins_url('build/frontend.css', plugin_basename($this->pluginFile)));
    }

    public function code_highlighter_frontend_assets() {
        wp_enqueue_script('highlightjs-init', plugins_url('build/frontend.js', plugin_basename($this->pluginFile)), array(), null, true);
    }

}
