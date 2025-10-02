<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Fruit extends Model
{
    use HasFactory;

    protected $primaryKey = 'fruit_id';
    protected $fillable = ['name', 'description', 'price', 'stock_quantity', 'type_id', 'image'];
    public $timestamps = false;

    public function getFruits() {
        $fruits = DB::table('fruits')
            ->join('fruits_types', 'fruits.type_id', '=', 'fruits_types.type_id')
            ->get()->toArray();
        return $fruits;
    }

    public function getFruitDetails($fid) {
        $fruit = DB::table('fruits')
            ->join('fruits_types', 'fruits.type_id', '=', 'fruits_types.type_id')
            ->where('fruit_id', $fid)
            ->get()->toArray();
        return $fruit;
    }

    public function getFruitDetailsBySlug($fname) {
        $fruit = DB::table('fruits')
            ->join('fruits_types', 'fruits.type_id', '=', 'fruits_types.type_id')
            // ->where('name', $fname)
            ->whereRaw('REPLACE(fruits.name, " ", "") = ?', [$fname])
            ->get()->toArray();
        return $fruit;
    }

    public function getFruitsByType($tid) {
        $fruit = DB::table('fruits')
            ->join('fruits_types', 'fruits.type_id', '=', 'fruits_types.type_id')
            ->where('fruits.type_id', $tid)
            ->get()->toArray();
        return $fruit;
    }
}
