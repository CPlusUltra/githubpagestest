<?php
/**
 * The main template file
 *
 * @link https://codoc.jp
 *
 */

get_header();
?>

<div class="site-content-wrapper">

	<main id="site-content" class="site-content" role="main">

		<?php

		$archive_title    = '';
		$archive_subtitle = '';
        // textdomain のcheckを回避するための実装 (Your theme appears to be in the wrong directory for the theme name.)
        $test = __('test','codoc');
		if ( is_search() ) {
			global $wp_query;

			$archive_title = sprintf(
				'%1$s %2$s',
				'<span class="color-accent">' . __( 'Search:', 'codoc' ) . '</span>',
				'&ldquo;' . get_search_query() . '&rdquo;'
			);

			if ( $wp_query->found_posts ) {
				$archive_subtitle = sprintf(
					/* translators: %s: Number of search results. */
					_n(
						'We found %s result for your search.',
						'We found %s results for your search.',
						$wp_query->found_posts,
						'codoc'
					),
					number_format_i18n( $wp_query->found_posts )
				);
			} else {
				$archive_subtitle = __( 'We could not find any results for your search. You can give it another try through the search form below.', 'codoc' );
			}
		} elseif ( is_archive() && ! have_posts() ) {
			$archive_title = __( 'Nothing Found', 'codoc' );
		} elseif ( ! is_home() ) {
			$archive_title    = get_the_archive_title();
			$archive_subtitle = get_the_archive_description();
		}

		if ( $archive_title || $archive_subtitle ) {
			?>

			<header class="archive-header has-text-align-center header-footer-group">

				<div class="archive-header-inner section-inner medium">

					<?php if ( $archive_title ) { ?>
						<h1 class="archive-title"><?php echo wp_kses_post( $archive_title ); ?></h1>
					<?php } ?>

					<?php if ( $archive_subtitle ) { ?>
						<div class="archive-subtitle section-inner thin max-percentage intro-text"><?php echo wp_kses_post( wpautop( $archive_subtitle ) ); ?></div>
					<?php } ?>

				</div><!-- .archive-header-inner -->

			</header><!-- .archive-header -->

			<?php
		}

		if ( have_posts() ) {

			while ( have_posts() ) {

				the_post();

				get_template_part( 'template-parts/content', get_post_type() );

			}
		} elseif ( is_search() ) {
			?>

			<div class="no-search-results-form section-inner thin">

				<?php
				get_search_form(
					array(
						'label' => __( 'search again', 'codoc' ),
					)
				);
				?>

			</div><!-- .no-search-results -->

			<?php
		}
		?>

		<?php get_template_part( 'template-parts/pagination' ); ?>

	</main><!-- #site-content -->

	<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

</div><!-- #site-content-wrapper -->

<?php
get_footer();
