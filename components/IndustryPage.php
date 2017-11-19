<?php namespace GreenImp\Industries\Components;

use Cms\Classes\ComponentBase;
use GreenImp\Industries\Models\Industry;

class IndustryPage extends ComponentBase
{
  public $industry;

  public function componentDetails()
  {
    return [
      'name'        => 'Industry page',
      'description' => 'Outputs an industry page in a CMS layout.'
    ];
  }

  public function defineProperties()
  {
    return [];
  }

  public function onRun(){
    $industryID = $this->param('industry_id');

    $query  = Industry::isActive();

    if(!is_numeric($industryID) || ($industryID < 1)){
      $this->industry  = $query->where('url_slug', $industryID)->first();
    }else{
      $this->industry  = $query->find($industryID);
    }
  }

  public function relatedProducts(){
    $collection = collect();

    foreach($this->industry->application()->has('productAndMode')->get() as $application){
      $collection = $collection->merge($application->productAndMode);
    }

    return $collection;
  }
}
