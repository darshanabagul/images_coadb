<?php
/**
 * Email Header
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-header.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates/Emails
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
		<title><?php echo get_bloginfo( 'name', 'display' ); ?></title>
	</head>
	<body <?php echo is_rtl() ? 'rightmargin' : 'leftmargin'; ?>="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
		<div id="wrapper" dir="<?php echo is_rtl() ? 'rtl' : 'ltr'?>">
			<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
				<tr>
					<td align="center" valign="top">
						<div id="template_header_image">
							<?php
								if ( $img = get_option( 'woocommerce_email_header_image' ) ) {
									echo '<p style="margin-top:0;"><img src="' . esc_url( $img ) . '" alt="' . get_bloginfo( 'name', 'display' ) . '" /></p>';
								}
							?>
						</div>
						<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container">
							<tr>
								<td align="center" valign="top">
									
									<!-- Header -->
									<table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color:
										#ddd; border-radius:3px 3px 0 0!important; color:#ffffff; border-bottom:0; font-weight:bold; line-height:100%; vertical-align:middle;font-family: 'Vidaloka', serif;">
											<tbody>
												<tr>
								          			<td align="center" style="padding: 10px 0 0;display: block;">
														<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png" alt="Coadb" title="Coadb">
													</td>
												</tr>
												<tr>
													<td align="center">
														<h1 style="color: #444;font-size: 14px;vertical-align: middle;text-align: center;font-family: 'Vidaloka', serif;font-weight: bold;"> DATABASE & SHOP </h1>
													</td>
												</tr>
											</tbody>
									</table>
									<!-- End Header -->
								</td>
							</tr>
							<tr>
								<td align="center" valign="top">
									<!-- Body -->
									<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
										<tr>
											<td valign="top" id="body_content">
												<!-- Content -->
												<table border="0" cellpadding="20" cellspacing="0" width="100%">
													<tr>
														<td valign="top">
															<div id="body_content_inner">
