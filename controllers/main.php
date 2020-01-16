<?php

class Main extends Controller {

	function Main()
	{
		parent::Controller();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->database();
		$this->load->config('paulitest');
	}
	
	function index()
	{
		$this->session->set_userdata(array('questionId'=>$this->session->userdata('session_id')));
		$data['questionId'] = $this->session->userdata('questionId');

		$data["max_cols"] = $this->config->item('max_cols');
		$data["max_rows"] = $this->config->item('max_rows');
		
		$this->load->view('main_view', $data);
	}

	function result() {
		//authentication, memastikan soal dari aplikasi
		if ($this->input->post('questionId') == ''){
			redirect ('http://google.co.id/search?q=cara+menjadi+orang+jujur');
		}elseif ($this->session->userdata('questionId') == '' || $this->session->userdata('questions') == '') {
			//redirect ('main/session_expired');
			redirect ('main');
		}elseif ($this->input->post('questionId') != $this->session->userdata('questionId')) {
			redirect ('main/session_expired');
		}

		$questions = str_split($this->session->userdata('questions'));
		$max_cols = $this->config->item('max_cols');
		$max_rows = $this->config->item('max_rows');
		//$totalNumbers = $max_cols * $max_rows;
		$totalNumbers = count($questions);
		//6 di sini karena ada 6 interval, berpikir untuk memasukkan ini ke configuration file
		//sebelumnya menghilangkan tanda "," di akhir string
		$numberAnsweredThisInterval = explode(',', substr($this->input->post('numberAnsweredPerInterval'), 0, -1), 6);

		//initiate value
		$rightAnswerPerInterval = array(0,0,0,0,0,0);
		$answers = $this->input->post('answers');
		$intervalIndex = 0;
		$numberCheckedThisInterval = 0;
		$questionIndex = 0;

		$this->session->unset_userdata(array('questionId' => ''));
		$this->session->sess_destroy();

		//memeriksa jawaban
		foreach ($answers as $index => $answer) {

			//lompat di awal setiap baris kecuali di kolom pertama
			if ($index != 0 && ($index % ($max_rows-1) == 0)){
				$questionIndex ++;
			}

			//pindah ke interval berikutnya kalau di interval ini tidak ada yang dijawab
			//tapi tetap tidak continue (karena continue melewatkan jawaban user)
			while ($numberAnsweredThisInterval[$intervalIndex] == 0) {
				$intervalIndex ++;
				$numberCheckedThisInterval = 0;
				if ($intervalIndex > $this->config->item('num_of_intervals') -1) {
					break(2);
				}
			}

			//pindah ke interval berikutnya kalau di interval ini semua jawaban telah dicek
			if ( $numberCheckedThisInterval >= $numberAnsweredThisInterval[$intervalIndex]) {
				$intervalIndex ++;
				$numberCheckedThisInterval = 0;
			}

			//jawaban benar adalah pertanyaan[questionIndex] ditambah pertanyaan dengan questionIndex yang lebih tinggi
			$trueAnswer = substr($questions[$questionIndex] + $questions[$questionIndex+1], -1);

			if ($trueAnswer == $answer) {
				//jawaban user benar, tidak perlu menyiapkan variabel untuk menghitung total benar (di semua interval)
				// karena bisa dihitung dengan array_sum()
				$rightAnswerPerInterval[$intervalIndex] ++;
			}

			$numberCheckedThisInterval++;
			$questionIndex++;
			
		}

		foreach ($numberAnsweredThisInterval as $key=>$value){
			echo "Interval ke-".($key+1).": ";
			echo $rightAnswerPerInterval[$key]."/".$value;
			echo "<br />";
		}
		echo "Total benar : ".array_sum($rightAnswerPerInterval)."/".array_sum($numberAnsweredThisInterval);
		echo "<br />";
		echo "Udah gitu doang.. ";
		echo '<img src="'.base_url().'/paulitest/views/styles/yahoo_bigsmile.gif" alt=":D" />';
		echo '<br />';
		echo anchor(site_url(), 'Coba lagi');
		exit();
		
		
		$data['questions'] = $questions;

		$this->load->view('result_view', $data);
	}

	function session_expired () {
		echo '<h1>Session expired</h1>Session Anda mungkin telah kadaluarsa (lebih dari 7 menit). Sila '.anchor(site_url(), 'cuba lagi');
	}

}

/* End of file main.php */
/* Location: ./paulitest/controllers/main.php */
