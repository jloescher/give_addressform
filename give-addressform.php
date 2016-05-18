<?php

/*
Plugin Name: Give Form Address
Plugin URI: http://jonathanloescher.com
Description: A plugin add-on to "Give - Donation Plugin" that incorporates address fields into the donation form.
Version: 1.0
Author: Jonathan Loescher
Author URI: http://jonathanloescher.com
License: GPL2
*/

function give_jls_custom_address_fields( $form_id ) {
	?>
	<div id="give-address-wrap">
        <label class="give-label" for="give-address-1">
			<?php _e( 'Address:', 'give' ); ?>
		</label>
		<span class="give-tooltip icon give-icon-question" data-tooltip="<?php _e( 'Please enter your street address.', 'give' ) ?>"></span>
		<input class="give-input required floatlabel-input" type="text" name="give-address-1" placeholder="Street Address" id="give-address-1" required>
		<label class="give-label" for="give-address-2">
			<?php _e( 'Address 2', 'give' ); ?>
		</label>
		<span class="give-tooltip icon give-icon-question" data-tooltip="<?php _e( 'Please use to enter additional address information if needed.', 'give' ) ?>"></span>
		<input class="give-input floatlabel-input" type="text" name="give-address-2" placeholder="Additional Address Information" id="give-address-2">
		<label class="give-label" for="give-city">
			<?php _e( 'City', 'give' ); ?>
		</label>
		<span class="give-tooltip icon give-icon-question" data-tooltip="<?php _e( 'Please enter your city.', 'give' ) ?>"></span>
		<input class="give-input required floatlabel-input" type="text" name="give-city" placeholder="City" id="give-city" required>
		<label class="give-label" for="give-state">
			<?php _e( 'State', 'give' ); ?>
		</label>
		<span class="give-tooltip icon give-icon-question" data-tooltip="<?php _e( 'Please select your state.', 'give' ) ?>"></span>
		<select style="width: 100%;" class="give-select floatlabel-input" name="give-state" id="give-state">
			<option value="AL">Alabama</option>
			<option value="AK">Alaska</option>
			<option value="AZ">Arizona</option>
			<option value="AR">Arkansas</option>
			<option value="CA">California</option>
			<option value="CO">Colorado</option>
			<option value="CT">Connecticut</option>
			<option value="DE">Delaware</option>
			<option value="DC">District Of Columbia</option>
			<option value="FL">Florida</option>
			<option value="GA">Georgia</option>
			<option value="HI">Hawaii</option>
			<option value="ID">Idaho</option>
			<option value="IL">Illinois</option>
			<option value="IN">Indiana</option>
			<option value="IA">Iowa</option>
			<option value="KS">Kansas</option>
			<option value="KY">Kentucky</option>
			<option value="LA">Louisiana</option>
			<option value="ME">Maine</option>
			<option value="MD">Maryland</option>
			<option value="MA">Massachusetts</option>
			<option value="MI">Michigan</option>
			<option value="MN">Minnesota</option>
			<option value="MS">Mississippi</option>
			<option value="MO">Missouri</option>
			<option value="MT">Montana</option>
			<option value="NE">Nebraska</option>
			<option value="NV">Nevada</option>
			<option value="NH">New Hampshire</option>
			<option value="NJ">New Jersey</option>
			<option value="NM">New Mexico</option>
			<option value="NY">New York</option>
			<option value="NC">North Carolina</option>
			<option value="ND">North Dakota</option>
			<option value="OH">Ohio</option>
			<option value="OK">Oklahoma</option>
			<option value="OR">Oregon</option>
			<option value="PA">Pennsylvania</option>
			<option value="RI">Rhode Island</option>
			<option value="SC">South Carolina</option>
			<option value="SD">South Dakota</option>
			<option value="TN">Tennessee</option>
			<option value="TX">Texas</option>
			<option value="UT">Utah</option>
			<option value="VT">Vermont</option>
			<option value="VA">Virginia</option>
			<option value="WA">Washington</option>
			<option value="WV">West Virginia</option>
			<option value="WI">Wisconsin</option>
			<option value="WY">Wyoming</option>
		</select>
		<label class="give-label" for="give-zip">
			<?php _e( 'Zip Code', 'give' ); ?>
		</label>
		<span class="give-tooltip icon give-icon-question" data-tooltip="<?php _e( 'Please enter your zip code.', 'give' ) ?>"></span>
		<input class="give-input required floatlabel-input" type="text" name="give-zip" placeholder="Zip Code" id="give-zip" required>
	</div>
	<?php
}

function give_jls_validate_custom_address_fields( $valid_data, $data ) {
	if ( empty( $data['give-address-1'] ) ) {
		give_set_error( 'give-address-1', __( 'Please enter your address.', 'give' ) );
	}
	if ( empty( $data['give-city'] ) ) {
		give_set_error( 'give-city', __( 'Please enter your city.', 'give' ) );
	}
	if ( empty( $data['give-state'] ) ) {
		give_set_error( 'give-state', __( 'Please select your state.', 'give' ) );
	}
	if ( empty( $data['give-zip'] ) ) {
		give_set_error( 'give-zip', __( 'Please enter your zip code.', 'give' ) );
	}
}

function give_jls_store_custom_address_fields( $payment_meta ) {
	$payment_meta['address1'] = isset( $_POST['give-address-1'] ) ? implode( "n". array_map( 'sanitize_text_field', explode( "n", $_POST['give-address-1'] ) ) ) : '';
	$payment_meta['address2'] = isset( $_POST['give-address-2'] ) ? implode( "n". array_map( 'sanitize_text_field', explode( "n", $_POST['give-address-2'] ) ) ) : '';
	$payment_meta['city'] = isset( $_POST['give-city'] ) ? implode( "n". array_map( 'sanitize_text_field', explode( "n", $_POST['give-city'] ) ) ) : '';
	$payment_meta['state'] = isset( $_POST['give-state'] ) ? implode( "n". array_map( 'sanitize_text_field', explode( "n", $_POST['give-state'] ) ) ) : '';
	$payment_meta['zip'] = isset( $_POST['give-zip'] ) ? implode( "n". array_map( 'sanitize_text_field', explode( "n", $_POST['give-zip'] ) ) ) : '';

	return $payment_meta;
}

function give_jls_purchase_details( $payment_meta, $user_info ) {
	if ( ! isset( $payment_meta['address1'] ) ) {
		return;
	}
	if ( ! isset( $payment_meta['city'] ) ) {
		return;
	}
	if ( ! isset( $payment_meta['state'] ) ) {
		return;
	}
	if ( ! isset( $payment_meta['zip'] ) ) {
		return;
	}
}

add_action( 'give_purchase_form_after_email', 'give_jls_custom_address_fields', 10, 1 );
add_action( 'give_checkout_error_checks', 'give_jls_validate_custom_address_fields', 10, 2 );
add_filter( 'give_payment_meta', 'give_jls_store_custom_address_fields' );
add_action( 'give_payment_personal_details_list', 'give_jls_purchase_details', 10, 2 );