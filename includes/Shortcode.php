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

    public function enqueue_assets($theme, $lang)
    {
        $this->theme_css = $this->get_theme_css_from_settings($this->settings['highlight-code']['theme']['values'], $theme);

        echo '<pre>';
        var_dump($this->settings['highlight-code']['theme']['values']);
        exit;

        wp_enqueue_script('rrze-typesettings');
        wp_enqueue_style('rrze-typesettings');

        wp_enqueue_style('prismjs', plugins_url('assets/css/' . $this->theme_css, plugin_basename($this->pluginFile)));
        wp_enqueue_script('prismjs');

        if (!empty($this->linenumbers)) {
            wp_enqueue_script('prismjs-linenumbers', plugins_url('assets/js/prism-line-numbers.min.js', plugin_basename($this->pluginFile)), ['prismjs', 'prism-lang'], null, false);
            wp_enqueue_style('prismjs-linenumbers', plugins_url('assets/css/prism-line-numbers.min.css', plugin_basename($this->pluginFile)), ['prismjs']);
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
                'linenumbers' => (string) $settings['highlight-code']['linenumbers']['default'],
                'theme' => $settings['highlight-code']['theme']['default'],
                'lang' => $settings['highlight-code']['lang']['default'],
                'copy' => $settings['highlight-code']['copy']['default'],
            ],
            $atts,
            'highlight-code'
        );

        $atts['copy'] = filter_var($atts['copy'], FILTER_VALIDATE_BOOLEAN);

        $this->linenumbers = ($atts['linenumbers'] == 'off' || $atts['linenumbers'] == 'false' ? '' : 'line-numbers');

        $this->enqueue_assets($atts['theme'], $atts['lang']);

        $output = '<div class="rrze-typesettings">';
        $output .= sprintf(
            '<pre class="%s"><code class="language-%s">%s</code></pre>',
            $this->linenumbers,
            $atts['lang'],
            $content
        );

        if ($atts['copy']){
            $output .= '<button type="button" class="btn" id="copyButton" name="copyButton" data-typesettings="' . $content . '"><img class="typesettings-copy-img" src="data:image/svg+xml,%3Csvg height=\'1024\' width=\'896\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M128 768h256v64H128v-64z m320-384H128v64h320v-64z m128 192V448L384 640l192 192V704h320V576H576z m-288-64H128v64h160v-64zM128 704h160v-64H128v64z m576 64h64v128c-1 18-7 33-19 45s-27 18-45 19H64c-35 0-64-29-64-64V192c0-35 29-64 64-64h192C256 57 313 0 384 0s128 57 128 128h192c35 0 64 29 64 64v320h-64V320H64v576h640V768zM128 256h512c0-35-29-64-64-64h-64c-35 0-64-29-64-64s-29-64-64-64-64 29-64 64-29 64-64 64h-64c-35 0-64 29-64 64z\' fill=\'%23000000\' /%3E%3C/svg%3E" alt="' . __('Copy to clipboard', 'rrze-typesettings') . '"><span class="screen-reader-text">' . __('Copy to clipboard', 'rrze-typesettings') . '</span></button><span id="typesettings-tooltip" class="typesettings-tooltip">' . __('Copied to clipboard', 'rrze-typesettings') . '</span>';
        }

        $output .= '</div>';

        return $output;
    }

    private function get_theme_css_from_settings($theme_options, $theme = '')
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

        $lang = strtolower($lang);

        foreach ($lang_options as $nr => $option) {
            if ($option['id'] === $lang) {
                return $option['id'];
            }
        }
        return 'javascript';
    }
}
