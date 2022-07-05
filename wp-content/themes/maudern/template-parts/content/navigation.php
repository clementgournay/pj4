<?php
/**
 * Displays the next and previous post navigation in single posts.
 *
 * @package maudern
 * @since Maudern 1.0
 */

$next_post = get_next_post();
$prev_post = get_previous_post();

if ( $next_post || $prev_post ) {
	?>

	<div class="navigation-wrapper">

		<?php if ( $prev_post ) { ?>
			<nav class="navigation-single fixed previous-post block-md" aria-label="<?php esc_attr_e( 'Previous Post', 'maudern' ); ?>" role="navigation">
				<a class="no-underline" href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>">
					<div class="nav-post-info">
						<?php $categories = get_the_category( $prev_post->ID ); ?>
						<?php if ( $categories ) { ?>
							<ul class="post-meta no-list-style no-padding no-margin">
								<?php foreach ( $categories as $category ) { ?>
									<li class="uppercase meta-size text-color">
										<?php echo esc_html( $category->name ); ?>
										<span><?php echo esc_html( ',' ); ?></span>
									</li>
								<?php } ?>
							</ul>
						<?php } ?>

						<h5 class="title text-color">
							<?php echo esc_html( get_the_title( $prev_post->ID ) ); ?>
						</h5>
					</div>

					<span class="nav-icon-link relative no-underline">
						<div class="nav-icon relative"></div>
					</span>
				</a>
			</nav><!-- .pagination-single -->
		<?php } ?>

		<?php if ( $next_post ) { ?>
			<nav class="navigation-single fixed next-post block-md" aria-label="<?php esc_attr_e( 'Next Post', 'maudern' ); ?>" role="navigation">
				<a class="no-underline" href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>">
					<div class="nav-post-info">
						<?php $categories = get_the_category( $next_post->ID ); ?>
						<?php if ( $categories ) { ?>
							<ul class="post-meta no-list-style no-padding no-margin">
								<?php foreach ( $categories as $category ) { ?>
									<li class="uppercase meta-size text-color">
										<?php echo esc_html( $category->name ); ?>
										<span><?php echo esc_html( ',' ); ?></span>
									</li>
								<?php } ?>
							</ul>
						<?php } ?>

						<h5 class="title text-color">
							<?php echo esc_html( get_the_title( $next_post->ID ) ); ?>
						</h5>
					</div>

					<span class="nav-icon-link relative no-underline">
						<div class="nav-icon relative"></div>
					</span>
				</a>
			</nav><!-- .pagination-single -->
		<?php } ?>

	</div>

	<?php
}
