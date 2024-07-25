<?php

namespace Applab\Sadad\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SadadLog extends Model
{
    use SoftDeletes;
    protected $fillable = ['sadad_id','status','response'];


    public function __construct() {
        parent::__construct();
        $this->table = config('applab-sadad.log_table');
    }

    public function loggable():MorphTo
    {
        return $this->morphTo();
    }
}
