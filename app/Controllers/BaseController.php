<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }
    public function layout2($viewpage, $data = [])
    {

    // permissions
       
        $userid = $_SESSION['userid'];
        $condition1['userid'] = $userid;
        $data['userSubscriptions'] = $this->Myprofile_Model->subscriptionDetails('all', $condition1);
        $userDetails = $this->getUserDetails($userid);
        $data['loginUser'] = $userDetails;
        // To show free trial dates
        $currentDate = date('Y-m-d');
        // BEGIN To get user active subscription details
        $condition['userid'] = $condition1['userid'] = $userid;
        $condition['currentDate'] = $currentDate;
        $condition['status'] = '0';
        $condition['orderby'] = 'subscription_id';
        $data['subscription'] = $this->Myprofile_Model->subscriptionDetails('row', $condition);

        $data['current_subscription'] = $this->Myprofile_Model->subscriptionDetails('row', $condition);
        // To get user future subscription
        $condition1['futureSubscription'] = 1;
        $futureSubscription = $this->Myprofile_Model->subscriptionDetails('row', $condition1);
        if($data['subscription'] == '' && isset($futureSubscription) && $futureSubscription !='')
        { $data['subscription'] = $futureSubscription; }
        // END To get user active subscription details
   
        // To get extend trial users
        $trialUsers = getFreeTrialUsers('freetrial_users', $userDetails['email']);
        $free_trial_user = 0;
        $trial_seats = 0;
        if(isset($trialUsers) && !empty($trialUsers))
        {
            $free_trial_user = 1;
            $trial_seats = $this->config->item('extend_trial_seats');
        }
        else{
            $free_trial_user = 0;
            $trial_seats = $this->config->item('trial_seats');
           
        }
        $data['free_trial_user'] = $free_trial_user;
        $data['trial_seats'] = $trial_seats;
        $trial_days = 0;
        $trial_days = ($free_trial_user == 0) ? $this->config->item('trial_days') : $this->config->item('extend_trial_days');
        $data['trial_days'] = $trial_days;

        $trialDate = '';
        $trialDate   = date('Y-m-d', strtotime("+".$trial_days." days", strtotime($userDetails['created_at'])));
        if($currentDate <= $trialDate)
        {
            $data['trialDate'] = $trialDate;
            $dateDiff    = strtotime($trialDate) - strtotime($currentDate);
            $data['interval'] = abs(round($dateDiff / 86400));
        }
        else{
       
            $data['interval'] = 0;
         }
        // To get team member detail
       
        $tmDetails = getRecordOnId('users_plumber', ['user_id' => $_SESSION['userid']]);
       // $tmDetails = getRecordOnId('users_plumber', ['user_id' => '33']);
        //echo "<pre>";print_r($tmDetails);die;
        $findarweb = '';
        $data['permission_edit']= array();
        $data['permission_view']= array();
        $permissionVal = '1,2,3,4,5,35,37,32,29,10';
        $data['mytype'] = (trim($userDetails['type']) !='') ? trim($userDetails['type']) : '';
        //if(isset($tmDetails) && !empty($tmDetails) && $tmDetails->company_user != 1 && $tmDetails->findarweb == 1)
        if(isset($tmDetails) && !empty($tmDetails)  && $tmDetails->manager_user == 0 && $tmDetails->findarweb == 1)
        {
            $data['permission_edit'] = explode(',', $tmDetails->permission_edit);
            $data['permission_view'] = explode(',', $tmDetails->permission_view);
        }
        else if(isset($tmDetails) && !empty($tmDetails) && $tmDetails->manager_user == 1)
        //else if(isset($tmDetails) && !empty($tmDetails) && $tmDetails->findarweb == 0)
        {
            $data['permission_edit'] = explode(',', $permissionVal);
            $data['permission_view'] = explode(',', $permissionVal);
        }
       
        if (!isset($data['exception'])) {
            $this->middleware();
        }
        //echo "<pre>";print_r($data['permission_edit']);die;
        $this->load->view('template/leftsidebar', $data);
        //$this->load->view('template/header', $data);
        $this->load->view($viewpage, $data);
        $this->load->view('template/footer');
    }
}
