<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Moller_Theme
 * @since Moller 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php $moller_opt = get_option( 'moller_opt' ); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="wrapper">
	<div class="page-wrapper">