<?php namespace GreenImp\Industries\Models;

use Model;

/**
 * ApplicationProduct Pivot Model
 * @link https://octobercms.com/docs/database/model
 */
class ApplicationProductMode extends Model
{

  /**
   * @var string The database table used by the model.
   */
  public $table = 'greenimp_industries_application_product_mode';

  /**
   * @var array Guarded fields
   */
  protected $guarded = [];

  /**
   * @var array Fillable fields
   */
  protected $fillable = [
    'product_id',
    'product_mode_id'
  ];

  /**
   * @var array Relations
   */
  public $hasOne = [];
  public $hasMany = [];
  public $belongsTo = [
    'application' => 'GreenImp\Industries\Models\Application',
    'product'     => 'GreenImp\TelcoProducts\Models\Product',
    'productMode' => 'GreenImp\TelcoProducts\Models\ProductMode'
  ];
  public $belongsToMany = [];
  public $morphTo = [];
  public $morphOne = [];
  public $morphMany = [];
  public $attachOne = [];
  public $attachMany = [];
}
