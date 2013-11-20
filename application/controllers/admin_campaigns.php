<?php
class Admin_campaigns extends CI_Controller {
 
    /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('campaigns_model');
        $this->load->model('competitions_model');

        if(!$this->session->userdata('is_logged_in')){
            redirect('admin/login');
        }
    }
 
    /**
    * Load the main view with all the current model model's data.
    * @return void
    */
    public function index()
    {

        //all the posts sent by the view
        $associated_competition = $this->input->post('associated_competition');        
        $search_string = $this->input->post('search_string');        
        $order = $this->input->post('order'); 
        $order_type = $this->input->post('order_type'); 

        //pagination settings
        $config['per_page'] = 5;
        $config['base_url'] = base_url().'admin/campaigns';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        //limit end
        $page = $this->uri->segment(3);

        //math to get the initial record to be select in the database
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0){
            $limit_end = 0;
        } 

        //if order type was changed
        if($order_type){
            $filter_session_data['order_type'] = $order_type;
        }
        else{
            //we have something stored in the session? 
            if($this->session->userdata('order_type')){
                $order_type = $this->session->userdata('order_type');    
            }else{
                //if we have nothing inside session, so it's the default "Asc"
                $order_type = 'Asc';    
            }
        }
        //make the data type var avaible to our view
        $data['order_type_selected'] = $order_type;        


        //we must avoid a page reload with the previous session data
        //if any filter post was sent, then it's the first time we load the content
        //in this case we clean the session filter data
        //if any filter post was sent but we are in some page, we must load the session data

        //filtered && || paginated
        if($associated_competition !== false && $search_string !== false && $order !== false || $this->uri->segment(3) == true){ 
           
            /*
            The comments here are the same for line 79 until 99

            if post is not null, we store it in session data array
            if is null, we use the session data already stored
            we save order into the the var to load the view with the param already selected       
            */

            if($associated_competition !== 0){
                $filter_session_data['competitions_selected'] = $associated_competition;
            }else{
                $associated_competition = $this->session->userdata('competitions_selected');
            }
            $data['competitions_selected'] = $associated_competition;

            if($search_string){
                $filter_session_data['search_string_selected'] = $search_string;
            }else{
                $search_string = $this->session->userdata('search_string_selected');
            }
            $data['search_string_selected'] = $search_string;

            if($order){
                $filter_session_data['order'] = $order;
            }
            else{
                $order = $this->session->userdata('order');
            }
            $data['order'] = $order;

            //save session data into the session
            $this->session->set_userdata($filter_session_data);

            //fetch manufacturers data into arrays
            $data['competitions'] = $this->competitions_model->get_competitions();

            $data['count_campaigns']= $this->campaigns_model->count_campaigns($associated_competition, $search_string, $order);
            $config['total_rows'] = $data['count_campaigns'];

            //fetch sql data into arrays
            if($search_string){
                if($order){
                    $data['campaigns'] = $this->campaigns_model->get_campaigns($associated_competition, $search_string, $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['campaigns'] = $this->campaigns_model->get_campaigns($associated_competition, $search_string, '', $order_type, $config['per_page'],$limit_end);           
                }
            }else{
                if($order){
                    $data['campaigns'] = $this->campaigns_model->get_campaigns($associated_competition, '', $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['campaigns'] = $this->campaigns_model->get_campaigns($associated_competition, '', '', $order_type, $config['per_page'],$limit_end);        
                }
            }

        }else{

            //clean filter data inside section
            $filter_session_data['competitions_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['competitions_selected'] = 0;
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['competitions'] = $this->competitions_model->get_competitions();
            $data['count_campaigns']= $this->campaigns_model->count_campaigns();
            $data['campaigns'] = $this->campaigns_model->get_campaigns('', '', '', $order_type, $config['per_page'],$limit_end);        
            $config['total_rows'] = $data['count_campaigns'];

        }//!isset($associated_competition) && !isset($search_string) && !isset($order)

        //initializate the panination helper 
        $this->pagination->initialize($config);   

        //load the view
        $data['main_content'] = 'admin/campaigns/list';
        $this->load->view('includes/template', $data);  

    }//index

    public function add()
    {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {

            //form validation
			$this->form_validation->set_rules('campaign_name', 'campaign_name', 'required');
			$this->form_validation->set_rules('campaign_description', 'campaign_description', 'required');
			$this->form_validation->set_rules('campaign_type', 'campaign_type', 'required');			
			$this->form_validation->set_rules('associated_competition', 'associated_competition', 'required');			
			$this->form_validation->set_rules('campaign_start_date', 'campaign_start_date', 'required');
			$this->form_validation->set_rules('campaign_end_date', 'campaign_end_date', 'required');
			$this->form_validation->set_rules('campaign_url', 'campaign_url', 'required');			
			$this->form_validation->set_rules('alert_preferences', 'alert_preferences', 'required');
			$this->form_validation->set_rules('survey_questions', 'survey_questions', 'required');
			$this->form_validation->set_rules('offers_creation', 'offers_creation', 'required');
			$this->form_validation->set_rules('default_emails', 'default_emails', 'required');		
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                              $data_to_store = array(
                             'campaign_name' => $this->input->post('campaign_name'),
                      'campaign_description' => $this->input->post('campaign_description'),
                             'campaign_type' => $this->input->post('campaign_type'),
                    'associated_competition' => $this->input->post('associated_competition'),
                       'campaign_start_date' => $this->input->post('campaign_start_date'),                    
                         'campaign_end_date' => $this->input->post('campaign_end_date'), 					
                              'campaign_url' => $this->input->post('campaign_url'),					
                         'alert_preferences' => $this->input->post('alert_preferences'),
                          'survey_questions' => $this->input->post('survey_questions'),
                           'offers_creation' => $this->input->post('offers_creation'),
                            'default_emails' => $this->input->post('default_emails')
                             );
							 
                //if the insert has returned true then we show the flash message
                if($this->campaigns_model->store_campaigns($data_to_store)){
                    $data['flash_message'] = TRUE; 
                }else{
                    $data['flash_message'] = FALSE; 
                }

            }

        }
        //fetch competitions data to populate the select field
        $data['competitions'] = $this->competitions_model->get_competitions();
        //load the view
        $data['main_content'] = 'admin/campaigns/add';
        $this->load->view('includes/template', $data);  
    }       

    /**
    * Update item by his id
    * @return void
    */
    public function update()
    {
        //product id 
        $id = $this->uri->segment(4);
  
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
			$this->form_validation->set_rules('campaign_name', 'campaign_name', 'required');
			$this->form_validation->set_rules('campaign_description', 'campaign_description', 'required');
			$this->form_validation->set_rules('campaign_type', 'campaign_type', 'required');			
			$this->form_validation->set_rules('associated_competition', 'associated_competition', 'required');			
			$this->form_validation->set_rules('campaign_start_date', 'campaign_start_date', 'required');
			$this->form_validation->set_rules('campaign_end_date', 'campaign_end_date', 'required');
			$this->form_validation->set_rules('campaign_url', 'campaign_url', 'required');			
			$this->form_validation->set_rules('alert_preferences', 'alert_preferences', 'required');
			$this->form_validation->set_rules('survey_questions', 'survey_questions', 'required');
			$this->form_validation->set_rules('offers_creation', 'offers_creation', 'required');
			$this->form_validation->set_rules('default_emails', 'default_emails', 'required');	
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
    
                              $data_to_store = array(
                             'campaign_name' => $this->input->post('campaign_name'),
                      'campaign_description' => $this->input->post('campaign_description'),
                             'campaign_type' => $this->input->post('campaign_type'),
                    'associated_competition' => $this->input->post('associated_competition'),
                       'campaign_start_date' => $this->input->post('campaign_start_date'),                    
                         'campaign_end_date' => $this->input->post('campaign_end_date'), 					
                              'campaign_url' => $this->input->post('campaign_url'),					
                         'alert_preferences' => $this->input->post('alert_preferences'),
                          'survey_questions' => $this->input->post('survey_questions'),
                           'offers_creation' => $this->input->post('offers_creation'),
                            'default_emails' => $this->input->post('default_emails')
                             );
							 
                //if the insert has returned true then we show the flash message
                if($this->campaigns_model->update_campaigns($id, $data_to_store) == TRUE){
                    $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                redirect('admin/campaigns/update/'.$id.'');

            }//validation run

        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data

        //product data 
        $data['campaigns'] = $this->campaigns_model->get_campaigns_by_id($id);
        //fetch competitions data to populate the select field
        $data['competitions'] = $this->competitions_model->get_competitions();
        //load the view
        $data['main_content'] = 'admin/campaigns/edit';
        $this->load->view('includes/template', $data);            

    }//update

    /**
    * Delete product by his id
    * @return void
    */
    public function delete()
    {
        //product id 
        $id = $this->uri->segment(4);
        $this->campaigns_model->delete_campaigns($id);
        redirect('admin/campaigns');
    }//edit

}