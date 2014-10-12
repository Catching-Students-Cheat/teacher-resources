<?php
/**
 *
 */
class StudentsCheat {
	private $html = '';
	private $rootFile = '';

	public function getHTML() {
		return $this -> html;
	}

	public function __construct($rootFile = '') {
		$this -> rootFile = $rootFile;
		$this -> studentCheat();
	}

	private function studentCheat() {
		$html = '';
		$html .= '<h1>Viewing Students Cheat</h1>';
		$html .= '      <section>';
		$html .= '          <article>';
		$html .= '          <h2>Code 1</h2>';
		if (file_exists("teacher/students.txt")) {
		$html .= '          <p>' . $this -> printWhoCheat() . '</p>';
		}else{
			$html .= '          <p>Currently there is no students added to the list.</p>';
		}
		$html .= '          </article>';
		$html .= '      </section>';
		$this -> html = $html;
	}

	private function findStudentNames() {
		$studentNames = array();
		$studentRow = 0;
		if (file_exists("teacher/students.txt")) {
			$myfile = fopen("teacher/students.txt", "r");

			if ($myfile) {
				while ($buffer = fgets($myfile)) {
					foreach ($this->findFile('teacher',$buffer) as $result) {
						if (strpos(trim($result), trim($buffer)) !== FALSE) {
							$studentNames[$studentRow][0] = trim($buffer);
							$studentNames[$studentRow][1] = trim($result);
							$studentNames[$studentRow][2] = "false";
							$studentRow++;
						}
					}
				}
			}

			fclose($myfile);
		}
		return $studentNames;
	}

	private function printWhoCheat() {

		$html = '';
		$currentNames = $this -> findStudentNames();
		$studentNames = $this -> findStudentNames();
		$currentCount = 0;
		$studentCount = 0;
		// Include the diff class

		require_once dirname(__FILE__) . '/../lib/Diff.php';
		require_once dirname(__FILE__) . '/../lib/Diff/Renderer/Html/SideBySide.php';

		for ($i = 0; $i < count($currentNames); $i++) {
			for ($j = $i; $j < count($studentNames); $j++) {
				if ($i != $j) {
					// Include two sample files for comparison
					//echo $this -> rootFile . '\\' . str_replace("/", "\\", $currentNames[$i][1]);
					$a = explode("\n", file_get_contents($this -> rootFile . '\\' . str_replace("/", "\\", $currentNames[$i][1])));
					$b = explode("\n", file_get_contents($this -> rootFile . '\\' . str_replace("/", "\\", $studentNames[$j][1])));

					// Options for generating the diff
					$options = array('ignoreWhitespace' => true, 'ignoreCase' => true, );

					// Initialize the diff class
					$diff = new Diff($a, $b, $options);

					// Generate a side by side diff
					$renderer = new Diff_Renderer_Html_SideBySide;
					$diff -> Render($renderer);

					if (($renderer -> getPercentChange() > 60) && 
					($studentNames[$j][2] == "false")) {
						if ($currentNames[$i][2] == "false") {
							$currentNames[$i][2] = "true";
							$html .= $currentNames[$i][0] . " Percent copied: ".$renderer -> getPercentChange(). "<BR>";
						}
						$studentNames[$j][2] = "true";
						$html .= $studentNames[$j][0] . " Percent copied: ".$renderer -> getPercentChange().  "<BR>";
					}
				}
			}
		}
		return $html;
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
