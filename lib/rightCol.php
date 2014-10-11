<?php
class RightCol {
	private $html;
	private $rootFile;

	public function __construct($rootFile = "") {
		$this -> rootFile = $rootFile;
		$this -> index();
	}

	private function index() {
		include_once $this -> rootFile . '/lib/studentList.php';

		$studentList = new StudentList;
		$html = '';
		$html .= '<h2>Recent Posts</h2>';
		$html .= '        <h3>Students:</h3>';
		$html .= '        <p>';
		if (file_exists("teacher/students.txt")) {
			$myfile = fopen("teacher/students.txt", "r");
			$studentList -> fileLinkPath($myfile);
			fclose($myfile);
		}
		$html .= $studentList -> html;
		$html .= '        </p>';
		$this -> html = $html;
	}

	public function run() {
		return $this -> html;
	}

}
?>