<?php
/*
* Template Name: Notebook
*/
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"  <?php  language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php  bloginfo('html_type') ?> charset=<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php  wp_head();?>
</head>
<body>
<?php
         if(have_posts()) : while(have_posts()) : the_post();

                   the_content();

              endwhile;
               else:
                  echo "No posts ";
			  endif;

?>
<?php wp_footer();?>
</body>
</html>