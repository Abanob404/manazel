<?php 
// templates/partials/search_form.php 
?>
<form action="<?php echo SITE_URL; ?>/listings" method="GET" class="search-form">
    <input type="text" name="search_query" placeholder="<?php echo trans("search_placeholder"); ?>" value="<?php echo isset($_GET["search_query"]) ? htmlspecialchars($_GET["search_query"]) : ''; ?>">
    <!-- Add more filters as needed, e.g., property type, price range, bedrooms -->
    <button type="submit" class="btn"><?php echo trans("filter_button"); ?></button>
</form>

