<?php
	

	class Upload extends Database
	{
		private $fileName;
		private $fileTmp;
		private $fileType;
		private $fileExt;
		private $errors = array();

		public function __construct($file){
			parent::__construct();

			$this->fileName = $file['name'];
			$this->fileTmp = $file['tmp_name'];
			$extension = explode('.',$this->fileName);
			$this->fileExt = end($extension);	
		}

		public function checkExtension(){
			$validExt = array("csv", "xls", "xlsx");
			if (in_array($this->fileExt, $validExt) === false){
				$this->errors[]="extension not allowed, please choose a valid excel format";
			}
		}

		public function uploadFile(){
			if(empty($this->errors) === true){
				if(file_exists("files/".$this->fileName)){
					unlink("files/".$this->fileName);
					move_uploaded_file($this->fileTmp, "files/".$this->fileName);
				}else{
					move_uploaded_file($this->fileTmp, "files/".$this->fileName);
				}
			}else{
			 	print_r($this->errors[0]);
			}
		}

		public function addToDatabase(){
			try{
				$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('files/'.$this->fileName);
				$rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);
				$numRow = count($rows);
				for($i = 1; $i < $numRow; $i++){
						$year = substr(date('Y'), 0, 2);
						$examyear = substr($rows[$i][0], 0,2);
						$exammonth = substr($rows[$i][0], 2,2);
						$this->insert("examinees",['examinee_no','lname','fname','m_i','year','month'])->build();
						$this->execute([$rows[$i][0], $rows[$i][1], $rows[$i][2] ,$rows[$i][3] ,$year.$examyear,$exammonth]);
						$inserted  = $this->getLastInserted();
						$total = (($rows[$i][4]*.20) + ($rows[$i][5]*.20) + ($rows[$i][6]*.15) + ($rows[$i][7]*.20) + ($rows[$i][8]*.10) + ($rows[$i][9]*.15));
						$this->insert("results",['examinee_id','cjp','lea','cdip','c','ca','csehr','gen_ave'])->build();
						$this->execute([$inserted,$rows[$i][4],$rows[$i][5],$rows[$i][6],$rows[$i][7],$rows[$i][8],$rows[$i][9],$total]);
				}
				return true; 
			}catch(Exception $e){
				return false;
			}		
		}
	}

?>