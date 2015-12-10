<?php namespace GreenImp\Industries\Models;

use Model;

/**
 * Contact Model
 * @link https://octobercms.com/docs/database/model
 */
class Application extends Model
{
  use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'greenimp_industries_applications';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
      'industry' => 'GreenImp\Industries\Models\Industry'
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

  public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

  public $translatable  = ['name', 'description'];

  public $rules = [
    'name'        => 'required|string',
    'description' => 'string',
    'industry_id' => 'required'
  ];

  public function scopeIsActive($query){
    return $query->where('active', true);
  }
}
