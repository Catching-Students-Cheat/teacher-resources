<?php
/**
 *
 */
class StudentInformation {

	private $html;
	private $rootFile;
	private $txtData;

	private $currentStudentURL;
	private $currentStudentInfomation = array();

	function __construct($rootFile = '') {
		$this -> rootFile = $rootFile;
	}

	public function getHTML() {
		return $this -> html;
	}

	public function setCurrentStudentURL($currentStudentURL = '') {
		$this -> currentStudentURL = $currentStudentURL;
	}

	public function setTxtData($txtData = '') {
		$this -> txtData = $txtData;

	}

	public function addStudentInformation() {
		$studentFirstName = "";
		$studentLastName = "";
		$studentPeriod = "";
		$studentCode = "";
		$teacherFiles = scandir("teacher");

		$myStudents = fopen("teacher/students.txt", "a+") or die("Unable to open file!");
		$myfile = "";
		foreach ($this->txtData as $key => $val) {
			if ($key == "fName") {
				$studentFirstName = $val;
			} else if ($key == "lName") {
				$studentLastName = $val;
			} else if ($key == "period") {
				$studentPeriod = $val;
			} else if ($key == "code") {
				$studentCode = $val;
			}
		}
		$studentFile = "teacher/" . trim($teacherFiles[2]) . "/" . "Period" . trim($studentPeriod) . "/" . trim($studentFirstName) . "_" . trim($studentLastName) . ".txt";
		$this -> currentStudentInfomation[0] = trim($teacherFiles[2]);
		$this -> currentStudentInfomation[1] = trim($studentPeriod);
		$this -> currentStudentInfomation[2] = trim($studentFirstName);
		$this -> currentStudentInfomation[3] = trim($studentLastName);
		$this -> currentStudentInfomation[4] = $studentCode;
		$myfile = fopen($studentFile, "w") or die("Unable to open file!");
		fwrite($myfile, $studentCode);
		fwrite($myStudents, "\r\n" . $studentFirstName . "_" . $studentLastName);
		fclose($myfile);
		$this -> currentStudentURL = $studentFile;

		fclose($myStudents);
	}

	public function editStudentInformation() {

		$studentFirstName = "";
		$studentLastName = "";
		$studentPeriod = "";
		$studentCode = "";
		$studentURL = "";
		foreach ($this->txtData as $key => $val) {
			if ($key == "studentName") {
				$studentName = explode("_", $val);
				$studentFirstName = $studentName[0];
				$studentLastName = $studentName[1];
			} elseif ($key == "studentURL") {
				$this -> currentStudentURL = $val;
				$studentLink = explode("/", $val);
				$studentPeriod = $studentLink[2];
			}

		}
		$myfile = fopen($this -> currentStudentURL, "r");
		while ($buffer = fgets($myfile)) {
			$studentCode .= $buffer;
		}
		$this -> currentStudentInfomation[1] = trim(str_replace("Period", "", $studentPeriod));
		$this -> currentStudentInfomation[2] = trim($studentFirstName);
		$this -> currentStudentInfomation[3] = trim($studentLastName);
		$this -> currentStudentInfomation[4] = $studentCode;
	}

	public function editStudent() {
		$fName = "";
		$lName = "";
		$period = "";
		$code = "";
		if ($this -> currentStudentURL != "") {
			$period = $this -> currentStudentInfomation[1];
			$fName = $this -> currentStudentInfomation[2];
			$lName = $this -> currentStudentInfomation[3];
			$code = $this -> currentStudentInfomation[4];
		}
		$html = '';
		if (file_exists("teacher/students.txt")) {
			$html .= '<h1>Student Information</h1>';
			$html .= '<section>';
			$html .= '<article>';
			$html .= '<p>';
			$html .= '<form  name="student" action="index.php?id=addStudent" method="POST">';
			$html .= 'First Name: <input type="text" value="' . $fName . '" name="fName"><br>';
			$html .= 'Last Name: <input type="text" value="' . $lName . '" name="lName"><br>';
			$html .= 'Period:  <select name="period">';

			$myfile = fopen("teacher/teacher.txt", "r");
			if ($myfile) {
				while ($buffer = fgets($myfile)) {
					if (strpos($buffer, 'classActive') !== false) {
						$name = substr($buffer, strpos($buffer, "=") + 1);
						$selected = (trim($name) == trim($period)) ? "selected" : "";
						$html .= '<option value="' . trim($name) . '"' . $selected . '>' . $name . '</option>';
					}
				}
			}
			fclose($myfile);

			$html .= '</select> <br>	';
			$html .= 'Code:<bt> <textarea name="code" rows="36" cols="75">' . $code . '</textarea><br>';
			$html .= '<input type="submit" value="Submit">';
			$html .= '</form>';
			$html .= '</p>';
			$html .= '</article>';
			$html .= '</section>';
		} else {
			$html .= '<h1>Need Teacher Information</h1>';
			$html .= '<section>';
			$html .= '<article>';
			$html .= '<p>';
			$html .= 'Please enter teacher and class information.';
			$html .= '</p>';
			$html .= '</article>';
			$html .= '</section>';
		}
		$this -> html = $html;
	}

	public function viewStudent() {
		$fName = "";
		$lName = "";
		$period = "";
		$code = "";
		if ($this -> currentStudentURL != "") {
			$period = $this -> currentStudentInfomation[1];
			$fName = $this -> currentStudentInfomation[2];
			$lName = $this -> currentStudentInfomation[3];
			$code = $this -> currentStudentInfomation[4];
		}
		$html = '';
		$html .= '<h1>Student Information</h1>';
		$html .= '<section>';
		$html .= '<article>';
		$html .= '<p>';
		$html .= 'First Name: <input type="text" value="' . $fName . '" name="fName"><br>';
		$html .= 'Last Name: <input type="text" value="' . $lName . '" name="lName"><br>';
		$html .= 'Period:  <select name="period">';
		$myfile = fopen("teacher/teacher.txt", "r");
		if ($myfile) {
			while ($buffer = fgets($myfile)) {
				if (strpos($buffer, 'classActive') !== false) {
					$name = substr($buffer, strpos($buffer, "=") + 1);
					$selected = (trim($name) == trim($period)) ? "selected" : "";
					$html .= '<option value="' . trim($name) . '"' . $selected . '>' . $name . '</option>';
				}
			}
		}
		fclose($myfile);
		$html .= '</select> <br>	';
		$html .= 'Code:<br> <textarea name="code" rows="36" cols="75">' . $code . '</textarea><br>';
		$html .= '</p>';
		$html .= '</article>';
		$html .= '</section>';

		$this -> html = $html;
	}

}
?>