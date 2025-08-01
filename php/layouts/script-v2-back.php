<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="back/assets/vendor/libs/jquery/jquery.js"></script>
<script src="back/assets/vendor/libs/popper/popper.js"></script>
<script src="back/assets/vendor/js/bootstrap.js"></script>
<script src="back/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="back/assets/vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- Vendors JS -->

<!-- Main JS -->
<script src="back/assets/js/main.js"></script>


<!-- Page JS -->

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>


<script src="back/assets/vendor/js/test.js"></script>

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