<?php
namespace RRZE\Typesettings;

use function RRZE\Typesettings\Config\getShortcodeSettings;

class Shortcode
{

    private $theme_css;
    private $lang_js;
    private $settings;

    protected $pluginFile;

    public function __construct($pluginFile)
    {
        add_shortcode('highlight-code', [$this, 'render_shortcode_highlight_code']);
        $this->settings = getShortcodeSettings();
        $this->pluginFile = $pluginFile;
    }

    public function enqueue_prism_assets($linenumbers, $theme, $lang)
    {
        $this->theme_css = $this->get_theme_css_from_settings($theme, $this->settings['highlight-code']['theme']['values']);

        // echo $this->theme_css;
        // exit;

        $this->lang_js = $this->get_lang_from_settings($lang, $this->settings['highlight-code']['lang']['values']);

        $this->lang_js = !empty($this->lang_js) ? $this->lang_js : 'javascript';

        wp_enqueue_script('prismjs', plugins_url('assets/js/prism.js', plugin_basename($this->pluginFile)), [], null, true);
        wp_enqueue_script('prism-lang-js', plugins_url('assets/js/prism-' . $this->lang_js . '.min.js', plugin_basename($this->pluginFile)), ['prismjs'], null, true);

        wp_enqueue_style('prismjs-css', plugins_url('assets/css/' . $this->theme_css, plugin_basename($this->pluginFile)));

        // if (!empty($linenumbers)) {
            wp_enqueue_script('prismjs-linenumbers-js', plugins_url('assets/js/prism-line-numbers.js', plugin_basename($this->pluginFile)), ['prismjs', 'prism-lang-js'], null, true);
            wp_enqueue_style('prismjs-linenumbers-css', plugins_url('assets/css/prism-line-numbers.css', plugin_basename($this->pluginFile)), ['prismjs-css']);
        // }
    }

    public function render_shortcode_highlight_code($atts, $content = null)
    {
        if (is_null($content) || empty(trim($content))) {
            return;
        }

        $settings = getShortcodeSettings();
        $atts = shortcode_atts(
            [
                'linenumbers' => $settings['highlight-code']['linenumbers']['default'],
                'theme' => $settings['highlight-code']['theme']['default'],
                'lang' => $settings['highlight-code']['lang']['default']
            ],
            $atts,
            'highlight-code'
        );

        // echo '<pre>';
        // var_dump($atts);
        // exit;

        $this->enqueue_prism_assets($atts['linenumbers'], $atts['theme'], $atts['lang']);

        $linenumbers_class = (!empty($atts['linenumbers']) ? 'line-numbers' : '');

        $output = sprintf(
            '<pre class="line-numbers"><code class="language-%s line-numbers">%s</code></pre>',
            $atts['lang'],
            $content
        );

        // $output = '<pre class="line-numbers"><code class="language-javascript">alert("hallo, du");</code></pre>';

        return $output;
    }

    private function get_theme_css_from_settings($theme = null, $theme_options)
    {
        if (is_null($theme)) {
            return 'prism.min.css';
        }

        foreach ($theme_options as $nr => $option) {
            if ($option['id'] === $theme) {
                return $option['css'];
            }
        }
        return 'prism.min.css';
    }

    private function get_lang_from_settings($lang = null, $lang_options)
    {
        if (is_null($lang)) {
            return 'javascript';
        }

        foreach ($lang_options as $nr => $option) {
            if ($option['id'] === $lang) {
                return $option['id'];
            }
        }
        return 'javascript';
    }
}
