<?php

namespace RRZE\Typesettings;

defined('ABSPATH') || exit;

/**
 * Hauptklasse (Main)
 */
class Main
{

    protected $pluginFile;

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
        add_action('init', [$this, 'register_blocks']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('add_meta_boxes', [$this, 'add_meta_box']);
        add_action('save_post', [$this, 'save_meta_box_data']);
        add_filter('the_content', [$this, 'content_filter']);
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style('rrze-typesettings-katex-css', plugins_url('assets/css/katex.min.css', plugin_basename($this->pluginFile)));
        wp_enqueue_script('rrze-typesettings-katex-js', plugins_url('assets/js/katex.min.js', plugin_basename($this->pluginFile)), array(), null, true);
        wp_enqueue_script('rrze-typesettings-auto-render', plugins_url('assets/js/auto-render.min.js', plugin_basename($this->pluginFile)), array('rrze-typesettings-katex-js'), null, true);
        wp_enqueue_style('rrze-typesettings-prism-css', plugins_url('assets/css/prism.css', plugin_basename($this->pluginFile)));
        wp_enqueue_script('rrze-typesettings-prism-js', plugins_url('assets/js/prism.js', plugin_basename($this->pluginFile)), array(), null, true);
        wp_enqueue_script('rrze-typesettings-js', plugin_dir_url($this->pluginFile) . 'assets/js/rrze-typesettings.min.js', array('jquery'), null, true);        
        // wp_enqueue_style('rrze-typesettings-css', plugins_url('assets/css/rrze-typesettings.min.css', plugin_basename($this->pluginFile)));
    }

    public function register_blocks()
    {
        register_block_type(__DIR__ . '/build');
    }

    public function add_meta_box()
    {
        add_meta_box(
            'rrze-typesettings_meta_box',
            'LaTeX, KaTeX und Prism Optionen',
            [$this, 'meta_box_callback'],
            'post',
            'side'
        );
    }

    public function meta_box_callback($post)
    {
        wp_nonce_field('rrze-typesettings_save_meta_box_data', 'rrze-typesettings_meta_box_nonce');
        $value = get_post_meta($post->ID, '_rrze-typesettings_meta_value_key', true);
        ?>
        <label for="rrze-typesettings_new_field">
            <?php _e('Aktiviere den Filter:', 'rrze-typesettings_textdomain'); ?>
        </label>
        <input type="checkbox" id="rrze-typesettings_new_field" name="rrze-typesettings_new_field" value="1" <?php checked($value, '1'); ?> />
        <?php
    }

    public function save_meta_box_data($post_id)
    {
        if (!isset($_POST['rrze-typesettings_meta_box_nonce'])) {
            return;
        }
        if (!wp_verify_nonce($_POST['rrze-typesettings_meta_box_nonce'], 'rrze-typesettings_save_meta_box_data')) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        $my_data = isset($_POST['rrze-typesettings_new_field']) ? '1' : '';
        update_post_meta($post_id, '_rrze-typesettings_meta_value_key', $my_data);
    }

    public function content_filter($content)
    {
        global $post;
        $value = get_post_meta($post->ID, '_rrze-typesettings_meta_value_key', true);
        if ($value === '1') {
            $content = '<div class="katex-prism-content">' . $content . '</div>';
        }
        return $content;
    }
}
