<?php

	/**
	 * Create the metabox
	 */
	function events_create_metabox() {
		add_meta_box( 'events_metabox', 'Event Details', 'events_render_metabox', 'gmt-events', 'normal', 'default');
	}
	add_action( 'add_meta_boxes', 'events_create_metabox' );



	/**
	 * Create the metabox default values
	 */
	function events_metabox_defaults() {
		return array(

			// Time
			'time_start_hour' => '',
			'time_start_minutes' => '',
			'time_start_ampm' => 'am',
			'time_end_hour' => '',
			'time_end_minutes' => '',
			'time_end_ampm' => 'am',
			'timezone' => '',

			// Location
			'location' => '',

			// Registration
			'register_html' => '',
			'register_html_markdown' => '',
			'register_link' => '',
			'register_label' => 'Learn More',

		);
	}



	/**
	 * Render the metabox
	 */
	function events_render_metabox() {

		// Variables
		global $post;
		$saved = get_post_meta( $post->ID, 'event_details', true );
		$defaults = events_metabox_defaults();
		$details = wp_parse_args( $saved, $defaults );
		$start_date = get_post_meta( $post->ID, 'event_start_date', true );
		$end_date = get_post_meta( $post->ID, 'event_end_date', true );

		?>

			<fieldset>

				<div>
					<label for="events_start_date"><?php _e( 'Start Date:', 'events' ); ?></label>
					<input type="date" class="" id="events_start_date" name="events_start_date" value="<?php echo esc_attr( 					date( 'Y-m-d', $start_date ) ); ?>" placeholder="MM/DD/YYYY">

					@

					<label class="screen-reader-text" for="events_time_start_hour"><?php _e( 'Start Time: Hour', 'events' ); ?></label>
					<select id="events_time_start_hour" name="events[time_start_hour]">
						<option <?php selected( $details['time_start_hour'], '' ); ?> value="">HH</option>
						<?php
							foreach ( range( 1, 12 ) as $num ) :
						?>
							<option <?php selected( $details['time_start_hour'], $num ); ?> value="<?php echo esc_attr( $num ); ?>"><?php echo esc_html( $num ); ?></option>
						<?php endforeach; ?>
					</select>

					<label class="screen-reader-text" for="events_time_start_minutes"><?php _e( 'Start Time: Minutes', 'events' ); ?></label>
					<select id="events_time_start_minutes" name="events[time_start_minutes]">
						<option <?php selected( $details['time_start_minutes'], '00' ); selected( $details['time_start_minutes'], '' ); ?> value="00">00</option>
						<option <?php selected( $details['time_start_minutes'], '15' ); ?> value="15">15</option>
						<option <?php selected( $details['time_start_minutes'], '30' ); ?> value="30">30</option>
						<option <?php selected( $details['time_start_minutes'], '45' ); ?> value="45">45</option>
					</select>

					<label class="screen-reader-text" for="events_time_start_ampm"><?php _e( 'Start Time: AM/PM', 'events' ); ?></label>
					<select id="events_time_start_ampm" name="events[time_start_ampm]">
						<option <?php selected( $details['time_start_ampm'], 'am' ); selected( $details['time_start_ampm'], '' ); ?> value="am">am</option>
						<option <?php selected( $details['time_start_ampm'], 'pm' ); ?> value="pm">pm</option>
					</select>

				</div>
				<br>

				<div>
					<label for="events_end_date"><?php _e( 'End Date:', 'events' ); ?></label>
					<input type="date" class="" id="events_end_date" name="events_end_date" value="<?php echo esc_attr( 					date( 'Y-m-d', $end_date ) ); ?>" placeholder="MM/DD/YYYY">

					@

					<label class="screen-reader-text" for="events_time_end_hour"><?php _e( 'End Time: Hour', 'events' ); ?></label>
					<select id="events_time_end_hour" name="events[time_end_hour]">
						<option <?php selected( $details['time_end_hour'], '' ); ?> value="">HH</option>
						<?php
							foreach ( range( 1, 12 ) as $num ) :
						?>
							<option <?php selected( $details['time_end_hour'], $num ); ?> value="<?php echo esc_attr( $num ); ?>"><?php echo esc_html( $num ); ?></option>
						<?php endforeach; ?>
					</select>

					<label class="screen-reader-text" for="events_time_end_minutes"><?php _e( 'End Time: Minutes', 'events' ); ?></label>
					<select id="events_time_end_minutes" name="events[time_end_minutes]">
						<option <?php selected( $details['time_end_minutes'], '00' ); selected( $details['time_end_minutes'], '' ); ?> value="00">00</option>
						<option <?php selected( $details['time_end_minutes'], '15' ); ?> value="15">15</option>
						<option <?php selected( $details['time_end_minutes'], '30' ); ?> value="30">30</option>
						<option <?php selected( $details['time_end_minutes'], '45' ); ?> value="45">45</option>
					</select>

					<label class="screen-reader-text" for="events_time_end_ampm"><?php _e( 'End Time: AM/PM', 'events' ); ?></label>
					<select id="events_time_end_ampm" name="events[time_end_ampm]">
						<option <?php selected( $details['time_end_ampm'], 'am' ); ?> value="am">am</option>
						<option <?php selected( $details['time_end_ampm'], 'pm' ); selected( $details['time_end_ampm'], '' ); ?> value="pm">pm</option>
					</select>
				</div>
				<br>

				<div>
					<label for="events_timezone"><?php _e( 'Timezone:', 'events' ); ?></label>
					<input type="text" class="regular-text" id="events_timezone" name="events[timezone]" value="<?php echo esc_attr( $details['timezone'] ); ?>">
				</div>
				<br>

				<div>
					<label for="events_location"><?php _e( 'Location', 'events' ); ?></label>
					<input type="text" class="large-text" id="events_location" name="events[location]" value="<?php echo esc_attr( $details['location'] ); ?>">
				</div>
				<br>

				<div>
					<label for="events_register_html"><?php _e( 'Registration Form/Markup', 'events' ); ?></label>
					<textarea class="large-text" id="events_register_html" name="events[register_html]" cols="50" rows="4"><?php echo esc_textarea( events_get_jetpack_markdown( $details, 'register_html' ) ); ?></textarea>
				</div>
				<br>

				<div>
					<label for="events_register_link"><?php _e( 'Registration Link:', 'events' ); ?></label>
					<input type="url" class="regular-text" id="events_register_link" name="events[register_link]" value="<?php echo esc_url( $details['register_link'] ); ?>">
				</div>
				<br>

				<div>
					<label for="events_register_label"><?php _e( 'Registration Link Label:', 'events' ); ?></label>
					<input type="text" class="regular-text" id="events_register_label" name="events[register_label]" value="<?php echo esc_attr( $details['register_label'] ); ?>">
				</div>
				<br>

			</fieldset>

		<?php

		// Security field
		wp_nonce_field( 'events_form_metabox_nonce', 'events_form_metabox_process' );

	}



	/**
	 * Save the metabox
	 * @param  Number $post_id The post ID
	 * @param  Array  $post    The post data
	 */
	function events_save_metabox( $post_id, $post ) {

		if ( !isset( $_POST['events_form_metabox_process'] ) ) return;

		// Verify data came from edit screen
		if ( !wp_verify_nonce( $_POST['events_form_metabox_process'], 'events_form_metabox_nonce' ) ) {
			return $post->ID;
		}

		// Verify user has permission to edit post
		if ( !current_user_can( 'edit_post', $post->ID )) {
			return $post->ID;
		}

		// Check that events details are being passed along
		if ( !isset( $_POST['events'] ) ) {
			return $post->ID;
		}

		// Sanitize all data
		$sanitized = array();
		foreach ( $_POST['events'] as $key => $detail ) {
			if ( $key === 'register_html' ) {
				$sanitized['register_html'] = events_process_jetpack_markdown( $detail );
				$sanitized['register_html_markdown'] = $detail;
				continue;
			}
			$sanitized[$key] = wp_filter_post_kses( $detail );
		}

		// Update data in database
		update_post_meta( $post->ID, 'event_details', $sanitized );

		// Save start date
		if ( isset( $_POST['events_start_date'] ) ) {
			update_post_meta( $post->ID, 'event_start_date', wp_filter_post_kses( strtotime( $_POST['events_start_date'] ) ) );
		}

		// Save end date
		if ( isset( $_POST['events_end_date'] ) ) {
			update_post_meta( $post->ID, 'event_end_date', wp_filter_post_kses( strtotime( $_POST['events_end_date'] ) ) );
		}

	}
	add_action('save_post', 'events_save_metabox', 1, 2);



	/**
	 * Save events data to revisions
	 * @param  Number $post_id The post ID
	 */
	function events_save_revisions( $post_id ) {

		// Check if it's a revision
		$parent_id = wp_is_post_revision( $post_id );

		// If is revision
		if ( $parent_id ) {

			// Get the data
			$parent = get_post( $parent_id );
			$details = get_post_meta( $parent->ID, 'event_details', true );
			$start_date = get_post_meta( $parent->ID, 'event_start_date', true );
			$end_date = get_post_meta( $parent->ID, 'event_end_date', true );

			// If data exists, add to revision
			if ( !empty( $details ) && is_array( $details ) ) {
				$defaults = events_metabox_defaults();
				foreach ( $defaults as $key => $value ) {
					if ( array_key_exists( $key, $details ) ) {
						add_metadata( 'post', $post_id, 'event_details_' . $key, $details[$key] );
					}
				}
			}

			// Start/End Date
			add_metadata( 'post', $post_id, 'event_start_date', $start_date );
			add_metadata( 'post', $post_id, 'event_end_date', $end_date );

		}

	}
	add_action( 'save_post', 'events_save_revisions' );



	/**
	 * Restore events data with post revisions
	 * @param  Number $post_id     The post ID
	 * @param  Number $revision_id The revision ID
	 */
	function events_restore_revisions( $post_id, $revision_id ) {

		// Variables
		$post = get_post( $post_id );
		$revision = get_post( $revision_id );
		$defaults = events_metabox_defaults();
		$details = array();

		// Update content
		foreach ( $defaults as $key => $value ) {
			$detail_revision = get_metadata( 'post', $revision->ID, 'event_details_' . $key, true );
			if ( isset( $detail_revision ) ) {
				$details[$key] = $detail_revision;
			}
		}
		update_post_meta( $post_id, 'event_details', $event_details );

		// Update start date
		$start_revision = get_metadata( 'post', $revision->ID, 'event_start_date', true );
		if ( isset( $start_revision ) ) {
			update_post_meta( $post_id, 'event_start_date', $start_revision );
		}

		// Update end date
		$end_revision = get_metadata( 'post', $revision->ID, 'event_end_date', true );
		if ( isset( $end_revision ) ) {
			update_post_meta( $post_id, 'event_end_date', $end_revision );
		}

	}
	add_action( 'wp_restore_post_revision', 'events_restore_revisions', 10, 2 );



	/**
	 * Get the data to display on the revisions page
	 * @param  Array $fields The fields
	 * @return Array The fields
	 */
	function events_get_revisions_fields( $fields ) {
		$defaults = events_metabox_defaults();
		foreach ( $defaults as $key => $value ) {
			$fields['event_details_' . $key] = ucfirst( $key );
		}
		$fields['event_start_date'] = 'Event Start Date';
		$fields['event_end_date'] = 'Event End Date';
		return $fields;
	}
	add_filter( '_wp_post_revision_fields', 'events_get_revisions_fields' );



	/**
	 * Display the data on the revisions page
	 * @param  String|Array $value The field value
	 * @param  Array        $field The field
	 */
	function events_display_revisions_fields( $value, $field ) {
		global $revision;
		return get_metadata( 'post', $revision->ID, $field, true );
	}
	add_filter( '_wp_post_revision_field_my_meta', 'events_display_revisions_fields', 10, 2 );