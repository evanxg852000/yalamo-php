<form name="myform" action="http://localhost/Framework/" method="post" enctype="multipart/form-data">
						<label for="filemyfile0">File:</label>
						<input name="file1" id="filemyfile" class="inputbox" type="file" />
						<label for="filemyfile">File:</label>
						<input name="file1" id="filemyfile" class="inputbox" type="file"/>
						<input name="btnSubmit" value="Submit" class="button" type="submit"/>
					</form>
<?php

$target="C:\wamp\www\Performance\\";
    $f=new File($target);
    $f->Upload(array("text/plain"));
    print_r($f->UploadedFiles());
?>


//////////////////////

zip exemple

<?php
            $sourcefolder="C:\wamp\www\yaltester";
           $zipfilename="u";

           $zip=new Zip($sourcefolder,$zipfilename);
           //$zip->Create();
           //$zip->AddFiles(array("sync.php","gre.xml"),"u");
           //$zip->AddFolder("sampefolder");

           //$zip->ArchiveFolder("u");

          // $zip->ExtractFiles("C:\wamp\www\yaltester\gre");
          $zip->DeleteArchive();


           $i=  Inspector::Instance();
           $i->Investigate(true);



?>

//exemple Pagination
   $l=new Loader();
        $l->Extension("Paginator");
        Paginator::$Configuration=array(
            "ItemPerPage"=>10,
            "Class"=>"pagination",
            "Previous"=>array("Text"=>"« Previous","Class"=>"previous"),
            "Next"=>array("Text"=>"Next »","Class"=>'next'),
            "Current"=>array("Class"=>"current"),
            "Desable"=>array("Class"=>"off")
        );
        $p=new Paginator();
        $p->Render(38,"/test/page/");