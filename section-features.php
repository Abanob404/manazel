<?php
/**
 * Template part for displaying the Features section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Manazel_Real_Estate_Theme
 */

// Placeholder data for features. In a real theme, this would come from theme options, custom fields, or a custom post type.
$features = array(
    array(
        'icon' => 'dashicons-star-filled', // Example Dashicon, or use custom SVG/image path
        'title' => __( '10+ Years Expertise', 'manazel-theme' ),
        'description' => __( 'Leveraging over a decade of experience in the real estate market to serve you better.', 'manazel-theme' ),
    ),
    array(
        'icon' => 'dashicons-money-alt',
        'title' => __( 'Best Price Guarantee', 'manazel-theme' ),
        'description' => __( 'We ensure you get the most competitive prices for your dream properties.', 'manazel-theme' ),
    ),
    array(
        'icon' => 'dashicons-shield-alt',
        'title' => __( 'Legal Support', 'manazel-theme' ),
        'description' => __( 'Comprehensive legal assistance throughout your buying or selling process.', 'manazel-theme' ),
    ),
    // Add a fourth feature if desired
    /*
    array(
        'icon' => 'dashicons-admin-users',
        'title' => __( 'Client Focused', 'manazel-theme' ),
        'description' => __( 'Our clients are our priority, we provide personalized services.', 'manazel-theme' ),
    ),
    */
);

?>

<section class="features-section" id="features">
    <div class="container">
        <h2 class="section-title"><?php esc_html_e( 'Why Choose Us?', 'manazel-theme' ); ?></h2>
        <div class="features-grid">
            <?php foreach ( $features as $feature ) : ?>
                <div class="feature-card">
                    <?php if ( ! empty( $feature['icon'] ) ) : ?>
                        <?php if ( strpos( $feature['icon'], 'dashicons-' ) === 0 ) : // Check if it's a Dashicon class ?>
                            <span class="dashicons <?php echo esc_attr( $feature['icon'] ); ?> feature-icon"></span>
                        <?php else: // Assume it's an image path or SVG code, handle accordingly ?>
                            <img src="<?php echo esc_url( $feature['icon'] ); ?>" alt="" class="feature-icon-img">
                        <?php endif; ?>
                    <?php endif; ?>
                    <h3 class="feature-title"><?php echo esc_html( $feature['title'] ); ?></h3>
                    <p class="feature-description"><?php echo esc_html( $feature['description'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
.features-section {
    padding: 60px 0;
    background-color: #f9f9f9; /* Light grey background for contrast */
    text-align: center;
}

.section-title {
    font-size: 2.2em;
    color: #2A3B47; /* Dark Blue */
    margin-bottom: 40px;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); /* Responsive grid */
    gap: 30px;
    text-align: left;
}

.feature-card {
    background-color: #FFFFFF; /* White card background */
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
}

.feature-icon {
    font-size: 3em; /* Adjust size of Dashicon */
    color: #D4AF37; /* Gold */
    margin-bottom: 15px;
    display: block; /* Or inline-block if preferred */
    text-align: center; /* Center icon within its space */
}

.feature-icon-img {
    max-width: 60px; /* Adjust as needed */
    margin-bottom: 15px;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.feature-title {
    font-size: 1.5em;
    color: #2A3B47; /* Dark Blue */
    margin-bottom: 10px;
    text-align: center;
}

.feature-description {
    font-size: 1em;
    color: #555;
    line-height: 1.7;
    text-align: center;
}
</style>

