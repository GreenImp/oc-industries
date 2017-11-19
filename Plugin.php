<?php namespace GreenImp\Industries;

use Event;
use Backend\Facades\Backend;
use System\Classes\PluginBase;

/**
 * Offices Plugin Information File
 */
class Plugin extends PluginBase
{
  /**
   * @var array Plugin dependencies
   */
  public $require = ['GreenImp.TelcoProducts'];

  /**
   * Returns information about this plugin.
   *
   * @return array
   */
  public function pluginDetails()
  {
    return [
      'name'        => 'greenimp.industries::lang.app.name',
      'description' => 'No description provided yet...',
      'author'      => 'GreenImp',
      'icon'        => 'icon-cubes'
    ];
  }

  public function registerComponents(){
    return [
      'GreenImp\Industries\Components\IndustryList'         => 'industryList',
      'GreenImp\Industries\Components\IndustryPage'         => 'industryPage',
      'GreenImp\Industries\Components\IndustryApplications' => 'industryApplications'
    ];
  }

  public function registerPermissions(){
    return [
      'greenimp.industries.manage_industries'  => [
        'tab'   => 'Industries',
        'label' => 'Manage industries',
        'order' => 200
      ],
      'greenimp.industries.manage_applications'  => [
        'tab'   => 'Industries',
        'label' => 'Manage applications',
        'order' => 200
      ]
    ];
  }

  public function registerNavigation(){
    return [
      'industries'  => [
        'label'       => 'greenimp.industries::lang.app.name',
        'url'         => Backend::url('greenimp/industries/industries'),
        'icon'        => 'icon-cubes',
        'permissions' => ['greenimp.industries.*'],
        'order'       => 500,

        'sideMenu'    => [
          'industries'    => [
            'label'       => 'greenimp.industries::lang.general.industries',
            'url'         => Backend::url('greenimp/industries/industries'),
            'icon'        => 'icon-cubes',
            'permissions' => ['greenimp.industries.manage_industries']
          ],
          'applications'  => [
            'label'       => 'greenimp.industries::lang.general.applications',
            'url'         => Backend::url('greenimp/industries/applications'),
            'icon'        => 'icon-plug',
            'permissions' => ['greenimp.industries.manage_applications'],
            'order'       => 500
          ]
        ]
      ]
    ];
  }

  public function registerSettings(){
    return [
      'settings'  => [
        'label'       => 'Industries',
        'description' => 'Manage industry settings.',
        'icon'        => 'icon-cubes',
        'class'       => 'GreenImp\Industries\Models\Settings'
      ]
    ];
  }

  public function boot(){
    Event::listen('pages.menuitem.listTypes', function(){
      return [
        'industries-industry'       => 'Industry',
        'industries-all-industries' => 'All industries'
      ];
    });

    Event::listen('pages.menuitem.getTypeInfo', function($type){
      if(($type == 'industries-industry') || ($type == 'industries-all-industries')){
        return \GreenImp\Industries\Classes\Industries::getMenuTypeInfo($type);
      }
    });

    Event::listen('pages.menuitem.resolveItem', function($type, $item, $url, $theme){
      if(($type == 'industries-industry') || ($type == 'industries-all-industries')){
        return \GreenImp\Industries\Classes\Industries::resolveMenuItem($item, $url, $theme);
      }
    });

    \GreenImp\TelcoProducts\Models\Product::extend(function($model){
      $model->hasMany['applicationAndMode'] = [
        'GreenImp\Industries\Models\ApplicationProductMode',
        'table' => 'greenimp_industries_application_product_mode'
      ];
    });
  }
}
