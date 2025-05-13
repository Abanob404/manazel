<?php
// templates/layouts/footer.php

// Ensure config and language are loaded (though index.php should handle this)
if (!defined(
'BASE_URL
')) {
    require_once __DIR__ . 
'/../../../config/config.php
';
}
if (!function_exists(
'lang
')) {
    require_once __DIR__ . 
'/../../../includes/language.php
';
}

$current_year = date(
'Y
');

?>
</main><!-- /.container -->

<footer class="footer mt-auto py-3 bg-light">
    <div class="container text-center">
        <span class="text-muted"><?php echo str_replace(
'{year}
', $current_year, lang(
'copyright
')); ?></span>
    </div>
</footer>

<!-- Basic JS (You will replace this with your actual JS files, e.g., for Bootstrap or custom scripts) -->
<!-- Example: Bootstrap 5 JS Bundle (requires Popper) -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="<?php echo base_url(
'assets/js/main.js
'); ?>"></script>

</body>
</html>

