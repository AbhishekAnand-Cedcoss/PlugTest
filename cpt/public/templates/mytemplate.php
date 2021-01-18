<?php

if ( isset( $_POST['submit'] ) ) {
	if ( wp_verify_nonce( $_POST['registration_nonce'] ) ) {
		// die('verified');.
		$titles    = sanitize_text_field( ( ! empty( $_POST['title'] ) ? wp_unslash( $_POST['title'] ) : '' ) );
		$content   = sanitize_text_field( ( ! empty( $_POST['content'] ) ? wp_unslash( $_POST['content'] ) : '' ) );
		$contactno = sanitize_text_field( ( ! empty( $_POST['contactno'] ) ? wp_unslash( $_POST['contactno'] ) : '' ) );
		$address   = sanitize_text_field( ( ! empty( $_POST['address'] ) ? wp_unslash( $_POST['address'] ) : '' ) );
		$review    = sanitize_text_field( ( ! empty( $_POST['review'] ) ? wp_unslash( $_POST['review'] ) : '' ) );
		$rating    = sanitize_text_field( ( ! empty( $_POST['rating'] ) ? wp_unslash( $_POST['rating'] ) : '' ) );

		if ( '' !== $titles && '' !== $content ) {
			// echo "<script>alert('valid');</script>";

			$post_data = array(
				'post_type'    => 'people',
				'post_title'   => $titles,
				'post_content' => $content,
				'post_status'  => 'publish',
			);
			$pid   = wp_insert_post( $post_data );

			$post_meta = array(
				'address'   => $address,
				'contactno' => $contactno,
				'review'    => $review,
				'rating'    => $rating,
			);
			update_post_meta( $pid , 'meta_key', $post_meta );

			if ( ! is_wp_error( $pid ) ) {
				echo "<script>
					alert('People Registered !!');
					// location.reload();
				</script>";
				exit;

			} else {
				echo "<script>alert('Registration Failed !!') </script>";
			}
		} else {
			echo "<script>alert('Please Fill All the Required Field');</script>";
		} 
	} else {
		die('not verified');
	}
	// die(); .
}
get_header();
?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header alignwide">
		<?php get_template_part( 'template-parts/header/entry-header' ); ?>
		<?php twenty_twenty_one_post_thumbnail(); ?>
	</header>

	<div class="entry-content">
		<form action="" method="POST">
		<?php $nonce = wp_create_nonce(); ?>
			<input type="hidden" name="registration_nonce" value="<?php esc_html_e( $nonce ); ?>" />
			<table>
			<tr>
				<td><?php esc_attr_e( 'Title' ); ?></td>
				<td><input type="text" name="title" id="title"><span id="userspan" style="display:none;">Verified</span></td>
			</tr>
			<tr>
				<td><?php esc_attr_e( 'Content' ); ?></td>
				<td><input type="text" name="content" id="content"><span id="emailspan" style="display:none;">Verified</span></td>
			</tr>
			<tr>
				<td><?php esc_attr_e( 'Contact No' ); ?></td>
				<td><input type="text" name="contactno" id="contactno"><span id="passwordspan" style="display:none;">Verified</span></td>
			</tr>
			<tr>
				<td><?php esc_attr_e( 'Address' ); ?></td>
				<td><textarea name="address" id="address" cols="2" rows="2"></textarea><span id="addressspan" style="display:none;">Verified</span></td>
			</tr>
			<?php
			$options = get_option( 'wporg_options' );
			if ( ! empty( $options ) ) {
				if ( 'on' === $options['wporg_field_pill_review'] ) {
					?>
			<tr>
				<td><?php esc_attr_e( 'Review' ); ?></td>
				<td><input type="text" name="review" class="review" id="review"><span id="phonespan" style="display:none;">Verified</span></td>
			</tr>
					<?php
				}
				if ( 'on' === $options['wporg_field_pill_rating'] ) {
					?>
			<tr>
				<td><?php esc_attr_e( 'Rating' ); ?></td>
				<td><input type="number" name="rating" id="rating"><span id="dobspan" style="display:none;">Verified</span></td>
			</tr>
					<?php
				}
			}
			?>

			</table><br>
			<center><input type="submit" name="submit" value="Register"></center>

		</form>
	</div><!-- .entry-content -->

	<footer class="entry-footer default-max-width">
		<?php get_footer(); ?>
	</footer><!-- .entry-footer -->

</article>
<?php
get_footer();
?>
