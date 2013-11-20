<?php
class Admin_competitions extends CI_Controller {
 
    /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
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
        $competitions_id = $this->input->post('id');        
        $search_string = $this->input->post('search_string');        
        $order = $this->input->post('order'); 
        $order_type = $this->input->post('order_type'); 

        //pagination settings
        $config['per_page'] = 5;
        $config['base_url'] = base_url().'admin/competitions';
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
        if($competitions_id !== false && $search_string !== false && $order !== false || $this->uri->segment(3) == true){ 
           
            /*
            The comments here are the same for line 79 until 99

            if post is not null, we store it in session data array
            if is null, we use the session data already stored
            we save order into the the var to load the view with the param already selected       
            */


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
            //$data['manufactures'] = $this->manufacturers_model->get_manufacturers();

            $data['count_competitions']= $this->competitions_model->count_competitions($competitions_id, $search_string, $order);
            $config['total_rows'] = $data['count_competitions'];

            //fetch sql data into arrays
            if($search_string){
                if($order){
                    $data['competitions'] = $this->competitions_model->get_competitions($competitions_id, $search_string, $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['competitions'] = $this->competitions_model->get_competitions($competitions_id, $search_string, '', $order_type, $config['per_page'],$limit_end);           
                }
            }else{
                if($order){
                    $data['competitions'] = $this->competitions_model->get_competitions($competitions_id, '', $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['competitions'] = $this->competitions_model->get_competitions($competitions_id, '', '', $order_type, $config['per_page'],$limit_end);        
                }
            }

        }else{

            //clean filter data inside section
            //$filter_session_data['manufacture_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            //$data['manufacture_selected'] = 0;
            $data['order'] = 'id';

            //fetch sql data into arrays
            //$data['manufactures'] = $this->manufacturers_model->get_manufacturers();
            $data['count_competitions']= $this->competitions_model->count_competitions();
            $data['competitions'] = $this->competitions_model->get_competitions('', '', '', $order_type, $config['per_page'],$limit_end);        
            $config['total_rows'] = $data['count_competitions'];

        }//!isset($competitions_id) && !isset($search_string) && !isset($order)

        //initializate the panination helper 
        $this->pagination->initialize($config);   

        //load the view
        $data['main_content'] = 'admin/competitions/list';
        $this->load->view('includes/template', $data);  

    }//index

    public function add()
    {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {

            //form validation
            $this->form_validation->set_rules('compt_name', 'compt_name', 'required');
		    $this->form_validation->set_rules('logo', 'logo', 'required');
		    $this->form_validation->set_rules('badge_text', 'badge_text', 'required');
		    $this->form_validation->set_rules('privacy_text', 'privacy_text', 'required');
		    $this->form_validation->set_rules('about_us', 'about_us', 'required');
		    $this->form_validation->set_rules('prize_details', 'prize_details', 'required');
		    $this->form_validation->set_rules('contest_rules', 'contest_rules', 'required');		    
		    $this->form_validation->set_rules('website_conditions', 'website_conditions', 'required');
            $this->form_validation->set_rules('page_link', 'page_link', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                          $data_to_store = array(
                            'compt_name' => $this->input->post('compt_name'),
                                  'logo' => $this->input->post('logo'),
                            'badge_text' => $this->input->post('badge_text'),
                          'privacy_text' => $this->input->post('privacy_text'),          
                              'about_us' => $this->input->post('about_us'),
                         'prize_details' => $this->input->post('prize_details'),
                         'contest_rules' => $this->input->post('contest_rules'),
                    'website_conditions' => $this->input->post('website_conditions'),
                             'page_link' => $this->input->post('page_link'),
                              );
                //if the insert has returned true then we show the flash message
                if($this->competitions_model->store_competitions($data_to_store)){
                    $data['flash_message'] = TRUE; 
                }else{
                    $data['flash_message'] = FALSE; 
                }

            }

        }
        //fetch manufactures data to populate the select field
        //$data['manufactures'] = $this->manufacturers_model->get_manufacturers();
        //load the view
        $data['main_content'] = 'admin/competitions/add';
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
            $this->form_validation->set_rules('compt_name', 'compt_name', 'required');
		    $this->form_validation->set_rules('logo', 'logo', 'required');
		    $this->form_validation->set_rules('badge_text', 'badge_text', 'required');
		    $this->form_validation->set_rules('privacy_text', 'privacy_text', 'required');
		    $this->form_validation->set_rules('about_us', 'about_us', 'required');
		    $this->form_validation->set_rules('prize_details', 'prize_details', 'required');
		    $this->form_validation->set_rules('contest_rules', 'contest_rules', 'required');		    
		    $this->form_validation->set_rules('website_conditions', 'website_conditions', 'required');
            $this->form_validation->set_rules('page_link', 'page_link', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
    
                $data_to_store = array(
                            'compt_name' => $this->input->post('compt_name'),
                                  'logo' => $this->input->post('logo'),
                            'badge_text' => $this->input->post('badge_text'),
                          'privacy_text' => $this->input->post('privacy_text'),          
                              'about_us' => $this->input->post('about_us'),
                         'prize_details' => $this->input->post('prize_details'),
                         'contest_rules' => $this->input->post('contest_rules'),
                    'website_conditions' => $this->input->post('website_conditions'),
                             'page_link' => $this->input->post('page_link'),
                              );
                //if the insert has returned true then we show the flash message
                if($this->competitions_model->update_competitions($id, $data_to_store) == TRUE){
                    $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                redirect('admin/competitions/update/'.$id.'');

            }//validation run

        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data

        //product data 
        $data['product'] = $this->competitions_model->get_competitions_by_id($id);
        //fetch manufactures data to populate the select field
        //$data['manufactures'] = $this->manufacturers_model->get_manufacturers();
        //load the view
        $data['main_content'] = 'admin/competitions/edit';
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
        $this->competitions_model->delete_competitions($id);
        redirect('admin/competitions');
    }//edit

}