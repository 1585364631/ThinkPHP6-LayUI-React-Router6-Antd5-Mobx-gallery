<?php
declare (strict_types = 1);

namespace app\admin\model;

use think\Model;

/**
 * @mixin Model
 */
class PhotoAlbum extends Model
{
    //

    public function pictures(): \think\model\relation\HasMany
    {
        return $this->hasMany(Pictures::class,"photoid");
    }
}
