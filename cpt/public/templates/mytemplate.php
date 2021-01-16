<?php

if ( isset( $_POST['submit'] ) ) {
	$titles    = $_POST['title'];
	$content   = $_POST['content'];
	$contactno = $_POST['contactno'];
	$address   = $_POST['address'];
	$review    = $_POST['review'];
	$rating    = $_POST['rating'];

	if ( '' != $titles  && '' !== $content ) {
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

		// $user = new WP_User( $user_id );
		// $user->set_role( 'customer_role' );

		// error in redirection else verified.
		if ( ! is_wp_error( $pid ) ) {
			echo "<script>
				alert('People Registered !!');
			</script>";
			exit;

		} else {
			echo "<script>alert('Registration Failed !!') </script>";
		}
	} else {
		echo "<script>alert('Please Fill All the Required Field');</script>";
	}
	// die();
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
		<td>Title</td>
		<td><input type="text" name="title" id="title"><span id="userspan" style="display:none;">Verified</span></td>
	</tr>
	<tr>
		<td>Content</td>
		<td><input type="text" name="content" id="content"><span id="emailspan" style="display:none;">Verified</span></td>
	</tr>
	<tr>
		<td>Contact No:</td>
		<td><input type="text" name="contactno" id="contactno"><span id="passwordspan" style="display:none;">Verified</span></td>
	</tr>
	<tr>
		<td>Address</td>
		<td><textarea name="address" id="address" cols="2" rows="2"></textarea><span id="addressspan" style="display:none;">Verified</span></td>
	</tr>
	<?php $options = get_option('wporg_options'); 
	if ( ! empty( $options ) ) {
	if ($options['wporg_field_pill_review'] === 'on') {
		?>
	<tr>
		<td>Review</td>
		<td><input type="text" name="review" class="review" id="review"><span id="phonespan" style="display:none;">Verified</span></td>
	</tr>
	<?php 
	} 
	if ($options['wporg_field_pill_rating'] === 'on') {
		?>
	<tr>
		<td>Rating</td>
		<td><input type="number" name="rating" id="rating"><span id="dobspan" style="display:none;">Verified</span></td>
	</tr>
	<?php } }
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



<!-- /**
 * Undocumented function
 *
 * @return void
 */
function mwb_register_form() {

	if ( wp_verify_nonce( $_POST['registration_nonce'] ) ) {
		esc_attr_e( 'Verified' );
		if ( isset($_POST['submit']) ) {//phpcs:ignore.
			$username    = sanitize_text_field( ! empty( $_POST['username'] ) ) ? ( wp_unslash( $_POST['username'] ) ) : '' ) );
			$password    = sanitize_text_field(! empty( $_POST['password'] ) ? wp_unslash( $_POST['password'] ): '' ) );
			$email       = sanitize_text_field( ( wp_unslash( ! empty( $_POST['email'] ) ) ? $_POST['email'] : '' ) );
			$address     = sanitize_text_field( ( wp_unslash( ! empty( $_POST['address'] ) ) ? $_POST['address'] : '' ) );
			$phonenumber = sanitize_text_field( ( wp_unslash( ! empty( $_POST['phonenumber'] ) ) ? $_POST['phonenumber'] : '' ) );
			$dob         = sanitize_text_field( ( wp_unslash( ! empty( $_POST['dob'] ) ) ? $_POST['dob'] : '' ) );

			if ( '' != $username  && '' !== $email && '' !== $password ) {
				// echo "<script>alert('valid');</script>";
				$roles = 'Customer';

				$user_data = array(
					'user_login' => $username,
					'user_pass'  => $password,
					'user_email' => $email,
					// 'role'    => $role.
				);
				$user_id = wp_insert_user( $user_data );

				$user_meta = array(
					'user_address'     => $address,
					'user_phonenumber' => $phonenumber,
					'user_dob'         => $dob,
					'user_role'        => $roles,
				);

				// error in redirection else verified.
				if ( ! is_wp_error( $user_id ) ) {
					echo "<script>
						alert('User Registered !!');
						window.location='http://user-roles.local/login';
					</script>";
					exit;

				} else {
					echo "<script>alert('Registration Failed !!') </script>";
				}
			} else {
				echo "<script>alert('Please Fill All the Required Field');</script>";
			}
			// die();
				// error in redirection else verified.
				if ( ! is_wp_error( $user_id ) ) {
					echo "<script>
						alert('User Registered !!');
						window.location='http://user-roles.local/login';
					</script>";
					exit;

				} else {
					echo "<script>alert('Registration Failed !!') </script>";
				}
			} else {
				echo "<script>alert('Please Fill All the Required Field');</script>";
			}
			// die();

		}
	} else {
		// esc_attr_e( 'Not verified' );.
	}
	// die();.
} -->
<!-- add_action( 'init', 'mwb_register_form' ); -->