<?php

namespace App\Model;

use Auth, Validator;

use App\Model\MultiTenacy\TenacyTrait;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @package App\Model
 * @author Daniel Bonatti
 */
class Exemplo extends BaseModel {

	use TenacyTrait;
	use SoftDeletes;

	/**
	 * events
	 * @return void
	 */
	public static function boot() {
    
        parent::boot();

        self::creating(function($institute){
        	
        	$institute->master_id = Auth::user()->master_id;
        	$institute->user_id_created = Auth::id();

        });

        self::updating(function($institute){
            
            $institute->user_id_updated = Auth::id();
            $institute->registerLog();
            
        });

        self::deleting(function($institute){
            
            $institute->user_id_deleted = Auth::id();

        });
    }
    
	/**
     * The rules for the model
     *
     * @var array
     */
	protected static $rules = [
		'name' => 'required|max:255',
		'email' => 'nullable|email|max:50',
		'zip_code' => 'max:10',
		'address' => 'max:255',
		'address_district' => 'max:50',
		'address_number' => 'max:50',
		'address_complement' => 'max:50',
		'city_id' => 'nullable|integer',
		'city_name' => 'max:255',
		'city_state' => 'max:2',
		'cnpj' => 'max:20',
		'ie' => 'max:50',
		'contact' => 'max:255',
		'phone' => 'max:15',
		'mobile_phone' => 'max:15'
	];

	/**
	 * Rules for the model
	 * 
	 * @return array
	 */
	public static function rules() {
		
		return self::$rules;

	}

	/**
	 * store the model
	 * @param array $data 
	 * @return bool
	 */
	public function store(array $data) {
		
		$this->name = @$data['name'];
		$this->email = @$data['email'];
		$this->zip_code = @$data['zip_code'];
		$this->address = @$data['address'];
		$this->address_number = @$data['address_number'];
		$this->address_district = @$data['address_district'];
		$this->address_complement = @$data['address_complement'];
		$this->city_id = @$data['city_id'];
		$this->city_name = @$data['city_name'];
		$this->city_state = @$data['city_state'];
		$this->cnpj = @$data['cnpj'];
		$this->ie = @$data['ie'];
		$this->contact = @$data['contact'];
		$this->phone = @$data['phone'];
		$this->mobile_phone = @$data['mobile_phone'];

		return $this->save();

	}

	/**
	 * return relationship for present->user_id_created
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function createdBy() {
		
		return $this->belongsTo(User::class, 'user_id_created', 'id');

	}

	/**
     * relationship for logs
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function logs() {

        return $this->belongsToMany(User::class, 'institute_logs')->
                      withTimestamps()->
                      withPivot(['before', 'after'])->
                      latest('pivot_updated_at');

    }

	/**
	 * query
	 * @param string|null $description 
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public static function q($q = null) {
		
		$query =

		self::when($q, function($query) use($q) {
			$query->where('name', 'like', "%{$q}%")->
					orWhere('contact', 'like', "%{$q}%")->
					orWhere('city_name', 'like', "%{$q}%")->
					orWhere('phone', 'like', "%{$q}%")->
					orWhere('mobile_phone', 'like', "%{$q}%");
		});

		return $query;

	}

	/**
	 * query by name or cnpj
	 * @param String $name 
	 * @param String $cnpj 
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public static function qNameOrCnpj($name, $cnpj) {
		
		$query =

		self::when($name, function($query) use($name) {
			$query->orWhere('name', "{$name}");
		})->when($cnpj, function($query) use($cnpj) {
			$query->orWhere('cnpj', "{$cnpj}");
		});

		return $query;

	}

}