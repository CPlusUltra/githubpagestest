<?php
/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 */

?>
			<footer id="site-footer" role="contentinfo" class="site-footer header-footer-group">

				<div class="section-inner">

					<div class="footer-credits">

						<p class="footer-copyright">&copy;
							<?php
							echo date_i18n(
								/* translators: Copyright date format, see https://www.php.net/manual/datetime.format.php */
								_x( 'Y', 'copyright date format', 'codoc' )
							);
							?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
						</p><!-- .footer-copyright -->

						<p class="powered-by-wordpress">
							<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'codoc' ) ); ?>">
								<?php _e( 'Powered by WordPress', 'codoc' ); ?>
							</a> and <a href="<?php echo esc_url( __( 'https://codoc.jp/', 'codoc' ) ); ?>">codoc</a>
						</p><!-- .powered-by-wordpress -->

					</div><!-- .footer-credits -->

				</div><!-- .section-inner -->

			</footer><!-- #site-footer -->

		<?php wp_footer(); ?>

	</body>
</html>
