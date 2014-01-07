				<div id="sidebar1" class="sidebar fourcol last clearfix" role="complementary">
					<div id="index">
						<h4>Table of Contents</h4>
						<ul>
							<?php 
							$page = get_page_by_title( 'Colophon' );
							wp_list_pages( 'include=' . $page->ID );
							?>
							<?php 
							$category = '';
							$args = array('post_type' => 'article', 'posts_per_page' => -1, 'order' => 'ASC');
							$the_query = new WP_Query( $args ); 
							if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
								$post_category = get_the_category();
								if (isset($post_category[0])) {
									$post_cat_name = $post_category[0]->cat_name;
									if ($post_cat_name != $category) { ?>
										<h5><?php echo $post_cat_name ?></h5>
										<?php $category = $post_cat_name;
									}
								}
							?>
							<li id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> >
								<h3>
									<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
								</h3>
								<p>by 
								<?php
								if ( function_exists( 'coauthors_posts_links' ) ) {
										coauthors_posts_links();
									} else {
										the_author_posts_link();
									}
								?>
								</p>
							</li>
							<?php endwhile; ?>
							<?php else : ?>
							<article id="post-not-found" class="hentry clearfix">
									<header class="article-header">
										<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
								</header>
									<section class="entry-content">
										<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
								</section>
								<footer class="article-footer">
										<p><?php _e( 'This is the error message in the index.php template.', 'bonestheme' ); ?></p>
								</footer>
							</article>
							<?php endif; ?>
						</ul>
					</div>
<!--
					<?php if ( is_active_sidebar( 'sidebar1' ) ) : ?>
						<?php dynamic_sidebar( 'sidebar1' ); ?>
					<?php else : ?>
						<?php // This content shows up if there are no widgets defined in the backend. ?>
						<div class="alert alert-help">
							<p><?php _e( 'Please activate some Widgets.', 'bonestheme' );  ?></p>
						</div>
					<?php endif; ?>
-->
				</div>