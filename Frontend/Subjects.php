 <?php
$name =  $_POST["name"];
$check = strlen($name)+1;
if ($check < 2){
	echo "Invalid Request";
	die();
	}
$email =  $_POST["email"];
$cat = $_POST["cat"];
$sub1 = $_POST["sub1"];
$subjects = array($_POST["sub1"],$_POST["sub2"],$_POST["sub3"],$_POST["sub4"],$_POST["sub5"],$_POST["sub6"]);
$theory = array($_POST["tm1"],$_POST["tm2"],$_POST["tm3"],$_POST["tm4"],$_POST["tm5"],$_POST["tm6"]);
$prac = array($_POST["pm1"],$_POST["pm2"],$_POST["pm3"],$_POST["pm4"],$_POST["pm5"],$_POST["pm6"]);
$max = array($_POST["mm1"],$_POST["mm2"],$_POST["mm3"],$_POST["mm4"],$_POST["mm5"],$_POST["mm6"]);
$marks = array(0,0,0,0,0,0);
$subcount = 0;
$subcodes = array(0,0,0,0,0,0);
$fcat = array("Unreserved", "OBC", "SC", "ST", "PwD", "Kashimiri Migrants", "Sikh Minority", "Nominated by Sikkim Govt");
$fsubs = array('Nil','Accountancy' ,'Anthropology' ,'Arabic' ,'Assamese' ,'Bengali' ,'Biochemistry' ,'Biology' ,'Biotechnology' ,'Bodo' ,'Business Mathematics' ,'Business Studies' ,'Chemistry' ,'Civics' ,'Commerce' ,'Computer Applications' ,'Computer Science' ,'Dogri' ,'Economics' ,'English' ,'French' ,'Geoglogy' ,'Geography' ,'German' ,'Gujrati' ,'Hindi' ,'History' ,'Home Science' ,'Informatics Practices' ,'Italian' ,'Kannada' ,'Kashimiri' ,'Konkani' ,'Legal Studies' ,'Logic and Philosopy' ,'Maithili' ,'Malyalam' ,'Manipuri' ,'Marathi' ,'Mathematics' ,'Nepali' ,'Odia' ,'Philosophy' ,'Physics' ,'Political Science' ,'Psycology' ,'Punjabi' ,'Sanskrit' ,'Santhali' ,'Sindhi' ,'Sociology' ,'Spanish' ,'Statistics' ,'Tamil' ,'Telegu' ,'Urdu' ,'Other');
$category = $fcat[$cat-1];
for ($x = 0; $x <= 5; $x++) {
	if ($subjects[$x] != 0) {
		if (is_numeric($prac[$x]) && is_numeric($theory[$x]) && is_numeric($max[$x])) {
			$cent = (($prac[$x] + $theory[$x])*100) / $max[$x];
			$subcount++;
			if ($cent > 100) {
				echo "Marks obtained cannot be higher than maximum marks.";
				die();
				}
			if ($subjects[$x]==56){
				$marks[$x] = $cent - 2.5;
			} else {
				$marks[$x] = $cent;
			}
		
			if (in_array($subjects[$x], $subcodes)) {
				echo "You cannot select 2 same subjects.";
				die();
			} else {
				$subcodes[$x] = $subjects[$x];
			}
		} else {
			echo "Please enter your marks correctly. <BR>Please fill all three columns of marks (Theory, Practical, Maximum). If your subject does not have a Practical, put 0 in Practical Marks' field.";
			die();
		}
	}
}
if ($subcount < 5){
	echo "You have selected less than 5 subjects";
	die();
	}

$username = "1162174";
$password = "du1234";
$host = "localhost";
$dbname = "1162174";

$conn = new mysqli($host, $username, $password, $dbname);
$xname = "'" . $name . "'";
$xemail = "'" . $email . "'";
$xcat = "'" . $cat . "'";
$xsub = "'" . implode(" ",$subjects) . "'";
$xmar = "'" . implode(" ",$marks) . "'";
$sql = "INSERT INTO searches (name, email, cat, sub, marks)
VALUES ($xname,$xemail,$xcat, $xsub, $xmar)";
if ($conn->query($sql) === TRUE) {
} else {
}
$conn->close();
$gp = "&nbsp;";
$displaysub = "<TR><TD>Subjects : </TD><TD>" . $gp . $gp . $gp . $gp;
$sno = 1;
for ($x = 0; $x <= 5; $x++) {
	if ($subcodes[$x] != 0){
			$tempsub = $fsubs[$subcodes[$x]];
			$tempmarks = $marks[$x];
			if ($x == 0 || $x == 2 || $x == 4) {
			$displaysub = $displaysub . "$sno" . ") " . "$tempsub" . "</TD><TD>". $gp.$gp." : " . "$tempmarks" . " % </TD><TD>" . $gp . $gp . $gp . $gp;
			} elseif ($x == 5){
				$displaysub = $displaysub . "$sno" . ") " . "$tempsub" . "</TD><TD>". $gp.$gp." : " . "$tempmarks" . " % </TD></TR>";
			} elseif ($x == 1 || $x == 3 ) {
			$displaysub = $displaysub . "$sno" . ") " . "$tempsub" . "</TD><TD>". $gp.$gp." : " . "$tempmarks" . " % </TD></TR><TR><TD> </TD><TD>" . $gp . $gp . $gp . $gp;	
				}
			$sno ++;
		}
}
$nm44 = array();
$mx44 = array();
$dx44 = array();
/*
Checking Subjects Criteria
*/
function bestoffour($marksxq, $pen, $max, $best, $penalty) {
	$penmarks = array();
	$goodmarks = array();
	$markst = $marksxq;
	$penst = $pen;
	for ($m = 0; $m < sizeof($marksxq); $m++){
		if ($pen[$m] > 0){
			array_push($penmarks,$marksxq[$m]);
		} else {
			array_push($goodmarks,$marksxq[$m]);
		}
	}
	sort($penmarks);
	sort($goodmarks);
	$finalout = array();
	$res = 0;

	if (sizeof($penmarks)<1){
		$finalout = $goodmarks;
		sort($finalout);
		for ($send = 1; $send < $best; $send++){
			$res = $res + $finalout[sizeof($finalout)-$send];		
		}
	} elseif (sizeof($goodmarks)<1){
		$finalout = $penmarks;
		sort($finalout);
		for ($send = 1; $send < $best; $send++){
			$res = $res + $finalout[sizeof($finalout)-$send];
		}
	$res = $res - ($max*$best);
	} else {
		$test = 0;	
		while($test < 1) {
				for ($p = 0; $p < sizeof($markst); $p++) {
					if (($p == sizeof($markst) - 1) && ($markst[$p] < $markst[$p-1])) {
						$test = 1;		
					} else {
						if ($markst[$p] < $markst[$p+1]){
							$tpp = $markst[$p];
							$tppx = $penst[$p];
							$markst[$p] = $markst[$p+1];
							$penst[$p] = $penst[$p+1];
							$markst[$p+1] = $tpp;
							$penst[$p+1] = $tppx;
							break;
						}				
					}
				}
		}
		$tempmax = $max;
		for ($mx = 0; $mx < sizeof($markst); $mx++){
			if ($penst[$mx] == 1) {
				if ($tempmax > 0) {
					$markst[$mx] = $markst[$mx] - ($best*$penalty);
					$tempmax = $tempmax - 1;
				} else {
					$penst[$mx] = 2;				
				}
			}
		}
		$test = 0;	
		while($test < 1) {
				for ($p = 0; $p < sizeof($markst); $p++) {
					if (($p == sizeof($markst) - 1) && ($markst[$p] < $markst[$p-1])) {
						$test = 1;		
					} else {
						if (($markst[$p] < $markst[$p+1]) && ($penst[$p] >= $penst[$p+1])){
							$tpp = $markst[$p];
							$tppx = $penst[$p];
							$markst[$p] = $markst[$p+1];
							$penst[$p] = $penst[$p+1];
							$markst[$p+1] = $tpp;
							$penst[$p+1] = $tppx;
							break;
						} elseif (($markst[$p] == $markst[$p+1]) && ($penst[$p] > $penst[$p+1])){	
							$tpp = $markst[$p];
							$tppx = $penst[$p];
							$markst[$p] = $markst[$p+1];
							$penst[$p] = $penst[$p+1];
							$markst[$p+1] = $tpp;
							$penst[$p+1] = $tppx;
							break;
						}			
					}
				}
		}
		for ($send = 0; $send < $best-1; $send++){
			$res = $res + $markst[$send];
		}		 
	}
	return $res;
}
$nextdeets = "<input type='text' name='name' hidden value='".$name."'><input type='text' name='category' hidden value='".$category."'><input type='text' name='displaysub' hidden value='".$displaysub."'>";
$lista = array(3,4,5,9,17,19,20,23,24,25,29,30,31,32,35,36,37,38,40,41,46,47,48,49,51,53,54,55);
$listall = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55);
$nonesorry = "No courses are available with the provided combination of Subjects and Marks.";
$langsubs = 0;		
		for ($x = 0; $x <= 5; $x++) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
							$langsubs++;
					}
				}
		}
if ($langsubs>2){
	echo "The Applicant cannot include more than 2 language subjects.";
	die();
	}
/*
1) English Hons.
*/
if (in_array(19, $subjects)) {
	$key = array_search(19, $subjects);
	$marks19 = $marks[$key];
	if ($marks19 > 33){
		$pen19 = array();
		$englishlist = array(18,22,26,33,39,42,44,45,50);
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
							array_push($pen19,0);
						}
					}
				}
			}
		}
		if (sizeof($bof) > 2) {
		$bofm = bestoffour($bof, $pen19,0,4,1);
		$bofp = ($marks19 + $bofm)/4;
		$bofp = sprintf('%0.2f', $bofp);
		if ($bofp > 44) {
		$out4 = "<TR><TD><input type='checkbox' name='r4'></TD><TD>&nbsp; B.A. (Hons) English </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m4' hidden value='".strval($bofp)."'></TD></TR>"; 
		array_push($nm44,$out4); array_push($mx44,$bofp); array_push($dx44,0); $nonesorry = "";} else { $out4 = ""; } }
	}
}
/*
2) Hindi Hons.
*/
if (in_array(25, $subjects)) {
	$key = array_search(25, $subjects);
	$marks19 = $marks[$key];
	if ($marks19 > 49){
		$pen19 = array();
		$englishlist = array();
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
							array_push($pen19,0);
						}
					}
				}
			}
		}
		if (sizeof($bof) > 2) {
		$bofm = bestoffour($bof, $pen19,0,4,1);
		$bofp = ($marks19 + $bofm)/4;
		$bofp = sprintf('%0.2f', $bofp);
		if ($bofp > 44) {
		$out8 = "<TR><TD><input type='checkbox' name='r8'></TD><TD>&nbsp; B.A. (Hons) Hindi </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m8' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out8); array_push($mx44,$bofp); array_push($dx44,0);$nonesorry = "";} else  { $out8 = ""; }}
	}
}
/*
3) Bengali Hons.
*/
if (in_array(5, $subjects)) {
	$key = array_search(5, $subjects);
	$marks19 = $marks[$key];
	$deduct = -2;
} else {
		$key = 7;
		$langsubs = array();		
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}		
		sort($langsubs);		
		if (sizeof($langsubs)>0){
			$marks19 = $langsubs[sizeof($langsubs)-1];
			$deduct = 5;
		} else {
			$marks19 = 10;
		}
}	
	if ($marks19 > 49){
		$pen19 = array();
		$englishlist = array();
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
							array_push($pen19,0);
						}
					}
				}
			}
		}
		sort($bof);
		if (sizeof($bof) > 2) {
		$bofm = $marks19 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2] + $bof[sizeof($bof)-3];
		$bofp = ($bofm/4)-$deduct;
		$bofp = sprintf('%0.2f', $bofp);
		if ($bofp > 44) {
		$out2 = "<TR><TD><input type='checkbox' name='r2'></TD><TD>&nbsp; B.A. (Hons) Bengali </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m2' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out2); array_push($mx44,$bofp); array_push($dx44,$deduct);$nonesorry = "";}
		}
}
/*
4) Punjabi Hons.
*/
if (in_array(46, $subjects)) {
	$key = array_search(46, $subjects);
	$marks19 = $marks[$key];
	$deduct = -2;
} else {
		$key = 7;
		$langsubs = array();		
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}		
		sort($langsubs);		
		if (sizeof($langsubs)>0){
			$marks19 = $langsubs[sizeof($langsubs)-1];
			$deduct = 5;
		} else {
			$marks19 = 10;
		}
}	
	if ($marks19 > 49){
		$pen19 = array();
		$englishlist = array();
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
							array_push($pen19,0);
						}
					}
				}
			}
		}
		sort($bof);
		if (sizeof($bof) > 2) {
		$bofm = $marks19 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2] + $bof[sizeof($bof)-3];
		$bofp = ($bofm/4)-$deduct;
		$bofp = sprintf('%0.2f', $bofp);
		if ($bofp > 44) {
		$out17 = "<TR><TD><input type='checkbox' name='r17'></TD><TD>&nbsp; B.A. (Hons) Punjabi </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m17' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out17); array_push($mx44,$bofp); array_push($dx44,$deduct);$nonesorry = "";} else  { $out17 = ""; }
	}
}
/*
5) Sanskrit Hons.
*/
if (in_array(47, $subjects)) {
	$key = array_search(47, $subjects);
	$marks19 = $marks[$key];
	$deduct = -2;
} else {
		$key = 7;
		$langsubs = array();		
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}		
		sort($langsubs);		
		if (sizeof($langsubs)>0){
			$marks19 = $langsubs[sizeof($langsubs)-1];
			$deduct = 5;
		} else {
			$marks19 = 10;
		}
}	
	if ($marks19 > 49){
		$pen19 = array();
		$englishlist = array();
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
							array_push($pen19,0);
						}
					}
				}
			}
		}
		sort($bof);
		if (sizeof($bof) > 2) {
		$bofm = $marks19 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2] + $bof[sizeof($bof)-3];
		$bofp = ($bofm/4)-$deduct;
		$bofp = sprintf('%0.2f', $bofp);
		if ($bofp > 44) {
		$out18 = "<TR><TD><input type='checkbox' name='r18'></TD><TD>&nbsp; B.A. (Hons) Sanskrit </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m18' hidden value='".strval($bofp)."'></TD></TR>";  array_push($nm44,$out18); array_push($mx44,$bofp); array_push($dx44,$deduct);$nonesorry = "";} else { $out18 = ""; }
	}
}
/*
6) Urdu Hons.
*/
if (in_array(55, $subjects)) {
	$key = array_search(55, $subjects);
	$marks19 = $marks[$key];
	$deduct = -2;
} else {
		$key = 7;
		$langsubs = array();		
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}		
		sort($langsubs);		
		if (sizeof($langsubs)>0){
			$marks19 = $langsubs[sizeof($langsubs)-1];
			$deduct = 5;
		} else {
			$marks19 = 10;
		}
}	
	if ($marks19 > 49){
		$pen19 = array();
		$englishlist = array();
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
							array_push($pen19,0);
						}
					}
				}
			}
		}
		sort($bof);
		if (sizeof($bof) > 2) {
		$bofm = $marks19 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2] + $bof[sizeof($bof)-3];
		$bofp = ($bofm/4)-$deduct;
		$bofp = sprintf('%0.2f', $bofp);
		if ($bofp > 44) {
		$out22 = "<TR><TD><input type='checkbox' name='r22'></TD><TD>&nbsp; B.A. (Hons) Urdu </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m22' hidden value='".strval($bofp)."'></TD></TR>";  array_push($nm44,$out22); array_push($mx44,$bofp); array_push($dx44,$deduct);$nonesorry = "";} else { $out22 = ""; }
	}
}
/*
7) Arabic Hons.
*/
if (in_array(3, $subjects)) {
	$key = array_search(3, $subjects);
	$marks19 = $marks[$key];
	$deduct = -2;
} else {
		$key = 7;
		$langsubs = array();		
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}		
		sort($langsubs);		
		if (sizeof($langsubs)>0){
			$marks19 = $langsubs[sizeof($langsubs)-1];
			$deduct = 5;
		} else {
			$marks19 = 10;
		}
}	
	if ($marks19 > 49){
		$pen19 = array();
		$englishlist = array();
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
							array_push($pen19,0);
						}
					}
				}
			}
		}
		sort($bof);
		if (sizeof($bof) > 2) {
		$bofm = $marks19 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2] + $bof[sizeof($bof)-3];
		$bofp = ($bofm/4)-$deduct;
		$bofp = sprintf('%0.2f', $bofp);
		if ($bofp > 44) {
		$out23 = "<TR><TD><input type='checkbox' name='r23'></TD><TD>&nbsp; B.A. (Hons) Arabic </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m23' hidden value='".strval($bofp)."'></TD></TR>"; 
		 array_push($nm44,$out23); array_push($mx44,$bofp); array_push($dx44,$deduct);$nonesorry = "";} else { $out23 = "";}
	}
}
/*
8) French Hons.
*/
$subccc = 20;
if (in_array($subccc, $subjects)) {
	$key = array_search($subccc, $subjects);
	$marks19 = $marks[$key];
	$deduct = -2;
} else {
		$key = 7;
		$langsubs = array();		
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}		
		sort($langsubs);		
		if (sizeof($langsubs)>0){
			$marks19 = $langsubs[sizeof($langsubs)-1];
			$deduct = 5;
		} else {
			$marks19 = 10;
		}
}	
	if ($marks19 > 49){
		$pen19 = array();
		$englishlist = array();
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
							array_push($pen19,0);
						}
					}
				}
			}
		}
		sort($bof);
		if (sizeof($bof) > 2) {
		$bofm = $marks19 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2] + $bof[sizeof($bof)-3];
		$bofp = ($bofm/4)-$deduct;
		$bofp = sprintf('%0.2f', $bofp);
		if ($bofp > 44) {
		$out5 = "<TR><TD><input type='checkbox' name='r5'></TD><TD>&nbsp; B.A. (Hons) French </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m5' hidden value='".strval($bofp)."'></TD></TR>";  array_push($nm44,$out5); array_push($mx44,$bofp); array_push($dx44,$deduct);$nonesorry = "";} else { $out5 = "";}
	}
}		
/*
9) German
*/
$subccc = 23;
if (in_array($subccc, $subjects)) {
	$key = array_search($subccc, $subjects);
	$marks19 = $marks[$key];
	$deduct = -2;
} else {
		$key = 7;
		$langsubs = array();		
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}		
		sort($langsubs);		
		if (sizeof($langsubs)>0){
			$marks19 = $langsubs[sizeof($langsubs)-1];
			$deduct = 5;
		} else {
			$marks19 = 10;
		}
}	
	if ($marks19 > 49){
		$pen19 = array();
		$englishlist = array();
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
							array_push($pen19,0);
						}
					}
				}
			}
		}
		sort($bof);
		if (sizeof($bof) > 2) {
		$bofm = $marks19 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2] + $bof[sizeof($bof)-3];
		$bofp = ($bofm/4)-$deduct;
		$bofp = sprintf('%0.2f', $bofp);
		if ($bofp > 44) {
		$out7 = "<TR><TD><input type='checkbox' name='r7'></TD><TD>&nbsp; B.A. (Hons) German </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m7' hidden value='".strval($bofp)."'></TD></TR>";  array_push($nm44,$out7); array_push($mx44,$bofp); array_push($dx44,$deduct);$nonesorry = "";} else {$out7 = "";}
	}
}	
/*
10) Italian Hons.
*/
$subccc = 29;
if (in_array($subccc, $subjects)) {
	$key = array_search($subccc, $subjects);
	$marks19 = $marks[$key];
	$deduct = -2;
} else {
		$key = 7;
		$langsubs = array();		
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}		
		sort($langsubs);		
		if (sizeof($langsubs)>0){
			$marks19 = $langsubs[sizeof($langsubs)-1];
			$deduct = 5;
		} else {
			$marks19 = 10;
		}
}	
	if ($marks19 > 49){
		$pen19 = array();
		$englishlist = array();
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
							array_push($pen19,0);
						}
					}
				}
			}
		}
		sort($bof);
		if (sizeof($bof) > 2) {
		$bofm = $marks19 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2] + $bof[sizeof($bof)-3];
		$bofp = ($bofm/4)-$deduct;
		$bofp = sprintf('%0.2f', $bofp);
		if ($bofp > 44) {
		$out11 = "<TR><TD><input type='checkbox' name='r11'></TD><TD>&nbsp; B.A. (Hons) Italian </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m11' hidden value='".strval($bofp)."'></TD></TR>";  array_push($nm44,$out11); array_push($mx44,$bofp); array_push($dx44,$deduct);$nonesorry = "";} else {$out11 = "";}
	}
}	
/*
11) Spanish Hons.
*/
$subccc = 51;
if (in_array($subccc, $subjects)) {
	$key = array_search($subccc, $subjects);
	$marks19 = $marks[$key];
	$deduct = -2;
} else {
		$key = 7;
		$langsubs = array();		
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}		
		sort($langsubs);		
		if (sizeof($langsubs)>0){
			$marks19 = $langsubs[sizeof($langsubs)-1];
			$deduct = 5;
		} else {
			$marks19 = 10;
		}
}	
	if ($marks19 > 49){
		$pen19 = array();
		$englishlist = array();
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
							array_push($pen19,0);
						}
					}
				}
			}
		}
		sort($bof);
		if (sizeof($bof) > 2) {
		$bofm = $marks19 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2] + $bof[sizeof($bof)-3];
		$bofp = ($bofm/4)-$deduct;
		$bofp = sprintf('%0.2f', $bofp);
		if ($bofp > 44) {
		$out21 = "<TR><TD><input type='checkbox' name='r21'></TD><TD>&nbsp; B.A. (Hons) Spanish </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m21' hidden value='".strval($bofp)."'></TD></TR>";  array_push($nm44,$out21); array_push($mx44,$bofp); array_push($dx44,$deduct);$nonesorry = "";} else {$out21 = "";}
	}
}
/*
12) Applied & Normal Psycho Hons.
*/
$subccc = 45;
$exists = 0;
$marks19 = 34;
if (in_array($subccc, $subjects)) {
	$key = array_search($subccc, $subjects);
	$marks19 = $marks[$key];
	$deduct = 0;
	$exists = 1;
} else {
	$deduct = 2.5;
	$key = 7;
	}
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} else {
			$lang19 = 0;
		}
		
	if (($lang19 > 33)&&($marks19 > 33)){
		$pen19 = array();
		$englishlist = array();
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
							array_push($pen19,0);
						}
					}
				}
			}
		}		
		sort($bof);
		if (sizeof($bof) >= 2) {
		$bofm = $lang19 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2] + $bof[sizeof($bof)-3];	
		$bofp = ($bofm/4) - $deduct;
		$bofp = sprintf('%0.2f', $bofp);
		if ($bofp > 44) {
		$out1 = "<TR><TD><input type='checkbox' name='r1'></TD><TD>&nbsp; B.A. (Hons) Applied Psychology </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m1' hidden value='".strval($bofp)."'></TD></TR>";
		$out16 = "<TR><TD><input type='checkbox' name='r16'></TD><TD>&nbsp; B.A. (Hons) Psycology </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m16' hidden value='".strval($bofp)."'></TD></TR>";   array_push($nm44,$out1); array_push($mx44,$bofp); array_push($dx44,$deduct);  array_push($nm44,$out16); array_push($mx44,$bofp); array_push($dx44,$deduct);$nonesorry = "";} else {$out1 = "";$out16 = "";}
	}
}	
/*
14) Geography Hons.
*/
$subccc =21;
$exists = 0;
$marks19 = 34;
if (in_array($subccc, $subjects)) {
	$key = array_search($subccc, $subjects);
	$marks19 = $marks[$key];
	$deduct = 0;
	$exists = 1;
} else {
	$deduct = 2.5;
	$key = 7;
	}
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} else {
			$lang19 = 0;
		}
		
	if (($lang19 > 33)&&($marks19 > 33)){
		$pen19 = array();
		$englishlist = array();
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
							array_push($pen19,0);
						}
					}
				}
			}
		}		
		sort($bof);
		if (sizeof($bof) >= 2) {
		$bofm = $lang19 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2] + $bof[sizeof($bof)-3];	
		$bofp = ($bofm/4) - $deduct;
		$bofp = sprintf('%0.2f', $bofp);
		if ($bofp > 44) {
		$out6 = "<TR><TD><input type='checkbox' name='r6'></TD><TD>&nbsp; B.A. (Hons) Geography </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m6' hidden value='".strval($bofp)."'></TD></TR>";  array_push($nm44,$out6); array_push($mx44,$bofp); array_push($dx44,$deduct);$nonesorry = "";} else {$out6 = "";}
	}
}	
/*
15) History Hons.
*/
$subccc =26;
$exists = 0;
$marks19 = 34;
if (in_array($subccc, $subjects)) {
	$key = array_search($subccc, $subjects);
	$marks19 = $marks[$key];
	$deduct = 0;
	$exists = 1;
} else {
	$deduct = 2.5;
	$key = 7;
	}
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} else {
			$lang19 = 0;
		}
		
	if (($lang19 > 33)&&($marks19 > 33)){
		$pen19 = array();
		$englishlist = array();
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
							array_push($pen19,0);
						}
					}
				}
			}
		}		
		sort($bof);
		if (sizeof($bof) >= 2) {
		$bofm = $lang19 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2] + $bof[sizeof($bof)-3];	
		$bofp = ($bofm/4) - $deduct;
		$bofp = sprintf('%0.2f', $bofp);
		if ($bofp > 44) {
		$out10 = "<TR><TD><input type='checkbox' name='r10'></TD><TD>&nbsp; B.A. (Hons) History </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m10' hidden value='".strval($bofp)."'></TD></TR>";  array_push($nm44,$out10); array_push($mx44,$bofp); array_push($dx44,$deduct);$nonesorry = "";} else {$out10 = "";}
	}
}	
/*
16) Political Science Hons.
*/
$subccc = 44;
$exists = 0;
$marks19 = 34;
if (in_array($subccc, $subjects)) {
	$key = array_search($subccc, $subjects);
	$marks19 = $marks[$key];
	$deduct = 0;
	$exists = 1;
} else {
	$deduct = 2.5;
	$key = 7;
	}
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} else {
			$lang19 = 0;
		}
		
	if (($lang19 > 33)&&($marks19 > 33)){
		$pen19 = array();
		$englishlist = array();
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
							array_push($pen19,0);
						}
					}
				}
			}
		}		
		sort($bof);
		if (sizeof($bof) >= 2) {
		$bofm = $lang19 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2] + $bof[sizeof($bof)-3];	
		$bofp = ($bofm/4) - $deduct;
		$bofp = sprintf('%0.2f', $bofp);
		if ($bofp > 44) {
		$out15 = "<TR><TD><input type='checkbox' name='r15'></TD><TD>&nbsp; B.A. (Hons) Political Science </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m15' hidden value='".strval($bofp)."'></TD></TR>";   array_push($nm44,$out15); array_push($mx44,$bofp); array_push($dx44,$deduct);$nonesorry = "";} else {$out15 = "";}
	}
}	
/*
17) Sociology Hons.
*/
$subccc = 50;
$exists = 0;
$marks19 = 34;
if (in_array($subccc, $subjects)) {
	$key = array_search($subccc, $subjects);
	$marks19 = $marks[$key];
	$deduct = 0;
	$exists = 1;
} else {
	$deduct = 2.5;
	$key = 7;
	}
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} else {
			$lang19 = 0;
		}
		
	if (($lang19 > 33)&&($marks19 > 33)){
		$pen19 = array();
		$englishlist = array();
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
							array_push($pen19,0);
						}
					}
				}
			}
		}		
		sort($bof);
		if (sizeof($bof) >= 2) {
		$bofm = $lang19 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2] + $bof[sizeof($bof)-3];	
		$bofp = ($bofm/4) - $deduct;
		$bofp = sprintf('%0.2f', $bofp);
		if ($bofp > 44) {
		$out20 = "<TR><TD><input type='checkbox' name='r20'></TD><TD>&nbsp; B.A. (Hons) Sociology </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m20' hidden value='".strval($bofp)."'></TD></TR>";   array_push($nm44,$out20); array_push($mx44,$bofp); array_push($dx44,$deduct);$nonesorry = "";} else {$out20 = "";}
	}
}	
/*
18) Philosophy & Social Work Hons.
*/
$subccc = 42;
$exists = 0;
$marks19 = 34;
$dcsocial = 0;
if (in_array($subccc, $subjects)) {
	$key = array_search($subccc, $subjects);
	$marks19 = $marks[$key];
	$deduct = 0;
	$exists = 1;
} else {
	$deduct = 2.5;
	$key = 7;
	$dcsocial = -2.5;
	}
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} else {
			$lang19 = 0;
		}
		
	if (($lang19 > 33)&&($marks19 > 33)){
		$pen19 = array();
		$englishlist = array();
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
							array_push($pen19,0);
						}
					}
				}
			}
		}		
		sort($bof);
		if (sizeof($bof) >= 2) {
		$bofm = $lang19 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2] + $bof[sizeof($bof)-3];	
		$bofp = ($bofm/4) - $deduct;
		$bofpx = $bofp - $dcsocial;
		$bofp = sprintf('%0.2f', $bofp);
		$bofpx = sprintf('%0.2f', $bofpx);
		if ($bofp > 44) {
		$out14 = "<TR><TD><input type='checkbox' name='r14'></TD><TD>&nbsp; B.A. (Hons) Philosophy </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m14' hidden value='".strval($bofp)."'></TD></TR>";   array_push($nm44,$out14); array_push($mx44,$bofp); array_push($dx44,$deduct);
		$out19 = "<TR><TD><input type='checkbox' name='r19'></TD><TD>&nbsp; B.A. (Hons) Social Work </TD><TD>&nbsp;  : ".strval($bofpx)."%<input type='text' name='m19' hidden value='".strval($bofp)."'></TD></TR>";   array_push($nm44,$out19); array_push($mx44,$bofpx); array_push($dx44,$deduct);$nonesorry = "";} else {$out14 = ""; $out19 = "";}
	}
}	
/*
19) Economics Hons.
*/
if (in_array(39, $subjects)) {
	$key = array_search(39, $subjects);
	$marks19 = $marks[$key];
	if ($marks19 > 33){
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} else {
			$lang19 = 0;
		}
		
	if ($lang19 > 33){
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
						}
					}
				}
			}
		}		
		sort($bof);
		if (sizeof($bof) >= 2) {
		$bofm = $lang19 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2] + $bof[sizeof($bof)-3];	
		$bofp = ($bofm/4);
			$bofp = sprintf('%0.2f', $bofp);
		if ($bofp > 44) {
		$out3 = "<TR><TD><input type='checkbox' name='r3'></TD><TD>&nbsp; B.A. (Hons) Economics </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m3' hidden value='".strval($bofp)."'></TD></TR>";  array_push($nm44,$out3); array_push($mx44,$bofp); array_push($dx44,$deduct);$nonesorry = "";} else {$out3 = "";}
	}
}	}}
/*
20) B.A. Prog
*/
$baprog = array(1,7,11,12,14,16,43);
$deduct = 0;
for ($xj = 0; $xj<6; $xj++){
if (in_array($subjects[$xj], $baprog)) {
	$deduct = 5;
} } 	
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} else {
			$lang19 = 0;
		}
		
	if ($lang19 > 33){
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
						}
					}
				}
		}		
		sort($bof);
		if (sizeof($bof) > 2) {
		$bofm = $lang19 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2] + $bof[sizeof($bof)-3];	
		$bofp = ($bofm/4) - $deduct;
		$bofp = sprintf('%0.2f', $bofp);
		if ($bofp > 39) {
		$out24 = "<TR><TD><input type='checkbox' name='r24'></TD><TD>&nbsp; B.A. Programme </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m24' hidden value='".strval($bofp)."'></TD></TR>";   array_push($nm44,$out24); array_push($mx44,$bofp); array_push($dx44,$deduct);$nonesorry = "";} else {$out24 = "";}
	}
}
/*
20a) B.A. (Hons.) Journa
*/
if (in_array(19, $subjects)) {
	$key = array_search(19, $subjects);
	$marks19 = $marks[$key];
	if ($marks19 > 33){
		$bof = array();
		$pen19 = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
						if ($marks19x > 0){
							array_push($bof,$marks19x);
							array_push($pen19,0);
						}
				}
			}
		}
		if (sizeof($bof) > 2) {
		$bofm = bestoffour($bof, $pen19,0,4,1);
		$bofp = ($marks19 + $bofm)/4;
		$bofp = sprintf('%0.2f', $bofp);
		if ($bofp > 44) {
		$out12 = "<TR><TD><input type='checkbox' name='r12'></TD><TD>&nbsp; B.A. (Hons) Journalism </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m12' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out12); array_push($mx44,$bofp); array_push($dx44,0);$nonesorry = "";} else  { $out12 = ""; }
	} }
}
/*
20a) B.A. (Hons.) Hindi Patri
*/
if (in_array(25, $subjects)) {
	$key = array_search(25, $subjects);
	$marks19 = $marks[$key];
	if ($marks19 > 33){
		$bof = array();
		$pen19 = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
						if ($marks19x > 0){
							array_push($bof,$marks19x);
							array_push($pen19,0);
						}
				}
			}
		}
		if (sizeof($bof) > 2) {
		$bofm = bestoffour($bof, $pen19,0,4,1);
		$bofp = ($marks19 + $bofm)/4;
		$bofp = sprintf('%0.2f', $bofp);
		if ($bofp > 44) {
		$out9 = "<TR><TD><input type='checkbox' name='r9'></TD><TD>&nbsp; B.A. (Hons) Hindi Patrikarita </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m9' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out9); array_push($mx44,$bofp); array_push($dx44,0);$nonesorry = "";} else  { $out9 = ""; }}
	}
}
/*
Result Arts
*/
$alpha = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
		$throwout = "Arts : <BR><BR> Not Eligible";
		if (sizeof($mx44)>0){
		$test = 0;	
		if (sizeof($mx44)==1){
		$test = 1; }
			while($test < 1) {
				for ($p = 0; $p < sizeof($mx44); $p++) {
					if (($p == sizeof($mx44) - 1) && ($mx44[$p] <= $mx44[$p-1])) {
						$test = 1;		
					} else {
						if ($mx44[$p] < $mx44[$p+1]){
							$tpp = $mx44[$p];
							$tppx = $nm44[$p];
							$tppy = $dx44[$p];
							$mx44[$p] = $mx44[$p+1];
							$nm44[$p] = $nm44[$p+1];
							$dx44[$p] = $dx44[$p+1];
							$mx44[$p+1] = $tpp;
							$nm44[$p+1] = $tppx;
							$dx44[$p+1] = $tppy;
							break;
						}			
					}
				}
			}
			$throwout = "Arts : <BR><BR>";
			for ($rp = 0; $rp < sizeof($nm44); $rp++){
			$throwout = $throwout . $nm44[$rp];
			}
		}
/* Science */			
$nm44 = array();
$mx44 = array();
$dx44 = array();
/*
21) B.Sc.(Hons.) Computer Sc
*/
if (in_array(39, $subjects)) {
	$key = array_search(39, $subjects);
	$marks19 = $marks[$key];
	if ($marks19 > 59){
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} else {
			$lang19 = 0;
		}
		
		if ($lang19 > 33){
			$bof = array();
			$penx = array();
			$accept21 = array(12,16,28,43);
			for ($x = 0; $x <= 5; $x++) {
				if ($x != $key) {
					$subx = $subjects[$x];
					if ($subx != 0) {
						$marks19x = $marks[$x];
						if (in_array($subx, $lista)) {
						} else {
							if ($marks19x > 0){
								if (in_array($subx, $accept21)) {
									array_push($bof,$marks19x); 
								} else {
									array_push($penx,$marks19x); 
								}
							}
						}
					}
				}
			}		
			sort($bof);
			sort($penx);
			$bofp = 0;
			if (sizeof($bof) > 1) {
			$bofm = $marks19 + $lang19 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2];	
			$bofp = ($bofm/4);
			$bofp = sprintf('%0.2f', $bofp);
			} elseif ((sizeof($bof) == 1) && (sizeof($penx) > 0)) {
			$bofm = $marks19 + $lang19 + $bof[sizeof($bof)-1] + $penx[sizeof($penx)-1];	
			$bofp = ($bofm/4) - 2;
			$bofp = sprintf('%0.2f', $bofp);
			} elseif ((sizeof($bof) == 0) && (sizeof($penx) > 1)) {
			$bofm = $marks19 + $lang19 + $penx[sizeof($penx)-2] + $penx[sizeof($penx)-1];	
			$bofp = ($bofm/4) - 2;
			$bofp = sprintf('%0.2f', $bofp);
			} 
			if ($bofp > 59) {
			$out42 = "<TR><TD><input type='checkbox' name='r42'></TD><TD>&nbsp; B.Sc. (Hons) Computer Science </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m42' hidden value='".strval($bofp)."'></TD></TR>";  		array_push($nm44,$out42); array_push($mx44,$bofp); array_push($dx44,$deduct);$nonesorry = "";} else {$out42 = "";}
	}
}	}
/*
22) B.Sc.(Hons.) Maths
*/
if (in_array(39, $subjects)) {
	$key = array_search(39, $subjects);
	$marks19 = $marks[$key];
	if ($marks19 > 49){
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} else {
			$lang19 = 0;
		}
		
		if ($lang19 > 33){
			$bof = array();
			for ($x = 0; $x <= 5; $x++) {
				if ($x != $key) {
					$subx = $subjects[$x];
					if ($subx != 0) {
						$marks19x = $marks[$x];
						if (in_array($subx, $lista)) {
						} else {
							if ($marks19x > 0){
								array_push($bof,$marks19x); 
							}
						}
					}
				}
			}		
			sort($bof);
			$bofp = 0;
			if (sizeof($bof) > 1) {
			$bofm = $marks19 + $lang19 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2];	
			$bofp = ($bofm/4);
			$bofp = sprintf('%0.2f', $bofp);
			}
			if ($bofp > 44) {
			$out47 = "<TR><TD><input type='checkbox' name='r47'></TD><TD>&nbsp; B.Sc. (Hons) Mathematics </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m47' hidden value='".strval($bofp)."'></TD></TR>";  		array_push($nm44,$out47); array_push($mx44,$bofp); array_push($dx44,$deduct);$nonesorry = "";} else {$out47 = "";}
	}
}	}
/*
23) B.Sc.(Hons.) Stats
*/
if (in_array(39, $subjects)) {
	$key = array_search(39, $subjects);
	$marks19 = $marks[$key];
	if ($marks19 > 49){
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} else {
			$lang19 = 0;
		}
		
		if ($lang19 > 33){
			$bof = array();
			for ($x = 0; $x <= 5; $x++) {
				if ($x != $key) {
					$subx = $subjects[$x];
					if ($subx != 0) {
						$marks19x = $marks[$x];
						if (in_array($subx, $lista)) {
						} else {
							if ($marks19x > 0){
								array_push($bof,$marks19x); 
							}
						}
					}
				}
			}		
			sort($bof);
			$bofp = 0;
			if (sizeof($bof) > 1) {
			$bofm = $marks19 + $lang19 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2];	
			$bofp = ($bofm/4);
			$bofp = sprintf('%0.2f', $bofp);
			}
			if ($bofp > 44) {
			$out51 = "<TR><TD><input type='checkbox' name='r51'></TD><TD>&nbsp; B.Sc. (Hons) Statistics </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m51' hidden value='".strval($bofp)."'></TD></TR>";  		array_push($nm44,$out51); array_push($mx44,$bofp); array_push($dx44,$deduct);$nonesorry = "";} else {$out51 = "";}
	}
}	}
/*
24) B.Sc. Mathematical Sciences
*/
if (in_array(39, $subjects)) {
	$key = array_search(39, $subjects);
	$marks19 = $marks[$key];
	if ($marks19 > 33){
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} else {
			$lang19 = 0;
		}
		
		if ($lang19 > 33){
			$bof = array();
			for ($x = 0; $x <= 5; $x++) {
				if ($x != $key) {
					$subx = $subjects[$x];
					if ($subx != 0) {
						$marks19x = $marks[$x];
						if (in_array($subx, $lista)) {
						} else {
							if ($marks19x > 0){
								array_push($bof,$marks19x); 
							}
						}
					}
				}
			}		
			sort($bof);
			$bofp = 0;
			if (sizeof($bof) > 1) {
			$bofm = $marks19 + $lang19 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2];	
			$bofp = ($bofm/4);
			$bofp = sprintf('%0.2f', $bofp);
			}
			if ($bofp > 33) {
			$out55 = "<TR><TD><input type='checkbox' name='r55'></TD><TD>&nbsp; B.Sc. Mathematical Sciences </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m55' hidden value='".strval($bofp)."'></TD></TR>";  		array_push($nm44,$out55); array_push($mx44,$bofp); array_push($dx44,$deduct);$nonesorry = "";} else {$out55 = "";}
	}
}	}
/*
25) B.Sc. (Hons.) Anthro
*/
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} 
if ($lang19>49){
if ((in_array(7, $subjects))&&(in_array(12, $subjects))&&(in_array(43, $subjects))) {
	$key1 = array_search(7, $subjects);
	$marks191 = $marks[$key1];
		$key2 = array_search(12, $subjects);
	$marks192 = $marks[$key2];
		$key3 = array_search(43, $subjects);
	$marks193 = $marks[$key3];

			$bofm = $marks191 + $marks192 + $marks193;	
			$bofp = ($bofm/3);
			$bofp = sprintf('%0.2f', $bofp);
			if ($bofp > 54) {
			$out36 = "<TR><TD><input type='checkbox' name='r36'></TD><TD>&nbsp; B.Sc. (Hons) Anthropology </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m36' hidden value='".strval($bofp)."'></TD></TR>";  		array_push($nm44,$out36); array_push($mx44,$bofp); array_push($dx44,$deduct);$nonesorry = "";} else {$out36 = "";}
	}}
/*
26) B.Sc. (Hons.) Biological Sciences/Botany/Microbiology/ Zoology
*/
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} 
if ($lang19>49){
if ((in_array(12, $subjects))&&(in_array(43, $subjects))) {
	if ((in_array(6, $subjects))||(in_array(7, $subjects))||(in_array(8, $subjects))) {
		$arrayone = array();
		if (in_array(6, $subjects)){
			$keytemp = array_search(6, $subjects);
			$markstemp = $marks[$keytemp];
			array_push($arrayone,$markstemp);
		}
		if (in_array(7, $subjects)){
			$keytemp = array_search(7, $subjects);
			$markstemp = $marks[$keytemp];
			array_push($arrayone,$markstemp);
		}
		if (in_array(8, $subjects)){
			$keytemp = array_search(8, $subjects);
			$markstemp = $marks[$keytemp];
			array_push($arrayone,$markstemp);
		}
		sort($arrayone);
		$marks191 = $arrayone[sizeof($arrayone)-1];
				
		$key2 = array_search(12, $subjects);
	$marks192 = $marks[$key2];
		$key3 = array_search(43, $subjects);
	$marks193 = $marks[$key3];

			$bofm = $marks191 + $marks192 + $marks193;	
			$bofp = ($bofm/3);
			$bofp = sprintf('%0.2f', $bofp);
			if ($bofp > 54) {
			$out38 = "<TR><TD><input type='checkbox' name='r38'></TD><TD>&nbsp; B.Sc. (Hons) Biological Sciences </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m38' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out38); array_push($mx44,$bofp); array_push($dx44,$deduct);
$out40 = "<TR><TD><input type='checkbox' name='r40'></TD><TD>&nbsp; B.Sc. (Hons) Botany </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m40' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out40); array_push($mx44,$bofp); array_push($dx44,$deduct);
$out48 = "<TR><TD><input type='checkbox' name='r48'></TD><TD>&nbsp; B.Sc. (Hons) Microbiology </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m48' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out48); array_push($mx44,$bofp); array_push($dx44,$deduct);
$out52 = "<TR><TD><input type='checkbox' name='r52'></TD><TD>&nbsp; B.Sc. (Hons) Zoology </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m52' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out52); array_push($mx44,$bofp); array_push($dx44,$deduct);
$nonesorry = "";
} else {$out38 = '';
$out40 = '';
$out48 = '';
$out52 = '';
}
	} } }
/*
27) B.Sc. (Hons.) Chemistry/Physics/Polymer Science/ Electronics/Instrument
*/
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} 
if ($lang19>49){
if ((in_array(39, $subjects))&&(in_array(12, $subjects))&&(in_array(43, $subjects))) {
	$key1 = array_search(39, $subjects);
	$marks191 = $marks[$key1];
		$key2 = array_search(12, $subjects);
	$marks192 = $marks[$key2];
		$key3 = array_search(43, $subjects);
	$marks193 = $marks[$key3];

			$bofm = $marks191 + $marks192 + $marks193;	
			$bofp = ($bofm/3);
			$bofp = sprintf('%0.2f', $bofp);
			if ($bofp > 54) {
			$out41 = "<TR><TD><input type='checkbox' name='r41'></TD><TD>&nbsp; B.Sc. (Hons) Chemistry </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m41' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out41); array_push($mx44,$bofp); array_push($dx44,$deduct); $nonesorry = ' ';
$out49 = "<TR><TD><input type='checkbox' name='r49'></TD><TD>&nbsp; B.Sc. (Hons) Physics </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m49' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out49); array_push($mx44,$bofp); array_push($dx44,$deduct); $nonesorry = ' ';
$out50 = "<TR><TD><input type='checkbox' name='r50'></TD><TD>&nbsp; B.Sc. (Hons) Polymer Science </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m50' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out50); array_push($mx44,$bofp); array_push($dx44,$deduct); $nonesorry = ' ';
$out43 = "<TR><TD><input type='checkbox' name='r43'></TD><TD>&nbsp; B.Sc. (Hons) Electronics </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m43' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out43); array_push($mx44,$bofp); array_push($dx44,$deduct); $nonesorry = ' ';
$out46 = "<TR><TD><input type='checkbox' name='r46'></TD><TD>&nbsp; B.Sc. (Hons) Instrumentation </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m46' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out46); array_push($mx44,$bofp); array_push($dx44,$deduct); $nonesorry = ' ';

			} else {
				$out41 = '';$out49 = '';$out50 = '';$out43 = '';$out46 = '';
				}
	}}
/*
28) B.Sc. (Hons.) Geology
*/
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} 
if ($lang19>49){
if ((in_array(12, $subjects))&&(in_array(43, $subjects))) {
		$key2 = array_search(12, $subjects);
	$marks192 = $marks[$key2];
		$key3 = array_search(43, $subjects);
	$marks193 = $marks[$key3];
	$geolist = array(39,21,6,7,8,22);
	
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $geolist)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		$marks191 = 0;
		if (sizeof($langsubs)>0){
			$marks191 = $langsubs[sizeof($langsubs)-1];
		} 
	

			$bofm = $marks191 + $marks192 + $marks193;	
			$bofp = ($bofm/3);
			$bofp = sprintf('%0.2f', $bofp);
			if (($bofp > 54)&&($marks191>0)) {
$out45 = "<TR><TD><input type='checkbox' name='r45'></TD><TD>&nbsp; B.Sc. (Hons) Geology </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m45' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out45); array_push($mx44,$bofp); array_push($dx44,$deduct); $nonesorry = ' ';
			} else {
				$out45 = '';
				}
	}}
/*
29) B.Sc. (Hons.) Food Tech
*/
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} 
if ($lang19>49){
if ((in_array(12, $subjects))&&(in_array(43, $subjects))) {
		$key2 = array_search(12, $subjects);
	$marks192 = $marks[$key2];
		$key3 = array_search(43, $subjects);
	$marks193 = $marks[$key3];
	$geolist = array(39,6,7,8);
	
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $geolist)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		$marks191 = 0;
		if (sizeof($langsubs)>0){
			$marks191 = $langsubs[sizeof($langsubs)-1];
		} 
		$relax = 0;
		if ((in_array(12, $subjects))&&(in_array(43, $subjects))&&(in_array(39, $subjects))) {
		if ((in_array(6, $subjects))||(in_array(7, $subjects))||(in_array(8, $subjects))) {
		$relax = 3;	
		} }

			$bofm = $marks191 + $marks192 + $marks193;	
			$bofp = ($bofm/3) + $relax;
			$bofp = sprintf('%0.2f', $bofp);
			if (($bofp > 54)&&($marks191>0)) {
$out44 = "<TR><TD><input type='checkbox' name='r44'></TD><TD>&nbsp; B.Sc. (Hons) Food Technology </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m44' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out44); array_push($mx44,$bofp); array_push($dx44,$deduct); $nonesorry = ' ';
			} else {
				$out44 = '';
				}
	}}
/*
30) B.Sc. (Hons.) Biochem
*/
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} 
if ($lang19>33){
if ((in_array(12, $subjects))) {
		$key2 = array_search(12, $subjects);
	$marks192 = $marks[$key2];
	$geolist = array(6,7,8);
	$geolistx = array(39,43);
		
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $geolist)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		$marks191 = 0;
		if (sizeof($langsubs)>0){
			$marks191 = $langsubs[sizeof($langsubs)-1];
		} 
		
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $geolistx)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		$marks193 = 0;
		if (sizeof($langsubs)>0){
			$marks193 = $langsubs[sizeof($langsubs)-1];
		} 

			$bofm = $marks191 + $marks192 + $marks193;	
			$bofp = ($bofm/3);
			$bofp = sprintf('%0.2f', $bofp);
			if (($bofp > 54)&&($marks191>0)&&($marks193>0)) {
$out37 = "<TR><TD><input type='checkbox' name='r37'></TD><TD>&nbsp; B.Sc. (Hons) Bio-Chemistry </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m37' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out37); array_push($mx44,$bofp); array_push($dx44,$deduct); $nonesorry = ' ';

			} else {
				$out37 = '';
				}
	}}
/*
31) B.Sc. (Hons.) Biomedical Science
*/
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} 
if ($lang19>49){
if ((in_array(12, $subjects))&&(in_array(43, $subjects))) {
		$key2 = array_search(12, $subjects);
	$marks192 = $marks[$key2];
		$key3 = array_search(43, $subjects);
	$marks193 = $marks[$key3];
	$geolist = array(6,7,8);
	
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $geolist)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		$marks191 = 0;
		if (sizeof($langsubs)>0){
			$marks191 = $langsubs[sizeof($langsubs)-1];
		} 
		$relax = 0;
		if (in_array(39, $subjects)) {
		$relax = 3;	
		}

			$bofm = $marks191 + $marks192 + $marks193;	
			$bofp = ($bofm/3) + $relax;
			$bofp = sprintf('%0.2f', $bofp);
			if (($bofp > 54)&&($marks191>0)) {
$out39 = "<TR><TD><input type='checkbox' name='r39'></TD><TD>&nbsp; B.Sc. (Hons) Biomedical Science </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m39' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out39); array_push($mx44,$bofp); array_push($dx44,$deduct); $nonesorry = ' ';
			} else {
				$out39 = '';
				}
	}}
/*
32) B.Sc. (Hons.) Home Sc
*/
if ((in_array(12, $subjects))||(in_array(43, $subjects))||(in_array(6, $subjects))||(in_array(7, $subjects))||(in_array(8, $subjects))) {
		$hsclist = array(12,43,6,7,8);
		$langsubs = array();
		$marks191 = 0;
		$key = 7;
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $hsclist)) {
				if ($marks[$x]>$marks191){
					$marks191 = $marks[$x];
					$key = $x;
					}
			}
		}
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
						}
					}
				}
			}
		}	
			sort($bof);
			if (sizeof($bof)>1){
			$bofm = $marks191 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2];	
			$bofp = ($bofm/3) + $relax;
			$bofp = sprintf('%0.2f', $bofp);
			if (($bofp > 49)&&($marks191>0)) {
$out53 = "<TR><TD><input type='checkbox' name='r53'></TD><TD>&nbsp; B.Sc (Hons.) Home Science </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m53' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out53); array_push($mx44,$bofp); array_push($dx44,$deduct); $nonesorry = ' ';
			} else {
$out53 = '';
				}
	} }
/*
33) B.Sc. Prog Applied Physical Sciences with Analytical Methods in Chemistry and Biochemistry/
	Applied Physical Sciences with Industrial Chemistry 
	Physical Science with Chemistry/
	Physical Science with Electronics
	Physical Science with ComputerScience
*/
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} 
if ($lang19>33){
if ((in_array(39, $subjects))&&(in_array(43, $subjects))) {
		$key2 = array_search(39, $subjects);
	$marks192 = $marks[$key2];
		$key3 = array_search(43, $subjects);
	$marks193 = $marks[$key3];
	
	$geolist = array(12,16);
	
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $geolist)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		$marks191 = 0;
		if (sizeof($langsubs)>0){
			$marks191 = $langsubs[sizeof($langsubs)-1];
		} 

			$bofm = $marks191 + $marks192 + $marks193;	
			$bofp = ($bofm/3);
			$bofp = sprintf('%0.2f', $bofp);
			if (($bofp > 44)&&($marks191>0)) {
$out56 = "<TR><TD><input type='checkbox' name='r56'></TD><TD>&nbsp; B.Sc. APS with AM in Chem & BioChem ** </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m56' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out56); array_push($mx44,$bofp); array_push($dx44,$deduct); $nonesorry = ' ';
$out57 = "<TR><TD><input type='checkbox' name='r57'></TD><TD>&nbsp; B.Sc. APS with Industrial Chemistry ** </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m57' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out57); array_push($mx44,$bofp); array_push($dx44,$deduct); $nonesorry = ' ';
$out58 = "<TR><TD><input type='checkbox' name='r58'></TD><TD>&nbsp; B.Sc. Physical Science with Chemistry </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m58' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out58); array_push($mx44,$bofp); array_push($dx44,$deduct); $nonesorry = ' ';
$out59 = "<TR><TD><input type='checkbox' name='r59'></TD><TD>&nbsp; B.Sc. Physical Science with Computer </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m59' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out59); array_push($mx44,$bofp); array_push($dx44,$deduct); $nonesorry = ' ';
$out60 = "<TR><TD><input type='checkbox' name='r60'></TD><TD>&nbsp; B.Sc. Physical Science with Electronics </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m60' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out60); array_push($mx44,$bofp); array_push($dx44,$deduct); $nonesorry = ' ';
			} else {
$out56 = '';$out57 = '';$out58 = '';$out59 = '';$out60 = '';
				}
	}}
/*
34) B.Sc. Applied Life Science / Life Science
*/
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $lista)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} 
if ($lang19>33){
if ((in_array(39, $subjects))&&(in_array(43, $subjects))) {
		$key2 = array_search(39, $subjects);
	$marks192 = $marks[$key2];
		$key3 = array_search(43, $subjects);
	$marks193 = $marks[$key3];
	
	$geolist = array(6,7,8);
	
		$langsubs = array();
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $geolist)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		$marks191 = 0;
		if (sizeof($langsubs)>0){
			$marks191 = $langsubs[sizeof($langsubs)-1];
		} 

			$bofm = $marks191 + $marks192 + $marks193;	
			$bofp = ($bofm/3);
			$bofp = sprintf('%0.2f', $bofp);
			if (($bofp > 44)&&($marks191>0)) {
$out54 = "<TR><TD><input type='checkbox' name='r54'></TD><TD>&nbsp; B.Sc (Life Sciences) </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m54' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out54); array_push($mx44,$bofp); array_push($dx44,$deduct); $nonesorry = ' ';
$out35 = "<TR><TD><input type='checkbox' name='r35'></TD><TD>&nbsp; B.Sc (Applied Life Sciences) </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m35' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out35); array_push($mx44,$bofp); array_push($dx44,$deduct); $nonesorry = ' ';

			} else {
$out54 = '';$out35 = '';
				}
	}}
/*
35) B.Sc. (Pass) Home Sc
*/
if (in_array(19, $subjects)) {
	$key = array_search(19, $subjects);
	$marks19 = $marks[$key];
	if ($marks19 > 33){
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
						}
					}
				}
			}
		}	
			sort($bof);
			if (sizeof($bof)>2){
			$bofm = $marks19 + $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2] + $bof[sizeof($bof)-3];	
			$bofp = ($bofm/4);
			$bofp = sprintf('%0.2f', $bofp);
			if (($bofp > 49)&&($marks191>0)) {
$out61 = "<TR><TD><input type='checkbox' name='r61'></TD><TD>&nbsp; B.Sc.(Pass) Home Science </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m61' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out61); array_push($mx44,$bofp); array_push($dx44,$deduct); $nonesorry = ' ';
			} else {
$out61 = '';
				}
	} } }
/*
Result Science
*/
$alpha = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
		$throwout2 = "Science : <BR><BR> Not Eligible";
		if (sizeof($mx44)>0){
		$test = 0;
		if (sizeof($mx44)==1){
		$test = 1; }
			while($test < 1) {
				for ($p = 0; $p < sizeof($mx44); $p++) {
					if (($p == sizeof($mx44) - 1) && ($mx44[$p] <= $mx44[$p-1])) {
						$test = 1;		
					} else {
						if ($mx44[$p] < $mx44[$p+1]){
							$tpp = $mx44[$p];
							$tppx = $nm44[$p];
							$tppy = $dx44[$p];
							$mx44[$p] = $mx44[$p+1];
							$nm44[$p] = $nm44[$p+1];
							$dx44[$p] = $dx44[$p+1];
							$mx44[$p+1] = $tpp;
							$nm44[$p+1] = $tppx;
							$dx44[$p+1] = $tppy;
							break;
						}			
					}
				}
			}
			$throwout2 = "Science : <BR><BR>";
			for ($rp = 0; $rp < sizeof($nm44); $rp++){
			$throwout2 = $throwout2 . $nm44[$rp];
			}
		}
/* Commerce */	
$throwout3 = "Commerce : <BR><BR> Not Eligible";		
$nm44 = array();
$mx44 = array();
$dx44 = array();

/*
36) B.Com. (Hons.)
*/
if ((in_array(39, $subjects))||(in_array(10, $subjects))) {
	if ((in_array(39, $subjects))&&(in_array(10, $subjects))) {
		$keyx = array_search(39, $subjects);
		$marks19x = $marks[$keyx];
		$keyy = array_search(10, $subjects);
		$marks19y = $marks[$keyy];
		if ($marks19x>$marks19y){
			$key = $keyx;} else {$key = $keyy;}
		}
	elseif (in_array(39, $subjects)) {
		$key = array_search(39, $subjects);
		} else {
	$key = array_search(10, $subjects);		
	}
	$marks19 = $marks[$key];
		$langsubs = array();
		$listenhn = array(19,25);
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $listenhn)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} 

	if (($marks19 > 33)&($lang19>33)){
		
		$key = 7;
		if ((in_array(11, $subjects))&&(in_array(14, $subjects))) {
			$bst =  array_search(11, $subjects);
			$comm =  array_search(14, $subjects);
			if ($marks[$bst]>$marks[$comm]){
				$key = $comm;
				}else{
				$key = $bst;	
					}
		}
		$pen19 = array();
		$englishlist = array(18,1,39,14,11);
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
					if (in_array($subx, $englishlist)) {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
							array_push($pen19,0);
						}
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x-4);
							array_push($pen19,1);
						}
					} }
				}
			}
		}

		if (sizeof($bof) > 2) {
		sort($bof);
		$bofm = $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2] + $bof[sizeof($bof)-3];
		$bofp = ($lang19 + $bofm)/4;
		$bofp = sprintf('%0.2f', $bofp);
		
		$throwout3 = strval($bofp);
		if ($bofp > 44) {
$out34 = "<TR><TD><input type='checkbox' name='r34'></TD><TD>&nbsp; B.Com. (Hons) </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m34' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out34); array_push($mx44,$bofp); array_push($dx44,$deduct); $nonesorry = ' ';
} else { $out34 = ""; }
		}
	}
}

/*
37) B.Com.
*/
		$langsubs = array();
		$listenhn = array(19,25);
		for ($x = 0; $x <= 5; $x++) {
			$subx = $subjects[$x];
			if (in_array($subx, $listenhn)) {
				array_push($langsubs,$marks[$x]);
			}
		}
		sort($langsubs);
		if (sizeof($langsubs)>0){
			$lang19 = $langsubs[sizeof($langsubs)-1];
		} 
	
	if ($lang19>33){
		
		$key = 7;
		if ((in_array(11, $subjects))&&(in_array(14, $subjects))) {
			$bst =  array_search(11, $subjects);
			$comm =  array_search(14, $subjects);
			if ($marks[$bst]>$marks[$comm]){
				$key = $comm;
				}else{
				$key = $bst;	
					}
		}
		$pen19 = array();
		$englishlist = array(18,1,39,14,11);
		$bof = array();
		for ($x = 0; $x <= 5; $x++) {
			if ($x != $key) {
				$subx = $subjects[$x];
				if ($subx != 0) {
					$marks19x = $marks[$x];
					if (in_array($subx, $lista)) {
					} else {
					if (in_array($subx, $englishlist)) {
						if ($marks19x > 0){
							array_push($bof,$marks19x);
							array_push($pen19,0);
						}
					} else {
						if ($marks19x > 0){
							array_push($bof,$marks19x-4);
							array_push($pen19,1);
						}
					} }
				}
			}
		}
		
		if (sizeof($bof) > 2) {
		sort($bof);
		$bofm = $bof[sizeof($bof)-1] + $bof[sizeof($bof)-2] + $bof[sizeof($bof)-3];
		$bofp = ($lang19 + $bofm)/4;
		$bofp = sprintf('%0.2f', $bofp);
		
		$throwout3 = strval($bofp);
		if ($bofp > 44) {
$out33 = "<TR><TD><input type='checkbox' name='r33'></TD><TD>&nbsp; B.Com. </TD><TD>&nbsp;  : ".strval($bofp)."%<input type='text' name='m33' hidden value='".strval($bofp)."'></TD></TR>"; array_push($nm44,$out33); array_push($mx44,$bofp); array_push($dx44,$deduct); $nonesorry = ' ';
} else { $out33 = ""; }
		}
}

/*
Result Commerce
*/
$alpha = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
		if (sizeof($mx44)>0){
		$test = 0;
		if (sizeof($mx44)==1){
		$test = 1; }
			while($test < 1) {
				for ($p = 0; $p < sizeof($mx44); $p++) {
					if (($p == sizeof($mx44) - 1) && ($mx44[$p] <= $mx44[$p-1])) {
						$test = 1;		
					} else {
						if ($mx44[$p] < $mx44[$p+1]){
							$tpp = $mx44[$p];
							$tppx = $nm44[$p];
							$tppy = $dx44[$p];
							$mx44[$p] = $mx44[$p+1];
							$nm44[$p] = $nm44[$p+1];
							$dx44[$p] = $dx44[$p+1];
							$mx44[$p+1] = $tpp;
							$nm44[$p+1] = $tppx;
							$dx44[$p+1] = $tppy;
							break;
						}			
					}
				}
			}
			$throwout3 = "Commerce : <BR><BR>";
			for ($rp = 0; $rp < sizeof($nm44); $rp++){
			$throwout3 = $throwout3 . $nm44[$rp];
			}
		}

?>

<html lang="en">
<head>
	<title>Available List of Subjects</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=1024">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/noui/nouislider.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body onLoad="javascript:start()">


	<div class="container-contact100">
		<div class="wrap-contact100">
			<form class="contact100-form validate-form"  action="/Colleges.php" method="post">
				<span class="contact100-form-title">
					Subjects 
				</span>

				<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">User Details</span>
					<BR><BR><H5><TABLE cellspacing="4" cellpadding="4">
							<TR><TD>Name : <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $name; ?> <TD>
							<TD>&nbsp;&nbsp;&nbsp;&nbsp;Category : <TD>&nbsp;&nbsp;<?php echo $category; ?></TR><TR><TD><BR><TD><TD></TR>
							<?php echo $displaysub; ?></TABLE><BR></H5>
				</div>
                <?php echo $nextdeets; ?>
				
				<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Subjects Available (Choose upto 5 from the following) :</span>
					<BR><BR><?php echo $nonesorry; ?>
					<TABLE cellspacing="4" cellpadding="4">
						<TR valign="top">
							<TD>
								<TABLE cellspacing="4" cellpadding="4">
									<?php echo $throwout; ?>
								</TABLE>
							</TD>
							<TD>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							</TD>
							<TD>
								<TABLE cellspacing="4" cellpadding="4">
									<?php echo $throwout3; ?>
								</TABLE>
							</TD>
						</TR>
					</TABLE>
								<BR>
								<TABLE cellspacing="4" cellpadding="4">
									<?php echo $throwout2; ?>
								</TABLE>
					<BR>
						 * Deductions and Relaxations in percentage has been made in accordance to the Delhi University guidelines.   <BR>
                         ** APS : Applied Physical Sciences, AM : Analytical Methods 
				</div>

				<div class="container-contact100-form-btn">
					<button class="contact100-form-btn">
						<span>
							Find predicted list of available colleges
							<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
						</span>
					</button>
				</div>
			</form>
		</div>
	</div>



</body>
</html>