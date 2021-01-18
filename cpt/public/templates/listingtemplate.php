<?php
get_header();
$args = array(
	'post_type' => 'people',
	'post_status' => 'publish',
);
$loop = new WP_Query( $args );
?>

<?php if ( $loop->have_posts() ) : ?>
	<?php while ( $loop->have_posts() ) : ?>
		<?php $loop->the_post(); ?>
		<?php
		$contactno = get_post_meta( get_the_ID(), 'contactno', true );
		$address   = get_post_meta( get_the_ID(), 'address', true );
		$review    = get_post_meta( get_the_ID(), 'review', true );
		$rating    = get_post_meta( get_the_ID(), 'rating', true );
		?>
		<div class="card">
			<img src="<?php the_post_thumbnail_url(); ?>" alt="Image Not Found" style="width:100%">
			<a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
			<p><?php echo esc_html( $contactno ); ?></p>
			<p><?php echo esc_html( $address ); ?></p>
			<p class="price"><?php echo esc_html( 'Review:' . $review ); ?></p>
			<p class="price"><?php echo esc_html( 'Rating:' . $rating ); ?></p>
			<p><button><?php for ( $i = 1; $i <= $rating; $i++ ) { echo '* '; } ?></button></p>
		</div>
	<?php endwhile; ?>
<?php endif; ?>


<?php
get_footer();
?>