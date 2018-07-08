<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entries';

    /**
    * Get the user that added the entry
    */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
