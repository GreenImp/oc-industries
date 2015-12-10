<?php namespace GreenImp\Industries\Models;

use Model;
use Cms\Classes\Page;

/**
 * Settings Model
 * @link https://octobercms.com/docs/database/model
 */
class Settings extends Model
{
  public $implement       = ['System.Behaviors.SettingsModel'];

  public $settingsCode    = 'greenimp_industries_code';

  public $settingsFields  = 'fields.yaml';

  public function getIndustryPageOptions(){
    return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
  }
}
