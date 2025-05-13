# Manazel Real Estate Theme - Installation and Setup Guide

Welcome to the Manazel Real Estate Theme! This guide will walk you through the steps to install and set up your new WordPress theme on your GoDaddy hosting (or any other WordPress hosting).

**Package Contents:**

Before you begin, ensure you have the following files from the package I will provide:

1.  `manazel_theme.zip`: This is the main WordPress theme file.
2.  `manazel-demo-content.xml`: This file contains sample content (pages, posts, property listings) to help you get started.
3.  `recommended_plugins.md`: A list of recommended plugins and their purposes (you should have this already).
4.  `installation_guide.md` (this file).

## Step 1: Install WordPress on GoDaddy (if not already done)

If you haven't already, you need a working WordPress installation on your GoDaddy hosting account.

1.  Log in to your GoDaddy account.
2.  Navigate to "My Products" and find your hosting plan.
3.  GoDaddy usually offers a one-click WordPress installation or a manual setup option. Follow GoDaddy's specific instructions for installing WordPress on your domain.
4.  Once WordPress is installed, make sure you can log in to your WordPress admin dashboard (usually at `yourdomain.com/wp-admin`).

## Step 2: Upload and Install the Manazel Real Estate Theme

1.  Log in to your WordPress admin dashboard.
2.  Navigate to **Appearance > Themes** from the left-hand menu.
3.  Click the **Add New** button at the top of the page.
4.  Click the **Upload Theme** button.
5.  Click **Choose File** and select the `manazel_theme.zip` file from your computer (this is the file I will provide you in the final package).
6.  Click **Install Now**.
7.  Once the theme is installed, click the **Activate** link.

Your Manazel Real Estate Theme is now active!

## Step 3: Install Recommended Plugins

To get the full functionality of the theme and the features discussed, you'll need to install some plugins. Refer to the `recommended_plugins.md` file for a detailed list and explanations. Here's a general guide to installing plugins:

1.  In your WordPress admin dashboard, navigate to **Plugins > Add New**.
2.  In the search box, type the name of the plugin you want to install (e.g., "Elementor Page Builder", "Yoast SEO", "WPForms Lite", or a Real Estate plugin like "Essential Real Estate").
3.  Find the plugin in the search results and click **Install Now**.
4.  After installation, click **Activate**.
5.  Repeat this process for all the recommended plugins you wish to use.

**Key Plugins to Install First:**

*   **Elementor Page Builder:** For building and customizing your pages.
*   **A Real Estate Plugin:** (e.g., Essential Real Estate) This is crucial for managing property listings. You will need to configure this plugin to create property listings, add property details (price, size, location, images, etc.), and manage agent profiles if applicable.
*   **A Contact Form Plugin:** (e.g., WPForms Lite or Contact Form 7) To make the contact form on your "Contact Us" page functional.

## Step 4: Import Demo Content (Optional, but Recommended)

The `manazel-demo-content.xml` file contains sample pages, blog posts, and placeholder property listings to give you a starting point and show you how the theme can look.

1.  In your WordPress admin dashboard, navigate to **Tools > Import**.
2.  You will see a list of import systems. Find **WordPress** and click **Install Now** if the importer plugin is not already installed. (It's a small plugin provided by WordPress.org).
3.  Once the WordPress Importer is installed, click **Run Importer**.
4.  Click **Choose File** and select the `manazel-demo-content.xml` file from your computer.
5.  Click **Upload file and import**.
6.  On the next screen, you will be asked to assign authors:
    *   You can assign posts to an existing user (e.g., your admin account).
    *   Or you can create a new user with the login name from the import file.
    *   **Important:** Check the box that says **"Download and import file attachments."** This will attempt to import any placeholder images referenced in the demo content (though you will likely replace these with your actual property images).
7.  Click **Submit**.
8.  Be patient, as the import process might take a few minutes.

Once the import is complete, you should see new pages (Homepage, About Us, Services, etc.), sample blog posts, and potentially sample property listings (depending on how your chosen Real Estate plugin handles CPT import via WXR).

## Step 5: Configure Basic WordPress Settings

1.  **Set Your Homepage and Blog Page:**
    *   Go to **Settings > Reading**.
    *   Under "Your homepage displays", select **A static page**.
    *   For "Homepage", choose the page you imported or created named "Homepage".
    *   For "Posts page", choose the page you imported or created named "Blog".
    *   Click **Save Changes**.

2.  **Permalinks:**
    *   Go to **Settings > Permalinks**.
    *   Choose a user-friendly permalink structure. **Post name** is a common and SEO-friendly option.
    *   Click **Save Changes**.

3.  **Navigation Menus:**
    *   Go to **Appearance > Menus**.
    *   You might find that the demo import created a menu, or you might need to create one.
    *   **Create a New Menu:** If needed, click "create a new menu", give it a name (e.g., "Main Menu").
    *   **Add Pages to Menu:** Select the pages you want in your menu (Homepage, Services, Listings, About, Blog, Contact Us) from the left and click "Add to Menu".
    *   **Arrange Menu Items:** Drag and drop the menu items to order them as you like.
    *   **Assign Menu to Location:** Under "Menu Settings" at the bottom, check the box for "Primary Menu" (or the theme location name specified in `functions.php`, which is `menu-1`).
    *   Click **Save Menu**.
    *   You can create a separate menu for the footer if desired and assign it to the "Footer Menu" location.

## Step 6: Customize Your Theme and Add Your Content

Now that the theme, plugins, and basic structure are in place, you can start customizing:

1.  **Theme Customizer:**
    *   Go to **Appearance > Customize**.
    *   Here you can typically change things like your Site Title & Tagline, upload your Logo (under Site Identity), set colors (if the theme provides options beyond the default CSS), and manage widgets.

2.  **Elementor:**
    *   Edit the pages (Homepage, About Us, etc.) using Elementor. Click "Edit with Elementor" when viewing a page or from the page list in the admin dashboard.
    *   The theme's sections (Hero, Features, etc.) are designed as separate PHP files. You can call these into your Elementor pages using a Shortcode plugin (if you create shortcodes for them) or by rebuilding similar layouts directly within Elementor using its widgets and the theme's styling as a base.
    *   Replace all placeholder text and images with your actual content.

3.  **Real Estate Plugin:**
    *   Go to the settings page of your chosen Real Estate plugin.
    *   Start adding your property listings with all their details: descriptions, prices, locations, images, features (bedrooms, bathrooms, size), etc.
    *   Configure how listings are displayed on the "Property Listings" page.

4.  **Contact Form:**
    *   Go to the settings of your contact form plugin (e.g., WPForms).
    *   Create a new contact form or edit the imported one.
    *   Copy the shortcode provided by the plugin.
    *   Edit your "Contact Us" page (with Elementor or the default editor) and paste the shortcode where you want the form to appear (the theme's `section-contact.php` has a placeholder for this).

5.  **Widgets:**
    *   Go to **Appearance > Widgets**.
    *   Add widgets to your sidebar (if your page templates use one) and footer widget areas (the theme registers `Footer 1`, `Footer 2`, etc.).

## Step 7: Final Checks

*   Test your website on different devices (desktop, tablet, mobile) to ensure it's responsive.
*   Check all links and navigation menus.
*   Test your contact form.
*   Ensure your property listings are displaying correctly with all information.

Congratulations! Your Manazel Real Estate website should now be set up and ready for you to populate with all your unique content and listings.

If you encounter any specific issues with GoDaddy hosting, their support channels are the best place for hosting-related queries. For theme-specific questions beyond this guide, you can refer back to me.
