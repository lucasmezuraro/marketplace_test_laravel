<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
    protected $fillable = ['description', 'id'];

    public function products() {
        return $this->HasMany('App/Product');
    }
}
