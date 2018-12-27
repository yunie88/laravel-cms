<?php

namespace Modules\Article\Entities;

use Houdunwang\Arr\Arr;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'pid'];

    public function getAll($category = null)
    {
        $data = $this->get()->toArray();
        if (!is_null($category)) {
            foreach ($data as $k => $v) {
                $data[$k]['_selected'] = $category['pid'] == $v['id'];
                $data[$k]['_disabled'] = $category['id'] == $v['id'] || (new Arr())->isChild($data, $v['id'], $category['id'], 'id', 'pid');
            }
            return (new Arr())->tree($data, 'name', 'id', 'pid');
        }
    }

    public function hasChildCategory()
    {
        $data = $this->get()->toArray();
        return (new Arr())->hasChild($data, $this->id, 'pid');
    }

}
