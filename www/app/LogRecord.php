<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogRecord extends Model
{
    protected $casts = ['log_level' => 'int', 'helper_id' => 'int', 'customer_id' => 'int'];
    protected $table = 'log';
}
