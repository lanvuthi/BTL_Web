<script type="text/javascript">
    $(function () {
        $('.datepicker').datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('update', new Date());

        $('[name="birthday"]').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        }).datepicker();

    });


</script>

</body>
</html>
