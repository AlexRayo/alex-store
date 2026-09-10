<?php
/**
 * The main template file
 *
 * @package TechStore
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <?php if (have_posts()) : ?>
        <header class="mb-8">
            <h1 class="text-3xl font-black text-dark tracking-tight">
                <?php single_post_title(); ?>
            </h1>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            while (have_posts()) : the_post();
            ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-card border border-neutral-border p-6 shadow-card flex flex-col justify-between'); ?>>
                    <div>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="mb-4 rounded-xl overflow-hidden aspect-video">
                                <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="text-xs text-neutral-subtle mb-2">
                            <?php echo get_the_date(); ?>
                        </div>

                        <h2 class="text-lg font-bold text-dark hover:text-primary mb-2">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>

                        <div class="text-xs text-neutral-subtle line-clamp-3 mb-4">
                            <?php the_excerpt(); ?>
                        </div>
                    </div>

                    <div>
                        <a href="<?php the_permalink(); ?>" class="text-xs font-bold text-primary hover:underline inline-flex items-center gap-1">
                            <?php esc_html_e('Leer más', 'tech-store'); ?> &rarr;
                        </a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <div class="mt-8 flex justify-center">
            <?php the_posts_pagination(['class' => 'flex gap-2 text-sm font-bold']); ?>
        </div>
    <?php else : ?>
        <div class="text-center py-16 bg-white rounded-card border border-neutral-border p-8">
            <h2 class="text-xl font-bold text-dark mb-2"><?php esc_html_e('No se encontraron publicaciones', 'tech-store'); ?></h2>
            <p class="text-sm text-neutral-subtle"><?php esc_html_e('Parece que no hay contenido disponible en esta sección.', 'tech-store'); ?></p>
        </div>
    <?php endif; ?>
</main>

<?php
get_footer();
