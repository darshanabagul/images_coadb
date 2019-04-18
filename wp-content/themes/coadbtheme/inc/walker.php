<?php 

/* Collection of walker classes */

/* 
	wp_nav_menu()
	<div class="menu-container">
		<ul> //start lvl
			<li><a><span>//start_el()</a></span> //end_el()</li>

			<li><a></a></li>
			<li><a></a></li>
			<li><a></a></li>
		</ul> //end_lvl 
	</div>
 */
class Walker_Nav_Primary extends Walker_Nav_menu{

	function start_lvl( &$output, $depth ) //ul
	{
		$indent = str_repeat("\t",$depth);
	}
	function start_el() //li a span
	{
		
	}
/*	function end_el() //closing li a span
	{
		
	}
	function end_lvl() //closing ul
	{
		
	}
*/
}



?>