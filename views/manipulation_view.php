<html>
<head>
    <title>Upload Form</title>
</head>
<body>
    <?php echo $error; ?>
    <?php echo form_open_multipart('Upload_file/do_upload');?> <!-- action: -->
    <input type='file' name='userfile' size='20' /><br /><br />
    <input type='submit' value = 'upload' />
    </form>

    <form action="<?php echo base_url('zip/download')?>">
        <input type='submit' value="Download processed images"/>
    </form>
</body>
</html>