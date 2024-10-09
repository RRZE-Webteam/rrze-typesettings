<?php
namespace RRZE\Typesettings;

use function RRZE\Typesettings\Config\getShortcodeSettings;

class Shortcode
{

    private $theme_css;
    private $lang_js;
    private $linenumbers;
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
        $this->theme_css = $this->get_theme_css_from_settings($this->settings['highlight-code']['theme']['values'], $theme);

        $this->lang_js = $this->get_lang_from_settings($this->settings['highlight-code']['lang']['values'],$lang);

        $this->lang_js = !empty($this->lang_js) ? $this->lang_js : 'javascript';

        wp_enqueue_script('prismjs', plugins_url('assets/js/prism.js', plugin_basename($this->pluginFile)), [], filemtime(plugin_dir_path($this->pluginFile) . 'assets/js/prism.js'), true);
        wp_enqueue_script('prism-lang-js', plugins_url('assets/js/prism-' . $this->lang_js . '.min.js', plugin_basename($this->pluginFile)), ['prismjs'], filemtime(plugin_dir_path($this->pluginFile) . 'assets/js/prism-' . $this->lang_js . '.min.js'), true);

        wp_enqueue_style('prismjs-css', plugins_url('assets/css/' . $this->theme_css, plugin_basename($this->pluginFile)), [], filemtime(plugin_dir_path($this->pluginFile) . 'assets/css/' . $this->theme_css));

        if (!empty($this->linenumbers)) {
            wp_enqueue_script('prismjs-linenumbers-js', plugins_url('assets/js/prism-line-numbers.min.js', plugin_basename($this->pluginFile)), ['prismjs', 'prism-lang-js'], filemtime(plugin_dir_path($this->pluginFile) . 'assets/js/prism-line-numbers.min.js'), true);
            wp_enqueue_style('prismjs-linenumbers-css', plugins_url('assets/css/prism-line-numbers.min.css', plugin_basename($this->pluginFile)), ['prismjs-css'], filemtime(plugin_dir_path($this->pluginFile) . 'assets/css/prism-line-numbers.min.css'));
        }
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
                'lang' => $settings['highlight-code']['lang']['default'],
                'copy' => $settings['highlight-code']['copy']['default'],
            ],
            $atts,
            'highlight-code'
        );

        $atts['copy'] = filter_var($atts['copy'], FILTER_VALIDATE_BOOLEAN);

        $this->linenumbers = ($atts['linenumbers'] == 'off' || $atts['linenumbers'] == 'false' ? '' : 'line-numbers');

        // wp_enqueue_script('rrze-typesettings', plugins_url('src/rrze-typesettings.js', plugin_basename($this->pluginFile)), [], null, true);
        // wp_enqueue_style('rrze-typesettings-css', plugins_url('src/rrze-typesettings.css', plugin_basename($this->pluginFile)));

        $this->enqueue_prism_assets($atts['linenumbers'], $atts['theme'], $atts['lang']);

        $output = '<div class="rrze-typesettings">';
        $output .= sprintf(
            '<pre class="%s"><code class="language-%s">%s</code></pre>',
            $this->linenumbers,
            $atts['lang'],
            $content
        );

        if ($atts['copy']) {
            $output .= '<button type="button" class="btn" id="copyButton" name="copyButton" data-typesettings="' . $content . '"><img class="typesettings-copy-img" src="data:image/svg+xml,%3Csvg height=\'1024\' width=\'896\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M128 768h256v64H128v-64z m320-384H128v64h320v-64z m128 192V448L384 640l192 192V704h320V576H576z m-288-64H128v64h160v-64zM128 704h160v-64H128v64z m576 64h64v128c-1 18-7 33-19 45s-27 18-45 19H64c-35 0-64-29-64-64V192c0-35 29-64 64-64h192C256 57 313 0 384 0s128 57 128 128h192c35 0 64 29 64 64v320h-64V320H64v576h640V768zM128 256h512c0-35-29-64-64-64h-64c-35 0-64-29-64-64s-29-64-64-64-64 29-64 64-29 64-64 64h-64c-35 0-64 29-64 64z\' fill=\'%23000000\' /%3E%3C/svg%3E" alt="' . __('Copy to clipboard', 'rrze-typesettings') . '"><span class="screen-reader-text">' . __('Copy to clipboard', 'rrze-typesettings') . '</span></button><span id="typesettings-tooltip" class="typesettings-tooltip">' . __('Copied to clipboard', 'rrze-typesettings') . '</span>';
        }

        $output .= '</div>';

        return $output;
    }

    private function get_theme_css_from_settings($theme_options, $theme = null)
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

    private function get_lang_from_settings($lang_options, $lang = null)
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
