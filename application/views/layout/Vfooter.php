
                    </div>
                </div>
                <!--row -->
            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> Website được xây dựng và phát triển bởi &nbsp;<i class="fa fa-heart text-danger"></i>&nbsp; FFC - Tổ phát triển và chuyển giao công nghệ FITHOU </footer>
        </div>
        <!-- End Page Content -->
    </div>
    <!-- End Wrapper -->

    <a id="back2Top" title="Back to top" href="#">
        <i class="ti-angle-double-up"></i>
    </a>

    <!-- Bootstrap Core JavaScript -->
    <script src="{$url}assets/template/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{$url}assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="{$url}assets/template/js/jquery.slimscroll.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{$url}assets/template/js/custom.min.js"></script>
    <script src="{$url}assets/plugins/bower_components/custom-select/custom-select.min.js" type="text/javascript"></script>
    <!-- Custom tab JavaScript -->
    <script src="{$url}assets/template/js/cbpFWTabs.js"></script>
    <script src="{$url}assets/plugins/bower_components/toast-master/js/jquery.toast.js"></script>
    <!--BlockUI Script -->
    <script src="{$url}assets/plugins/bower_components/blockUI/jquery.blockUI.js"></script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="{$url}assets/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- DataTable -->
    <script src="{$url}assets/plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
    <script src="{$url}assets/js/bootstrap-paginator.js"></script>
    <script src="{$url}assets/js/jquery.bootstrap-duallistbox.js"></script>
    <!-- Main js -->
    <script src="{$url}assets/js/main.js"></script>
    
    {if !empty($message)}
    <script type="text/javascript">
        $(document).ready(function() {
            showMessage('{$message.type}', '{$message.msg}');
        });
    </script>
    {/if}
</body>
</html>
