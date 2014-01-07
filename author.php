<?php get_header(); ?>
			<div id="content">
				<div id="inner-content" class="wrap clearfix">
					<div id="main" class="eightcol first clearfix" role="main">
						<?php if ( have_posts() ) : ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
								<header class="article-header">
									<h1 class="entry-title single-title" itemprop="headline">
									<?php
										echo get_the_author();
									?>
									</h1>
										<?php if ( get_the_author_meta( 'description' ) ) : ?>
									<div class="author-description"><?php the_author_meta( 'description' ); ?></div>
										<?php endif; ?>
								</header><!-- .archive-header -->
								<h3>By <?php echo get_the_author(); ?></h3>
									<?php
									rewind_posts();
									// Start the Loop.
										while ( have_posts() ) : the_post(); ?>
											<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
												<header class="article-header">
													<h5 class="book-section">
														<?php $post_category = get_the_category();
														if (isset($post_category[0])) {
															$post_cat_name = $post_category[0]->cat_name;
															echo $post_cat_name;
														} ?>
													</h5>
													<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
													<p class="author"><?php
													if ( function_exists( 'coauthors_posts_links' ) ) {
														coauthors_posts_links();
													} else {
														the_author_posts_link();
													}
													?></p>
				<!--
													<p class="byline vcard"><?php
														printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&amp;</span> filed under %4$s.', 'bonestheme' ), get_the_time( 'Y-m-j' ), get_the_time( get_option('date_format')), bones_get_the_author_posts_link(), get_the_category_list(', ') );
													?></p>
				-->
												</header>
												<section class="entry-content clearfix" itemprop="articleBody">
													<?php the_content(); ?>
												</section>
												<footer class="article-footer">
													<?php the_tags( '<p class="tags"><span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '</p>' ); ?>
												</footer>
											</article>
										<?php endwhile;
									else :
										// If no content, include the "No posts found" template.
										echo 'none';
									endif;
									?>
						</div>
					<?php get_sidebar(); ?>
				</div>
			</div>
<?php get_footer(); ?>