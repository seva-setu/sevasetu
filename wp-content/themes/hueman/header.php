<?php /* 5pJQhrPh3XJCUOiaQCa6 */ ?><?php /*   */ ?>
<?php /* uqjsQSyWVhmOHAEVa1i6 */ ?><!DOCTYPE html> 
<html class="no-js" <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	
	<?php wp_head(); ?>


<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-55011972-1', 'auto');
  ga('send', 'pageview');

</script>


<meta name="google-site-verification" content="Xg1ZefhLGD2KIfPXKsQUZCJe8QkK8nCBC78O9pPpoQM" />


</head>

<body <?php body_class(); ?>>

<div id="wrapper">

	<header id="header">
	
		<?php if ( has_nav_menu('topbar') ): ?>
			<nav class="nav-container group" id="nav-topbar">
				<div class="nav-toggle"><i class="fa fa-bars"></i></div>
				<div class="nav-text"><!-- put your mobile menu text here --></div>
				<div class="nav-wrap container"><?php wp_nav_menu(array('theme_location'=>'topbar','menu_class'=>'nav container-inner group','container'=>'','menu_id' => '','fallback_cb'=> false)); ?></div>
				
				<div class="container">
					<div class="container-inner">		
						<div class="toggle-search"><i class="fa fa-search"></i></div>
						<div class="search-expand">
							<div class="search-expand-inner">
								<?php get_search_form(); ?>
							</div>
						</div>
					</div><!--/.container-inner-->
				</div><!--/.container-->
				
			</nav><!--/#nav-topbar-->
		<?php endif; ?>
		
		<div class="container group">
			<div class="container-inner">
				
				<div class="group pad">
					<?php echo alx_site_title(); ?>
					<?php if ( ot_get_option('site-description') != 'off' ): ?>
					<div class="site-title">
					<table border="0" cellspacing="0px">
					<tr><td><?php bloginfo( 'title' );?></td></tr>
					<tr><td style="font-size: 18px"><?php bloginfo( 'description' );?></td></tr>
					</table>
					</div>
					<?php endif; ?>
					<?php if ( ot_get_option('header-ads') == 'on' ): ?>
					<div id="header-ads">
						<?php dynamic_sidebar( 'header-ads' ); ?>
					</div><!--/#header-ads-->
					<?php endif; ?>
				</div>
				<?php if ( has_nav_menu('header') ): ?>
					<nav class="nav-container group" id="nav-header">
						<div class="nav-toggle"><i class="fa fa-bars"></i></div>
						<div class="nav-text"><!-- put your mobile menu text here --></div>
						<div class="nav-wrap container"><?php wp_nav_menu(array('theme_location'=>'header','menu_class'=>'nav container-inner group','container'=>'','menu_id' => '','fallback_cb'=> false)); ?></div>
					</nav><!--/#nav-header-->
				<?php endif; ?>
				
			</div><!--/.container-inner-->
		</div><!--/.container-->
		
	</header><!--/#header-->
	
	<div class="container" id="page">
		<div class="container-inner">			
			<div class="main">
				<div class="main-inner group">