<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="http://www.google-analytics.com" rel="dns-prefetch">
	<?php wp_head();?>
</head>
<body>
	<nav class="inner-page-nav navbar-fixed-top">
	  <div class="container">
	  	<div class="row">
    		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
				<div class="navbar-header">
				  	<a class="logo-link" href="https://coadb.com">
	                    <img src="<?php echo get_site_url()?>/wp-content/uploads/2019/04/coadblogo-300x196.jpg" width="100" alt="Coat of Arms Database Logo" class="logo-img" />
	               	</a>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-6">
				<?php $coat_of_arms = find_coat_of_arms();?>
				<?php if(is_page_template('purchase-jpg.php')): ?>
					<h1 class="header-title"><?php echo(ucfirst($coat_of_arms['page_slug'])) ?> Coat of Arms & Surname History</h1>
                <?php elseif(is_singular()): ?>
                	<h1 class="header-title"><?php the_title(); ?></h1>
                <?php endif; ?>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
				<div id="cart_container">
					<ul class="nav navbar-nav navbar-right">
						<li><?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
					    	$count = WC()->cart->cart_contents_count;
					    ?>
					    <a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php 
					    	if ( $count > 0 ) {
					        ?>
					        <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
					        <?php
					    	}
					        ?>
					    </a>
					<?php } ?></li>
						<li><a href="https://coadb.com/surname-list/surname-meaning-origin-family-history">Online Shop</a></li>
						<?php if(!is_page_template('purchase-jpg.php')): ?>
							<?php $page = $_SESSION['slug'];?>
							<li><a href="<?php echo esc_url( add_query_arg( 'surname', $page , site_url( '/index.php/purchase-digital-jpg/' ) ) )?>">Purchase JPG</a></li>
					    <?php endif; ?>
					</ul>
				</div>
				<div class="header-search">
	                <form role="search" class="searchform" method="get" action="https://coadb.com">
					    <div class="search-table">
					        <div class="search-field">
					            <input type="text" value="" name="s" class="s" placeholder="Type your surname here...">
					        </div>
					        <div class="search-button">
					            <input type="submit" class="searchsubmit" value="">
					        </div>
					    </div>
					</form>
				</div>
			</div>
		</div>
	  </div>
	</nav>