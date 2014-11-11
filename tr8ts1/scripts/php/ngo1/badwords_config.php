<?php 
			//$filename='/data/ngo1_gi/docs/static/cusswords.txt';
			$filename =$argv[1];
			$file_handle = @fopen($filename,"rb")or die("can't open file");
			if($file_handle){
				
				while(!feof($file_handle)){
					$list[] = trim(fgets($file_handle));	
				}
				@fclose($file_handle);
			}
			
			$stringData = "<?php\n";
			$stringData .= "\$badlist=array(";
			$numlist = count($list);
			$lastnum = $numlist-1;
			for($i=0;$i<$numlist;$i++){
				if($i==$lastnum){
					$arraydata .= "'".$list[$i]."'";
				}else{
					$arraydata .= "'".$list[$i]."',";
				}
			}
			$stringData .= $arraydata;
			$stringData .= ");\n";
			$stringData .= "?>\n";
			
			//$myFile = "testarray.php";
			$myFile = $argv[2];
			$fh = @fopen($myFile, 'w') or die("can't open file");
			fwrite($fh, $stringData);
			fclose($fh);
			echo "Created ".$argv[2]." file\n";

?>