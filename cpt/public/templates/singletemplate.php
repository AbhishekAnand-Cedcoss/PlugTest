<?php
get_header();
?>
<?php
$contactno = get_post_meta( get_the_ID(), 'contactno', true );
$address   = get_post_meta( get_the_ID(), 'address', true );
$review    = get_post_meta( get_the_ID(), 'review', true );
$rating    = get_post_meta( get_the_ID(), 'rating', true );
?>
<div class="card">
	<img src="<?php the_post_thumbnail_url(); ?>" alt="Denim Jeans" style="width:100%">
	<h3><?php the_title(); ?></h3>
	<p><?php echo esc_html( $contactno ); ?></p>
	<p><?php echo esc_html( $address ); ?></p>
	<p class="price"><?php echo esc_html( 'Review:' . $review ); ?></p>
	<p class="price"><?php echo esc_html( 'Rating:' . $rating ); ?></p>
	<p><button>Add to Cart</button></p>
</div>

<?php
get_footer();
?>
