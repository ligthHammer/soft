<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class BaseController extends CI_Controller {

	private $css; // css a incluir a la plantilla
	private $js; // js a incluir a la plantilla

	public function __construct()
	{
		parent::__construct();

		$this->load->model("BaseModel");
		$this->css = array();
		$this->js = array();
	}

	public function init($view,$array = array())
	{

		/*if(isset($_SESSION["user"])){*/
			$data["view"] = $view;
			if(count($array)>0) {
				$data["param"] = $array;
			}
			#$data["permisos"] = $this->BaseModel->permisos();

			$this->load->view("layout",$data);
		/*}else{
			redirect('loginController');
		}*/

	}

	public function cargar_css($css_array)
	{
		for($i = 0 ; $i < count($css_array) ; $i++) {
			$this->css[] = '<link href="'.base_url('public/css/'.$css_array[$i]).'" rel="stylesheet" />';
		}

		return $this->css;
	}


	public function cargar_js($js_array)
	{
		for($i = 0 ; $i < count($js_array) ; $i++) {
			$this->js[] = '<script src="'.base_url('public/app_js/'.$js_array[$i]).'"></script>';
		}
		return $this->js;
	}


	public function desencriptar($array,$campos)
	{
		$select = array(""=>"Seleccione");

		if(count($array)>0) {
			foreach ($array as $value) {

				$select[$value->$campos[0]] = $value->$campos[1];
			}
		}

		return $select;
	}

	public function prepare($dato){
		$dato=  str_replace('../../public/images/tmp', $this->config->config['base_url'].'/public/images/tmp', $dato);
		$dato= str_replace('../public/images/tmp', $this->config->config['base_url'].'/public/images/tmp', $dato);
		return $dato;
	}

	public function grilla($columns,$table,) {

		$total_registros = $this->db->get_where($table,array("estado"=>"1"))->num_rows();
		$sql = "select ";
		for ($i=0; $i < count($columns) ; $i++) {
			if($i == count($columns)-1) {
				$sql .= $columns[$i];
			} else {
				$sql .= $columns[$i].", ";
			}

		}

		$this->db->select($sql)->get($table)->result();
	}



}



