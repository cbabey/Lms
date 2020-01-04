<?php
//My first program in php
/*echo "My name is <br> <b> Kavindu Randika Rathnayaka....!</b>";

*/
$jObject=[];
class bigFile{

    function bigFile(){
		require_once 'Classes/PHPExcel.php';
		$excel = PHPExcel_IOFactory::load('GPA Calculator.xlsx');
			$excel2 = PHPExcel_IOFactory::load('YEAR1 RESULTS.xlsx');
			$excel -> setActiveSheetIndex(0);
		
		
	echo "<Table>";
	$i = 1;
	while ($excel -> getActiveSheet() -> getCell('A'.$i) -> getValue() != "")
	{
		
	$Index_No[$i-1] = $excel -> getActiveSheet() -> getCell('A'.$i) -> getValue();
	$Subject[0][$i-1] = $excel -> getActiveSheet() -> getCell('B'.$i) -> getValue();
	$Subject[1][$i-1] = $excel -> getActiveSheet() -> getCell('D'.$i) -> getValue();
	$Subject[2][$i-1] = $excel -> getActiveSheet() -> getCell('F'.$i) -> getValue();
	$Subject[3][$i-1] = $excel -> getActiveSheet() -> getCell('H'.$i) -> getValue();
	$Subject[4][$i-1] = $excel -> getActiveSheet() -> getCell('J'.$i) -> getValue();
	$Subject[5][$i-1] = $excel -> getActiveSheet() -> getCell('L'.$i) -> getValue();
	$Subject[6][$i-1] = $excel -> getActiveSheet() -> getCell('N'.$i) -> getValue();
	$i++;
	}
	
	
	$i2 = 1;
	while ($excel2 -> getActiveSheet() -> getCell('A'.$i2) -> getValue() != "")
	{
	$Index_No2[$i2-1] = $excel2 -> getActiveSheet() -> getCell('A'.$i2) -> getValue();
	$Subject2[0][$i2-1] = $excel2 -> getActiveSheet() -> getCell('B'.$i2) -> getValue();
	$Subject2[1][$i2-1] = $excel2 -> getActiveSheet() -> getCell('D'.$i2) -> getValue();
	$Subject2[2][$i2-1] = $excel2 -> getActiveSheet() -> getCell('F'.$i2) -> getValue();
	$Subject2[3][$i2-1] = $excel2 -> getActiveSheet() -> getCell('H'.$i2) -> getValue();
	$Subject2[4][$i2-1] = $excel2 -> getActiveSheet() -> getCell('J'.$i2) -> getValue();
	$Subject2[5][$i2-1] = $excel2 -> getActiveSheet() -> getCell('L'.$i2) -> getValue();
	//$Subject2[6][$i-1] = $excel2 -> getActiveSheet() -> getCell('N'.$i) -> getValue();
	$i2++;
	}
	echo "</Table>";
	
	$Index = 93;
	
	$credits = array(3,3,2,2,2,2,2);
	$credits2 = array(3,2,3,3,3,3);
	$temp = array('a+' => 4, 'a' => 4, 'a-' => 3.7, 'b+' => 3.3, 'b' => 3.0, 'b-' => 2.7, 'c+' => 2.3, 'c' => 2.0);
	$temp2 = array('A+' => 4, 'A' => 4, 'A-' => 3.7, 'B+' => 3.3, 'B' => 3.0, 'B-' => 2.7, 'C+' => 2.3, 'C' => 2.0);
	$keys = array_keys($temp); 
	$value = count($temp);
	$Ttl_credits = 0;
	$keys2 = array_keys($temp2); 
	$value2 = count($temp2);
	$Ttl_credits2 = 0;
	for ($k=0; $k < sizeof($credits); $k++) { 
	$Ttl_credits += $credits[$k]; 
	}
	for ($k=0; $k < sizeof($credits2); $k++) { 
	$Ttl_credits2 += $credits2[$k]; 
	}
	
	
	
	$gpaarry=[];
	$gpaarry2=[];
	for($j=1;$j<$i-1;$j++){
	$Res_GPA = 0;
	for ($Subj=0; $Subj < 7; $Subj++) { 
	for ($m=0; $m < 8; $m++) {
	if ($Subject[$Subj][$j] == $keys[$m]) {
		
	$Res_GPA += $temp[$keys[$m]]*$credits[$Subj];
	}
	}
	}
	$gpaarry[ $Index_No[$j]]=$Res_GPA;
	}
	for($j2=1;$j2<$i2-1;$j2++){
			
	$Res_GPA2 = 0;
	for ($Subj2=0; $Subj2 < 6; $Subj2++) { 
	for ($m2=0; $m2 < 8; $m2++) {
	
		
	
	if ($Subject2[$Subj2][$j2] == $keys2[$m2]) {
		
	$Res_GPA2 += $temp2[$keys2[$m2]]*$credits2[$Subj2];
	}
	}
	}
	$gpaarry2[ $Index_No2[$j2]]=$Res_GPA2;
	}
	
	
	$totalcredits =$Ttl_credits+ $Ttl_credits2;
	$finalarry=[];
	
	
	
	foreach($gpaarry as $x => $x_value) {
		   $temp=$gpaarry2[$x]+$gpaarry[$x];
		   $temp/=$totalcredits;
			  $finalarry[$x]  =$temp; 
	}
	  echo "<br>";
		echo "<br>";  echo "<br>";
		
		arsort($finalarry);
		
		$rankarry=[];
		
	/*
		foreach($finalarry as $x => $x_value) {
			  echo "Key=" . $x . ", Value=" . $x_value;
			  echo "<br>";
	}
	*/
		$counter=1;
		foreach($finalarry as $x => $x_value) {
			  $rankarry[$x]=$counter++;
	}
	
	writeMsg($finalarry,$rankarry,1,$Subject2,$Subject,$gpaarry,$gpaarry2);
	

	  }
	

	
	//$excel2 -> setActiveSheetIndex(0);
	
	 Public function writeMsg($gpaarry,$inputAtty,$index,$Subject2,$Subject,$gpaarryk,$gpaarry2k) {
		echo "your GPA is $gpaarry[$index]  and the rank is ".$inputAtty[$index];echo nl2br("\r");
		echo "first Sem Results==>".$gpaarryk[$index]/16;
		echo nl2br("\r");
		echo "Mathematics I	".$Subject[0][$index];
		echo nl2br("\r");
		echo "Mechanics ".$Subject[1][$index];
		echo nl2br("\r");
		echo "Elec ".$Subject[2][$index];
		echo nl2br("\r");
		echo "Material	".$Subject[3][$index];
		echo nl2br("\r");
		echo "Measurment	".$Subject[4][$index];echo nl2br("\r");
		echo "Comp	".$Subject[5][$index];echo nl2br("\r");
		echo "Thermo	".$Subject[6][$index];
		echo nl2br("\r");
		echo nl2br("\r");
		echo nl2br("\r");
		echo "second Sem Results ==>".$gpaarry2k[$index]/17;
		echo nl2br("\r");
		echo "Mathematics II	".$Subject2[0][$index];
		echo nl2br("\r");
		echo "Fluid Mechanics ".$Subject2[1][$index];
		echo nl2br("\r");
		echo "Drawing	".$Subject2[2][$index];
		echo nl2br("\r");
		echo "Electronics	".$Subject2[3][$index];
		echo nl2br("\r");
		echo "Programming	".$Subject2[4][$index];echo nl2br("\r");
		echo "Manufacturing	 ".$Subject2[5][$index];
	
		$jObject=json([
			'sem1'=>$gpaarryk[$index]/16,
			'Mathematics I'=>$Subject[0][$index],
			'Mechanics '=>$Subject[1][$index],
			'Elec '=>$Subject[2][$index],
			'Material	'=>$Subject[3][$index],
			'Measurment	'=>$Subject[4][$index],
			'Comp	'=>$Subject[5][$index],
			'Thermo	'=>$Subject[6][$index],
			'sem2'=>$gpaarry2k[$index]/17,
		
			'Mathematics II	'=>$Subject2[0][$index],
		
			'Fluid Mechanics '=>$Subject2[1][$index],
		
			'Drawing	'=>$Subject2[2][$index],
	
			'Electronics	'=>$Subject2[3][$index],
	
			'Programming	'=>$Subject2[4][$index],
			'Manufacturing	 '=>$Subject2[5][$index]
	
	
			
		]);
	
	}

	public function getJson(){
		return  $jObject;
	}
	
};
?>
