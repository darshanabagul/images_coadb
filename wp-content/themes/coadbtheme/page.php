<?php
get_header('sub');
?>
<div class="page-wrap">
	<?php get_header('search');?>
	<div class="about-sect">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="about-cont">
						<?php 
							if ( have_posts() ) : 
								while ( have_posts() ) : the_post();
									the_content();
								endwhile; 
							else: ?>
								<p>Sorry, no posts matched your criteria.</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer();?>