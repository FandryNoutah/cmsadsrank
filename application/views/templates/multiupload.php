<?php echo form_open_multipart('multiupload/do_upload');?>

Userfile<input type="file" name="userfile_1" size="20" />
Userfiles<input type="file" multiple name="userfile[]" size="20" />
<input type="submit" value="upload" />

</form>