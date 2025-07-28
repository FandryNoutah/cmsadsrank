<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class User extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library(array('ion_auth','form_validation'));
        $this->load->helper(array('url','language'));
		$this->load->model("panneau_model");
		$this->load->model("ion_auth_model");
		$this->load->model('MaBase');

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        
    }

    public function index() {
     
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            redirect('admin/user/login', 'refresh');
        }
        elseif (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
        {
            // redirect them to the home page because they must be an administrator to view this
            return show_error('You must be an administrator to view this page.');
        }
        else
        {
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            //list the users
            $this->data['users'] = $this->ion_auth->users()->result();
            foreach ($this->data['users'] as $k => $user)
            {
                $this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
            }

            //$this->_render_page('auth/index', $this->data);
            $this->page = "templates/admin_userlist_page";
            $this->layout();
        }
        
    }

	
	public function login() {
        $this->data['page_title'] = 'Login';

        if($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('identity', 'Identity', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('remember','Remember me','integer');
			$this->data['users'] = $this->ion_auth->users()->result();
			foreach ($this->data['users'] as $k => $user)
            {
             $groups = $this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
            }
			//datadump($groups);
				//	 die();
            if($this->form_validation->run()===TRUE) {
                $remember = (bool) $this->input->post('remember');
                if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                    
					 //$this->page = "admin";
					redirect('admin', 'refresh');
                } else {
                    $this->session->set_flashdata('message',$this->ion_auth->errors());
                    //redirect('admin/user/login', 'refresh');
                }
            }
        }
        
        $this->load->helper('form');
        $this->page = "templates/admin_login_page";
        $this->layout();
    }

	/*public function connectionUser(){
		  $this->data['page_title'] = 'Login';
        $type = $this->input->post('type');
        $username = $this->input->post('login');
        $password = $this->input->post('password');
		$group_id = $this->MaBase->getgroupe_id();
		//$group = $this->MaBase->groupe($group_id);
		
        $user = $this->MaBase->connectionUser($username);
		$iduser = $this->session->set_userdata('id',$user['id']);

        if($user!=null){
					
          $this->session->set_userdata('id',$user['id']);
			
          // $this->session->set_userdata('privilege','ADM');
          $this->session->set_userdata('nom',$user['username']);
         redirect('admin'.$user['id']);	
		  echo('ADMIN');

        }
		$this->load->helper('form');
        $this->page = "templates/admin_login_page";
        $this->layout();
        
      }*/
	
	 public function accedervisuel($group_id,$iduser){
         $this->session->set_userdata('group_id',$group_id);
         $this->session->set_userdata('iduser',$iduser);
         redirect('BaseController/index');
      }


    public function logout() {
        $this->data['title'] = "Logout";

        // log the user out
        $logout = $this->ion_auth->logout();

        // redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('admin', 'refresh');
    }

    // create a new user
    public function create() {
		$sam[""] = "Aucun";
		foreach ($this->panneau_model->get_all_sam() as $allsam) {
			$sam[$allsam->id] = $allsam->label;
		}
		
		$this->data['attributes'] = array(
			'id'    				=> 'status',
			"class" 				=> "form-control border-primary",
			"data-toggle" 			=> "", 
			"data-trigger" 			=> "",
			"data-placement" 		=> "", 
			"data-title" 			=> "Priority",
			"data-original-title" 	=> "", 
			"title" 				=> "",
		);
		
        $this->data['sam_id'] = $sam;
		
        $this->data['title'] = $this->lang->line('create_user_heading');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('auth', 'refresh');
        }

        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        if($identity_column!=='email')
        {
            $this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        }
        else
        {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true)
        {
            $email    = strtolower($this->input->post('email'));
            $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'company'    => $this->input->post('company'),
                'phone'      => $this->input->post('phone'),
				'sam_id'	 => $this->input->post('sam_id'),
            );
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data))
        {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("admin/user", 'refresh');
        }
        else
        {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
            $this->data['first_name'] = array(
                'name'  => 'first_name',
                'id'    => 'first_name',
                'type'  => 'text',
                'class' => 'form-control border-primary',
                'placeholder' => 'Prénom',
                'required' => 'required',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $this->data['last_name'] = array(
                'name'  => 'last_name',
                'id'    => 'last_name',
                'type'  => 'text',
                'class' => 'form-control border-primary',
                'placeholder' => 'Nom',
                'required' => 'required',
                'value' => $this->form_validation->set_value('last_name'),
            );
            $this->data['identity'] = array(
                'name'  => 'identity',
                'id'    => 'identity',
                'type'  => 'text',
                'class' => 'form-control border-primary',
                'placeholder' => 'Login (Nom d\'utilisateur)',
                'required' => 'required',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['email'] = array(
                'name'  => 'email',
                'id'    => 'email',
                'type'  => 'text',
                'class' => 'form-control border-primary',
                'placeholder' => 'Adresse E-mail',
                'required' => 'required',
                'value' => $this->form_validation->set_value('email'),
            );
            $this->data['company'] = array(
                'name'  => 'company',
                'id'    => 'company',
                'type'  => 'text',
                'class' => 'form-control border-primary',
                'placeholder' => 'Société',
                'required' => 'required',
                'value' => $this->form_validation->set_value('company'),
            );
            $this->data['phone'] = array(
                'name'  => 'phone',
                'id'    => 'phone',
                'type'  => 'text',
                'class' => 'form-control border-primary',
                'placeholder' => 'Téléphone',
                'required' => 'required',
                'value' => $this->form_validation->set_value('phone'),
            );
            $this->data['password'] = array(
                'name'  => 'password',
                'id'    => 'password',
                'type'  => 'password',
                'class' => 'form-control border-primary',
                'placeholder' => 'Mot de passe',
                'required' => 'required',
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array(
                'name'  => 'password_confirm',
                'id'    => 'password_confirm',
                'type'  => 'password',
                'class' => 'form-control border-primary',
                'placeholder' => 'Confirmation mot de passe',
                'required' => 'required',
                'value' => $this->form_validation->set_value('password_confirm'),
            );

            $this->page = "templates/admin_usercreate_page";
            $this->layout();

            //$this->_render_page('templates/admin_usercreate_page', $this->data);
        }
    }

    public function edit($id)
    {
        $this->data['title'] = $this->lang->line('edit_user_heading');

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
        {
            redirect('admin/user', 'refresh');
        }

        $user = $this->ion_auth->user($id)->row();
        $groups=$this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
        $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
        $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');

        if (isset($_POST) && !empty($_POST))
        {
            // do we have a valid request?
            if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
            {
                show_error($this->lang->line('error_csrf'));
            }

            // update the password if it was posted
            if ($this->input->post('password'))
            {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
            }

            if ($this->form_validation->run() === TRUE)
            {
                $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name'  => $this->input->post('last_name'),
                    'company'    => $this->input->post('company'),
                    'phone'      => $this->input->post('phone'),
                    'email'      => $this->input->post('email'),
                    'username'   => $this->input->post('identity'),
                );

                // update the password if it was posted
                if ($this->input->post('password'))
                {
                    $data['password'] = $this->input->post('password');
                }



                // Only allow updating groups if user is admin
                if ($this->ion_auth->is_admin())
                {
                    //Update the groups user belongs to
                    $groupData = $this->input->post('groups');

                    if (isset($groupData) && !empty($groupData)) {

                        $this->ion_auth->remove_from_group('', $id);

                        foreach ($groupData as $grp) {
                            $this->ion_auth->add_to_group($grp, $id);
                        }

                    }
                }

            // check to see if we are updating the user
               if($this->ion_auth->update($user->id, $data))
                {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', $this->ion_auth->messages() );
                    if ($this->ion_auth->is_admin())
                    {
                        redirect('admin/user', 'refresh');
                    }
                    else
                    {
                        redirect('/', 'refresh');
                    }

                }
                else
                {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', $this->ion_auth->errors() );
                    if ($this->ion_auth->is_admin())
                    {
                        redirect('admin/user', 'refresh');
                    }
                    else
                    {
                        redirect('/', 'refresh');
                    }

                }

            }
        }

        // display the edit user form
        $this->data['csrf'] = $this->_get_csrf_nonce();

        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        // pass the user to the view
        $this->data['user'] = $user;
        $this->data['groups'] = $groups;
        $this->data['currentGroups'] = $currentGroups;

        $this->data['first_name'] = array(
            'name'  => 'first_name',
            'id'    => 'first_name',
            'type'  => 'text',
            'class' => 'form-control border-primary',
            'required' => 'required',
            'value' => $this->form_validation->set_value('first_name', $user->first_name),
        );
        $this->data['last_name'] = array(
            'name'  => 'last_name',
            'id'    => 'last_name',
            'type'  => 'text',            
            'class' => 'form-control border-primary',
            'required' => 'required',
            'value' => $this->form_validation->set_value('last_name', $user->last_name),
        );
        $this->data['company'] = array(
            'name'  => 'company',
            'id'    => 'company',
            'type'  => 'text',
            'class' => 'form-control border-primary',
            'required' => 'required',
            'value' => $this->form_validation->set_value('company', $user->company),
        );
        $this->data['phone'] = array(
            'name'  => 'phone',
            'id'    => 'phone',
            'type'  => 'text',
            'class' => 'form-control border-primary',
            'required' => 'required',
            'value' => $this->form_validation->set_value('phone', $user->phone),
        );
        $this->data['password'] = array(
            'name' => 'password',
            'id'   => 'password',
            'type' => 'password',
            'class' => 'form-control border-primary',
            'required' => 'required',
        );
        $this->data['password_confirm'] = array(
            'name' => 'password_confirm',
            'id'   => 'password_confirm',
            'type' => 'password',
            'class' => 'form-control border-primary',
            'required' => 'required',
        );
        $this->data['identity'] = array(
            'name' => 'identity',
            'id'   => 'identity',
            'type' => 'text',
            'class' => 'form-control border-primary',
            'required' => 'required',
            'value' => $this->form_validation->set_value('identity', $user->username),
        );
        $this->data['email'] = array(
            'name' => 'email',
            'id'   => 'email',
            'type' => 'email',
            'class' => 'form-control border-primary',
            'required' => 'required',
            'value' => $this->form_validation->set_value('email', $user->email),
        );
        //$this->_render_page('auth/edit_user', $this->data);
        $this->page = "templates/admin_useredit_page";
        $this->layout();
    }

    public function delete($user_id = NULL) {
        if (is_null($user_id)) {
            $this->session->set_flashdata('message', 'There\'s no user to delete');
        } else {
            $this->ion_auth->delete_user($user_id);
            $this->session->set_flashdata('message', $this->ion_auth->messages());
        }
        redirect('admin/user', 'refresh');
    }

    public function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key   = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    public function _valid_csrf_nonce()
    {
        $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue'))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
    {

        $this->viewdata = (empty($data)) ? $this->data: $data;

        $view_html = $this->load->view($view, $this->viewdata, $returnhtml);

        if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
    }
}