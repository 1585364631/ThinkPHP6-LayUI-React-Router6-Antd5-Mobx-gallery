<?php
declare (strict_types = 1);

namespace app\admin\model;

use think\Model;

/**
 * @mixin Model
 */
class Pictures extends Model
{
    public function photoAlbum(): \think\model\relation\HasOne
    {
        return $this->hasOne(PhotoAlbum::class,"id","photoid");
    }
}
