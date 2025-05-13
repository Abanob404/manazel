<?php
/**
 * Template part for displaying the Testimonials section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Manazel_Real_Estate_Theme
 */

// Placeholder data for testimonials. In a real theme, this would loop through a custom post type or use a plugin.
$testimonials = array(
    array(
        'quote' => __( 'Working with Manazel was a fantastic experience. They helped us find our dream home quickly and efficiently. Highly recommended!', 'manazel-theme' ),
        'author' => __( 'John & Jane Doe', 'manazel-theme' ),
        'image' => get_template_directory_uri() . "/assets/images/author-1.jpg", // Placeholder image
        'details' => __( 'Home Buyers, New York', 'manazel-theme' ),
    ),
    array(
        'quote' => __( 'The team at Manazel provided exceptional service and expert advice throughout the selling process. We couldn\'t be happier with the outcome.', 'manazel-theme' ),
        'author' => __( 'Alice Smith', 'manazel-theme' ),
        'image' => get_template_directory_uri() . "/assets/images/author-2.jpg", // Placeholder image
        'details' => __( 'Property Seller, California', 'manazel-theme' ),
    ),
    // Add more testimonials as needed
);

?>

<section class="testimonials-section" id="testimonials">
    <div class="container">
        <h2 class="section-title"><?php esc_html_e( 'What Our Clients Say', 'manazel-theme' ); ?></h2>
        <div class="testimonials-slider-wrapper">
            <?php // For a real slider, you would use JavaScript (e.g., Swiper.js, Slick) or a WordPress plugin. This is a basic static layout. ?>
            <div class="testimonials-grid">
                <?php foreach ( $testimonials as $testimonial ) : ?>
                    <div class="testimonial-card">
                        <?php if ( ! empty( $testimonial['image'] ) ) : ?>
                            <img src="<?php echo esc_url( $testimonial['image'] ); ?>" alt="<?php echo esc_attr( $testimonial['author'] ); ?>" class="testimonial-author-image">
                        <?php endif; ?>
                        <blockquote class="testimonial-quote">
                            <p>"<?php echo esc_html( $testimonial['quote'] ); ?>"</p>
                        </blockquote>
                        <cite class="testimonial-author">
                            <span class="author-name"><?php echo esc_html( $testimonial['author'] ); ?></span>
                            <?php if ( ! empty( $testimonial['details'] ) ) : ?>
                                <span class="author-details"><?php echo esc_html( $testimonial['details'] ); ?></span>
                            <?php endif; ?>
                        </cite>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php // Add slider navigation/pagination here if implementing a JS slider ?>
        </div>
    </div>
</section>

<style>
.testimonials-section {
    padding: 60px 0;
    background-color: #f0f4f7; /* A slightly different light background */
    text-align: center;
}

/* .section-title is already defined, ensure consistency or move to style.css */

.testimonials-slider-wrapper {
    /* Add styles for slider container if using JS slider */
    position: relative;
}

.testimonials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 30px;
}

.testimonial-card {
    background-color: #FFFFFF;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.07);
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.testimonial-author-image {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 20px;
    border: 3px solid #D4AF37; /* Gold border */
}

.testimonial-quote {
    font-size: 1.1em;
    color: #333;
    line-height: 1.7;
    margin-bottom: 20px;
    font-style: italic;
    position: relative;
    padding: 0 15px;
}

.testimonial-quote p::before {
    content: '\201C'; /* Left double quotation mark */
    font-size: 2.5em;
    color: #D4AF37; /* Gold */
    position: absolute;
    left: -10px;
    top: -10px;
    line-height: 1;
}

.testimonial-quote p::after {
    content: '\201D'; /* Right double quotation mark */
    font-size: 2.5em;
    color: #D4AF37; /* Gold */
    position: absolute;
    right: -10px;
    bottom: -15px;
    line-height: 1;
}

.testimonial-author {
    font-size: 1em;
    color: #2A3B47; /* Dark Blue */
    font-weight: bold;
    display: block;
}

.testimonial-author .author-name {
    display: block;
}

.testimonial-author .author-details {
    font-size: 0.9em;
    font-weight: normal;
    color: #777;
    display: block;
    margin-top: 5px;
}

/* Basic styles for potential slider controls - to be expanded if JS slider is used */
.slider-nav-button {
    background-color: #2A3B47;
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
}

.slider-prev {
    left: -20px;
}

.slider-next {
    right: -20px;
}
</style>

