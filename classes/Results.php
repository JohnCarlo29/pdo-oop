<?php 
	class Results extends Database{

		public function __construct(){
			parent::__construct();
		}

		public function getExamineeResult($id){
			$this->select("*","results")->where("id")->build();
			return $this->execute([$id])->fetch();
		}


		public function updateResult($id,$test1,$test2,$test3,$test4,$test5,$test6){
			$total = (($test1*.20) + ($test2*.20) + ($test3*.15) + ($test4*.20) + ($test5*.10) + ($test6*.15));
			$this->update("results", "cjp")->up_new_field("lea")->up_new_field("cdip")->up_new_field("c")->up_new_field("ca")->up_new_field("csehr")->up_new_field("gen_ave")->where("examinee_id")->build();
			$update = $this->execute([$test1,$test2,$test3,$test4,$test5,$test6,$total,$id]);
			if(!$update){
				return false;
			}
			return true;
		}


		private function getMinMaxYear(){
			$sql = "select MIN(year) as min_year, MAX(year) as max_year from examinees";
			$this->query($sql)->build();
			return $this->execute()->fetch_all();
		}


		public function getPerYearPass(){

			$data = [];
			$maxYear  = $this->getMinMaxYear()[0]->max_year;
			if($maxYear-1 == $this->getMinMaxYear()[0]->min_year){
				$minYear  = $this->getMinMaxYear()[0]->min_year;	
			}else{
				$minYear = $maxYear - 2;
			}

			for ($i = $minYear ; $i<=$maxYear; $i++){
				$sql = "select Distinct year , (Select Count(*) FROM results,examinees WHERE year = ".$i." and examinees.id = results.examinee_id and results.cjp >= 75) / (SELECT COUNT(*) FROM results, examinees WHERE examinees.id= results.examinee_id and examinees.year = ".$i.") * 100 AS cjp, (Select Count(*) FROM results,examinees WHERE year = ".$i." and examinees.id = results.examinee_id and results.lea >= 75) / (SELECT COUNT(*) FROM results, examinees WHERE examinees.id= results.examinee_id and examinees.year = ".$i.") * 100 AS lea, (Select Count(*) FROM results,examinees WHERE year = ".$i." and examinees.id = results.examinee_id and results.cdip >= 75) / (SELECT COUNT(*) FROM results, examinees WHERE examinees.id= results.examinee_id and examinees.year = ".$i.") * 100 AS cdip, (Select Count(*) FROM results,examinees WHERE year = ".$i." and examinees.id = results.examinee_id and results.c >= 75) / (SELECT COUNT(*) FROM results, examinees WHERE examinees.id= results.examinee_id and examinees.year = ".$i.") * 100 AS c, (Select Count(*) FROM results,examinees WHERE year = ".$i." and examinees.id = results.examinee_id and results.ca >= 75) / (SELECT COUNT(*) FROM results, examinees WHERE examinees.id= results.examinee_id and examinees.year = ".$i.") * 100 AS ca, (Select Count(*) FROM results,examinees WHERE year = ".$i." and examinees.id = results.examinee_id and results.csehr >= 75) / (SELECT COUNT(*) FROM results, examinees WHERE examinees.id= results.examinee_id and examinees.year = ".$i.") * 100 AS csehr from examinees where year = ".$i;
				$this->query($sql)->build();
				$data[] = $this->execute()->fetch_all();
			}

			return $data;
		}
		
		public function getPerBatchResult(){
			$data = [];
			$data['year'] = [];
			$data['first'] = [];
			$data['second'] = [];
			

			$maxYear  = $this->getMinMaxYear()[0]->max_year;
			if($maxYear-1 == $this->getMinMaxYear()[0]->min_year){
				$minYear  = $this->getMinMaxYear()[0]->min_year;	
			}else{
				$minYear = $maxYear-2;
			}

			for ($i = $minYear ; $i<=$maxYear; $i++){
				array_push($data['year'], $i);
				$sql = "select DISTINCT(Select Count(*) FROM results,examinees WHERE year = {$i} and examinees.id = results.examinee_id and results.gen_ave >= 75 and month = (SELECT MIN(month) from examinees where year = {$i}) ) / (SELECT COUNT(*) FROM results, examinees WHERE examinees.id= results.examinee_id and examinees.year = {$i} and month = (SELECT MIN(month) from examinees where year = {$i})) * 100 AS percent FROM examinees where year = {$i}";
				$this->query($sql)->build();
				$result = $this->execute()->fetch_all();
				array_push($data['first'], $result[0]->percent);
				$sql1 = "select DISTINCT(Select Count(*) FROM results,examinees WHERE year = {$i} and examinees.id = results.examinee_id and results.gen_ave >= 75 and month = (SELECT MAX(month) from examinees where year = {$i}) ) / (SELECT COUNT(*) FROM results, examinees WHERE examinees.id= results.examinee_id and examinees.year = {$i} and month = (SELECT MAX(month) from examinees where year = {$i})) * 100 AS percent FROM examinees where year = {$i}";
				$this->query($sql1)->build();
				$result1 = $this->execute()->fetch_all();
				array_push($data['second'], $result1[0]->percent);
				
			}
			return $data;

		}

		public function getPerYearBatchTotal(){
			$data = [];
			$data['year'] = [];
			$data['fbtotal'] = [];
			$data['sbtotal'] = [];

			$maxYear  = $this->getMinMaxYear()[0]->max_year;
			if($maxYear-1 == $this->getMinMaxYear()[0]->min_year){
				$minYear  = $this->getMinMaxYear()[0]->min_year;	
			}else{
				$minYear = $maxYear-2;
			}

			for ($i = $minYear ; $i<=$maxYear; $i++){
				array_push($data['year'], $i);
				$sql = "Select Count(*) as fbtotal from examinees where year = ".$i." and month = (Select MIN(month) from examinees where year = ".$i.")";
				$this->query($sql)->build();
				$result = $this->execute()->fetch_all();
				array_push($data['fbtotal'], $result[0]->fbtotal);

				$sql1 = "Select Count(*) as sbtotal from examinees where year = ".$i." and month = (Select MAX(month) from examinees where year = ".$i.")";
				$this->query($sql1)->build();
				$result1 = $this->execute()->fetch_all();
				array_push($data['sbtotal'], $result1[0]->sbtotal);
			}

			return $data;
		}

		public function getPerYearPercentage(){
			$data = [];
			$maxYear  = $this->getMinMaxYear()[0]->max_year;
			if($maxYear-1 == $this->getMinMaxYear()[0]->min_year){
				$minYear  = $this->getMinMaxYear()[0]->min_year;	
			}else{
				$minYear = $maxYear - 2;
			}

			for ($i = $minYear ; $i<=$maxYear; $i++){
				$sql = "select Distinct year , (Select Count(*) FROM results,examinees WHERE year = ".$i." and examinees.id = results.examinee_id and results.gen_ave >= 75) / (SELECT COUNT(*) FROM results, examinees WHERE examinees.id= results.examinee_id and examinees.year = ".$i.") * 100 AS percent FROM examinees where year = ".$i;
				$this->query($sql)->build();
				$data[] = $this->execute()->fetch_all();
			}

			return $data;		
		}

		public function addNPR($year, $batch, $result){
			$this->insert('npr',['year', 'batch', 'result'])->build();
			$insertion = $this->execute([$year, $batch, $result]);
			if($insertion){
				return true;
			}else{
				return false;
			}
		}

		public function getNPR(){
			$data = [];
			$batch1 = [];
			$batch2 = [];
			

			$sql = "SELECT year, result FROM `npr` where batch = 0 and year BETWEEN (select Max(year)-2 from npr ) and (SELECT MAX(year) from npr)";
			$this->query($sql)->build();
			$results = $this->execute()->fetch_all();

			foreach($results as $result){
				$batch1[$result->year] = $result->result;
			}

			$sql = "SELECT year, result FROM `npr` where batch = 1 and year BETWEEN (select Max(year)-2 from npr ) and (SELECT MAX(year) from npr)";
			$this->query($sql)->build();
			$results1 = $this->execute()->fetch_all();

			foreach($results1 as $result){
				$batch2[$result->year] = $result->result;
			}

			$diffs = array_diff_key($batch1, $batch2);

			foreach ($diffs as $key => $value) {
				$batch2[$key] = 0;
			}

			ksort($batch1);
			ksort($batch2);

			array_push($data, array_keys($batch1));
			array_push($data, $batch1);
			array_push($data, $batch2);

			return $data;
		}
	}

?>