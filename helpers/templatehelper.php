<?php
abstract class TemplateHelper {
	static function fetch_menu() {
		$output = NULL;
		$output .= "<a href='/'><li>Home</li></a>";
		$output .= "<a href='/test'><li>Test</li></a>";
		return $output;
	}
}
?>