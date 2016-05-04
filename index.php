<html>
	<head>
		<?php wp_head(); ?>
	</head>
	<body>
		<header>
			<?php esc_html_e( 'This is a demo of the Content Layout Control', 'clc-demo-theme' ); ?>
		</header>
		<div class="content">
			<?php
				while ( have_posts() ) : the_post();
					the_content();
				endwhile;
			?>
		</div>
		<footer>
			<?php esc_html_e( 'This was a demo of the Content Layout Control', 'clc-demo-theme' ); ?>
		</footer>
		<?php wp_footer(); ?>
	</body>
</html>
