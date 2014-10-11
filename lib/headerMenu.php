<?php
class HeaderMenu {
	private $html;
	
	public function __construct($getID="") {
	
		$this->index($getID);
	}

	private function index($getID="") {
		$teacher="";
		$home="";
		$students="";
		$cheated="";
		if($getID=="teacherInformation"){
			$teacher="highlight";
		}else if($getID=="studentInformation"){
			$students="highlight";
		}else if($getID=="addTeacher"){
			$teacher="highlight";
		}else if($getID=="studentsCheat"){
			$cheated="highlight";
		}else{
			$home="highlight";
		}
		$html = '';
		$html .= '<li class="'.$home.'" id="index"><a href="index.php?id=index">Home</a></li>';
		$html .= '<li class="'.$teacher.'" id="teacherInformation"><a href="index.php?id=teacherInformation">Teacher</a></li>';
		$html .= '<li class="'.$students.'" id="studentList"><a href="index.php?id=studentInformation">Students</a></li>';
		$html .= '<li class="'.$cheated.'" id="studentsCheat"><a href="index.php?id=studentsCheat">Who Cheated</a></li>';
		return $this->html = $html;
	}
	
	public function run() {
		return $this->html;
	}


}
?>