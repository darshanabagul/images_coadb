<?php
/*Template Name: Purchase-jpg*/
 get_header('sub');
?>
<!--Page Main content Start Here -->
<div class="page-wrap which_one_is_mine_page">
	<!-- tab Starts Here -->
	<!-- tab end Here -->
	<section class="space same-box-wrap bg-white purchase-jpg-section">
		<div class="container">
		 	<div class="row purchase-jpg">
		 		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	            	<div id="demo" class="carousel slide carousel-fade" data-ride="carousel" data-interval="false">
						<div class="gallery row carousel-inner">
					 		<?php
				    			$args = array( 'post_type' => 'product', 'posts_per_page' => 10, 'product_cat' => 'JPG');
				        		$loop = new WP_Query( $args );
								if (!empty($coat_of_arms = find_coat_of_arms(20))) { ?>
								<?php if(!empty($coat_of_arms['images'])) { ?>
									<?php foreach($coat_of_arms['images'] as $key=>$img) { ?>
										<div class="item <?php if($key==0) echo 'active' ?>">
										<?php foreach ($img as $k=>$v) { ?>
											<?php
					 						while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
					 						<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
										      	<div class="card-stamp">
											      	<div class="image-box">
											      		<img src="https://s3.us-east-2.amazonaws.com/bucket.coadb/<?php echo $coat_of_arms['page_slug']?>/shop-images/<?php echo $v?>" class="img-responsive">
											      	</div>
											      	<div class="detail-box text-center">
											      		<p class="price"><?php echo $product->get_price_html(); ?></p>
											      		<p class="info">Not Watermarked</p>
											      		<div class="add_to_cart_div" coat_of_arm_img="<?php echo $v ?>" product_id="<?php echo $loop->post->ID ?>"><button class="btn primary-btn" data-product_id="<?php echo $loop->post->ID ?>" data-quantity="1">Add to cart</button>
											      			<?php //woocommerce_template_loop_add_to_cart( $loop->post, $product); ?></div>
											      	</div>
										      	</div>
									   		</div>
									   		<?php endwhile; ?>
									   	<?php } ?>
									   	</div>
								   	<?php } ?>
					   			<?php } 
					   			else { ?>
					   				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					   					<h3 class="text-center">Sorry!! Digital Images are not available.</h3>
					   					<p class="text-center"><a href="https://coadb.com/surname-list/surname-meaning-origin-family-history">Click here for Online Shop</a></p>
					   				</div>
					   			<?php } 
					   			} ?>
				    		<?php wp_reset_query(); ?>
		    			</div>
		    		</div>
				</div>
		  	</div>

		  	<?php if(count($coat_of_arms['images']) > 1) { ?>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				  		<div class="pagination-main text-center clearfix">
							<ul class="pagination">
								<li><a class="color" href="#demo" data-slide="prev">Prev</a></li>
								<?php for($i=1;$i<=count($coat_of_arms['images']);$i++) {?>						   
								    <li><a data-target="#demo" data-slide-to="<?php echo $i-1?>" class="active"><?php echo $i; ?></a></li>
								<?php } ?>
								<li><a class="color" href="#demo" data-slide="next">Next</a></li>
							</ul>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</section>
</div>
<?php get_footer(); ?>

<script type="text/javascript">
	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    $( document ).on( 'click', '.add_to_cart_div', function(e) {
    	var coat_of_arm_img = $(this).attr('coat_of_arm_img');
    	var product_id = $(this).attr('product_id');
    	$.ajax({
            url: ajaxurl,
            type : 'post',
            data:    {
              action  : 'save_custom_data',
              'coat_of_arm_img':coat_of_arm_img,
              'product_id': product_id
            },
            success: function(result) {
            	var url = '/images_coadb/?wc-ajax=%%endpoint%%';//woocommerce_params.wc_ajax_url; //|| 
            	url = url.replace("%%endpoint%%", "get_refreshed_fragments");
				$.post(url, function(data, status){
					if ( data.fragments )
					{
						$.each(data.fragments, function(key, value){
							$(key).replaceWith(value);
						});
					}
					$('body').trigger( 'wc_fragments_refreshed' );
				});
        	}
        });
	});
</script>