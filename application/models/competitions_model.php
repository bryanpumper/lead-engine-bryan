<?php
class Competitions_model extends CI_Model {
 
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }

    /**
    * Get product by his is
    * @param int $product_id 
    * @return array
    */
    public function get_competitions_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('competition_tbl_yle');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }

    /**
    * Fetch products data from the database
    * possibility to mix search, filter and order
    * @param int $manufacuture_id 
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
    public function get_competitions($competitions_id=null, $search_string=null, $order=null, $order_type='Asc', $limit_start, $limit_end)
    {
	    
		$this->db->select('competition_tbl_yle.id');
		$this->db->select('competition_tbl_yle.compt_name');
	    $this->db->select('competition_tbl_yle.logo');
	    $this->db->select('competition_tbl_yle.badge_text');
	    $this->db->select('competition_tbl_yle.privacy_text');		
	    $this->db->select('competition_tbl_yle.about_us');				
	    $this->db->select('competition_tbl_yle.prize_details');	
	    $this->db->select('competition_tbl_yle.contest_rules');			
	    $this->db->select('competition_tbl_yle.website_conditions');
	    $this->db->select('competition_tbl_yle.page_link');						
		$this->db->from('competition_tbl_yle');
		if($competitions_id != null && $competitions_id != 0){
			$this->db->where('id', $competitions_id);
		}
		if($search_string){
			$this->db->like('compt_name', $search_string);
		}

		//$this->db->join('manufacturers', 'products.manufacture_id = manufacturers.id', 'left');

		//$this->db->group_by('products.id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('id', $order_type);
		}


		$this->db->limit($limit_start, $limit_end);
		//$this->db->limit('4', '4');


		$query = $this->db->get();
		
		return $query->result_array(); 	
    }

    /**
    * Count the number of rows
    * @param int $manufacture_id
    * @param int $search_string
    * @param int $order
    * @return int
    */
    function count_competitions($competitions_id=null, $search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('competition_tbl_yle');
		if($competitions_id != null && $competitions_id != 0){
			$this->db->where('id', $competitions_id);
		}
		if($search_string){
			$this->db->like('compt_name', $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_competitions($data)
    {
		$insert = $this->db->insert('competition_tbl_yle', $data);
	    return $insert;
	}

    /**
    * Update product
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_competitions($id, $data)
    {
		$this->db->where('id', $id);
		$this->db->update('competition_tbl_yle', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}

    /**
    * Delete product
    * @param int $id - product id
    * @return boolean
    */
	function delete_competitions($id){
		$this->db->where('id', $id);
		$this->db->delete('competition_tbl_yle'); 
	}
 
}
?>	
