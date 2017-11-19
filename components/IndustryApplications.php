<?php namespace GreenImp\Industries\Components;

use Cms\Classes\ComponentBase;
use GreenImp\Industries\Models\Industry;
use GreenImp\TelcoProducts;

class IndustryApplications extends ComponentBase
{
  public $industry;
  public $applications;
  public $carousel  = false;

  public function componentDetails()
  {
    return [
      'name'        => 'Industry applications',
      'description' => 'Outputs industry applications for an industry.'
    ];
  }

  public function defineProperties()
  {
      return [
        'carousel'  => [
          'title'             => 'Carousel',
          'description'       => 'Whether to show the applications in a carousel or not',
          'default'           => false,
          'type'              => 'checkbox',
        ]
      ];
  }

  public function onRun(){
    // get the industry and its applications
    $industryID = $this->param('industry_id');

    $query  = Industry::isActive();

    if(!is_numeric($industryID) || ($industryID < 1)){
      $this->industry  = $query->where('url_slug', $industryID)->first();
    }else{
      $this->industry  = $query->find($industryID);
    }

    if($this->industry){
      $this->applications = $this->industry->application()->isActive()->get();
    }else{
      // no industry - check for product and mode
      $mode     = TelcoProducts\Classes\Menu::getProductModeFromIdOrSlug($this->param('product_mode_id'));
      $product  = TelcoProducts\Classes\Menu::getProductFromIdOrSlug($this->param('product_id'));

      if(!is_null($mode) && !is_null($product)){
        $this->applications = collect();

        foreach($product->applicationAndMode()->hasMode($mode->id)->get() as $applicationMode){
          $this->applications->push($applicationMode->application);
        }
      }
    }


    // check if we're using a carousel
    $this->carousel = $this->property('carousel', false);

    // if we're using the carousel, we need to include the carousel JS/CSS
    if($this->carousel) {
      //$this->addCss('assets/vendor/slick/slick.css');
      //$this->addCss('assets/vendor/slick/slick-theme.css');
      //$this->addJs('assets/vendor/slick/slick.min.js');
      $this->addJs('assets/js/plugin.js');
    }
  }
}
