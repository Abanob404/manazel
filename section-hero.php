<?php
/**
 * Template part for displaying the Hero section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Manazel_Real_Estate_Theme
 */

// Get data from Customizer or theme options if available, otherwise use defaults
// For now, we'll use placeholder text. These would ideally be editable via the Customizer.

$hero_tagline = get_theme_mod( 'manazel_hero_tagline', __( 'Find Your Dream Home with Manazel', 'manazel-theme' ) );
// In a real theme, you'd have options for video/slider background

?>

<section class="hero-section" id="hero">
    <div class="container">
        <div class="hero-content">
            <h1><?php echo esc_html( $hero_tagline ); ?></h1>
            <p><?php esc_html_e( 'Discover a wide range of properties tailored to your needs. Start your search today!', 'manazel-theme' ); ?></p>
            
            <div class="hero-search-bar">
                <form role="search" method="get" class="search-form-hero" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <label class="screen-reader-text" for="s-hero"><?php esc_html_e( 'Search for:', 'manazel-theme' ); ?></label>
                    <input type="search" id="s-hero" class="search-field-hero" placeholder="<?php esc_attr_e( 'Enter Property Type, Location, Price...', 'manazel-theme' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                    
                    <?php // Add filters here - Property Type, Location, Price Range - these would typically be dropdowns or separate inputs ?>
                    <?php /*
                    <select name="property_type" class="hero-filter-property-type">
                        <option value=""><?php esc_html_e( 'Property Type', 'manazel-theme' ); ?></option>
                        <option value="apartment"><?php esc_html_e( 'Apartment', 'manazel-theme' ); ?></option>
                        <option value="house"><?php esc_html_e( 'House', 'manazel-theme' ); ?></option>
                        <option value="villa"><?php esc_html_e( 'Villa', 'manazel-theme' ); ?></option>
                    </select>
                    <input type="text" name="location" class="hero-filter-location" placeholder="<?php esc_attr_e( 'Location', 'manazel-theme' ); ?>">
                    <select name="price_range" class="hero-filter-price-range">
                        <option value=""><?php esc_html_e( 'Price Range', 'manazel-theme' ); ?></option>
                        <option value="0-100000"><?php esc_html_e( '$0 - $100,000', 'manazel-theme' ); ?></option>
                        <option value="100000-500000"><?php esc_html_e( '$100,000 - $500,000', 'manazel-theme' ); ?></option>
                        <option value="500000+"><?php esc_html_e( '$500,000+', 'manazel-theme' ); ?></option>
                    </select>
                    */ ?>

                    <button type="submit" class="search-submit-hero"><span class="screen-reader-text"><?php esc_html_e( 'Search', 'manazel-theme' ); ?></span><svg aria-hidden="true" role="img" focusable="false" class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></button>
                </form>
            </div>
        </div>
    </div>
    <?php // Placeholder for full-screen video/slider background. This would be implemented with JS and CSS, or a plugin. ?>
    <div class="hero-background-placeholder" style="background-image: url("<?php echo get_template_directory_uri() . '/assets/images/hero-placeholder.jpg'; ?>"); background-size: cover; background-position: center; min-height: 400px; /* Adjust as needed */ ">
        <?php // If using a video background, the video tag would go here. ?>
    </div>
</section>

<style>
.hero-section {
    position: relative; /* For absolute positioning of background if needed */
    color: #fff; /* Text color on top of image/video */
    text-align: center;
    padding: 60px 0; /* Adjust padding as needed */
}
.hero-background-placeholder {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1; /* Behind the content */
    opacity: 0.7; /* Example opacity */
}
.hero-content {
    position: relative; /* To ensure it's above the background */
    z-index: 1;
    background-color: rgba(42, 59, 71, 0.7); /* Dark blue semi-transparent overlay #2A3B47 */
    padding: 40px;
    border-radius: 8px;
    display: inline-block; /* To center the box if needed */
}
.hero-section h1 {
    font-size: 2.8em;
    margin-bottom: 0.5em;
    color: #FFFFFF;
}
.hero-section p {
    font-size: 1.2em;
    margin-bottom: 1.5em;
    color: #f0f0f0;
}
.search-form-hero {
    display: flex;
    gap: 10px;
    align-items: center;
    background-color: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    max-width: 800px; /* Limit width of search bar */
    margin: 0 auto; /* Center the search bar */
}
.search-field-hero {
    flex-grow: 1;
    padding: 12px 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1em;
}
.hero-filter-property-type, .hero-filter-location, .hero-filter-price-range {
    padding: 12px 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
    min-width: 150px; /* Adjust as needed */
}
.search-submit-hero {
    background-color: #D4AF37; /* Gold */
    color: #2A3B47; /* Dark Blue */
    border: none;
    padding: 12px 18px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
    display: flex;
    align-items: center;
    gap: 5px;
}
.search-submit-hero:hover {
    background-color: #c09b30; /* Darker Gold */
}
.search-icon {
    stroke: #2A3B47;
}
</style>

