<textarea id="myCode" style="height: 70vh !important;">
<?php echo $code; ?>
</textarea>

<link rel="stylesheet" href="<?php echo base_url('assets/codemirror/lib/codemirror.css'); ?>" />
<script src="<?php echo base_url('assets/codemirror/lib/codemirror.js'); ?>"></script>
<script type="text/javascript">
    window.onload = function() {
        var myTextarea = document.getElementById("myCode");
        editor = CodeMirror.fromTextArea(myTextarea, {
            lineNumbers: true
        });
    };
</script>