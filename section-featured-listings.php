<?php
/**
 * Template part for displaying the Featured Listings section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Manazel_Real_Estate_Theme
 */

// Placeholder data for featured listings. In a real theme, this would loop through a custom query of a 'property' custom post type.
$featured_listings = array(
    array(
        'image' => get_template_directory_uri() . "/assets/images/property-1.jpg", // Placeholder image
        'title' => __( 'Luxury Villa with Ocean View
', 'manazel-theme' ),
        'price' => __( '$1,200,000
', 'manazel-theme' ),
        'size' => __( '350 sqm
', 'manazel-theme' ),
        'location' => __( 'Malibu, California
', 'manazel-theme' ),
        'link' => '#',
    ),
    array(
        'image' => get_template_directory_uri() . "/assets/images/property-2.jpg", // Placeholder image
        'title' => __( 'Modern Downtown Apartment
', 'manazel-theme' ),
        'price' => __( '$650,000
', 'manazel-theme' ),
        'size' => __( '120 sqm
', 'manazel-theme' ),
        'location' => __( 'New York, NY
', 'manazel-theme' ),
        'link' => '#',
    ),
    array(
        'image' => get_template_directory_uri() . "/assets/images/property-3.jpg", // Placeholder image
        'title' => __( 'Cozy Suburban House
', 'manazel-theme' ),
        'price' => __( '$450,000
', 'manazel-theme' ),
        'size' => __( '200 sqm
', 'manazel-theme' ),
        'location' => __( 'Austin, Texas
', 'manazel-theme' ),
        'link' => '#',
    ),
    // Add more listings as needed
);

?>

<section class="featured-listings-section" id="featured-listings">
    <div class="container">
        <h2 class="section-title"><?php esc_html_e( 'Featured Properties
', 'manazel-theme' ); ?></h2>
        <div class="listings-grid">
            <?php foreach ( $featured_listings as $listing ) : ?>
                <div class="listing-card">
                    <a href="<?php echo esc_url( $listing['link'] ); ?>" class="listing-image-link">
                        <img src="<?php echo esc_url( $listing['image'] ); ?>" alt="<?php echo esc_attr( $listing['title'] ); ?>" class="listing-image">
                    </a>
                    <div class="listing-details">
                        <h3 class="listing-title"><a href="<?php echo esc_url( $listing['link'] ); ?>"><?php echo esc_html( $listing['title'] ); ?></a></h3>
                        <p class="listing-price"><?php echo esc_html( $listing['price'] ); ?></p>
                        <div class="listing-meta">
                            <span class="listing-size"><?php echo esc_html( $listing['size'] ); ?></span>
                            <span class="listing-location"><?php echo esc_html( $listing['location'] ); ?></span>
                        </div>
                        <a href="<?php echo esc_url( $listing['link'] ); ?>" class="listing-view-details-button"><?php esc_html_e( 'View Details
', 'manazel-theme' ); ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
.featured-listings-section {
    padding: 60px 0;
    background-color: #FFFFFF; /* White background */
    text-align: center;
}

/* .section-title is already defined in section-features.php, ensure consistency or move to style.css */

.listings-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Responsive grid for listings */
    gap: 30px;
}

.listing-card {
    background-color: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden; /* To contain the image within rounded corners */
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-align: left;
}

.listing-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
}

.listing-image-link {
    display: block;
}

.listing-image {
    width: 100%;
    height: 200px; /* Fixed height for images */
    object-fit: cover; /* Ensures images cover the area well */
    display: block;
}

.listing-details {
    padding: 20px;
}

.listing-title {
    font-size: 1.4em;
    color: #2A3B47; /* Dark Blue */
    margin-bottom: 10px;
}

.listing-title a {
    color: inherit;
    text-decoration: none;
}

.listing-title a:hover {
    color: #D4AF37; /* Gold */
}

.listing-price {
    font-size: 1.3em;
    font-weight: bold;
    color: #D4AF37; /* Gold */
    margin-bottom: 15px;
}

.listing-meta {
    font-size: 0.9em;
    color: #555;
    margin-bottom: 15px;
    display: flex;
    justify-content: space-between;
}

.listing-size, .listing-location {
    /* Add icons later if needed */
}

.listing-view-details-button {
    display: inline-block;
    background-color: #2A3B47; /* Dark Blue */
    color: #FFFFFF;
    padding: 10px 15px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 0.9em;
    transition: background-color 0.3s ease;
}

.listing-view-details-button:hover {
    background-color: #1e2a33; /* Darker Blue */
    color: #FFFFFF;
}
</style>

