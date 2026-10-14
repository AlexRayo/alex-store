<?php
/**
 * The header for Tech Store theme
 *
 * @package TechStore
 */

if (!defined('ABSPATH')) {
    exit;
}
?><!doctype html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class('bg-neutral-bg text-dark font-sans antialiased min-h-screen flex flex-col justify-between'); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site flex flex-col min-h-screen">
    <a class="skip-link sr-only focus:not-sr-only focus:absolute focus:p-4 focus:bg-primary focus:text-white focus:z-50" href="#content">
        <?php esc_html_e('Saltar al contenido principal', 'alex-store'); ?>
    </a>

    <!-- Smart Auto-Hiding Header (Slide-up on scroll down, Slide-down on scroll up) -->
    <header id="tech-main-header" class="sticky top-0 z-40 bg-white transition-transform duration-300 ease-in-out will-change-transform transform-gpu">
        <?php get_template_part('template-parts/header/announcement-bar'); ?>
        <?php get_template_part('template-parts/header/navbar'); ?>
        <?php get_template_part('template-parts/header/category-bar'); ?>
    </header>

    <!-- Mobile Navigation Drawer -->
    <?php get_template_part('template-parts/header/mobile-menu'); ?>

    <!-- Main Content Container -->
    <div id="content" class="site-content flex-1">
