<?php
/**
 * Header file for the codoc theme.
 *
 * @link https://codoc.jp
 *
 */

?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >
		<link rel="profile" href="https://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<?php
		wp_body_open();
		?>
		<header id="site-header" class="site-header header-footer-group" role="banner">
			<div class="header-inner section-inner">
				<?php
				// Check whether the header search is activated in the customizer.
				$enable_header_search = get_theme_mod( 'enable_header_search', true );
				if ( true === $enable_header_search ) {
					?>
					<button class="toggle search-toggle mobile-search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
						<span class="toggle-inner">
							<span class="toggle-icon">
								<?php twentytwenty_the_theme_svg( 'search' ); ?>
							</span>
							<span class="toggle-text"><?php _ex( 'Search', 'toggle text', 'codoc' ); ?></span>
						</span>
					</button><!-- .search-toggle -->
				<?php } ?>
                <?php
                if (!function_exists('is_plugin_active')) {
                    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
                }
                $CODOC_AUTHINFO_OPTION_NAME = '';
                if (is_plugin_active('codoc/codoc.php')) {
                    $CODOC_AUTHINFO_OPTION_NAME = defined('CODOC_AUTHINFO_OPTION_NAME') ? CODOC_AUTHINFO_OPTION_NAME : 'codoc_authinfo';
                }
                ?>
                <?php $CODOC_AUTH_INFO = get_option($CODOC_AUTHINFO_OPTION_NAME); ?>
                <?php
                if ($CODOC_AUTH_INFO and isset($CODOC_AUTH_INFO['connect_image_url']) and $logo_url = $CODOC_AUTH_INFO['connect_image_url']) {
                ?>
                <div id="codoc-auth-info" data-image-url="<?php echo htmlspecialchars($logo_url); ?>"></div>
                <?php } else { ?>
                <div id="codoc-auth-info" data-image-url=""></div>
                <?php
                }
                ?>
                <?php
                // codocと認証してない場合（初期状態）はロゴを表示しない
                if (!$CODOC_AUTH_INFO) {
                ?>
                <div id="codoc-no-auth-info"></div>
                <?php
                }
                ?>
				<div class="header-titles-wrapper">
					<div class="header-titles">
						<?php
							// Site title or logo.
							twentytwenty_site_logo();
						?>
						<?php
							// Site description.
							twentytwenty_site_description();
						?>
					</div><!-- .header-titles -->
				</div><!-- .header-titles-wrapper -->
				<button class="toggle nav-toggle mobile-nav-toggle" data-toggle-target=".menu-modal"  data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".close-nav-toggle">
					<span class="toggle-inner">
						<span class="toggle-icon">
							<?php twentytwenty_the_theme_svg( 'ellipsis' ); ?>
						</span>
						<span class="toggle-text"><?php _e( 'Menu', 'codoc' ); ?></span>
					</span>
				</button><!-- .nav-toggle -->


				<div class="header-navigation-wrapper">
					<?php
					if ( has_nav_menu( 'primary' ) || ! has_nav_menu( 'expanded' ) ) {
						?>

						<?php
					}
					if ( true === $enable_header_search || has_nav_menu( 'expanded' ) ) {
						?>
						<div class="header-toggles hide-no-js">
						<?php
						if ( has_nav_menu( 'expanded' ) ) {
							?>
							<div class="toggle-wrapper nav-toggle-wrapper has-expanded-menu">
								<button class="toggle nav-toggle desktop-nav-toggle" data-toggle-target=".menu-modal" data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".close-nav-toggle">
									<span class="toggle-inner">
										<span class="toggle-text"><?php _e( 'Menu', 'codoc' ); ?></span>
										<span class="toggle-icon">
											<?php twentytwenty_the_theme_svg( 'ellipsis' ); ?>
										</span>
									</span>
								</button><!-- .nav-toggle -->
							</div><!-- .nav-toggle-wrapper -->
							<?php
						}
						if ( true === $enable_header_search ) {
							?>
							<div class="toggle-wrapper search-toggle-wrapper">
								<button class="toggle search-toggle desktop-search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
									<span class="toggle-inner">
										<?php twentytwenty_the_theme_svg( 'search' ); ?>
									</span>
								</button><!-- .search-toggle -->
							</div>
							<?php
						}
						?>
						</div><!-- .header-toggles -->
						<?php
					}
					?>
				</div><!-- .header-navigation-wrapper -->
			</div><!-- .header-inner -->
			<?php
			// Output the search modal (if it is activated in the customizer).
			if ( true === $enable_header_search ) {
				get_template_part( 'template-parts/modal-search' );
			}
			?>
		</header><!-- #site-header -->

		<div class="header-bottom">
			<?php
			if ( has_nav_menu( 'primary' ) || ! has_nav_menu( 'expanded' ) ) {
				?>
					<nav class="primary-menu-wrapper sub-navigation" aria-label="<?php echo esc_attr_x( 'Horizontal', 'menu', 'codoc' ); ?>" role="navigation">
						<ul class="primary-menu reset-list-style">
						<?php
						if ( has_nav_menu( 'primary' ) ) {

							wp_nav_menu(
								array(
									'container'  => '',
									'items_wrap' => '%3$s',
									'theme_location' => 'primary',
								)
							);
						} elseif ( ! has_nav_menu( 'expanded' ) ) {

							wp_list_pages(
								array(
									'match_menu_classes' => true,
									'show_sub_menu_icons' => true,
									'title_li' => false,
									'walker'   => new TwentyTwenty_Walker_Page(),
								)
							);
						}
						?>
						</ul>
					</nav><!-- .primary-menu-wrapper -->
				<?php
			}
			?>
			<div class="header-widgets">
				<div class="widget">
						<?php if ( true ) { ?>

							<div class="footer-widgets column-two grid-item">
								<?php dynamic_sidebar( 'sidebar-0' ); ?>
                                <?php if ( isset($CODOC_AUTH_INFO['connect_code']) ) { ?>
                                <div id="codoc-connect-login-<?php echo htmlspecialchars($CODOC_AUTH_INFO['connect_code']); ?>" class="codoc-connect-login" data-show-purchases-button="1" data-show-subscribed-button="1"></div>
                                <?php } ?>
							</div>

						<?php } ?>

				</div>
			</div>
		</div>
		<div class="profile">
			<div class="profile-cover">
			<?php if ( $header_image = get_header_image() and $header_image ) { ?>
				<img src="<?php echo $header_image ?>" alt="<?php echo htmlspecialchars(bloginfo('name')); ?>">
			<?php } elseif ( isset($CODOC_AUTH_INFO['cover_image_url']) ) { ?>
				<img src="<?php echo htmlspecialchars($CODOC_AUTH_INFO['cover_image_url']); ?>" alt="<?php echo htmlspecialchars($CODOC_AUTH_INFO['name']); ?>">
			<?php } else { ?>
				<img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cover.png" alt="codoc">                
			<?php } ?>                                
			</div>
			<div class="profile-icon">
			<?php if ( isset($CODOC_AUTH_INFO['profile_image_url']) ) { ?>
				<img src="<?php echo htmlspecialchars($CODOC_AUTH_INFO['profile_image_url']); ?>" alt="<?php echo htmlspecialchars($CODOC_AUTH_INFO['name']); ?>">
			<?php } else { ?>                                                
				<img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/default-user-icon.svg" alt="ユーザー名">
			<?php } ?>                                
			</div>
			<div class="profile-status">
				<a href=""></a>
			</div>
		</div>

		<?php
		// Output the menu modal.
		get_template_part( 'template-parts/modal-menu' );
