<?php
/**
 * The footer for Tech Store theme
 *
 * @package TechStore
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
    </div><!-- #content -->

    <!-- Global Footer -->
    <footer id="colophon" class="site-footer mt-auto">
        <?php get_template_part('template-parts/footer/trust-badges'); ?>
        <?php get_template_part('template-parts/footer/newsletter'); ?>
        <?php get_template_part('template-parts/footer/footer-nav'); ?>
    </footer>
</div><!-- #page -->

<!-- Global Slide-Over Mini-Cart Drawer -->
<?php get_template_part('template-parts/components/cart-drawer'); ?>

<!-- Global Predictive Search Modal -->
<?php get_template_part('template-parts/components/search-modal'); ?>

<!-- Mobile Bottom Fixed Navigation Bar -->
<?php get_template_part('template-parts/components/mobile-bottom-bar'); ?>

<?php wp_footer(); ?>
</body>
</html>
