<?php namespace GreenImp\Industries\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Offices Back-end Controller
 */
class Applications extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig      = 'config_form.yaml';
    public $listConfig      = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('GreenImp.Industries', 'industries', 'applications');
    }

  public function index(){
    // Call the ListController behavior index() method
    $this->asExtension('ListController')->index();
  }
}
