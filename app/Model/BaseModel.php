<?php

namespace App\Model;

use Auth, Validator;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Daniel Bonatti
 */
class BaseModel extends Model {

	/**
     * register log of diff in pivot
     * 
     * @param integer|null $userId 
     * @param array|null $diff 
     * @return void
     */
    public function registerLog($user_id = null, $diff = null) {

        $user_id = $user_id ?: Auth::id();
        $diff = $diff ?: $this->getDiff();

        return $this->logs()->attach($user_id, $diff);

    }


    /**
     * return the diff between new and old model data
     * 
     * @return array
     */
    protected function getDiff() {

        $after = $this->getDirty();

        $before = json_encode(array_intersect_key($this->fresh()->toArray(), $after));

        $after = json_encode($after);

        return compact('after', 'before');
    }


    /**
     * validate the model
     * 
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    public static function validate(array $data, $rules = null) {

        return Validator::make($data, $rules ?: self::rules());

    }
	
}