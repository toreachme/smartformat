<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once "./phpword/vendor/autoload.php";

class Home extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('home_model');
	}

	public function index(){


		$headerObj = $this->home_model->getAllHeaders();
		$qaObj = $this->home_model->getQandAbyDomain('ClearedConnection.com');

		foreach ($headerObj as $headerObject) {
			echo "<u>".$headerObject->Header."</u><br/><br/>";
			foreach ($qaObj as $qaObject) {
				if ($qaObject->H_id == $headerObject->H_id) {
					echo "<b>".$qaObject->Question."</b><br/>";
					echo $qaObject->Answer. "<br/><br/>";
					
				}
				
			}
			echo "<br/><br/><br/>";
		}

	


		//$this->formatWithAllData($headerObj, $qaObj);


	}

	public function formatword($text){
		// Creating the new document...
		$phpWord = new \PhpOffice\PhpWord\PhpWord();

		$section = $phpWord->addSection();

  		// Adding Text element to the Section having font styled by default...
		$section->addText($text);

		$phpWord->getCompatibility()->setOoxmlVersion(15);

		// Saving the document as OOXML file...
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		$objWriter->save('textword.docx');


	}

	public function formatWithAllData($headerObject, $qaObject){
		// Creating the new document...
		$phpWord = new \PhpOffice\PhpWord\PhpWord();


		// Add title styles
		$phpWord->addTitleStyle(1, array('size' => 10, 'name' => 'Arial','color'=>'333333', 'bold'=>true, 'underline' => \PhpOffice\PhpWord\Style\Font::UNDERLINE_SINGLE),array('justify' => \PhpOffice\PhpWord\SimpleType\Jc::JUSTIFY));

        //Question styles
		$phpWord->addFontStyle('question_font', array('size' => 10, 'name' => 'Arial','bold'=>true, 'color'=>'4F81BD'));
		$phpWord->addParagraphStyle('question_paragraph', array('justify' => \PhpOffice\PhpWord\SimpleType\Jc::JUSTIFY));
		$predefinedMultilevelStyle = array('listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER);

		$phpWord->addFontStyle('answers_font', array('size' => 10, 'name' => 'Arial'));
		$phpWord->addParagraphStyle('answers_paragraph', array('indent' => 1,'justify' => \PhpOffice\PhpWord\SimpleType\Jc::JUSTIFY));



		$section = $phpWord->addSection();


		foreach ($headerObject as $hObjectrow) {
			$section->addTitle($hObjectrow->Header, 1);
			$section->addTextBreak();

			foreach ($qaObject as $qaObjectrow) {

				//Output Q&A specific to this Header Section
				if ($qaObjectrow->H_id == $hObjectrow->H_id) {
					$section->addListItem($qaObjectrow->Question, 0, 'question_font', $predefinedMultilevelStyle, 'question_paragraph');
					$section->addTextBreak();
		            
		            // Add text elements
					$section->addText($qaObjectrow->Answer, 'answers_font', 'answers_paragraph');
					$section->addTextBreak();

				}

			}
			$section->addTextBreak();
			$section->addTextBreak();


		}



		$phpWord->getCompatibility()->setOoxmlVersion(15);

		// Saving the document as OOXML file...
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		$objWriter->save('texttitleword.docx');

	}
}
