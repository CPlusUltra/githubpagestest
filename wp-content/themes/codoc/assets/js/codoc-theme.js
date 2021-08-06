/* global wp, jQuery */

( function( $ ) {
	$( document ).ready( function() {
        if ($('#codoc-auth-info').length && $('#codoc-auth-info').data('image-url')) {
            // codoc側で設定されているロゴと動機
            let backgroundImage = "url('" + $('#codoc-auth-info').data('image-url').toString() + "')";
            $('.site-title a').css('background',backgroundImage);
            $('.site-title a').css('background-size','100px 24px');
            $('.site-title a').css('text-indent','-9999px');
        } else {
            // デフォルトのロゴを表示
            $('.site-title a').css('background-size','100px 24px');
            $('.site-title a').css('text-indent','-9999px');
        }
        if ($('#codoc-no-auth-info').length) {
            // codocと認証してない場合（初期状態）はデフォルトロゴを表示しない
            $('.site-title a').css('background-image','none');
            $('.site-title a').css('text-indent','0');
        }
        // 非表示を解除
        $('.site-title a').css('opacity','1');
	} );
}( jQuery) );
