<?php

namespace RRZE\Typesettings;


class Settings
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_options_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    // Add a menu item to the Settings menu
    public function add_options_page()
    {
        add_options_page(
            'RRZE Typesettings',
            'RRZE Typesettings',
            'manage_options',
            'rrze-typesettings',
            [$this, 'render_options_page']
        );
    }


    // Register settings sections and fields
    public function register_settings()
    {
        // General tab settings
        add_settings_section(
            'rrze_typesettings_general_section',
            '&nbsp;',
            [$this, 'render_general_section'],
            'rrze_typesettings_general'
        );

        register_setting('rrze_typesettings_general', 'rrze_typesettings_general');

    }



    // Render the options page
    public function render_options_page()
    {
        $_GET['tab'] = (empty($_GET['tab']) ? 'general' : $_GET['tab']);

        ?>
        <div class="wrap">
            <h1>RRZE Typesettings Settings</h1>
            <?php settings_errors(); ?>

            <h2 class="nav-tab-wrapper">
                <a href="?page=rrze-typesettings&tab=general"
                    class="nav-tab <?php echo isset($_GET['tab']) && $_GET['tab'] === 'general' ? 'nav-tab-active' : ''; ?>"><?php echo __('General', 'rrze-typesettings'); ?></a>
            </h2>

            <div class="tab-content">
                <?php
                $current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'services';
                switch ($current_tab) {
                    case 'general':
                        settings_fields('rrze_typesettings_general');
                        do_settings_sections('rrze_typesettings_general');
                        break;
                    default:
                        settings_fields('rrze_typesettings_services');
                        do_settings_sections('rrze_typesettings_services');
                }
                ?>
            </div>
        </div>
        <?php
    }



    // Render the General tab section
    public function render_general_section()
    {
        $message = '';
        $aOptions = json_decode(get_option('rrze-typesettings'), true);

        if (isset($_POST['submit_general'])) {
            update_option('rrze-typesettings', json_encode($aOptions));
        }

        ?>

        <div class="wrap">
            <?php if (!empty($message)): ?>
                <div class="<?php echo strpos($message, 'Error') !== false ? 'error' : 'updated'; ?>">
                    <p>
                        <?php echo $message; ?>
                    </p>
                </div>
            <?php endif; ?>
            <form method="post" action="" id="general-form">
                <table class="typesettings-wp-list-table widefat fixed striped">
                    <tbody>
                        <tr>
                            <td>Dieser Bereich dient nur als Gerüst</td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" name="submit_general" class="button button-primary">
                    <?php echo __('Save Changes', 'rrze-typesettings'); ?>
                </button>
            </form>
        </div>
        <?php
    }



}

