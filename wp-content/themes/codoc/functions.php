<?php

/**
 * twentytwenty のスタイルよりあとに読み込むように変更
 */
function codoc_twentytwenty_register_styles() {
    remove_action( 'wp_enqueue_scripts', 'twentytwenty_register_styles');
    $theme_version = wp_get_theme()->get( 'Version' );
    // 主にconnectから取得した情報でスタイルを書き換える用
    wp_enqueue_script( 'codoc-twentytwenty-', get_stylesheet_directory_uri() . '/assets/js/codoc-theme.js', array( 'jquery' ), $theme_version, false );
    
    // <style id='twentytwenty-style-inline-css'> を最初に出力するための実装
    wp_enqueue_style( 'twentytwenty-style', get_stylesheet_directory_uri() . '/codoc.css', array(), $theme_version );
    wp_style_add_data( 'twentytwenty-style', 'rtl', 'replace' );

    // Add output of Customizer settings as inline style.
    wp_add_inline_style( 'twentytwenty-style', twentytwenty_get_customizer_css( 'front-end' ) );

    // Add print CSS.
    wp_enqueue_style( 'twentytwenty-print-style', get_stylesheet_directory_uri() . '/print.css', null, $theme_version, 'print' );

    wp_enqueue_style( 'codoc-twentytwenty-style', get_stylesheet_uri(), array(), $theme_version );
}

add_action( 'wp_enqueue_scripts', 'codoc_twentytwenty_register_styles',10 );

/**
 *
 * ウィジェットにヘッダーを追加
 *
 */
function codoc_twentytwenty_sidebar_registration() {
    remove_action( 'widgets_init', 'twentytwenty_sidebar_registration' );
    // Arguments used in all register_sidebar() calls.
    $shared_args = array(
        'before_title'  => '<h2 class="widget-title subheading heading-size-3">',
        'after_title'   => '</h2>',
        'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
        'after_widget'  => '</div></div>',
    );

    // Header #1.
    register_sidebar(
        array_merge(
            [
                'before_title'  => '<div style="display:none;">',
                'after_title'   => '</div>',
                'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
                'after_widget'  => '</div></div>',
            ],
            array(
                'name'        => __( 'ヘッダー1', 'codoc' ),
                'id'          => 'sidebar-0',
                'description' => __( 'このエリアのウィジェットはヘッダーの１行目に表示されます。', 'codoc' ),
            )
        )
    );

    // Footer #1.
    register_sidebar(
        array_merge(
            $shared_args,
            array(
                'name'        => __( 'Footer #1', 'codoc' ),
                'id'          => 'sidebar-1',
                'description' => __( 'Widgets in this area will be displayed in the first column in the footer.', 'codoc' ),
            )
        )
    );

    // Footer #2.
    register_sidebar(
        array_merge(
            $shared_args,
            array(
                'name'        => __( 'Footer #2', 'codoc' ),
                'id'          => 'sidebar-2',
                'description' => __( 'Widgets in this area will be displayed in the second column in the footer.', 'codoc' ),
            )
        )
    );

}

add_action( 'widgets_init', 'codoc_twentytwenty_sidebar_registration',10);

/*

カスタマイズ→色でメインカラーの設定を抜く

 */
if ( ! class_exists( 'CodocTwentyTwenty_Customize' ) ) {
    class CodocTwentyTwenty_Customize {
        public static function register( $wp_customize ) {
            $wp_customize->remove_control('accent_hue_active');
            // assets/js/customize.js がエラーをだすのでダミーでいれる
            $wp_customize->add_control('accent_hue_active',[
                    'type'    => 'radio',
                    'section' => 'colors',
            ]);
        }
    }
    add_action( 'customize_register', array( 'CodocTwentyTwenty_Customize', 'register' ),10000);
}

/*
  テーマサポートの追加 (親テーマよりあとに実施する)
*/

add_action( 'after_setup_theme', function() {
    add_theme_support( "title-tag" );
    add_theme_support( 'automatic-feed-links' ).
    add_theme_support( 'custom-header');
    add_theme_support( 'custom-background');
    load_child_theme_textdomain( 'codoc', get_stylesheet_directory() . '/languages' );
    codoc_check_plugin_condition();
},1000);


/*
  codocテーマ変更されたとき
*/
add_action( 'after_switch_theme', function() {
    codoc_dismiss_reset();
    // after_setup_theme よりあとのため。
    codoc_check_plugin_condition();
},1000);

/*
  プラグインのインストールチェックのwarningを確認
*/
function codoc_dismiss_nonce_url($type) {
    return esc_url(
        wp_nonce_url(
            add_query_arg( 'codoc-dismiss-' . $type, 'dismiss_admin_notices' ),
            'codoc-dismiss-' . get_current_user_id()
        )
    );
}
function codoc_dismiss($type) {
    //echo check_admin_referer( 'codoc-dismiss-' . get_current_user_id() );
    $status = get_user_meta( get_current_user_id(), 'codoc_dismissed_notice_' . $type);
    if ($type == 'authorize') {
        //die(print_r($status,true));
    }
    if (is_array($status) and isset($status[0]) and  $status[0]) {
        $status = 1;
    } else {
        $status = 0;
    }
    if ($status == 1) {
        return true;
    }
    if ( isset( $_GET['codoc-dismiss-' . $type] ) && !$status and check_admin_referer( 'codoc-dismiss-' . get_current_user_id() ) ) {
        update_user_meta( get_current_user_id(), 'codoc_dismissed_notice_' . $type, 1 );
        return true;
    }
    return false;
}
//<button type="button" class="notice-dismiss"><span class="screen-reader-text">この通知を非表示にする。</span></button>
function codoc_dismiss_reset() {
    delete_metadata( 'user', null, 'codoc_dismissed_notice_install', null, true );
    delete_metadata( 'user', null, 'codoc_dismissed_notice_authorize', null, true );
    delete_metadata( 'user', null, 'codoc_dismissed_notice_connect', null, true );
}

/*
  管理画面で常に実施される処理
*/

function codoc_check_plugin_condition() {
    if (!is_admin()) {
        return;
    }
    if (!function_exists('is_plugin_active')) {
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }

    if (!codoc_dismiss('install')  and !is_plugin_active('codoc/codoc.php')) {
        add_action('admin_notices', function () {
            $name = 'codoc';
            $url = network_admin_url( "plugin-install.php?tab=search&s=" . $name );
            echo "<div class=\"notice notice-warning is-dismissible\"><p><a href=\"${url}\">${name}</a> プラグインを有効化してください</p><p><a href=\""  . codoc_dismiss_nonce_url('install')  . "\">表示しない</a></p></div>";
        });
        return;
    }
    $CODOC_AUTHINFO_OPTION_NAME = '';
    if (is_plugin_active('codoc/codoc.php')) {
        $CODOC_AUTHINFO_OPTION_NAME = defined('CODOC_AUTHINFO_OPTION_NAME') ? CODOC_AUTHINFO_OPTION_NAME : 'codoc_authinfo';
    }
    // プラグインで認証がとれてない場合
    $CODOC_AUTH_INFO = get_option($CODOC_AUTHINFO_OPTION_NAME);
    if (!codoc_dismiss('authorize') and !$CODOC_AUTH_INFO) {
        add_action('admin_notices', function () {
            $name = 'codoc';
            $url = admin_url('options-general.php') . '?page=codoc';
            echo "<div class=\"notice notice-warning is-dismissible\"><p><a href=\"${url}\">${name}</a> プラグインを認証してください</p><p><a href=\""  . codoc_dismiss_nonce_url('authorize')  . "\">表示しない</a></p></div>";
        });
        return;
    }
    if (!codoc_dismiss('connect') and $CODOC_AUTH_INFO and
        (!isset($CODOC_AUTH_INFO['connect_code']) or !$CODOC_AUTH_INFO['connect_code'])
    ) {
        add_action('admin_notices', function () {
            $name = 'codoc';
            $url = admin_url('options-general.php') . '?page=codoc';
            echo "<div class=\"notice notice-warning is-dismissible\"><p><a href=\"${url}\">${name}</a> 外部サービス連携を有効にするために再認証してください</p><p><a href=\""  . codoc_dismiss_nonce_url('connect')  . "\">表示しない</a></p></div>";
        });
        return;
    }
}

