<?php
/*
* Illustrates how to add custom user fields to the Restrict Content Pro registration form that can also be edited by the site admins
* Author: Pippin Williamson - Contributors: mordauk
*/


/**
 * Adds the custom fields to the registration form and profile editor
 *
 */
function pw_rcp_add_user_fields() {

	$profession 			= get_user_meta( get_current_user_id(), 'rcp_profession', true );
	$location   			= get_user_meta( get_current_user_id(), 'rcp_location', true );
	$university   		= get_user_meta( get_current_user_id(), 'rcp_university', true );
	$mother_tongue  	= get_user_meta( get_current_user_id(), 'rcp_mother_tongue', true );
	$other_education  = get_user_meta( get_current_user_id(), 'rcp_other_education', true );

	?>
		<label for="rcp_mother_tongue"><?php _e( 'Mother Tongue', 'rcp' ); ?></label>
		<input name="rcp_mother_tongue" id="rcp_mother_tongue" type="text" value="<?php echo esc_attr( $mother_tongue ); ?>"/>
	</p>
	<p>
		<label for="rcp_university"><?php _e( 'University Degree', 'rcp' ); ?></label>
		<input name="rcp_university" id="rcp_university" type="text" value="<?php echo esc_attr( $university ); ?>"/>
	</p>
	<p>
	<p>
		<label for="rcp_other_education"><?php _e( 'Other Education', 'rcp' ); ?></label>
		<input name="rcp_other_education" id="rcp_other_education" type="text" value="<?php echo esc_attr( $other_education ); ?>"/>
	</p>
	<p>
		<label for="rcp_profession"><?php _e( 'Profession', 'rcp' ); ?></label>
		<input name="rcp_profession" id="rcp_profession" type="text" value="<?php echo esc_attr( $profession ); ?>"/>
	</p>
	<p>
		<label for="rcp_location"><?php _e( 'Location', 'rcp' ); ?></label>
		<input name="rcp_location" id="rcp_location" type="text" value="<?php echo esc_attr( $location ); ?>"/>
	</p>

	<?php
}
add_action( 'rcp_before_subscription_form_fields', 'pw_rcp_add_user_fields' );
add_action( 'rcp_profile_editor_after', 'pw_rcp_add_user_fields' );

/**
 * Adds the custom fields to the member edit screen
 *
 */
function pw_rcp_add_member_edit_fields( $user_id = 0 ) {

	$profession 			= get_user_meta( $user_id, 'rcp_profession', true );
	$location   			= get_user_meta( $user_id, 'rcp_location', true );
	$university   		= get_user_meta( $user_id, 'rcp_university', true );
	$mother_tongue   	= get_user_meta( $user_id, 'rcp_mother_tongue', true );
	$other_education  = get_user_meta( $user_id, 'rcp_other_education', true );
	?>

	<tr valign="top">
		<th scope="row" valign="top">
			<label for="rcp_mother_tongue"><?php _e( 'Mother Tongue', 'rcp' ); ?></label>
		</th>
		<td>
			<input name="rcp_mother_tongue" id="rcp_mother_tongue" type="text" value="<?php echo esc_attr( $mother_tongue ); ?>"/>
			<p class="description"><?php _e( 'The member\'s mpother tongue', 'rcp' ); ?></p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row" valign="top">
			<label for="rcp_university"><?php _e( 'University', 'rcp' ); ?></label>
		</th>
		<td>
			<input name="rcp_university" id="rcp_university" type="text" value="<?php echo esc_attr( $university ); ?>"/>
			<p class="description"><?php _e( 'The member\'s University', 'rcp' ); ?></p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row" valign="top">
			<label for="rcp_other_education"><?php _e( 'Other Education', 'rcp' ); ?></label>
		</th>
		<td>
			<input name="rcp_other_education" id="rcp_other_education" type="text" value="<?php echo esc_attr( $other_education ); ?>"/>
			<p class="description"><?php _e( 'The member\'s other qualification', 'rcp' ); ?></p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row" valign="top">
			<label for="rcp_profession"><?php _e( 'Profession', 'rcp' ); ?></label>
		</th>
		<td>
			<input name="rcp_profession" id="rcp_profession" type="text" value="<?php echo esc_attr( $profession ); ?>"/>
			<p class="description"><?php _e( 'The member\'s profession', 'rcp' ); ?></p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row" valign="top">
			<label for="rcp_location"><?php _e( 'Location', 'rcp' ); ?></label>
		</th>
		<td>
			<input name="rcp_location" id="rcp_location" type="text" value="<?php echo esc_attr( $location ); ?>"/>
			<p class="description"><?php _e( 'The member\'s location', 'rcp' ); ?></p>
		</td>
	</tr>

	<?php
}
add_action( 'rcp_edit_member_after', 'pw_rcp_add_member_edit_fields' );

/**
 * Determines if there are problems with the registration data submitted
 *
 */
/*function pw_rcp_validate_user_fields_on_register( $posted ) {

	if( empty( $posted['rcp_profession'] ) ) {
		rcp_errors()->add( 'invalid_profession', __( 'Please enter your profession', 'rcp' ), 'register' );
	}

	if( empty( $posted['rcp_location'] ) ) {
		rcp_errors()->add( 'invalid_location', __( 'Please enter your location', 'rcp' ), 'register' );
	}


}
add_action( 'rcp_form_errors', 'pw_rcp_validate_user_fields_on_register', 10 );*/

/**
 * Stores the information submitted during registration
 *
 */
function pw_rcp_save_user_fields_on_register( $posted, $user_id ) {

	if( ! empty( $posted['rcp_profession'] ) ) {
		update_user_meta( $user_id, 'rcp_profession', sanitize_text_field( $posted['rcp_profession'] ) );
	}
	if( ! empty( $posted['rcp_location'] ) ) {
		update_user_meta( $user_id, 'rcp_location', sanitize_text_field( $posted['rcp_location'] ) );
	}
	if( ! empty( $posted['rcp_university'] ) ) {
		update_user_meta( $user_id, 'rcp_university', sanitize_text_field( $posted['rcp_university'] ) );
	}
	if( ! empty( $posted['rcp_mother_tongue'] ) ) {
		update_user_meta( $user_id, 'rcp_mother_tongue', sanitize_text_field( $posted['rcp_mother_tongue'] ) );
	}
	if( ! empty( $posted['rcp_other_education'] ) ) {
		update_user_meta( $user_id, 'rcp_other_education', sanitize_text_field( $posted['rcp_other_education'] ) );
	}
}
add_action( 'rcp_form_processing', 'pw_rcp_save_user_fields_on_register', 10, 2 );

/**
 * Stores the information submitted profile update
 *
 */
function pw_rcp_save_user_fields_on_profile_save( $user_id ) {

	if( ! empty( $_POST['rcp_profession'] ) ) {
		update_user_meta( $user_id, 'rcp_profession', sanitize_text_field( $_POST['rcp_profession'] ) );
	}

	if( ! empty( $_POST['rcp_location'] ) ) {
		update_user_meta( $user_id, 'rcp_location', sanitize_text_field( $_POST['rcp_location'] ) );
	}
	if( ! empty( $_POST['rcp_university'] ) ) {
		update_user_meta( $user_id, 'rcp_university', sanitize_text_field( $_POST['rcp_university'] ) );
	}
	if( ! empty( $_POST['rcp_mother_tongue'] ) ) {
		update_user_meta( $user_id, 'rcp_mother_tongue', sanitize_text_field( $_POST['rcp_mother_tongue'] ) );
	}
	if( ! empty( $_POST['rcp_other_education'] ) ) {
		update_user_meta( $user_id, 'rcp_other_education', sanitize_text_field( $_POST['rcp_other_education'] ) );
	}
}

add_action( 'rcp_user_profile_updated', 'pw_rcp_save_user_fields_on_profile_save', 10 );
add_action( 'rcp_edit_member', 'pw_rcp_save_user_fields_on_profile_save', 10 );
