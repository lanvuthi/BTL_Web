<script type="text/javascript">


    $('#bell').click((e) => {
        $('.notification').toggle();
    });

    $(function () {
        $('#deadline_at').datetimepicker({
            format: 'Y/M/d H:m:s',
            locale: moment.locale('vi'),
            showTodayButton: true
        });
        //
        // $('.datepicker').datepicker({
        //     autoclose: true,
        //     todayHighlight: true
        // }).datepicker('update', new Date());

        $('[name="birthday"]').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        }).datepicker();

    });


</script>

</body>
</html>
