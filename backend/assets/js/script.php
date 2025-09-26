<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
<script src="<?= BASE_URL ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?= BASE_URL ?>assets/js/bootstrap/bootstrap.min.js"></script>

<script src="<?= BASE_URL ?>assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?= BASE_URL ?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?= BASE_URL ?>assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="<?= BASE_URL ?>assets/js/hideshow.js" type="text/javascript"></script>
<script src="<?= BASE_URL ?>assets/js/datepickr.js" type="text/javascript"></script>
<!-- date-range-picker -->
<!-- InputMask -->
<?php
//*******************************Impotation des Dependences du pluggins Datatable********************
if (isset($set_pluggin_selection_wise)) { ?>
  <script src="<?= BASE_URL ?>assets/plugins/daterangepicker/moment.min.js"></script>
  <script src="<?= BASE_URL ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
  <script src="<?= BASE_URL ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>

  <!-- Select2 -->
  <script src="<?= BASE_URL ?>assets/plugins/select2/select2.full.min.js"></script>
<script>

  // Below code sets format to the
  // datetimepicker having id as
  // datetime
  $('#datetime_entree').datetimepicker({
    format: 'HH:mm:ss'
  });
  $('#datetime_exit').datetimepicker({
    format: 'HH:mm:ss'
  });
</script>
<script type="text/javascript">
  function ShowLoading(e) {
    var div = document.createElement('div');
    var img = document.createElement('img');

    div.innerHTML = "Transfert des données...<br />";
    div.id = "pop"
    div.style.cssText = 'background-image:url(images/loading2.gif); background-size : auto;  display: block; position: absolute; top: 30%; left: 40%; width: 25%; height: 30%; padding: 16px; border-radius: 5px 5px 5px 5px;   background-color: white; z-index:1002; overflow: auto; transform-style : preserve-3d;';
    div.appendChild(img);
    document.body.appendChild(div);
    return true;
    // These 2 lines cancel form submission, so only use if needed.
    //window.event.cancelBubble = true;
    //e.stopPropagation();
  }
  function HideLoading(e) {
    document.getElementById('pop').style.display = 'none';

    return true;
    // These 2 lines cancel form submission, so only use if needed.
    //window.event.cancelBubble = true;
    //e.stopPropagation();
  }
  function ShowLoading2(e) {
    document.getElementById('submit_box').style.display = 'block';
    document.getElementById('back_page').style.display = 'block';

  }
</script>
<script>
  function selectItemByValue(elmnt, value) {

    for (var i = 0; i < elmnt.options.length; i++) {
      if (elmnt.options[i].value === value) {
        elmnt.selectedIndex = i;
        break;
      }
    }
  }
  function display_pop() {
    setTimeout('real_display()', 1000);
    //hide_pop();

  }
  function real_display() {
    document.getElementById('light').style.display = 'block';
    document.getElementById('fade').style.display = 'block';

  }

  function hide_pop() {
    //document.getElementById('fade').transform='rotateY(180deg)';
    document.getElementById('light').style.display = 'none';
    document.getElementById('fade').style.display = 'none';


  }

  <?php if (isset($_GET['action_tache']) || isset($_GET['action']) || isset($_POST['change_taux']) || isset($_POST['action']) || isset($_POST['btn_action']) || isset($_GET['id_action']) || isset($_GET['set_taux']) || isset($_GET['view_transact']) || isset($_GET['compte']) || isset($_GET['id_parameter'])) {

    ?>

    real_display();

  <?php } ?>  
</script>
  <script>

    $(function () {
      $(".select2").select2();
      //Datemask dd/mm/yyyy

      //Date range picker
      $('#date2').daterangepicker({ format: 'YYYY/MM/DD' });
      $('#date1').daterangepicker({ format: 'YYYY/MM/DD' });
      $('#date3').daterangepicker({ format: 'YYYY/MM/DD' });
      $('#date4').daterangepicker({ format: 'YYYY/MM/DD' });
      $('#date5').datepicker({ format: 'yyyy/mm/dd' });

      $('#date_payment').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true,
        todayHighlight: true // Met en surbrillance la date d'aujourd'hui
      }).datepicker('setDate', new Date()); // Définit la date par défaut sur aujourd'hui



      //Date range picker with time picker
    });
  </script>

  <?php
}

?>
<script>
  $(function () {

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("dd/mm/yyyy", { "placeholder": "dd/mm/yyyy" });
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("mm/dd/yyyy", { "placeholder": "mm/dd/yyyy" });
    //Money Euro
    $("[data-mask]").inputmask();

  });
</script>
<!-- AdminLTE App -->

<?php
//*******************************Impotation des Dependences du pluggins Datatable********************
$requirement_datatable = (isset($set_pluggin_datatable)) ? '<!-- DataTables -->
    <script src="<?= BASE_URL ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= BASE_URL ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="<?= BASE_URL ?>assets/js/export_to_csv.js"></script>
    <!-- SlimScroll -->
    <script src="<?= BASE_URL ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?= BASE_URL ?>assets/plugins/fastclick/fastclick.min.js"></script><script>
      $(function () {
        $("#example1").DataTable();
		$("#example3").DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
		  "aLengthMenu": [ 10, 25, 50, 100, 500, 1000, 1500, 2000, 3000, 4000, 5000, 10000, 20000 ],
		  "bProcessing": true,
          "autoWidth": true
        });
        $("#example2").DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
		  "aLengthMenu": [ 10, 25, 50, 100, 500, 1000, 1500, 2000, 3000, 4000, 5000, 10000, 20000 ],
		  "bProcessing": true,
          "autoWidth": true
        });
        $("#example5").DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": false,
          "info": true,
		  "aLengthMenu": [ 10, 25, 50, 100, 500, 1000, 1500, 2000, 3000, 4000, 5000, 10000, 20000 ],
		  "bProcessing": true,
          "autoWidth": true
        });
		 $("#example4").DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
    </script>' : "";
echo $requirement_datatable;
?>
<script src="<?= BASE_URL ?>assets/js/app.min.js"></script>
<script src="<?= BASE_URL ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
  $(function () {

    //bootstrap WYSIHTML5 - text editor
    $("#zone").wysihtml5();
  });
</script>