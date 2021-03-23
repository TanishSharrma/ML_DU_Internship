<?php
$name =  $_POST["name"];
$check = strlen($name)+1;
if ($check < 2){
	echo "Invalid Request";
	die();
	}
$courses = array();
for ($x=1;$x<66;$x++){
	$code = "r".strval($x);
	$sub = $_POST[$code];
	if (strval($sub)=="on"){
		array_push($courses,$x);
		}
	}
if (sizeof($courses)==0){
	echo "Please select at least 1 course.";
	die();
	}
if (sizeof($courses)>5){
	echo "You can only select upto 5 courses.";
	die();
	}
$name =  $_POST["name"];
$category =  $_POST["category"];
$displaysub =  $_POST["displaysub"]; 
$clist = array(0,'B.A (Hons) Applied Psychology',
'B.A (Hons) Bengali',
'B.A (Hons) Economics',
'B.A (Hons) English',
'B.A (Hons) French',
'B.A (Hons) Geography',
'B.A (Hons) German',
'B.A (Hons) Hindi',
'B.A (Hons) Hindi Patrikarita',
'B.A (Hons) History',
'B.A (Hons) Italian',
'B.A (Hons) Journalism',
'B.A (Hons) Persian',
'B.A (Hons) Philosophy',
'B.A (Hons) Political Science',
'B.A (Hons) Psychology',
'B.A (Hons) Punjabi',
'B.A (Hons) Sanskrit',
'B.A (Hons) Social Work',
'B.A (Hons) Sociology',
'B.A (Hons) Spanish',
'B.A (Hons) Urdu',
'B.A (Hons)Arabic',
'B.A Programme',
'B.A. (Voc.) HUMAN  RESOURCE MANAGEMENT',
'B.A. (Voc.) OFFICE MANAGEMENT AND SECRETARIAL PRACTICE',
'B.A. (Voc.) SMALL AND MEDIUM ENTERPRISES',
'B.A. (Voc.) TOURISM MANAGEMENT',
'B.A. Honours (Humanities & Social Sciences)',
'B.A.(VS) MANAGEMENT AND MARKETING OF INSURANCE',
'B.A.(Voc.) MATERIAL  MANAGEMENT',
'B.A.(Voc.)MARKETING  MANAGEMENT AND RETAIL BUSINESS ',
'B.Com',
'B.Com (Hons)',
'B.Sc (Applied Life Sciences)',
'B.Sc (Hons) Anthropology',
'B.Sc (Hons) Bio-Chemistry',
'B.Sc (Hons) Biological Sciences',
'B.Sc (Hons) Biomedical Science',
'B.Sc (Hons) Botany',
'B.Sc (Hons) Chemistry',
'B.Sc (Hons) Computer Science',
'B.Sc (Hons) Electronics',
'B.Sc (Hons) Food Technology',
'B.Sc (Hons) Geology',
'B.Sc (Hons) Instrumentation',
'B.Sc (Hons) Mathematics',
'B.Sc (Hons) Microbiology',
'B.Sc (Hons) Physics',
'B.Sc (Hons) Polymer Science',
'B.Sc (Hons) Statistics',
'B.Sc (Hons) Zoology',
'B.Sc (Hons.) Home Science',
'B.Sc (Life Sciences)',
'B.Sc Mathematical Sciences',
'B.Sc. Applied Physical Sciences with Analytical Methods in Chemistry & Biochemistry',
'B.Sc. Applied Physical Sciences with Industrial Chemistry',
'B.Sc. Physical Science with Chemistry',
'B.Sc. Physical Science with Computer',
'B.Sc. Physical Science with Electronics',
'B.Sc.(Pass) Home Science',
'B.Voc. Printing Technology',
'B.Voc. Software Development',
'B.Voc. Web Designing',
'B.Voc.Banking Operations');
$f = 1;
$coursename = array();
$coursemarks = array();
$nocrs = sizeof($courses);
for ($m = 0; $m < sizeof($courses); $m++){
	$marksqwer = "m".strval($courses[$m]);
	array_push($coursename,$clist[$courses[$m]]);
	array_push($coursemarks,$_POST[$marksqwer]);
	$f++;
	}
$finalcollegelist = "";
/*Fetch and Compare*/
$fcat = array("Unreserved", "OBC", "SC", "ST", "PwD", "Kashimiri Migrants", "Sikh Minority", "Nominated by Sikkim Govt");
$cat = array_search($category, $fcat); //Category in numerical format
$username = "1162174";
$password = "du1234";
$host = "localhost";
$dbname = "1162174db2";
// Create connection
$conn = new mysqli($host, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    echo "Our Servers are currently under maintenance, please try again later.";
	die();
}
$sql = "SELECT College, Subjects, UR, OBC, SC, ST, PwD, KM, SG, SM FROM federer";
$result = $conn->query($sql);
$College = array();
$Subjects = array();
$UR = array();
$OBC = array();
$SC = array();
$ST = array();
$PwD = array();
$KM = array();
$SG = array();
$SM = array();
$radio = "";
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		array_push($College,$row["College"]);
		array_push($Subjects,$row["Subjects"]);
		array_push($UR,$row["UR"]);
		array_push($OBC,$row["OBC"]);
		array_push($SC,$row["SC"]);
		array_push($ST,$row["ST"]);
		array_push($PwD,$row["PwD"]);
		array_push($KM,$row["KM"]);
		array_push($SG,$row["SG"]);
		array_push($SM,$row["SM"]);		
    }
	for ($px = 0; $px<sizeof($courses); $px++){
		$temp = array();
		$tempx = array();
		$tempcoll = array();
		$tempcat = array();
		$tempur = array();
		$tcrs = $clist[$courses[$px]];
		$radio = $radio . "<input type='radio' onclick='displaysub()' name='sub' id='r" . strval($px+1) . "'> &nbsp;&nbsp; " . strval($px+1). ") " . $coursename[$px] . "<BR>";

    	// Output data of each row
    	for($pp=0;$pp<sizeof($College);$pp++) {
			$fcrs = $Subjects[$pp];
			if ($fcrs == $tcrs) {
				 array_push($tempcoll,$College[$pp]);
				 array_push($tempur,$UR[$pp]);
				 if ($cat == 0) {
						array_push($tempcat,$UR[$pp]);
				 } elseif ($cat == 1) {
				 		array_push($tempcat,$OBC[$pp]);
				 } elseif ($cat == 2) {
				 		array_push($tempcat,$SC[$pp]);
				 } elseif ($cat == 3) {
				 		array_push($tempcat,$ST[$pp]);
				 } elseif ($cat == 4) {
				 		array_push($tempcat,$PwD[$pp]);
				 } elseif ($cat == 5) {
				 		array_push($tempcat,$KM[$pp]);
				 } elseif ($cat == 6) {
				 		array_push($tempcat,$SG[$pp]);
				 } elseif ($cat == 7) {
						array_push($tempcat,$SM[$pp]);
				 }
			}
    	}
		// Compare Marks
		for ($mx = 0; $mx<sizeof($tempcoll); $mx++){
			if ($tempur[$mx]<$tempcat[$mx]) {
				$marx = $tempur[$mx];
			} else {
				$marx = $tempcat[$mx];	
			}
			$bof = $coursemarks[$px];
			if ($bof >= $marx){
				array_push($temp,$tempcoll[$mx]);
				array_push($tempx,$tempur[$mx]);
			}
		}
		
		// College Sorting Algorithm
		$test = 0;
		if (sizeof($tempx)<2){
			$test = 1;
		}
		while($test < 1) {
				for ($p = 0; $p < sizeof($tempx); $p++) {
					if (($p == sizeof($tempx) - 1) && ($tempx[$p] < $tempx[$p-1])) {
						$test = 1;		
					} else {
						if ($tempx[$p] < $tempx[$p+1]){
							$tpp = $temp[$p];
							$tppx = $tempx[$p];
							$temp[$p] = $temp[$p+1];
							$tempx[$p] = $tempx[$p+1];
							$temp[$p+1] = $tpp;
							$tempx[$p+1] = $tppx;
							break;
						}	
					}
				}
		}
		if (sizeof($tempx)>1){
			$finalcollegelist = $finalcollegelist . strval($px+1) . ") " . $tcrs . "<BR><BR>" . implode("<BR>",$temp) ."<BR><BR>";
		} elseif (sizeof($tempx)>1) {
			$finalcollegelist = $finalcollegelist . strval($px+1) . ") " . $tcrs . "<BR><BR>" . $temp[0] ."<BR><BR>";
		} else {
			$finalcollegelist = $finalcollegelist . strval($px+1) . ") " . $tcrs . "<BR><BR>" . "No Colleges Available" ."<BR><BR>";
		}
	}	
} else {
    echo "Our Servers are currently under maintenance, please try again later.";
	die();
}
$conn->close();
?>

<html lang="en">
<head>
	<title>Predicted List of Colleges</title>
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
<script>
function displaysub(){
	var len = <?php echo $nocrs; ?>;
	var i;
	var selx;
	for (i = 1; i <= len; i++) {
		var curr = "r" + toString(i);
  		if(document.getElementById(toString(curr)).checked) {
 			var str2 = "p";
			selx = str2 + toString(i+1);
			break;
		}
	}
	document.getElementById("p0").innerHTML = selx;
}
</script>
</head>
<body>
	<div class="container-contact100">
		<div class="wrap-contact100">
			<form class="contact100-form validate-form"  action="" method="post">
				<span class="contact100-form-title">
					Colleges
				</span>

				<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">User Details</span>
					<BR><BR><H5><TABLE cellspacing="4" cellpadding="4">
							<TR><TD>Name :<TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $name; ?> <TD>
							<TD>&nbsp;&nbsp;&nbsp;&nbsp;Category : <TD>&nbsp;&nbsp;<?php echo $category; ?></TR><TR><TD><BR><TD><TD></TR>
							<?php echo $displaysub; ?></TABLE><BR></H5>
				</div>

				<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Selected Subjects</span>
					<BR><BR>
					<?php echo $radio; ?>
					<BR>
				</div>
				
				<div class="wrap-input100 validate-input bg1">
				<span class="label-input100">Predicted List of Colleges :</span>
					<BR><BR>
					<p id="p0"></p>
				</div>

				<div class="container-contact100-form-btn">
					<button class="contact100-form-btn">
						<span>
							Print
							<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
						</span>
					</button>
				</div>
			</form>
		</div>
	</div>



</body>
</html>