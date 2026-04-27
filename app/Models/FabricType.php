<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FabricType extends Model
{
    protected $guarded= [];

       public function fabricType_p()
    {
        return $this->hasOne(Product::class);
    }

}
