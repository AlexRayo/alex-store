<?php
/**
 * The template for displaying all single posts
 *
 * @package TechStore
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-3xl border border-neutral-border p-6 sm:p-10 shadow-card'); ?>>
            <header class="entry-header mb-6">
                <div class="text-xs text-neutral-subtle mb-2 font-medium">
                    <?php echo get_the_date(); ?> &bull; <?php the_author(); ?>
                </div>
                <h1 class="entry-title text-2xl sm:text-4xl font-black text-dark tracking-tight mb-6">
                    <?php the_title(); ?>
                </h1>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="rounded-2xl overflow-hidden mb-6 aspect-video">
                        <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover']); ?>
                    </div>
                <?php endif; ?>
            </header>

            <div class="entry-content prose max-w-none text-dark leading-relaxed">
                <?php the_content(); ?>
            </div>

            <?php if (comments_open() || get_comments_number()) : ?>
                <div class="mt-12 pt-8 border-t border-neutral-border">
                    <?php comments_template(); ?>
                </div>
            <?php endif; ?>
        </article>
    <?php endwhile; ?>
</main>

<?php
get_footer();
