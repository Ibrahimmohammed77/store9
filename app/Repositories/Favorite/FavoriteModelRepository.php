<?php 
namespace App\Repositories\Favorite;

use App\Models\Product;
use Illuminate\Support\Collection;

class FavoriteModelRepository implements FavoriteRepository {

    public $items;
    public function __construct()
    {
        $this->items=collect([]);
    }
    public function get():Collection{
        return $this->items;
    }

    public function add(Product $product,$quantity=1)
    {

    }
    public function update($id,$quantity=1)
    {

    }
     public function delete($id)
    {

    }
    public function empty()
    {

    }
}