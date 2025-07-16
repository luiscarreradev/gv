<?php
/*
Plugin Name: WP AdLog
Plugin URI: https://luiscarrera.dev
Description: A WordPress plugin that customizes the login screen and allows hiding menu items, plugins, and various admin notices.
Version: 1.0.0
Author: Luis Carrera
Author URI: https://luiscarrera.dev
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wp-adlog
Domain Path: /languages
*/

function wpa_discover_menu_items() {
    global $menu;
    $o = get_option('wpa_login_settings', array());
    if (!isset($o['all_menus'])) $o['all_menus'] = array();
    foreach ($menu as $m) {
        if (!isset($m[2])) continue;
        $slug = $m[2];
        $label = strip_tags($m[0]);
        if (strpos($slug, 'separator') !== false) continue;
        if (empty($slug)) continue;
        if (!isset($o['all_menus'][$slug])) $o['all_menus'][$slug] = $label;
    }
    update_option('wpa_login_settings', $o);
}
add_action('admin_menu', 'wpa_discover_menu_items', 998);

function wpa_register_settings() {
    register_setting('wpa_login_settings_group', 'wpa_login_settings');
}
add_action('admin_init', 'wpa_register_settings');

function wpa_discover_plugins() {
    if (!function_exists('get_plugins')) require_once ABSPATH . 'wp-admin/includes/plugin.php';
    $all_plugins = get_plugins();
    $o = get_option('wpa_login_settings', array());
    if (!isset($o['all_plugins_list'])) $o['all_plugins_list'] = array();
    foreach ($all_plugins as $plugin_file => $plugin_data) {
        if (!isset($o['all_plugins_list'][$plugin_file])) {
            $o['all_plugins_list'][$plugin_file] = $plugin_data['Name'];
        }
    }
    update_option('wpa_login_settings', $o);
}
add_action('admin_init', 'wpa_discover_plugins');

function wpa_add_admin_menu() {
    add_options_page('Ajustes Login','WP AdLog','manage_options','wpa-login-settings','wpa_login_settings_page');
}
add_action('admin_menu', 'wpa_add_admin_menu');

function wpa_login_settings_page() {
    if (!current_user_can('manage_options')) return;
    $o = get_option('wpa_login_settings');
    $l = isset($o['logo_url']) ? esc_url($o['logo_url']) : '';
    $b = isset($o['background_url']) ? esc_url($o['background_url']) : '';
    $pc = isset($o['primary_color']) ? sanitize_text_field($o['primary_color']) : '#1984be';
    $ph = isset($o['primary_color_hover']) ? sanitize_text_field($o['primary_color_hover']) : '#3c515b';
    $fbg = isset($o['form_bg_color']) ? sanitize_text_field($o['form_bg_color']) : '#ffffff';
    $itc = isset($o['input_text_color']) ? sanitize_text_field($o['input_text_color']) : '#333333';
    $ibg = isset($o['input_bg_color']) ? sanitize_text_field($o['input_bg_color']) : '#ffffff';
    $ibd = isset($o['input_border_color']) ? sanitize_text_field($o['input_border_color']) : '#cccccc';
    $lc = isset($o['label_color']) ? sanitize_text_field($o['label_color']) : '#333333';
    $links = isset($o['login_links_color']) ? sanitize_text_field($o['login_links_color']) : '#1984be';
    $links_hover = isset($o['login_links_hover_color']) ? sanitize_text_field($o['login_links_hover_color']) : '#3c515b';
    $footer_link = isset($o['footer_link_color']) ? sanitize_text_field($o['footer_link_color']) : '#1984be';
    $logo_width_desktop = isset($o['logo_width_desktop']) ? sanitize_text_field($o['logo_width_desktop']) : '150px';
    $logo_height_desktop = isset($o['logo_height_desktop']) ? sanitize_text_field($o['logo_height_desktop']) : '150px';
    $logo_width_tablet = isset($o['logo_width_tablet']) ? sanitize_text_field($o['logo_width_tablet']) : '120px';
    $logo_height_tablet = isset($o['logo_height_tablet']) ? sanitize_text_field($o['logo_height_tablet']) : '120px';
    $logo_width_mobile = isset($o['logo_width_mobile']) ? sanitize_text_field($o['logo_width_mobile']) : '100px';
    $logo_height_mobile = isset($o['logo_height_mobile']) ? sanitize_text_field($o['logo_height_mobile']) : '100px';
    $body_login_bg = isset($o['body_login_bg']) ? sanitize_text_field($o['body_login_bg']) : '#b22424';
    $login_container_bg = isset($o['login_container_bg']) ? sanitize_text_field($o['login_container_bg']) : 'rgba(255, 0, 0, 0.9)';
    $btn_text_color = isset($o['button_text_color']) ? sanitize_text_field($o['button_text_color']) : '#ffffff';
    $btn_text_color_hover = isset($o['button_text_color_hover']) ? sanitize_text_field($o['button_text_color_hover']) : '#ffffff';
    $login_image_bg = isset($o['login_image_bg']) ? sanitize_text_field($o['login_image_bg']) : '#747474';
    $login_image_blend = isset($o['login_image_blend']) ? sanitize_text_field($o['login_image_blend']) : 'multiply';
    $menu_items = isset($o['all_menus']) ? $o['all_menus'] : array();
    $hidden_items = isset($o['hidden_menu_items']) ? (array) $o['hidden_menu_items'] : array();
    $all_plugins_list = isset($o['all_plugins_list']) ? $o['all_plugins_list'] : array();
    $hidden_plugins = isset($o['hidden_plugins']) ? (array) $o['hidden_plugins'] : array();
    $notice_types = array(
        'update_nag' => 'Update Nag (update-nag)',
        'updated' => 'Updated (updated)',
        'error' => 'Error (error)',
        'notice-warning' => 'Warning (notice-warning)',
        'notice-success' => 'Success (notice-success)',
        'notice-error' => 'Error Notice (notice-error)',
        'notice-info' => 'Info Notice (notice-info)',
        'is-dismissible' => 'Dismissible (is-dismissible)'
    );
    $hidden_notice_types = isset($o['hidden_notice_types']) ? $o['hidden_notice_types'] : array();
    ?>
    <div class="wrap">
        <h1>Configuración de Login y Elementos Ocultos</h1>
        <h2 class="nav-tab-wrapper">
            <a href="#tab-1" class="nav-tab nav-tab-active">Personalización del Login</a>
            <a href="#tab-2" class="nav-tab">Ocultar Menús</a>
            <a href="#tab-3" class="nav-tab">Ocultar Plugins</a>
            <a href="#tab-4" class="nav-tab">Ocultar Notificaciones</a>
        </h2>
        <form method="post" action="options.php">
            <?php settings_fields('wpa_login_settings_group'); ?>
            <div id="tab-1" class="tab-content" style="display:block;">
                <table class="form-table">
                    <tr><th>Logo URL</th><td><input type="text" name="wpa_login_settings[logo_url]" value="<?php echo $l; ?>" style="width: 400px;"></td></tr>
                    <tr><th>Fondo Lateral URL</th><td><input type="text" name="wpa_login_settings[background_url]" value="<?php echo $b; ?>" style="width: 400px;"></td></tr>
                    <tr><th>Color Primario</th><td><input type="text" name="wpa_login_settings[primary_color]" value="<?php echo $pc; ?>" style="width:100px;"></td></tr>
                    <tr><th>Color Hover Primario</th><td><input type="text" name="wpa_login_settings[primary_color_hover]" value="<?php echo $ph; ?>" style="width:100px;"></td></tr>
                    <tr><th>Color Fondo Formulario</th><td><input type="text" name="wpa_login_settings[form_bg_color]" value="<?php echo $fbg; ?>" style="width:100px;"></td></tr>
                    <tr><th>Color Texto Inputs</th><td><input type="text" name="wpa_login_settings[input_text_color]" value="<?php echo $itc; ?>" style="width:100px;"></td></tr>
                    <tr><th>Color Fondo Inputs</th><td><input type="text" name="wpa_login_settings[input_bg_color]" value="<?php echo $ibg; ?>" style="width:100px;"></td></tr>
                    <tr><th>Color Borde Inputs</th><td><input type="text" name="wpa_login_settings[input_border_color]" value="<?php echo $ibd; ?>" style="width:100px;"></td></tr>
                    <tr><th>Color Etiquetas</th><td><input type="text" name="wpa_login_settings[label_color]" value="<?php echo $lc; ?>" style="width:100px;"></td></tr>
                    <tr><th>Color Enlaces</th><td><input type="text" name="wpa_login_settings[login_links_color]" value="<?php echo $links; ?>" style="width:100px;"></td></tr>
                    <tr><th>Color Enlaces Hover</th><td><input type="text" name="wpa_login_settings[login_links_hover_color]" value="<?php echo $links_hover; ?>" style="width:100px;"></td></tr>
                    <tr><th>Color Pie de Página</th><td><input type="text" name="wpa_login_settings[footer_link_color]" value="<?php echo $footer_link; ?>" style="width:100px;"></td></tr>
                    <tr><th>Logo Ancho Desktop</th><td><input type="text" name="wpa_login_settings[logo_width_desktop]" value="<?php echo $logo_width_desktop; ?>" style="width:100px;"></td></tr>
                    <tr><th>Logo Alto Desktop</th><td><input type="text" name="wpa_login_settings[logo_height_desktop]" value="<?php echo $logo_height_desktop; ?>" style="width:100px;"></td></tr>
                    <tr><th>Logo Ancho Tablet</th><td><input type="text" name="wpa_login_settings[logo_width_tablet]" value="<?php echo $logo_width_tablet; ?>" style="width:100px;"></td></tr>
                    <tr><th>Logo Alto Tablet</th><td><input type="text" name="wpa_login_settings[logo_height_tablet]" value="<?php echo $logo_height_tablet; ?>" style="width:100px;"></td></tr>
                    <tr><th>Logo Ancho Mobile</th><td><input type="text" name="wpa_login_settings[logo_width_mobile]" value="<?php echo $logo_width_mobile; ?>" style="width:100px;"></td></tr>
                    <tr><th>Logo Alto Mobile</th><td><input type="text" name="wpa_login_settings[logo_height_mobile]" value="<?php echo $logo_height_mobile; ?>" style="width:100px;"></td></tr>
                    <tr><th>Background Color Body Login</th><td><input type="text" name="wpa_login_settings[body_login_bg]" value="<?php echo $body_login_bg; ?>" style="width:100px;"></td></tr>
                    <tr><th>Background Color Contenedor Login</th><td><input type="text" name="wpa_login_settings[login_container_bg]" value="<?php echo $login_container_bg; ?>" style="width:100px;"></td></tr>
                    <tr><th>Color Texto Botón</th><td><input type="text" name="wpa_login_settings[button_text_color]" value="<?php echo $btn_text_color; ?>" style="width:100px;"></td></tr>
                    <tr><th>Color Texto Hover Botón</th><td><input type="text" name="wpa_login_settings[button_text_color_hover]" value="<?php echo $btn_text_color_hover; ?>" style="width:100px;"></td></tr>
                    <tr><th>Color de fondo imagen lateral</th><td><input type="text" name="wpa_login_settings[login_image_bg]" value="<?php echo $login_image_bg; ?>" style="width:100px;"></td></tr>
                    <tr><th>Blend-mode imagen lateral</th><td><input type="text" name="wpa_login_settings[login_image_blend]" value="<?php echo $login_image_blend; ?>" style="width:100px;"></td></tr>
                </table>
            </div>
            <div id="tab-2" class="tab-content" style="display:none;">
                <h2>Ocultar Elementos del Menú</h2>
                <table class="form-table">
                <?php foreach ($menu_items as $slug => $label):
                $checked = in_array($slug, $hidden_items) ? 'checked' : ''; ?>
                    <tr>
                        <th><?php echo esc_html($label); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="wpa_login_settings[hidden_menu_items][]" value="<?php echo esc_attr($slug); ?>" <?php echo $checked; ?> />
                                Ocultar
                            </label>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </table>
            </div>
            <div id="tab-3" class="tab-content" style="display:none;">
                <h2>Ocultar Plugins</h2>
                <table class="form-table">
                <?php foreach ($all_plugins_list as $pf => $pn):
                $checked = in_array($pf, $hidden_plugins) ? 'checked' : ''; ?>
                    <tr>
                        <th><?php echo esc_html($pn); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="wpa_login_settings[hidden_plugins][]" value="<?php echo esc_attr($pf); ?>" <?php echo $checked; ?> />
                                Ocultar
                            </label>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </table>
            </div>
            <div id="tab-4" class="tab-content" style="display:none;">
                <h2>Ocultar Tipos de Notificaciones</h2>
                <table class="form-table">
                <?php
                foreach ($notice_types as $class => $label) {
                    $checked = in_array($class, $hidden_notice_types) ? 'checked' : '';
                    echo '<tr><th>'.$label.'</th><td><label><input type="checkbox" name="wpa_login_settings[hidden_notice_types][]" value="'.$class.'" '.$checked.' /> Ocultar</label></td></tr>';
                }
                ?>
                </table>
            </div>
            <?php submit_button(); ?>
        </form>
    </div>
    <script>
    (function(){
        const tabs = document.querySelectorAll('.nav-tab-wrapper a');
        const tabContents = document.querySelectorAll('.tab-content');
        tabs.forEach(t=>{
            t.addEventListener('click',function(e){
                e.preventDefault();
                tabs.forEach(tab=>tab.classList.remove('nav-tab-active'));
                tabContents.forEach(tc=>tc.style.display='none');
                this.classList.add('nav-tab-active');
                const selector = this.getAttribute('href');
                document.querySelector(selector).style.display='block';
            });
        });
    })();
    </script>
<?php
}

function wpa_hide_admin_menus() {
    if (!current_user_can('manage_options')) return;
    $o = get_option('wpa_login_settings');
    if (!isset($o['hidden_menu_items']) || !is_array($o['hidden_menu_items'])) return;
    foreach ($o['hidden_menu_items'] as $slug) {
        remove_menu_page($slug);
    }
}
add_action('admin_menu', 'wpa_hide_admin_menus', 999);

function wpa_hide_plugins($plugins) {
    if (!current_user_can('manage_options')) return $plugins;
    $o = get_option('wpa_login_settings');
    if (!isset($o['hidden_plugins']) || !is_array($o['hidden_plugins'])) return $plugins;
    foreach ($o['hidden_plugins'] as $pf) {
        if (isset($plugins[$pf])) unset($plugins[$pf]);
    }
    return $plugins;
}
add_filter('all_plugins', 'wpa_hide_plugins');

function wpa_hide_selected_notices() {
    $o = get_option('wpa_login_settings');
    if (!isset($o['hidden_notice_types']) || !is_array($o['hidden_notice_types'])) return;
    add_action('admin_head', function() use ($o) {
        $css = '';
        foreach ($o['hidden_notice_types'] as $class) {
            if ($class === 'update_nag') {
                remove_action('admin_notices', 'update_nag', 3);
                $css .= '.update-nag{display:none!important;}';
            } else {
                $css .= '.'.$class.'{display:none!important;}';
            }
        }
        if ($css !== '') {
            echo '<style>'.$css.'</style>';
        }
    }, 999);
}
add_action('admin_init', 'wpa_hide_selected_notices', 999);

function wpa_custom_login_styles() {
    $o = get_option('wpa_login_settings');
    $l = isset($o['logo_url']) ? esc_url($o['logo_url']) : '';
    $b = isset($o['background_url']) ? esc_url($o['background_url']) : '';
    $pc = isset($o['primary_color']) ? sanitize_text_field($o['primary_color']) : '#1984be';
    $ph = isset($o['primary_color_hover']) ? sanitize_text_field($o['primary_color_hover']) : '#3c515b';
    $fbg = isset($o['form_bg_color']) ? sanitize_text_field($o['form_bg_color']) : '#ffffff';
    $itc = isset($o['input_text_color']) ? sanitize_text_field($o['input_text_color']) : '#333333';
    $ibg = isset($o['input_bg_color']) ? sanitize_text_field($o['input_bg_color']) : '#ffffff';
    $ibd = isset($o['input_border_color']) ? sanitize_text_field($o['input_border_color']) : '#cccccc';
    $lc = isset($o['label_color']) ? sanitize_text_field($o['label_color']) : '#333333';
    $links = isset($o['login_links_color']) ? sanitize_text_field($o['login_links_color']) : '#1984be';
    $links_hover = isset($o['login_links_hover_color']) ? sanitize_text_field($o['login_links_hover_color']) : '#3c515b';
    $footer_link = isset($o['footer_link_color']) ? sanitize_text_field($o['footer_link_color']) : '#1984be';
    $logo_width_desktop = isset($o['logo_width_desktop']) ? sanitize_text_field($o['logo_width_desktop']) : '150px';
    $logo_height_desktop = isset($o['logo_height_desktop']) ? sanitize_text_field($o['logo_height_desktop']) : '150px';
    $logo_width_tablet = isset($o['logo_width_tablet']) ? sanitize_text_field($o['logo_width_tablet']) : '120px';
    $logo_height_tablet = isset($o['logo_height_tablet']) ? sanitize_text_field($o['logo_height_tablet']) : '120px';
    $logo_width_mobile = isset($o['logo_width_mobile']) ? sanitize_text_field($o['logo_width_mobile']) : '100px';
    $logo_height_mobile = isset($o['logo_height_mobile']) ? sanitize_text_field($o['logo_height_mobile']) : '100px';
    $body_login_bg = isset($o['body_login_bg']) ? sanitize_text_field($o['body_login_bg']) : '#b22424';
    $login_container_bg = isset($o['login_container_bg']) ? sanitize_text_field($o['login_container_bg']) : '#b22424';
    $btn_text_color = isset($o['button_text_color']) ? sanitize_text_field($o['button_text_color']) : '#ffffff';
    $btn_text_color_hover = isset($o['button_text_color_hover']) ? sanitize_text_field($o['button_text_color_hover']) : '#ffffff';
    $login_image_bg = isset($o['login_image_bg']) ? sanitize_text_field($o['login_image_bg']) : '#000000';
    $login_image_blend = isset($o['login_image_blend']) ? sanitize_text_field($o['login_image_blend']) : 'multiply';
    ?>
    <style type="text/css">
    :root {
        --primary-color: <?php echo $pc; ?>;
        --primary-color-hover: <?php echo $ph; ?>;
        --form-bg-color: <?php echo $fbg; ?>;
        --input-text-color: <?php echo $itc; ?>;
        --input-bg-color: <?php echo $ibg; ?>;
        --input-border-color: <?php echo $ibd; ?>;
        --label-color: <?php echo $lc; ?>;
        --links-color: <?php echo $links; ?>;
        --links-hover-color: <?php echo $links_hover; ?>;
        --footer-link-color: <?php echo $footer_link; ?>;
        --logo-width-desktop: <?php echo $logo_width_desktop; ?>;
        --logo-height-desktop: <?php echo $logo_height_desktop; ?>;
        --logo-width-tablet: <?php echo $logo_width_tablet; ?>;
        --logo-height-tablet: <?php echo $logo_height_tablet; ?>;
        --logo-width-mobile: <?php echo $logo_width_mobile; ?>;
        --logo-height-mobile: <?php echo $logo_height_mobile; ?>;
    }
    body.login { background-color: #ffffff; }
    #login { position: relative; width: 100%; max-width: 420px; }
    .login h1 a {
        background-image: url('<?php echo $l; ?>') !important;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center center;
        width: 100%;
        height: 100px;
        max-width: 100%;
        margin: 0 auto;
    }
    @media (max-width: 767px) {
        .login h1 a {
            width: var(--logo-width-mobile);
            height: var(--logo-height-mobile);
        }
    }
    @media (min-width: 768px) and (max-width: 1023px) {
        .login h1 a {
            width: var(--logo-width-tablet);
            height: var(--logo-height-tablet);
        }
    }
    @media (min-width: 1024px) {
        .login h1 a {
            width: var(--logo-width-desktop);
            height: var(--logo-height-desktop);
        }
    }
    .login form {
        background: var(--form-bg-color);
        padding: 26px 24px 46px;
        margin-top: 0px;
        border: none;
        box-shadow: none;
    }
    .login label { color: var(--label-color); }
    .login form .input,
    .login input[type="text"],
    .login input[type="password"] {
        margin-bottom: 20px;
        font-size: 16px;
        padding: 10px;
        width: 100%;
        box-sizing: border-box;
        color: var(--input-text-color);
        background: var(--input-bg-color);
        border: 1px solid var(--input-border-color);
    }
    .login form .button-primary {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: <?php echo $btn_text_color; ?> !important;
        font-size: 16px;
        padding: 10px;
        margin-top: 20px;
        width: 100%;
        cursor: pointer;
    }
    .login form .button-primary:hover {
        background: var(--primary-color-hover);
        color: <?php echo $btn_text_color_hover; ?> !important;
    }
    .login .forgetmenot { margin-bottom: 10px; }
    .login #nav, .login #backtoblog { text-align: center; }
    .login #nav a, .login #backtoblog a { color: var(--primary-color); }
    .login #nav a:hover, .login #backtoblog a:hover { color: var(--primary-color-hover); }
    .login-background { display: flex; flex-wrap: wrap; min-height: 100vh; }
    .login-image {
        background: <?php echo $login_image_bg; ?> url('<?php echo $b; ?>') no-repeat center center;
        background-size: cover;
        background-blend-mode: <?php echo $login_image_blend; ?>;
        flex: 2;
        display: none;
    }
    form#language-switcher, .language-switcher {
        display: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .loginCopyright {
        position: absolute;
        top: 100%;
        left: 20%;
        color: var(--primary-color);
    }
    @media (min-width: 768px) {
        .login h1 a { height: 120px; }
        #login { max-width: 450px; }
    }
    @media (min-width: 1024px) {
        .login #login {
            flex: 1;
            max-width: none;
            padding: 60px;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-image { display: block; }
        .login h1 a { height: 150px; }
        .loginCopyright { left: 36%; }
    }
    body.login { background-color: <?php echo $body_login_bg; ?> !important; }
    .login #login { background: <?php echo $login_container_bg; ?> !important; }
    </style>
<?php
}
add_action('login_head', 'wpa_custom_login_styles');

function wpa_custom_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'wpa_custom_login_logo_url');

function wpa_custom_login_logo_url_title() {
    return 'WP AdLog';
}
add_filter('login_headertext', 'wpa_custom_login_logo_url_title');

function wpa_custom_login_body_class($classes) {
    $classes[] = 'login-background';
    return $classes;
}
add_filter('login_body_class', 'wpa_custom_login_body_class');

function wpa_custom_login_footer() {
    echo '<div class="login-image"></div>';
}
add_action('login_footer', 'wpa_custom_login_footer');
