<?php

namespace App\Base\Repository\Traits;

/**
 * 更新処理
 * 更新する際の関数を定義する
 *
 * 当Traitを利用する場合はExclusionTraitを
 * useする必要あり
 *
 * @package App\Base\Repository\Traits
 * @author yanahiro
 * @version 1.0.0
 */
trait UpdateTrait
{
    /**
     * オブジェクトの更新
     *
     * @param  array  $data
     * @param  int|string  $id
     * @param  array  $add
     * @return static
     */
    public function update($data, $id = null, $add = [])
    {
        $obj = $this->getRecord($id);
        if(!is_null($obj)) {
            $this->checkExclusion($obj, $data);

            $obj->fill($this->eloquent->makePost($data, $add))->save();
            return $obj;
        }
        return false;
    }
}