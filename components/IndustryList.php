<?php namespace GreenImp\Industries\Components;

use Cms\Classes\ComponentBase;
use GreenImp\Industries\Classes\Industries;
use GreenImp\Industries\Models\Industry;

class IndustryList extends ComponentBase
{
  public $industryPage  = '';

  public function componentDetails()
  {
    return [
      'name'        => 'Industry list',
      'description' => 'Displays a list of industries'
    ];
  }

  public function defineProperties()
  {
    return [
      'maxItems'  => [
        'title'             => 'Max items',
        'description'       => 'The most amount of industries to show',
        'default'           => '',
        'type'              => 'string',
        'validationPattern' => '^[0-9]*$',
        'validationMessage' => 'The `Max items` property can only contain numeric symbols',
        'placeholder'       => '0 = unlimited'
      ]
    ];
  }

  public function onRun(){
    $this->industryPage  = Industries::getIndustryPage();
  }

  public function industries(){
    $limit  = $this->property('maxItems', 0);

    $query  = Industry::isActive();

    // limit the results
    if($limit > 0){
      $query->take($limit);
    }

    return $query->get();
  }
}
