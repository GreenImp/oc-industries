<?php namespace GreenImp\Industries\Classes;

use URL;
use Cms\Classes\Page;
use Cms\Classes\Theme;
use GreenImp\Industries\Models\Industry;

/**
 * Represents industries
 *
 * @package greenimp\insdustries
 */
class Industries{
  public static function getIndustryPage(){
    $settings   = \GreenImp\Industries\Models\Settings::instance();
    return $settings->industryPage;
  }

  public static function getIndustryPageURL(Industry $industry){
    return Page::url(self::getIndustryPage(), ['industry_id' => $industry->url_slug]);
  }

  /**
   * Handler for the pages.menuitem.getTypeInfo event.
   * Returns a menu item type information. The type information is returned as array
   * with the following elements:
   * - references - a list of the item type reference options. The options are returned in the
   *   ["key"] => "title" format for options that don't have sub-options, and in the format
   *   ["key"] => ["title"=>"Option title", "items"=>[...]] for options that have sub-options. Optional,
   *   required only if the menu item type requires references.
   * - nesting - Boolean value indicating whether the item type supports nested items. Optional,
   *   false if omitted.
   * - dynamicItems - Boolean value indicating whether the item type could generate new menu items.
   *   Optional, false if omitted.
   * - cmsPages - a list of CMS pages (objects of the Cms\Classes\Page class), if the item type requires a CMS page reference to
   *   resolve the item URL.
   * @param string $type Specifies the menu item type
   * @return array Returns an array
   */
  public static function getMenuTypeInfo($type)
  {
    if($type == 'industries-all-industries'){
      return [
        'dynamicItems' => true
      ];
    }elseif($type == 'industries-industry'){
      return [
        'references'   => self::listIndustryMenuOptions()
      ];
    }

    return [];
  }

  /**
   * Returns a list of options for the Reference drop-down menu in the
   * menu item configuration form, when the group item type is selected.
   * @return array Returns an array
   */
  protected static function listIndustryMenuOptions()
  {
    $result = [];

    foreach(Industry::isActive()->get() as $industry){
      $result[$industry->id]  = $industry->name;
    }

    return $result;
  }

  /**
   * Handler for the pages.menuitem.resolveItem event.
   * Returns information about a menu item. The result is an array
   * with the following keys:
   * - url - the menu item URL. Not required for menu item types that return all available records.
   *   The URL should be returned relative to the website root and include the subdirectory, if any.
   *   Use the URL::to() helper to generate the URLs.
   * - isActive - determines whether the menu item is active. Not required for menu item types that
   *   return all available records.
   * - items - an array of arrays with the same keys (url, isActive, items) + the title key.
   *   The items array should be added only if the $item's $nesting property value is TRUE.
   * @param \RainLab\Pages\Classes\MenuItem $item Specifies the menu item.
   * @param \Cms\Classes\Theme $theme Specifies the current theme.
   * @param string $url Specifies the current page URL, normalized, in lower case
   * The URL is specified relative to the website root, it includes the subdirectory name, if any.
   * @return mixed Returns an array. Returns null if the item cannot be resolved.
   */
  public static function resolveMenuItem($item, $url, $theme)
  {
    $result = [];

    if($item->type == 'industries-industry'){
      $industry = Industry::isActive()->find($item->reference);

      if(!is_null($industry)){
        $result['url'] = self::getIndustryPageURL($industry);
        $result['isActive'] = $result['url'] == $url;
      }
    }

    if($item->nesting || ($item->type == 'industries-all-industries')){
      $iterator = function($items) use (&$iterator, $url){
        $branch = [];

        foreach($items as $item){
          $branchItem = [];
          $branchItem['url']      = self::getIndustryPageURL($item);
          $branchItem['isActive'] = $branchItem['url'] == $url;
          $branchItem['title']    = $item->name;

          $branch[] = $branchItem;
        }

        return $branch;
      };

      $result['items'] = $iterator($item->type == 'industries-industry' ? (isset($industry) ? [$industry] : []) : Industry::isActive()->get());
    }

    return $result;
  }
}
