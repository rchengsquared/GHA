<?php
/* Template Name: HomeDesign */
get_header();?>
<?php
if ( has_post_thumbnail() ) {
the_post_thumbnail();
}  ?>
<div class="build">
<section>
<div class="purple-btn-container left">
    <a href="<?php echo esc_url( home_url( '/home-design' ) ); ?>">


    </a>
</div>
</section>
<div class="top_rectangle"></div>

<p style="margin-left:262px; width:303px;font-size:14px;font-family:lato;">Showing 1-5 of 5 Energy efficient home designs</p>
</div>

<div class="posts-content">
<?php
//$exclude_id
$r_arg = array(
    'post_type' => 'home',
    /*'post_status' => 'publish',
    'posts_per_page'	=> -1,
    'tax_query' => array(
          array(
            'taxonomy' => 'recipe_category',
            'field' => 'slug',
            'terms' => $slug_t,
          ),
        ),*/
  );
if($exclude_id){
  $r_arg['post__not_in'] = array($exclude_id);
}
$wpex_port_query = new WP_Query($r_arg);
$hideShowClass = " active";
$i = 0;
$total_post = 0;
$remainPost = 0;
if( $wpex_port_query->posts ) {
  $total_post = $wpex_port_query->found_posts;
  $remainPost = $total_post - 6;
   while ( $wpex_port_query->have_posts() ) : $wpex_port_query->the_post();

    $termsArray = get_the_terms( $post->ID, "recipe_category" );
    $termsString = "";
    $curTerms = array();
    foreach ( $termsArray as $term ) {
      $curTerms[] = $term->slug;
      $termsString .= $term->slug.' ';
    }
    if(count($curTerms) == 1 && $curTerms[0] == 'featured-recipes') continue;
    if($i >= 6) {
      $hideShowClass = " inactive";
    } $i++;
    $active  = "";
    if($visibleCount != "")
    {
      if(count($class)){
        foreach($class as $_c)
        {
          $hideShowClass = " inactive";
          $checkclass = explode(" ",$termsString);

          if(in_array($_c,$checkclass))
          {
            $hideShowClass = "inactive";
            $active = "active";
            break;
          }
        }
      }else if($visibleCount >= 1){

        $active = "active";
        $hideShowClass = "inactive";
      }
    }

   ?>
   <?php  if($visibleCount >= 1 && $active == "active"){ $visibleCount = $visibleCount - 1;  ?>
   <div id="postid_<?php echo $post->ID; ?>" class="item <?php echo $termsString . $active; ?>" style="">
   <?php  }else{ ?>
<div id="postid_<?php echo $post->ID; ?>" class="item <?php echo $termsString . $hideShowClass; ?>" style="">
   <?php } ?>
  <div class="rp-item-inner">
              <?php  $fimage_url = ''; $url = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'medium' ); if($url && isset($url[0])){$fimage_url = $url[0];}
              //echo $fimage_url;
    /*$postImageId = get_post_thumbnail_id($post->ID);
    //echo $postImageId;
    $postCurImage 	= wp_get_attachment_image_src($postImageId , 'custom-post-list');
    $fimage_url 	= '';
  if($postCurImage && count($postCurImage) && $postCurImage[1] == CUSTPOSTLISTWIDTH && $postCurImage[2] == CUSTPOSTLISTHEIGHT){
      $fimage_url = $postCurImage[0];
    }else{
      $fimage_url = aa_resized_image($postImageId,CUSTPOSTLISTWIDTH, CUSTPOSTLISTHEIGHT,true);
    }*/
  ?>
              <div class="thumb" style="background-image: url('<?php echo $fimage_url; ?>')">
                  <a href="<?php the_permalink(); ?>" data-postid="<?php echo get_the_ID();?>"><div class="view-active">
                      <span><?php the_title();?></span>
                      </div></a>

                      </div>
                      <div class="check">
                     <p class="recipe-info xs-hidden"><?php if(get_field( "landarea" ))
				 echo '<span class="min-left" >'.'<span class="featured-date icon-enable"></span>'.'<span class="">Landarea:</span> <b>'.get_field( "landarea" ).'</b><span class="min-right"></span>';if(get_field( "bedrooms" ))
				 echo '<span class="min-left" >'.'<span class="featured-date icon-enable"></span>'.'<span class="">Bedroom:</span> <b>'.get_field( "bedrooms" ).'</b><span class="min-right"></span>';if(get_field( "bathrooms" ))
				 echo '<span class="min-left">Bathrooms:</span> <b>'.get_field( "bathrooms" ).'</b><span class="min-right"></span>'; if(get_field( "carspaces" ))
				 echo '<span class="min-left">Carspaces:</span> <b>'.get_field( "carspaces" ).'</b><span class="min-right"></span>';?></p> <?php  ?>

              </div>

  <?php
  $inlbs = get_field('info_label');
  ?>
    <div class="ingredients">
    <?php
    if( $inlbs ):
    foreach( $inlbs as $inlb):
        $urlIcon = wp_get_attachment_image_src( get_post_thumbnail_id($inlb->ID), 'custom-icon' );
        if($urlIcon) {
          $fimage_url = $urlIcon[0];
        } else {
          $fimage_url = '';
        }
    ?>
      <span class="<?php echo $inlb->slug ?>" style="background-image: url('<?php echo $fimage_url; ?>')" ><span class="label hide"><?php echo $inlb->post_name; ?></span></span>
    <?php endforeach; ?>
    <?php endif; ?>
    </div>
    <?php  $sepr_recipe = ""; if(get_field( "preparation_time" ) && get_field( "servings" )) { $sepr_recipe = "|"; }?>
  <!--p class="blog-title"><a href="<?php the_permalink(); ?>" title="<?php the_title();?>" data-postid="<?php echo get_the_ID();?>"><?php the_title(); ?></a></p-->

  </div>
          </div>

<?php
  endwhile;
  wp_reset_postdata();
  $total_post = $i;
  $remainPost = $total_post - 6;
}
?>

          <br class="clear" />
</div>
<?php $showLoadMore = ""; if($remainPost < 1) { $remainPost = 0;  $showLoadMore = " style='display:none' ";  } ?>
          <a href="javascript:void(0)" id="loadMoreAction" data-curpage="1" class="btn-red" <?php echo $showLoadMore; ?> data-total="<?php echo $total_post; ?>">Show more recipes (<span><?php echo $remainPost; ?></span>)</a>
      </div>

      <p class="p">Showing 1-5 of 5 Energy efficient home designs</p>
      <form style="text-align:center">
      <input style="text-align:center" type="button" value="SEE MORE">
      </form>

<?php get_footer(); ?>
<style>
.min-right {
  padding-right: 6px !important;
  top: 0px;
}
.min-left {
  padding-left: 6px !important;
  top: 0px;
}
.xs-hidden {
    display: block!important;
}
.recipe-info {
    border: 0px;
    padding: 0px;
    margin-top: 11px;
    color: #000000;
font-size: 16px;
letter-spacing: 0;
line-height: 22px;
padding: 0px 0 14px 0;
font-family:Helvetica-light;
}

.icon-enable.featured-date {
  background: rgba(0, 0, 0, 0) url("images/timer.png") no-repeat scroll left 5px / 18px 18px;
  padding-left: 25px;
  line-height:26px;
}


.posts-content
  {
    display: flex;
    flex-wrap: wrap;
    width:1396px;
    margin-right: auto;
    margin-left: auto;
  }
  .view-active{
    width:452px;
    height:291px;
    padding-right:20px;
  }
  .blog-title a{

  }
  .active span{
  color: #ffffff;

font-size: 24px;
line-height: 29px;
max-width: 90%;
position: relative;
top: 247px;
width: 100%;
left:17px;
font-family: lato;
font-weight: 400;
}

.check span{
  top:0px!important;
  color:black;
  left:0px;
  font-size:16px;
}
.top_rectangle {
  margin-top: 82px;
  margin-right: auto;
  margin-left: auto;
  width:1396px;
  height:128px;
  border:1px solid #DDDDDD;
  opacity:100%;
}

.p {
  text-align: center;
  font-size: 13px;
  padding-top: 100px;
}
.rp-item-inner{
  padding-right:10px;
  padding-top:40px;
}

</style>
