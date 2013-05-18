<?php
$dir = getcwd();
$dir = str_replace("\\", "/", $dir);
$i=-1;

   $i++;
   if($checkDir = opendir($dir)){
       $cDir = 0;

       while($file = readdir($checkDir)){
           if($file != "." && $file != ".."){
               if(is_dir($dir . "/" . $file)){
                   $listDir[$cDir] = $file;
                   $cDir++;
               }
           }
       }

	print("&a=0<br>&nbgaleries=$cDir");

       if(count($listDir) > 0){
           sort($listDir);
           for($j = 0; $j < count($listDir); $j++){
                   $spacer = "";
                   for($l = 0; $l < $i; $l++) $spacer .= "&emsp;";
                   
		   $jb=$j+1;
			
                   print("&a=0<br>&nom".$jb."=".$listDir[$j]);

// lectures fichiers
$dir2 = $dir . "/" . $listDir[$j];
$dir2 = str_replace("\\", "/", $dir2);
$i2=-1;
unset($listFile2);
   $i2++;
   if($checkDir2 = opendir($dir2)){
       $cFile2 = 0;
       while($file2 = readdir($checkDir2)){
           if($file2 != "." && $file2 != ".."){
               if(is_dir($dir2 . "/" . $file2)){
               }
               else{
		$fin = substr($file2, -3);
		$fin=strtoupper($fin);
		if($fin == "JPG" || $fin == "SWF"){   
                   $listFile2[$cFile2] = $file2;
		   $cFile2++;
		}
               }
           }
       }

       $nbcFile2 = 0;
       $nbpfFile2 = 0;	

       if(count($listFile2) > 0){

           sort($listFile2);
           for($j2 = 0; $j2 < count($listFile2); $j2++){

                   $spacer = "";
                   for($l2 = 0; $l2 < $i2; $l2++) $spacer .= "&emsp;";
                   
		   //$jb2=$j2+1;
			

		   if((substr($listFile2[$j2], -6, -4) != '_t') and (substr($listFile2[$j2], -6, -4) != '_T')){
		      $nbcFile2++;
                      print("&a=0<br>&photo".$jb."_".$nbcFile2."=".$listFile2[$j2]);
		      

		   }else{
		      $nbpfFile2++;
                      print("&a=0<br>&photopt".$jb."_".$nbpfFile2."=".$listFile2[$j2]);

		   }


		
           }
       }

       print("&a=0<br>&nbphotos".$jb."=$nbcFile2");

       closedir($checkDir2);
   }   
           }
       }
        closedir($checkDir);
   }
print("&a=0<br>&faux=4");
?> 
