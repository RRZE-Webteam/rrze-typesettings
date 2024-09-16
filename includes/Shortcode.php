<?php
namespace RRZE\Typesettings;

use function RRZE\Typesettings\Config\getShortcodeSettings;

class Shortcode {

    private $theme_css;
    private $settings;

    public function __construct() {
        add_shortcode('highlight-code', [$this, 'render_shortcode_highlight_code']);
        $this->settings = getShortcodeSettings();
    }

    public function enqueue_prism_assets($atts) {
        $this->theme_css = $this->get_theme_css_from_settings($atts['theme'], $this->settings['highlight-code']['theme']['values']);

        wp_enqueue_style('prismjs-css', plugin_dir_url(__FILE__) . 'assets/css/' . $this->theme_css);

        if ($atts['linenumber']) {
            wp_enqueue_style('prismjs-line-numbers-css', plugin_dir_url(__FILE__) . 'assets/css/prism-line-numbers.css');
            wp_enqueue_script('prismjs-line-numbers', plugin_dir_url(__FILE__) . 'assets/js/prism-line-numbers.js', ['prismjs'], null, true);
        }

        wp_enqueue_script('prismjs', plugin_dir_url(__FILE__) . 'assets/js/prism.js', [], null, true);
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


        $this->enqueue_prism_assets($atts);

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
            return  'prism.css'; 
        }
        foreach ($theme_options as $option) {
            if ($option['id'] === $theme) {
                return $option['id'] === 'light' ? 'prism-solarizedlight.css' :
                       ($option['id'] === 'dark' ? 'prism-okaidia.css' : 'prism.css');
            }
        }
        return 'prism.css'; 
    }
}
