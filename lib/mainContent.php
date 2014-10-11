<?php
class MainContent {

	private $html;
	private $rootFile;
	private $txtData;
	private $currentStudentURL;
	private $currentStudentInfomation = array();

	public function __construct($rootFile = "", $getID = "", $txtData = "") {
		$this -> rootFile = $rootFile;

		if ($getID == "teacherInformation") {
			include_once $rootFile . '/lib/teacherInformation.php';
			$teacher = new TeacherInformation();
			if (file_exists("teacher/teacher.txt")) {
				$teacher -> editTeacher();
				$this -> html = $teacher -> html;
			} else {
				$teacher -> addTeacher();
				$this -> html = $teacher -> html;
			}
		} else if ($getID == "addStudent") {
			include_once $rootFile . '/lib/studentInformation.php';
			$studentInformation = new StudentInformation($rootFile);
			$studentInformation -> setTxtData($txtData);
			$studentInformation -> addStudentInformation();
			$studentInformation -> editStudent();
			$this -> html = $studentInformation -> getHTML();
		} else if ($getID == "editStudent") {
			include_once $rootFile . '/lib/studentInformation.php';
			$studentInformation = new StudentInformation($rootFile);
			$studentInformation -> setTxtData($txtData);
			$studentInformation -> editStudentInformation();
			$studentInformation -> editStudent();
			$this -> html = $studentInformation -> getHTML();
		} else if ($getID == "viewStudent") {
			include_once $rootFile . '/lib/studentInformation.php';
			$studentInformation = new StudentInformation($rootFile);
			$studentInformation -> setTxtData($txtData);
			$studentInformation -> editStudentInformation();
			$studentInformation -> viewStudent();
			$this -> html = $studentInformation -> getHTML();
		} else if ($getID == "studentInformation") {
			include_once $rootFile . '/lib/studentInformation.php';
			$studentInformation = new StudentInformation($rootFile);
			$studentInformation -> setCurrentStudentURL("");
			$studentInformation -> editStudent();
			$this -> html = $studentInformation -> getHTML();
		} else if ($getID == "studentsCheat") {
			include_once $rootFile . '/lib/studentsCheat.php';
			$studentsCheat = new StudentsCheat($rootFile);
			$this -> html = $studentsCheat -> getHTML();
		} else if ($getID == "addTeacher") {
			include_once $rootFile . '/lib/teacherInformation.php';
			$teacher = new TeacherInformation;
			if (file_exists("teacher/teacher.txt")) {
				$teacher -> editTeacher();
				$this -> html = $teacher -> html;
			} else {
				$teacher -> txtData = $txtData;
				$teacher -> writeTeacherData();
				$teacher -> addTeacher();
				$this -> html = $teacher -> html;
			}
		} else {
			$this -> index();
		}
	}

	private function index() {
		$html = '';
		$html .= '<h1>Catching Students Cheat</h1>';
		$html .= '      <section>';
		$html .= '          <article>';
		$html .= '          <h2>Fact 1</h2>';
		$html .= '<p>Academic cheating is defined as representing someone else\'s work as your own. It can take many forms, including sharing another\'s work, purchasing a term paper or test questions in advance, paying another to do the work for you.</p>';
		$html .= '          </article>';
		$html .= '          <article>';
		$html .= '          <h2>Fact 2</h2>';
		$html .= '<p>Statistics show that cheating among high school students has risen dramatically during the past 50 years.</p>';
		$html .= '          </article>';
		$html .= '      </section>';

		$this -> html = $html;
	}

	public function run() {
		return $this -> html;
	}

}
?>