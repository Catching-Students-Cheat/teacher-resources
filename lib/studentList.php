<?php
/**
 * 
 */
class StudentList {
	
	public $rootFile = '';
	public $html = '';
	
	function __construct() {
		
	}
	public function fileLinkPath($myfile = '') {
		$html = '';
		$count = 1;
		if ($myfile) {
			while ($buffer = fgets($myfile)) {
				foreach ($this->findFile('teacher',$buffer) as $result) {
					if (strpos(trim($result), trim($buffer)) !== FALSE) {
						$html .= '<form name="student'.$count.'" action="index.php?id=viewStudent" method="POST">';
						$html .= '<input type="hidden" name="studentName" value="' . trim($buffer) . '">';
						$html .= '<input type="hidden" name="studentURL" value="' . trim($result) . '">';
						$html .= '<a type="submit" href="javascript: submitform'.$count.'()">' . trim($buffer) . '</a><br/>';
						$html .= '</form>';
						$html .= '<script type="text/javascript">';
						$html .= 'function submitform'.$count.'()';
						$html .= '{';
						$html .= 'document.student'.$count.'.submit();';
						$html .= '}';
						$html .= '</script>';
						$count++;
					}
				}
			}
		}
		$this->html =  $html;
	}

	private function findFile($dir, $wordSearch = '') {
		$dir = rtrim($dir, '\\/');
		$result = array();

		foreach (scandir($dir) as $f) {
			if ($f !== '.' and $f !== '..') {
				if (is_dir("$dir/$f")) {
					$result = array_merge($result, $this -> findfile("$dir/$f", "$f/"));
				} else {
					$result[] = $dir . "/" . $f;
				}
			}
		}

		return $result;
	}
}

?>