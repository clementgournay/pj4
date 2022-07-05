<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Recent Reviews Widget.
 *
 * @author   WooThemes
 * @category Widgets
 * @package  WooCommerce/Widgets
 * @version  2.3.0
 * @extends  WC_Widget
 */
class Custom_WC_Widget_Recent_Reviews extends WC_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->widget_cssclass    = 'woocommerce widget_recent_reviews';
		$this->widget_description = esc_html__( 'Display a list of your most recent reviews on your site.', 'cosmeli' );
		$this->widget_id          = 'woocommerce_recent_reviews';
		$this->widget_name        = esc_html__( 'WooCommerce Recent Reviews', 'cosmeli' );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => esc_html__( 'Recent Reviews', 'cosmeli' ),
				'label' => esc_html__( 'Title', 'cosmeli' )
			),
			'number' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 10,
				'label' => esc_html__( 'Number of reviews to show', 'cosmeli' )
			)
		);

		parent::__construct();
	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	 public function widget( $args, $instance ) {
		global $comments, $comment;

		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		ob_start();

		$number   = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];
		$comments = get_comments( array( 'number' => $number, 'status' => 'approve', 'post_status' => 'publish', 'post_type' => 'product' ) );

		if ( $comments ) {
			$this->widget_start( $args, $instance );

			echo '<ul class="product_list_widget">';

			foreach ( (array) $comments as $comment ) {

				$_product = wc_get_product( $comment->comment_post_ID );

				$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

				$rating_html = $_product->get_rating_html( $rating );

				echo '<li>';
				echo '<div class="image-block"><a href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '">'.$_product->get_image().'</a></div>';
				echo '<div class="text-block">';
					echo '<h3 class="product-title"><a href="'.get_permalink( $product->get_id() ).'">'.$_product->get_title().'</a></h3>';

					echo $rating_html;

					printf( '<span class="reviewer">' . _x( 'by %1$s', 'by comment author', 'cosmeli' ) . '</span>', get_comment_author() );
				echo '</div>';
				echo '</li>';
			}

			echo '</ul>';

			$this->widget_end( $args );
		}

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}
}
