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


//////////////////////

zip exemple

<?php
            $sourcefolder="C:\wamp\www\yaltester";
           $zipfilename="sampe";

           $zip=new Zip($sourcefolder,$zipfilename);
           $zip->Create();
           $zip->AddFiles(array("index.php","sample.xml"),"sample");
           $zip->AddFolder("sampefolder");

           $zip->ArchiveFolder("sample");

           $zip->ExtractFiles("C:\wamp\www\yaltester\gre");
           $zip->DeleteArchive();
?>