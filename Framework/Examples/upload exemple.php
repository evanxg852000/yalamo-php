<form name="myform" action="http://localhost/Framework/" method="post" enctype="multipart/form-data">
						<label for="filemyfile0">File:</label>
						<input name="file[]" id="filemyfile" class="inputbox" type="file" />
						<label for="filemyfile">File:</label>
						<input name="file[]" id="filemyfile" class="inputbox" type="file"/>
						<input name="btnSubmit" value="Submit" class="button" type="submit"/>
					</form>
<?php

$target="C:\wamp\www\yaltester\\";

           $f=new File($target);
           echo $f->Upload($_FILES);
?>
