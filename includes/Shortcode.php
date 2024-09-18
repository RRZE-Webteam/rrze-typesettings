<?php
namespace RRZE\Typesettings;

use function RRZE\Typesettings\Config\getShortcodeSettings;

class Shortcode {

    private $theme_css;
    private $lang_js;
    private $settings;

    protected $pluginFile;

    public function __construct($pluginFile) {
        add_shortcode('highlight-code', [$this, 'render_shortcode_highlight_code']);
        $this->settings = getShortcodeSettings();
        $this->pluginFile = $pluginFile;
    }

    public function enqueue_prism_assets($linenumber, $theme, $lang) {
        $this->theme_css = $this->get_theme_css_from_settings($theme, $this->settings['highlight-code']['theme']['values']);
        $this->lang_js = $this->get_lang_from_settings($lang, $this->settings['highlight-code']['lang']['values']);
        
        $this->lang_js = !empty($this->lang_js) ? $this->lang_js : 'javascript';
    
        wp_enqueue_style('prismjs-css', plugins_url('assets/css/prism.min.css', plugin_basename($this->pluginFile)));
        wp_enqueue_script('prismjs', plugins_url('assets/js/prism.js', plugin_basename($this->pluginFile)), [], null, true);        
        wp_enqueue_script('prism-lang-js', plugins_url('assets/js/prism-' . $this->lang_js . '.min.js', plugin_basename($this->pluginFile)), ['prismjs'], null, true);
    
        if (!empty($linenumber)) {
            wp_enqueue_style('prismjs-linenumbers-css', plugins_url('assets/css/prism-line-numbers.min.css', plugin_basename($this->pluginFile)), ['prismjs-css']);
            wp_enqueue_script('prismjs-linenumbers-js', plugins_url('assets/js/prism-line-numbers.min.js', plugin_basename($this->pluginFile)), ['prismjs'], null, true);
        }
    }
    
    public function render_shortcode_highlight_code($atts, $content = null) {
        $settings = getShortcodeSettings();
        $atts = shortcode_atts(
            [
                'linenumber' => $settings['highlight-code']['linenumber']['default'],
                'theme' => $settings['highlight-code']['theme']['default'],
                'lang' => $settings['highlight-code']['lang']['default']
            ],
            $atts,
            'highlight-code'
        );

        if (is_null($content) || empty(trim($content))) {
            return;
        }

        $this->enqueue_prism_assets($atts['linenumber'], $atts['theme'], $atts['lang']);

        $linenumber_class = (!empty($atts['linenumber']) ? 'line-numbers' : '');

        return sprintf(
            '<pre class="%s"><code class="language-%s line-numbers">%s</code></pre>',
            esc_attr($linenumber_class),
            $atts['lang'],
            $content
        );
    }

    private function get_theme_css_from_settings($theme = null, $theme_options) {
        if (is_null($theme)){
            return  'default.css'; 
        }

        foreach ($theme_options as $nr => $option) {
            if ($option['id'] === $theme) {
                return $option['id'] . '.min.css';
            }
        }
        return 'default.css'; 
    }

    private function get_lang_from_settings($lang = null, $lang_options) {
        if (is_null($lang)){
            return  'javascript'; 
        }

        foreach ($lang_options as $nr => $option) {
            if ($option['id'] === $lang) {
                return $option['id'];
            }
        }
        return 'javascript'; 
    }
}
