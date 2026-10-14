<?php
/**
 * The template for displaying all pages
 *
 * @package TechStore
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$is_wc_special_page = false;
if (class_exists('WooCommerce')) {
    $is_wc_special_page = is_cart() || is_checkout() || is_account_page();
}
?>

<main id="primary" class="site-main <?php echo $is_wc_special_page ? 'py-4 sm:py-6' : 'site-container py-8'; ?>">
    <?php while (have_posts()) : the_post(); ?>
        <?php if ($is_wc_special_page) : ?>
            <!-- WooCommerce Full App Pages (Cart, Checkout, Account) without redundant containers -->
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php the_content(); ?>
            </div>
        <?php else : ?>
            <!-- Standard Content / Editorial Pages -->
            <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-3xl border border-neutral-200 p-6 sm:p-10 shadow-subtle'); ?>>
                <header class="entry-header mb-6 pb-4 border-b border-neutral-200">
                    <h1 class="entry-title text-2xl sm:text-3xl font-black text-neutral-900 tracking-tight">
                        <?php the_title(); ?>
                    </h1>
                </header>

                <div class="entry-content prose max-w-none text-neutral-700 leading-relaxed">
                    <?php
                    the_content();

                    wp_link_pages([
                        'before' => '<div class="page-links">' . esc_html__('Páginas:', 'alex-store'),
                        'after'  => '</div>',
                    ]);
                    ?>
                </div>
            </article>
        <?php endif; ?>
    <?php endwhile; ?>
</main>

<?php
get_footer();
