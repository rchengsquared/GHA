<?php
/* Template Name: AboutGHA */
get_header();?>
<?php
if ( has_post_thumbnail() ) {
the_post_thumbnail();
}  ?>
<?php the_title(); ?>


<?php get_footer();?>
