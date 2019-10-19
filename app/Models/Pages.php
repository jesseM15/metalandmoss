<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    protected $table = 'pages';
    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';

    public function parent()
    {
    	return $this->belongsTo(self::class, 'parent', 'id');
    }

    public function pages()
    {
    	return $this->hasMany(self::class, 'id', 'parent');
    }
}
