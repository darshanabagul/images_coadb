<?php
/*Template Name: About*/
get_header('sub');
?>
<div class="page-wrap">
	<?php get_header('search');?>
	<div class="about-sect">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<div class="img-sect">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/John-Lehman.jpg" alt="" title="" class="img-responsive" />
					</div>
				</div>
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
					<div class="about-cont">
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
							the_content();
							endwhile; else: ?>
							<p>Sorry, no posts matched your criteria.</p>
							<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer();?>