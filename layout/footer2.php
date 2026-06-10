<!-- bootstrap js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- asset plugin datatables -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<!-- load fontawesome with cdn -->
<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"
integrity="sha384-rOA1PnstxnOBlcLMcre8ywbwmemjzdNlILg807zlUiXozs4OHonlDtnE7fpc"
crossorigin="anonymous"></script>

<!-- load ckeditor cdn -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.22.1/ckeditor.js"></script>

<script>
if (document.getElementById('alamat')) {
    CKEDITOR.replace('alamat', {
        filebrowserBrowseUrl: 'assets/ckfinder_php_3.7.1/ckfinder/ckfinder.html',
        filebrowserUploadUrl: 'assets/ckfinder_php_3.7.1/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        height: '400px'
    });
}
</script>

<script>
  $(document).ready(function() {
    $('#table').DataTable();
  });
</script>

</body>
</html>