<footer id="footer" class="footer light-background">

    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6 footer-about">
                <a href="candidate.php" class="logo d-flex align-items-center">
                    <span class="sitename">MyPass</span>
                </a>
                <div class="footer-contact pt-3">
                    <p><strong>Adresse:</strong></p>
                    <p>Siège National à Kinshasa :</p>
                    <p> 14, Avenue Sergent Moke, Commune de Ngaliema, Kinshasa
                        A l'intérieur de la concession SAFRICAS, proche du Rond-point Haute Cour Militaire/GB.
                        +243 82 7000 755 </p>
                    <p>Bureau de Lubumbashi :</p>
                    <p>  Bâtiment Hypnose 2ème Niveau
                        826, Avenue Mama Yemo, Ville de Lubumbashi
                        +243 82 6999 755 / +243 97 0639 702 </p>
                    <p class="mt-3"><strong>Phone:</strong>


                        <span>+243 82 7000 755 | +243 85 0050 755 | +243 82 6999 755 (Clients de Lubumbashi uniquement)</span>

                    </p>


                    <p><strong>Email:</strong> <span>admin@passportsarl.voyage</span></p>
                </div>
                <div class="social-links d-flex mt-4">
                    <a href=""><i class="bi bi-facebook"></i></a>
                    <a href=""><i class="bi bi-instagram"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Accès Rapide</h4>
                <ul>
                    <li><a href="#">Accueil</a></li>
                    <li><a href="#">À propos</a></li>
                    <li><a href="#">Nos services</a></li>
                    <li><a href="#">Testimonials</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>


            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Informations</h4>
                <ul>
                    <li><a href="candidate-terms-condition.php">Conditions Générales</a></li>
                </ul>
            </div>


        </div>
    </div>

    <div class="container copyright text-center mt-4">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">MyPass</strong> <span>tous droits réservés.</span></p>
        <div class="credits">

            Fait avec  par <svg class="bi bi-suit-heart-fill" xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="#EB6453" viewBox="0 0 16 16">
                <path d="M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1z"></path>
            </svg> SnB Company <a href="https://www.snbapp.com/" target="_blank"></a>

        </div>
    </div>

</footer>
<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="candidate/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="candidate/assets/vendor/php-email-form/validate.js"></script>
<script src="candidate/assets/vendor/aos/aos.js"></script>
<script src="candidate/assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="candidate/assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="candidate/assets/vendor/swiper/swiper-bundle.min.js"></script>

<!-- Main JS File -->
<script src="candidate/assets/js/main.js"></script>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

</script>
<script src="back/assets/vendor/libs/jquery/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script>
    $(document).ready(function(){

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;

        $(".next").click(function(){

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({'opacity': opacity});
                },
                duration: 600
            });
        });

        $(".previous").click(function(){

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();

            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({'opacity': opacity});
                },
                duration: 600
            });
        });

        $('.radio-group .radio').click(function(){
            $(this).parent().find('.radio').removeClass('selected');
            $(this).addClass('selected');
        });

        $(".submit").click(function(){
            return false;
        })

    });
</script>
<script>
    $(function() {
        $('#addMoreTb1').on('click', function() {
            var data = $("#tb1 tr:eq(1)").clone(true).appendTo("#tb1");
            console.log('data', data);
            data.find("input").val('');
        });
        $(document).on('click', '.remove', function() {
            var trIndex = $(this).closest("tr").index();
            if (trIndex > 1) {
                $(this).closest("tr").remove();
            } else {
                alert("Sorry!! Can't remove first row!");
            }
        });
    });
    $(function() {
        $('#addMoreTb2').on('click', function() {
            var data = $("#tb2 tr:eq(1)").clone(true).appendTo("#tb2");
            console.log('data', data);
            data.find("input").val('');
        });
        $(document).on('click', '.remove', function() {
            var trIndex = $(this).closest("tr").index();
            if (trIndex > 1) {
                $(this).closest("tr").remove();
            } else {
                alert("Sorry!! Can't remove first row!");
            }
        });
    });
    $(function() {
        $('#addMoreTb3').on('click', function() {
            var data = $("#tb3 tr:eq(1)").clone(true).appendTo("#tb3");
            data.find("input").val('');
        });
        $(document).on('click', '.remove', function() {
            var trIndex = $(this).closest("tr").index();
            if (trIndex > 1) {
                $(this).closest("tr").remove();
            } else {
                alert("Sorry!! Can't remove first row!");
            }
        });
    });

    function yesnoCheck(that) {
        if (that.value == "Autre") {
            document.getElementById("ifYes").style.display = "block";
        } else {
            document.getElementById("ifYes").style.display = "none";
        }
    }

    $(function() {
        $(".answer_destination_famille").hide();
        $(".vo_destination_famille_chk").click(function() {
            if ($(this).is(":checked")) {
                $(".answer_destination_famille").show();
            } else {
                $(".answer_destination_famille").hide();
            }
        });

        $(".answer_ancien_visa").hide();
        $(".vo_ancien_visa").click(function() {
            if ($(this).is(":checked")) {
                $(".answer_ancien_visa").show();
            } else {
                $(".answer_ancien_visa").hide();
            }
        });

        $(".answer_refus_visa").hide();
        $(".vo_refus_visa_chk").click(function() {
            if ($(this).is(":checked")) {
                $(".answer_refus_visa").show();
            } else {
                $(".answer_refus_visa").hide();
            }
        });

        $(".answer_universite").hide();
        $(".vo_obtention_chk").click(function() {
            if ($(this).is(":checked")) {
                $(".answer_universite").show();
            } else {
                $(".answer_universite").hide();
            }
        });

        $(".answer_activite").hide();
        $(".pc_activite_pro_chk").click(function() {
            if ($(this).is(":checked")) {
                $(".answer_activite").show();
            } else {
                $(".answer_activite").hide();
            }
        });



    });
    $(function() {
        $("#datepicker").datepicker({
            autoclose: true,
            todayHighlight: true,
        }).datepicker('' );

        $("#datepicker_expiration").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('' );

        $("#datepicker_naissance_pere").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('' );

        $("#date_naissance_mere").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('' );


    });
</script>