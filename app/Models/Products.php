<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Products extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $guarded = [];
    protected $primaryKey = 'id';

    public function scopeFilter($query, array $filter)
    {
        $query->when($filter['keyword'] ?? false, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        });
    }

    public function getCover()
    {
        if (substr($this->image, 0, 5) == 'https') {
            $image = substr($this->image, 6);
            $assets = asset('storage' . $image);
            return $assets;
        }

        if ($this->image) {
            $image = substr($this->image, 6);
            $assets = asset('storage' . $image);
            return $assets;
        }

        return 'https://via.placeholder.com/150x200.png?text=No+Cover';
    }
}
