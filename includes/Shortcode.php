<?php
namespace RRZE\Typesettings;

use function RRZE\Typesettings\Config\getShortcodeSettings;

class Shortcode {

    private $theme_css;
    private $settings;

    protected $pluginFile;

    public function __construct($pluginFile) {
        add_shortcode('highlight-code', [$this, 'render_shortcode_highlight_code']);
        $this->settings = getShortcodeSettings();
        $this->pluginFile = $pluginFile;
    }

    public function enqueue_prism_assets($theme) {
        $this->theme_css = $this->get_theme_css_from_settings($theme, $this->settings['highlight-code']['theme']['values']);

        wp_enqueue_style('prismjs-css', plugins_url('assets/css/', plugin_basename($this->pluginFile)) . $this->theme_css);
        wp_enqueue_script('prismjs', plugins_url('assets/js/prism.js', plugin_basename($this->pluginFile)), [], null, true);
    }

    public function render_shortcode_highlight_code($atts, $content = null) {
        $settings = getShortcodeSettings();
        $atts = shortcode_atts(
            [
                'linenumber' => $settings['highlight-code']['linenumber']['default'],
                'theme' => $settings['highlight-code']['theme']['default']
            ],
            $atts,
            'highlight-code'
        );

        $this->enqueue_prism_assets($atts['theme']);

        $linenumber_class = (!empty($atts['linenumber']) ? 'line-numbers' : '');

        if (is_null($content) || empty(trim($content))) {
            throw new \Exception('No code content provided for highlighting.');
        }

        $escaped_content = esc_html($content);

        return sprintf(
            '<pre class="%s"><code class="language-javascript %s">%s</code></pre>',
            esc_attr($linenumber_class),
            $this->theme_css,
            $escaped_content
        );
    }

    private function get_theme_css_from_settings($theme = null, $theme_options) {
        if (is_null($theme)){
            return  'default.css'; 
        }

        foreach ($theme_options as $nr => $option) {
            if ($option['id'] === $theme) {
                return $option['id'] . '.css';
            }
        }
        return 'default.css'; 
    }
}
