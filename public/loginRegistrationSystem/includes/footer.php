<footer style="border-top: 1px solid #ccc; padding: 20px 0; background-color:rgb(224, 224, 224);">
    <div class="container text-center">
        <!-- Contact Us and Subscribe links -->
        <p style="margin-bottom: 20px; font-weight: bold; font-size: 16px;">
            <a href="/loginRegistrationSystem/pages/newsletter" style="margin-left: 15px; color: #333; text-decoration: none;">Subscribe</a>
            |
            <a href="/loginRegistrationSystem/pages/contact" style="margin-right: 15px; color: #333; text-decoration: none;">Contact Us</a>
        </p>
        
        <!-- Social Media Icons -->
        <div class="my-3 d-flex justify-content-center align-items-center" style="gap: 20px;">
            <a href="https://facebook.com" target="_blank" style="color: #4267B2; font-size: 30px;" aria-label="Facebook">
                <i class="fab fa-facebook"></i>
            </a>
            <a href="https://instagram.com" target="_blank" style="color: #C13584; font-size: 30px;" aria-label="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="https://x.com" target="_blank" style="color: #1DA1F2; font-size: 30px;" aria-label="X">
                <i class="fa-brands fa-x-twitter"></i>
            </a>
        </div>

        <!-- Back to Top -->
        <div style="margin-top: 20px;">
            <a href="#" onclick="scrollToTop(event);" style="font-weight: bold; color: #333; text-decoration: none;">Back to Top</a>
        </div>
        
        <!-- Copyright -->
        <p class="mt-3">&copy; <?php echo date("Y"); ?> My Application</p>
    </div>
</footer>

<!-- Smooth Scroll Script -->
<script>
    function scrollToTop(event) {
        event.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>

<!-- Font Awesome CDN for Icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/js/all.min.js" crossorigin="anonymous"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
