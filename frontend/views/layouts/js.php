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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const contactForm = document.getElementById('contactForm');
        const submitBtn = document.getElementById('submitBtn');
        const formMessage = document.getElementById('formMessage');

        // Remplir les champs cachés
        document.getElementById('ip_address').value = getUserIP();
        document.getElementById('user_agent').value = navigator.userAgent;

        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Désactiver le bouton
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<?= t('contact_form_sending') ?>...';
            formMessage.style.display = 'none';

            // Récupérer les données du formulaire
            const formData = new FormData(contactForm);

            // Envoyer la requête AJAX
            fetch(contactForm.action, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Succès
                        showMessage(data.message, 'success');
                        contactForm.reset();
                    } else {
                        // Erreur
                        showMessage(data.message, 'danger');

                        // Afficher les erreurs de champ
                        if (data.errors) {
                            displayFieldErrors(data.errors);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessage('Une erreur est survenue. Veuillez réessayer.', 'danger');
                })
                .finally(() => {
                    // Réactiver le bouton
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<?= t('contact_form_send_button') ?>';
                });
        });

        function showMessage(message, type) {
            formMessage.innerHTML = message;
            formMessage.className = `alert alert-${type} mt-3`;
            formMessage.style.display = 'block';

            // Scroll vers le message
            formMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        function displayFieldErrors(errors) {
            // Réinitialiser les erreurs
            document.querySelectorAll('.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });
            document.querySelectorAll('.invalid-feedback').forEach(el => {
                el.remove();
            });

            // Afficher les nouvelles erreurs
            for (const field in errors) {
                const input = document.getElementById(field);
                if (input) {
                    input.classList.add('is-invalid');

                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.textContent = errors[field];

                    input.parentNode.appendChild(errorDiv);
                }
            }
        }

        // Fonction pour obtenir l'IP de l'utilisateur
        function getUserIP() {
            return new Promise((resolve) => {
                // Essayer d'obtenir l'IP via un service externe
                fetch('https://api.ipify.org?format=json')
                    .then(response => response.json())
                    .then(data => resolve(data.ip))
                    .catch(() => {
                        // Fallback vers l'IP du serveur
                        resolve('<?= $_SERVER['REMOTE_ADDR'] ?>');
                    });
            });
        }

        // Initialiser avec l'IP
        getUserIP().then(ip => {
            document.getElementById('ip_address').value = ip;
        });
    });
</script>