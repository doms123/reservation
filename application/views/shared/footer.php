      <footer class="main-footer no-print">
        <strong>Copyright &copy; 2019 <a href="https://hacienda-galea.netlify.com/" target="_blank">Hacienda Galea</a>.</strong> All rights reserved.
      </footer>
    </div>

    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/fastclick.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/dataTables.bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/adminlte.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/dropzone.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/toast.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap-datepicker.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/moment.js');?>"></script>
    <script src="<?php echo base_url('assets/js/fullcalendar.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/quill.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/select2.full.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/script.js'); ?>"></script>

    <script>
      // Prevent right click
      document.addEventListener('contextmenu', event => event.preventDefault());

      $(document).keydown(function (event) {
          if (event.keyCode == 123) { // Prevent F12
              return false;
          } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I        
              return false;
          }
      });
    </script>
  </body>
</html>