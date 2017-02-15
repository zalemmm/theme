<?php
/**
* @package WordPress
* @subpackage Classic_Theme
*/
get_header();
?>
<div id="content"><div id="content_bg_top"><div id="content_zawartosc">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="storycontent">
      <?php the_content(__('(more...)')); ?>
    </div>
  <?php endwhile; else: ?>
    <p><?php _e('Désolé, pas de correspondance trouvée.'); ?></p>
  <?php endif; ?>
  <div style="clear:both"></div>
</div>
</div>
</div>

<?php get_footer(); ?>
