<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FruitType extends Model
{
    use HasFactory;
    protected $table = 'fruits_types';
    protected $fillable = [
        'type_id', 'type_name', 'type_img'
    ];
    public $timestamps = false;

    public function getFruitTypes() {
        $types = DB::select('select * from fruits_types'); //gives array of objects
        // return json_decode(json_encode($types), true); //gives array
        return $types;
    }

    public function getFruitType($ftid) {
        $type = FruitType::where('type_id', $ftid)
               ->first();
        return $type;
    }
}
