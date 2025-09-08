<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>assets/lib/wow/wow.min.js"></script>
<script src="<?= BASE_URL ?>assets/lib/easing/easing.min.js"></script>
<script src="<?= BASE_URL ?>assets/lib/waypoints/waypoints.min.js"></script>
<script src="<?= BASE_URL ?>assets/lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Template Javascript -->
<script src="<?= BASE_URL ?>assets/js/main.js"></script>

<script>
    // Initialisation des popovers
    document.addEventListener('DOMContentLoaded', function () {
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl, {
                container: 'body',
                customClass: 'popover-custom',
                trigger: 'click',
                placement: 'bottom'
            });
        });
    });
</script>