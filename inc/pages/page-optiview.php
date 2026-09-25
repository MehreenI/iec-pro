<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'IEC_OPTIVIEW_NOTIFY_CPT', 'iec_optiview_notify' );
define( 'IEC_OPTIVIEW_ADMIN_EMAIL', 'newsletter@iec-telecom.com' );
define( 'IEC_OPTIVIEW_TAG', 'Optiview' );

function iec_optiview_register_notify_cpt() {
	register_post_type(
		IEC_OPTIVIEW_NOTIFY_CPT,
		array(
			'labels'              => array(
				'name'          => 'Optiview Notify',
				'singular_name' => 'Optiview Notify',
				'menu_name'     => 'Optiview Notify',
			),
			'public'              => false,
			'show_ui'             => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'has_archive'         => false,
			'rewrite'             => false,
			'supports'            => array( 'title' ),
			'menu_icon'           => 'dashicons-email-alt',
		)
	);
}
add_action( 'init', 'iec_optiview_register_notify_cpt' );

function iec_optiview_notify_ajax() {
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ?? '' ) ), 'iec_nonce' ) ) {
		wp_send_json_error( array( 'code' => 'invalid_nonce' ), 403 );
	}

	$email = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
	if ( ! is_email( $email ) ) {
		wp_send_json_error( array( 'code' => 'invalid_email' ), 400 );
	}

	if ( '1' !== (string) ( $_POST['gdpr_consent'] ?? '' ) ) {
		wp_send_json_error( array( 'code' => 'consent_required' ), 400 );
	}

	$email = strtolower( $email );
	$ip    = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ?? '' ) );

	if ( $ip ) {
		$rate_key = 'iec_ov_notify_' . md5( $ip );
		$hits     = (int) get_transient( $rate_key );
		if ( $hits >= 5 ) {
			wp_send_json_error( array( 'code' => 'rate_limited' ), 429 );
		}
		set_transient( $rate_key, $hits + 1, 10 * MINUTE_IN_SECONDS );
	}

	$existing = get_posts(
		array(
			'post_type'      => IEC_OPTIVIEW_NOTIFY_CPT,
			'title'          => $email,
			'post_status'    => 'private',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);

	if ( $existing ) {
		wp_send_json_success( array( 'saved' => true, 'duplicate' => true, 'mail' => false ) );
	}

	$post_id = wp_insert_post(
		array(
			'post_type'   => IEC_OPTIVIEW_NOTIFY_CPT,
			'post_title'  => $email,
			'post_status' => 'private',
		),
		true
	);

	if ( is_wp_error( $post_id ) ) {
		wp_send_json_error( array( 'code' => 'save_failed' ), 500 );
	}

	update_post_meta( $post_id, '_iec_optiview_source', 'coming-soon-modal' );
	update_post_meta( $post_id, '_iec_optiview_tag', IEC_OPTIVIEW_TAG );
	update_post_meta( $post_id, '_iec_optiview_gdpr_consent', '1' );
	update_post_meta( $post_id, '_iec_optiview_gdpr_consent_at', current_time( 'mysql' ) );

	wp_send_json_success( iec_optiview_notify_send_emails( $email, $post_id ) );
}
add_action( 'wp_ajax_iec_optiview_notify', 'iec_optiview_notify_ajax' );
add_action( 'wp_ajax_nopriv_iec_optiview_notify', 'iec_optiview_notify_ajax' );

function iec_optiview_notify_columns( $columns ) {
	$date = $columns['date'] ?? '';
	unset( $columns['date'] );

	$columns['iec_consent']    = 'Consent';
	$columns['iec_consent_at'] = 'Consent Date';
	$columns['iec_mail']       = 'Mail';

	if ( $date ) {
		$columns['date'] = $date;
	}

	return $columns;
}
add_filter( 'manage_' . IEC_OPTIVIEW_NOTIFY_CPT . '_posts_columns', 'iec_optiview_notify_columns' );

function iec_optiview_notify_column_value( $column, $post_id ) {
	if ( 'iec_consent' === $column ) {
		echo ( '1' === (string) get_post_meta( $post_id, '_iec_optiview_gdpr_consent', true ) ) ? 'Yes' : 'No';
		return;
	}

	if ( 'iec_consent_at' === $column ) {
		$at = get_post_meta( $post_id, '_iec_optiview_gdpr_consent_at', true );
		echo $at ? mysql2date( 'd M Y H:i', $at ) : '—';
		return;
	}

	if ( 'iec_mail' !== $column ) {
		return;
	}

	$sent  = get_post_meta( $post_id, '_iec_optiview_mail_sent', true );
	$error = get_post_meta( $post_id, '_iec_optiview_mail_error', true );

	echo ( '1' === (string) $sent ) ? 'Sent' : 'Failed';
	if ( $error ) {
		echo '<br>' . $error;
	}
}
add_action( 'manage_' . IEC_OPTIVIEW_NOTIFY_CPT . '_posts_custom_column', 'iec_optiview_notify_column_value', 10, 2 );

function iec_optiview_notify_metabox() {
	add_meta_box(
		'iec_optiview_consent',
		'GDPR Consent',
		'iec_optiview_consent_metabox',
		IEC_OPTIVIEW_NOTIFY_CPT,
		'side'
	);
}
add_action( 'add_meta_boxes', 'iec_optiview_notify_metabox' );

function iec_optiview_consent_metabox( $post ) {
	$consent = get_post_meta( $post->ID, '_iec_optiview_gdpr_consent', true );
	$at      = get_post_meta( $post->ID, '_iec_optiview_gdpr_consent_at', true );
	?>
	<p><strong>Consent:</strong> <?= ( '1' === (string) $consent ) ? 'Yes' : 'No'; ?></p>
	<p><strong>Date Time:</strong> <?= $at ? mysql2date( 'd M Y H:i:s', $at ) : '—'; ?></p>
	<?php
}

function iec_optiview_send_mail( $to, $subject, $body, $reply_to = '' ) {
	$result = array(
		'sent'  => false,
		'error' => '',
		'via'   => 'optiview-swift',
		'from'  => get_config( 'optiview_email_smtp_user', 'newsletter@iec-telecom.com' ),
	);

	if ( ! class_exists( '\Swift_SmtpTransport' ) || ! class_exists( '\Swift_Message' ) ) {
		$result['error'] = 'SwiftMailer not available';
		return $result;
	}

	$transport = new \Swift_SmtpTransport();
	$transport->setHost( get_config( 'optiview_email_smtp_host', 'smtp.office365.com' ) );
	$transport->setPort( (int) get_config( 'optiview_email_smtp_port', 587 ) );
	$transport->setEncryption( 'tls' );
	$smtp_pass = (string) get_config( 'optiview_email_smtp_pass', '' );
	if ( '' === $smtp_pass ) {
		$result['error'] = 'SMTP password is not configured';
		return $result;
	}

	$transport->setUsername( $result['from'] );
	$transport->setPassword( $smtp_pass );

	$message = new \Swift_Message();
	$message->setFrom( $result['from'], get_config( 'optiview_email_from_name', 'IEC Telecom' ) );
	$message->setTo( $to );
	$message->setSubject( $subject );
	$message->setBody( $body, 'text/html' );

	if ( $reply_to && is_email( $reply_to ) ) {
		$message->setReplyTo( $reply_to );
	}

	try {
		$mailer = class_exists( '\Swift_Mailer' ) ? new \Swift_Mailer( $transport ) : $transport;
		$mailer->send( $message );
		$result['sent'] = true;
	} catch ( \Exception $e ) {
		$result['error'] = $e->getMessage();
	}

	return $result;
}

function iec_optiview_notify_send_emails( $email, $post_id = 0 ) {
	$user = iec_optiview_send_mail(
		$email,
		'We have received your Optiview enquiry',
		'<p>Hello,</p><p>Thank you for your interest in Optiview.</p><p>We have received your enquiry and will get in touch at this email address when Optiview is available.</p><p>Kind regards,<br>IEC Telecom</p>',
		IEC_OPTIVIEW_ADMIN_EMAIL
	);

	iec_optiview_send_mail(
		IEC_OPTIVIEW_ADMIN_EMAIL,
		'Optiview 3 - New User Subscribe',
		'<p>A new user subscribed via the Optiview Coming Soon form.</p><p>Email: ' . $email . '</p>',
		$email
	);

	if ( $post_id ) {
		update_post_meta( $post_id, '_iec_optiview_mail_sent', ! empty( $user['sent'] ) ? '1' : '0' );
		update_post_meta( $post_id, '_iec_optiview_mail_error', $user['error'] );
	}

	return array(
		'saved'      => true,
		'duplicate'  => false,
		'mail'       => ! empty( $user['sent'] ),
		'mail_error' => $user['error'],
	);
}
