<?php namespace GreenImp\Industries\Models;

use Model;

/**
 * Office Model
 * @link https://octobercms.com/docs/database/model
 */
class Industry extends Model
{
  use \October\Rain\Database\Traits\Validation;
  use \October\Rain\Database\Traits\Sluggable;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'greenimp_industries_industries';

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
    public $hasOne = [
    ];
    public $hasMany = [
      'application' => 'GreenImp\Industries\Models\Application'
    ];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

  public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

  public $translatable  = ['name', 'description'];

  protected $slugs = ['url_slug' => 'name'];

  public $rules = [
    'name'        => 'required|string',
    'description' => 'string'
  ];

  public function scopeIsActive($query){
    return $query->where('active', true);
  }
}
