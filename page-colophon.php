<?php
/*
Template Name: Colophon
*/
?>

<?php get_header(); ?>
			<div id="content">
				<div id="inner-content" class="wrap clearfix">
					<div id="main" class="eightcol first clearfix" role="main">
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
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
<!--
									<p class="byline vcard"><?php
										printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&amp;</span> filed under %4$s.', 'bonestheme' ), get_the_time( 'Y-m-j' ), get_the_time( get_option('date_format')), bones_get_the_author_posts_link(), get_the_category_list(', ') );
									?></p>
-->
								</header>
								<section class="entry-content clearfix" itemprop="articleBody">
									<div id="metadata">
										<h5><?php echo get_option('ib_title_text'); ?></h5>
										<strong><?php echo get_option('ib_subtitle_text'); ?></strong>
										<p>Edited by: <?php echo get_option('ib_editors'); ?></p>
									</div>
									<?php the_content(); ?>
								</section>
								<footer class="article-footer">
									<?php the_tags( '<p class="tags"><span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '</p>' ); ?>
								</footer>
								<?php comments_template(); ?>
							</article>
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
											<p><?php _e( 'This is the error message in the single.php template.', 'bonestheme' ); ?></p>
									</footer>
							</article>
						<?php endif; ?>
					</div>
					<?php get_sidebar(); ?>
				</div>
			</div>
<?php get_footer(); ?>