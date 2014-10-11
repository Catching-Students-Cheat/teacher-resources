<?php
class TeacherInformation {
	private $html = '';
	private $txtData = '';

	function __construct($txtData = '') {
		$this -> txtData = $txtData;
	}

	public function getHTML() {
		return $this -> html;
	}

	public function writeTeacherData() {
		$teacherFirstName = "";
		$teacherLastName = "";
		$myfile = fopen("teacher/teacher.txt", "w") or die("Unable to open file!");
		foreach ($this->txtData as $key => $val) {
			if (is_array($val)) {
				foreach ($val as $keyArray => $valArray) {
					$txt = "classActive=$valArray\n";
					fwrite($myfile, $txt);
					if (!file_exists("teacher/" . $teacherFirstName . "_" . $teacherLastName . "/Period" . $valArray)) {
						if (!mkdir("teacher/" . $teacherFirstName . "_" . $teacherLastName . "/Period" . $valArray, 0777, true)) {
							die('Failed to create folders...');
						}
					}
				}
			} else {
				if ($key == "fName") {
					$teacherFirstName = $val;
				} else if ($key == "lName") {
					$teacherLastName = $val;
				} else if ($teacherFirstName != "" && $teacherLastName != "" && !file_exists("teacher/" . $teacherFirstName . "_" . $teacherLastName)) {
					if (!mkdir("teacher/" . $teacherFirstName . "_" . $teacherLastName, 0777, true)) {
						die('Failed to create folders...');
					}
				}
				$txt = "$key=$val\n";
				fwrite($myfile, $txt);
			}
		}
		fclose($myfile);
		
		header('Location: index.php?id=teacherInformation');
	}

	public function addTeacher() {

		$html = '';
		$html .= '<h1>Teacher Information</h1>';
		$html .= '<section>';
		$html .= '<article>';
		$html .= '<p>';
		$html .= '<form  name="student" action="index.php?id=writeTeacherData" method="POST">';
		$html .= 'First Name: <input type="text" name="fName" value=""><br>';
		$html .= 'Last Name: <input type="text" name="lName" value=""><br>';
		$html .= 'Classes: <input type="text" name="class" value=""><br>	';
		$html .= '<input type="checkbox" name="periods[]" value="1">Period 1<br>';
		$html .= '<input type="checkbox" name="periods[]" value="2">Period 2<br>';
		$html .= '<input type="checkbox" name="periods[]" value="3">Period 3<br>';
		$html .= '<input type="checkbox" name="periods[]" value="4">Period 4<br>';
		$html .= '<input type="checkbox" name="periods[]" value="5">Period 5<br>';
		$html .= '<input type="checkbox" name="periods[]" value="6">Period 6<br>';
		$html .= '<input type="checkbox" name="periods[]" value="7">Period 7<br>';
		$html .= '<input type="submit" value="Submit">';
		$html .= '</form>';
		$html .= '</p>';
		$html .= '</article>';
		$html .= '</section>';

		$this -> html = $html;
	}

	public function editTeacher() {
		$fName = $lName = $class = $checked = $classActive1 = $classActive2 = $classActive3 = $classActive4 = $classActive5 = $classActive6 = $classActive7 = "";
		$myfile = fopen("teacher/teacher.txt", "r");
		if ($myfile) {
			while ($buffer = fgets($myfile)) {
				if (strpos($buffer, 'fName=') !== false)
					$fName = substr($buffer, strpos($buffer, "=") + 1);
				elseif (strpos($buffer, 'lName=') !== false)
					$lName = substr($buffer, strpos($buffer, "=") + 1);
				elseif (strpos($buffer, 'class=') !== false)
					$class = substr($buffer, strpos($buffer, "=") + 1);
				elseif (strpos($buffer, 'classActive=1') !== false)
					$checked[1] = "checked";
				elseif (strpos($buffer, 'classActive=2') !== false)
					$checked[2] = "checked";
				elseif (strpos($buffer, 'classActive=3') !== false)
					$checked[3] = "checked";
				elseif (strpos($buffer, 'classActive=4') !== false)
					$checked[4] = "checked";
				elseif (strpos($buffer, 'classActive=5') !== false)
					$checked[5] = "checked";
				elseif (strpos($buffer, 'classActive=6') !== false)
					$checked[6] = "checked";
				elseif (strpos($buffer, 'classActive=7') !== false)
					$checked[7] = "checked";
			}
			fclose($myfile);
		}

		$html = '';
		$html .= '<h1>Edit Teacher Information</h1>';
		$html .= '<section>';
		$html .= '<article>';
		$html .= '<p>';
		$html .= '<form  name="student" action="index.php?id=editTeacher" method="POST">';
		$html .= 'First Name: <input type="text" name="fName" value="' . $fName . '"><br>';
		$html .= 'Last Name: <input type="text" name="lName" value="' . $lName . '"><br>';
		$html .= 'Classes: <input type="text" name="class" value="' . $class . '"><br>	';
		for ($i = 1; $i <= 7; $i++) {
			$check = array_key_exists($i, $checked) ? "checked" : null;
			$html .= '<input type="checkbox" name="periods[]" value="' . $i . '" ' . $check . '>Period ' . $i . '<br>';
		}
		$html .= '<input type="submit" value="Submit">';
		$html .= '</form>';
		$html .= '</p>';
		$html .= '</article>';
		$html .= '</section>';

		$this -> html = $html;
	}

}
?>
