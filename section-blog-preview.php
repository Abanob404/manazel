<?php
/**
 * Template part for displaying a preview of latest blog posts on the homepage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Manazel_Real_Estate_Theme
 */

$args = array(
    'post_type' => 'post',
    'posts_per_page' => 3, // Number of posts to display
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
);

$latest_posts_query = new WP_Query( $args );

?>

<section class="blog-preview-section" id="blog-preview">
    <div class="container">
        <h2 class="section-title"><?php esc_html_e( 'From Our Blog
', 'manazel-theme' ); ?></h2>
        <?php if ( $latest_posts_query->have_posts() ) : ?>
            <div class="blog-posts-grid">
                <?php while ( $latest_posts_query->have_posts() ) : $latest_posts_query->the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class("blog-post-card"); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>" class="post-thumbnail-link">
                                <?php the_post_thumbnail( 'medium_large', array( 'class' => 'post-thumbnail-image' ) ); // medium_large is a good size for previews ?>
                            </a>
                        <?php endif; ?>
                        <div class="entry-content-preview">
                            <header class="entry-header-preview">
                                <?php the_title( sprintf( '<h3 class="entry-title-preview"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
                                <div class="entry-meta-preview">
                                    <span class="posted-on"><?php echo get_the_date(); ?></span>
                                    <?php /* <span class="byline"> by <?php the_author_posts_link(); ?></span> */ ?>
                                </div><!-- .entry-meta -->
                            </header><!-- .entry-header -->
                            <div class="entry-summary-preview">
                                <?php the_excerpt(); ?>
                            </div><!-- .entry-summary -->
                             <a href="<?php the_permalink(); ?>" class="read-more-button"><?php esc_html_e( 'Read More
', 'manazel-theme' ); ?></a>
                        </div>
                    </article><!-- #post-<?php the_ID(); ?> -->
                <?php endwhile; ?>
            </div>
            <div class="view-all-posts-link">
                <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="button-primary"><?php esc_html_e( 'View All Posts
', 'manazel-theme' ); ?></a>
            </div>
        <?php else : ?>
            <p><?php esc_html_e( 'No recent posts to display at the moment.
', 'manazel-theme' ); ?></p>
        <?php endif; ?>
        <?php wp_reset_postdata(); // Restore original Post Data ?>
    </div>
</section>

<style>
.blog-preview-section {
    padding: 60px 0;
    background-color: #FFFFFF;
    text-align: center;
}

/* .section-title is already defined, ensure consistency or move to style.css */

.blog-posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 30px;
    text-align: left;
}

.blog-post-card {
    background-color: #fff;
    border: 1px solid #e9e9e9;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.blog-post-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.post-thumbnail-link {
    display: block;
}

.post-thumbnail-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
}

.entry-content-preview {
    padding: 20px;
}

.entry-header-preview .entry-title-preview {
    font-size: 1.3em;
    color: #2A3B47; /* Dark Blue */
    margin-bottom: 8px;
}

.entry-header-preview .entry-title-preview a {
    color: inherit;
    text-decoration: none;
}

.entry-header-preview .entry-title-preview a:hover {
    color: #D4AF37; /* Gold */
}

.entry-meta-preview {
    font-size: 0.85em;
    color: #777;
    margin-bottom: 15px;
}

.entry-summary-preview p {
    font-size: 0.95em;
    color: #555;
    line-height: 1.6;
    margin-bottom: 15px;
}

.read-more-button {
    display: inline-block;
    color: #D4AF37; /* Gold */
    text-decoration: none;
    font-weight: bold;
    font-size: 0.9em;
}

.read-more-button:hover {
    text-decoration: underline;
}

.view-all-posts-link {
    margin-top: 40px;
}

.button-primary {
    display: inline-block;
    background-color: #2A3B47; /* Dark Blue */
    color: #FFFFFF;
    padding: 12px 25px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 1em;
    transition: background-color 0.3s ease;
}

.button-primary:hover {
    background-color: #1e2a33; /* Darker Blue */
    color: #FFFFFF;
}

</style>

