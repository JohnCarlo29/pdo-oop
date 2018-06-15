<?php
	class Examinees Extends Database{
		public function __construct(){
			parent::__construct();
		}

		public function getExamineesNo(){
			$this->select("id,examinee_no","examinees")->build();
			return $this->execute()->fetch_all();
		}


		public function getYears(){
			$sql = "select distinct(year) from examinees ORDER BY year DESC";
			$this->query($sql)->build();
			return $this->execute()->fetch_all();
		}

		public function display_examinees($year){

			$this->select("*", "examinees")->where("year")->orderBy("id", "DESC")->limit(0,10)->build();
			return $this->execute([$year])->fetch_all();
		}

		public function display_results($year){
			$sql = "select examinees.examinee_no, examinees.lname, examinees.fname, examinees.m_i, results.cjp,results.lea,results.cdip,results.c,results.ca,results.csehr,results.gen_ave from examinees, results where results.examinee_id = examinees.id and examinees.year = {$year} limit 0,10";
			$this->query($sql)->build();
			return $this->execute()->fetch_all();
		}


		/*public function countExaminees(){
			$this->select("*",'examinees')->build();
			return $this->execute()->rowCount();
		}*/

		public function searchExaminees($examineeNo, $year){
			$this->select("*",'examinees')->where('year')->and_where('examinee_no')->build();
			return $this->execute([$year, $examineeNo])->fetch_all();
		}

		public function searchExamineesResult($examineeNo, $year){
			$sql = "select examinees.examinee_no, examinees.lname, examinees.fname, examinees.m_i, results.cjp,results.lea,results.cdip,results.c,results.ca,results.csehr,results.gen_ave from examinees, results where results.examinee_id = examinees.id and examinees.year = {$year} and examinees.examinee_no = {$examineeNo}";
			$this->query($sql)->build();
			return $this->execute()->fetch_all();
		}

		/*public function countPassed(){
			$this->select("*","results")->greaterEqual_where("gen_ave")->build();
			return $this->execute(array("75"))->rowCount();
		}
		
		public function countFailed(){
			$this->select("*",'results')->lessThan_where("gen_ave")->build();
			return $this->execute(["75"])->rowCount();
		}*/

		public function getTotalExamineePerYear(){
			$data = [];
			$maxYear  = $this->getMinMaxYear()[0]->max_year;
			$minYear  = $this->getMinMaxYear()[0]->min_year;

			for($i = $maxYear; $i >= $minYear; $i--){
				$sb = null;
				$fb = null;
				$minMonth = $this->getMinMaxMonth($i)[0]->min_month;
				$maxMonth = $this->getMinMaxMonth($i)[0]->max_month;
				if($minMonth == $maxMonth){
					$sql = "select id from examinees where month = {$minMonth} and year = {$i}";
					$this->query($sql)->build();
					$fb = $this->execute()->rowCount();
					$sb = 0;
				}else{
					$sql = "select id from examinees where month = {$minMonth} and year = {$i}";
					$this->query($sql)->build();
					$fb = $this->execute()->rowCount();

					$sql = "select id from examinees where month = {$maxMonth} and year = {$i}";
					$this->query($sql)->build();
					$sb = $this->execute()->rowCount();
				}

				$data[$i] = [$fb, $sb,$fb+$sb];
			}

			return $data;
		}

		public function getTotalPassed(){
			$data = [];
			$maxYear  = $this->getMinMaxYear()[0]->max_year;
			$minYear  = $this->getMinMaxYear()[0]->min_year;

			for($i = $maxYear; $i >= $minYear; $i--){
				$sb = null;
				$fb = null;
				$minMonth = $this->getMinMaxMonth($i)[0]->min_month;
				$maxMonth = $this->getMinMaxMonth($i)[0]->max_month;
				if($minMonth == $maxMonth){
					$sql = "Select results.* From examinees, results Where results.gen_ave >= 75 AND examinees.year = {$i} AND month = {$minMonth} AND results.examinee_id = examinees.id";
					$this->query($sql)->build();
					$fb = $this->execute()->rowCount();
					$sb = 0;
				}else{
					$sql = "Select results.* From examinees, results Where results.gen_ave >= 75 AND examinees.year = {$i} AND month = {$minMonth} AND results.examinee_id = examinees.id";
					$this->query($sql)->build();
					$fb = $this->execute()->rowCount();

					$sql = "Select results.* From examinees, results Where results.gen_ave >= 75 AND examinees.year = {$i} AND month = {$maxMonth} AND results.examinee_id = examinees.id";
					$this->query($sql)->build();
					$sb = $this->execute()->rowCount();
				}

				$data[$i] = [$fb, $sb,$fb+$sb];
			}

			return $data;
		}

		public function getTotalFailed(){

			$data = [];
			$maxYear  = $this->getMinMaxYear()[0]->max_year;
			$minYear  = $this->getMinMaxYear()[0]->min_year;

			for($i = $maxYear; $i >= $minYear; $i--){
				$sb = null;
				$fb = null;
				$minMonth = $this->getMinMaxMonth($i)[0]->min_month;
				$maxMonth = $this->getMinMaxMonth($i)[0]->max_month;
				if($minMonth == $maxMonth){
					$sql = "Select results.* From examinees, results Where results.gen_ave < 75 AND examinees.year = {$i} AND month = {$minMonth} AND results.examinee_id = examinees.id";
					$this->query($sql)->build();
					$fb = $this->execute()->rowCount();
					$sb = 0;
				}else{
					$sql = "Select results.* From examinees, results Where results.gen_ave < 75 AND examinees.year = {$i} AND month = {$minMonth} AND results.examinee_id = examinees.id";
					$this->query($sql)->build();
					$fb = $this->execute()->rowCount();

					$sql = "Select results.* From examinees, results Where results.gen_ave < 75 AND examinees.year = {$i} AND month = {$maxMonth} AND results.examinee_id = examinees.id";
					$this->query($sql)->build();
					$sb = $this->execute()->rowCount();
				}

				$data[$i] = [$fb, $sb,$fb+$sb];
			}

			return $data;
		}

		public function getCorrelation(){
			$data = [];
			$maxYear  = $this->getMinMaxYear()[0]->max_year;
			$minYear  = $this->getMinMaxYear()[0]->min_year;
			$examinees = [];
			$results = [];

			for($i = $maxYear; $i >= $minYear; $i--){
					$sql = "select id from examinees where year = {$i}";
					$this->query($sql)->build();
					$ex = $this->execute()->rowCount();
					array_push($examinees, $ex);

					$sql1 = "select DISTINCT(Select Count(*) FROM results,examinees WHERE year = {$i} and examinees.id = results.examinee_id and results.gen_ave >= 75 ) / (SELECT COUNT(*) FROM results, examinees WHERE examinees.id= results.examinee_id and examinees.year = {$i}) * 100 AS percent FROM examinees where year = {$i}";
					$this->query($sql1)->build();
					$res = $this->execute()->fetch_all();
					array_push($results, $res[0]->percent);

			}
			array_push($data, $examinees);
			array_push($data, $results);

			return $data;
		}

		/*public function getgen_aveExamineePerYearSB($year){
			$sql = "select id from examinees where month = (SELECT Max(month) from examinees where year = {$year}) and year = {$year}";
			$this->query($sql)->build();
			return $this->execute()->rowCount();
		}

		public function getgen_avePassedFB($year){
			$sql = "Select results.* From examinees, results Where results.gen_ave >= 75 AND examinees.year = {$year} AND results.examinee_id = examinees.id and examinees.month = (SELECT MIN(month) from examinees where year = {$year})";
			$this->query($sql)->build();
			return $this->execute()->rowCount();
		}

		public function getgen_avePassedSB($year){

			$sql = "Select results.* From examinees, results Where results.gen_ave >= 75 AND examinees.year = {$year} AND results.examinee_id = examinees.id and examinees.month = (SELECT Max(month) from examinees where year = {$year})";
			$this->query($sql)->build();
			return $this->execute()->rowCount();
		}

		public function getgen_aveFailedFB($year){
			$sql = "Select results.* From examinees, results Where results.gen_ave < 75 AND examinees.year = {$year} AND results.examinee_id = examinees.id and examinees.month = (SELECT MIN(month) from examinees where year = {$year})";
			$this->query($sql)->build();
			return $this->execute()->rowCount();
		}

		public function getgen_aveFailedSB($year){
			$sql = "Select results.* From examinees, results Where results.gen_ave < 75 AND examinees.year = {$year} AND results.examinee_id = examinees.id and examinees.month = (SELECT Max(month) from examinees where year = {$year})";
			$this->query($sql)->build();
			return $this->execute()->rowCount();
		}*/

		private function getMinMaxYear(){
			$sql = "select MIN(year) as min_year, MAX(year) as max_year from examinees";
			$this->query($sql)->build();
			return $this->execute()->fetch_all();
		}

		private function getMinMaxMonth($year){
			$sql = "select MIN(month) as min_month, MAX(month) as max_month from examinees where year = {$year}";
			$this->query($sql)->build();
			return $this->execute()->fetch_all();
		}
	}

?>