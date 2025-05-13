<?php
/**
 * Template part for displaying the Contact section on the homepage or a contact page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Manazel_Real_Estate_Theme
 */

// Placeholder contact information - ideally from theme options or Customizer
$contact_email = get_theme_mod( 'manazel_contact_email', 'contact@manazel.me' );
$contact_phone = get_theme_mod( 'manazel_contact_phone', '+123 456 7890' );
$contact_address = get_theme_mod( 'manazel_contact_address', '123 Real Estate St, Property City, CA 90210' );
$whatsapp_link = get_theme_mod('manazel_whatsapp_link', 'https://wa.me/1234567890'); // Example WhatsApp link

?>

<section class="contact-section" id="contact">
    <div class="container">
        <h2 class="section-title"><?php esc_html_e( 'Get In Touch', 'manazel-theme' ); ?></h2>
        <div class="contact-content-wrapper">
            <div class="contact-form-column">
                <h3 class="contact-subtitle"><?php esc_html_e( 'Send Us a Message', 'manazel-theme' ); ?></h3>
                <?php 
                // Check if a contact form plugin like WPForms or Contact Form 7 is active and a form is set.
                // This is a placeholder for a shortcode.
                // Replace '[your_contact_form_shortcode]' with the actual shortcode from your chosen plugin.
                // Example: echo do_shortcode( '[wpforms id="123"]' ); 
                // For now, a simple placeholder form:
                if ( shortcode_exists( 'wpforms' ) ) { // Example check for WPForms
                    // echo do_shortcode( '[wpforms id="your_form_id_here"]' ); // Replace with actual form ID
                    echo '<p>' . esc_html__('WPForms detected. Please insert your form shortcode here or configure it in theme options.', 'manazel-theme') . '</p>';
                } elseif ( shortcode_exists( 'contact-form-7' ) ) { // Example check for Contact Form 7
                    // echo do_shortcode( '[contact-form-7 id="your_form_id_here" title="Contact form 1"]' ); // Replace with actual form ID
                    echo '<p>' . esc_html__('Contact Form 7 detected. Please insert your form shortcode here or configure it in theme options.', 'manazel-theme') . '</p>';
                } else {
                ?>
                <form action="#" method="post" class="simple-contact-form">
                    <p>
                        <label for="contact-name"><?php esc_html_e( 'Name', 'manazel-theme' ); ?></label>
                        <input type="text" id="contact-name" name="contact_name" required>
                    </p>
                    <p>
                        <label for="contact-email"><?php esc_html_e( 'Email', 'manazel-theme' ); ?></label>
                        <input type="email" id="contact-email" name="contact_email" required>
                    </p>
                    <p>
                        <label for="contact-subject"><?php esc_html_e( 'Subject', 'manazel-theme' ); ?></label>
                        <input type="text" id="contact-subject" name="contact_subject">
                    </p>
                    <p>
                        <label for="contact-message"><?php esc_html_e( 'Message', 'manazel-theme' ); ?></label>
                        <textarea id="contact-message" name="contact_message" rows="5" required></textarea>
                    </p>
                    <p>
                        <input type="submit" value="<?php esc_attr_e( 'Send Message', 'manazel-theme' ); ?>">
                    </p>
                </form>
                <?php 
                }
                ?>
            </div>
            <div class="contact-details-column">
                <h3 class="contact-subtitle"><?php esc_html_e( 'Contact Information', 'manazel-theme' ); ?></h3>
                <p class="contact-detail-item contact-address">
                    <span class="dashicons dashicons-location-alt"></span> <?php echo esc_html( $contact_address ); ?>
                </p>
                <p class="contact-detail-item contact-phone">
                    <span class="dashicons dashicons-phone"></span> <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $contact_phone ) ); ?>"><?php echo esc_html( $contact_phone ); ?></a>
                </p>
                <p class="contact-detail-item contact-email">
                    <span class="dashicons dashicons-email-alt"></span> <a href="mailto:<?php echo esc_attr( $contact_email ); ?>"><?php echo esc_html( $contact_email ); ?></a>
                </p>
                <p class="contact-detail-item contact-whatsapp">
                    <span class="dashicons dashicons-whatsapp"></span> <a href="<?php echo esc_url( $whatsapp_link ); ?>" target="_blank"><?php esc_html_e('Chat on WhatsApp', 'manazel-theme'); ?></a>
                </p>
                
                <h3 class="contact-subtitle map-title"><?php esc_html_e( 'Our Location', 'manazel-theme' ); ?></h3>
                <div class="contact-map-placeholder">
                    <?php 
                    // Placeholder for Google Maps iframe or a map plugin shortcode
                    // Example: <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d...."></iframe>
                    // Or: echo do_shortcode('[your_map_plugin_shortcode]');
                    ?>
                    <p><?php esc_html_e( 'Map will be displayed here. Integrate Google Maps iframe or a map plugin.', 'manazel-theme' ); ?></p>
                    <img src="<?php echo get_template_directory_uri() . '/assets/images/map-placeholder.png'; ?>" alt="Map Placeholder" style="width:100%; height:auto; border:1px solid #ccc;">
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.contact-section {
    padding: 60px 0;
    background-color: #f9f9f9; /* Light background */
}

/* .section-title is already defined, ensure consistency or move to style.css */

.contact-content-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr; /* Two equal columns */
    gap: 40px;
    margin-top: 30px;
}

@media (max-width: 768px) {
    .contact-content-wrapper {
        grid-template-columns: 1fr; /* Stack columns on smaller screens */
    }
}

.contact-subtitle {
    font-size: 1.5em;
    color: #2A3B47; /* Dark Blue */
    margin-bottom: 20px;
}

.simple-contact-form p {
    margin-bottom: 15px;
}

.simple-contact-form label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

.simple-contact-form input[type="text"],
.simple-contact-form input[type="email"],
.simple-contact-form textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1em;
}

.simple-contact-form textarea {
    min-height: 120px;
}

.simple-contact-form input[type="submit"] {
    background-color: #D4AF37; /* Gold */
    color: #2A3B47; /* Dark Blue */
    padding: 12px 25px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.simple-contact-form input[type="submit"]:hover {
    background-color: #c09b30; /* Darker Gold */
}

.contact-details-column .contact-detail-item {
    font-size: 1.1em;
    color: #333;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
}

.contact-details-column .contact-detail-item .dashicons {
    color: #D4AF37; /* Gold */
    margin-right: 10px;
    font-size: 1.5em;
}

.contact-details-column .contact-detail-item a {
    color: #2A3B47; /* Dark Blue for links */
    text-decoration: none;
}

.contact-details-column .contact-detail-item a:hover {
    color: #D4AF37; /* Gold on hover */
    text-decoration: underline;
}

.map-title {
    margin-top: 30px;
}

.contact-map-placeholder {
    width: 100%;
    height: 300px; /* Adjust as needed */
    background-color: #e0e0e0;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    border-radius: 5px;
    color: #777;
}
.contact-map-placeholder img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

</style>

