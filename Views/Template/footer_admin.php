</div>
                </div>
            </main>
        </div>
    </div>   
   
   
   <script>
        const base_url = "<?= base_url(); ?>";
    </script>
    <!-- Essential javascripts for application to work-->
    <script src="<?= media(); ?>/js/plugins/jquery-3.7.0.js"></script>
    <script src="<?= media(); ?>/js/plugins/bootstrap.bundle.min.js"></script>
    <script src="<?=media()?>/js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="<?= media();?>/js/plugins/script.js"></script>

    <!-- sweetalert2@11 plugins-->
    <script type="text/javascript" src="<?= media();?>/js/plugins/sweetalert2@11.js"></script>

    <!-- Data table plugin-->
    <script type="text/javascript" src="<?= media(); ?>/js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?= media(); ?>/js/plugins/dataTables.bootstrap5.min.js"></script>

    <script type="text/javascript" src="<?= media(); ?>/js/plugins/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="<?= media(); ?>/js/plugins/buttons.bootstrap5.min.js"></script>
    <script type="text/javascript" src="<?= media(); ?>/js/plugins/jszip.min.js"></script>
    <script type="text/javascript" src="<?= media(); ?>/js/plugins/pdfmake.min.js"></script>
    <script type="text/javascript" src="<?= media(); ?>/js/plugins/vfs_fonts.js"></script>
    <script type="text/javascript" src="<?= media(); ?>/js/plugins/buttons.html5.min.js"></script>

 
    <!-- <script type="text/javascript" src="<?= media();?>/js/plugins/functions_admin.js"></script> -->
    <script src="<?= media(); ?>/js/<?= $data['page_functions_js']; ?>"></script>
  </body>
</html>