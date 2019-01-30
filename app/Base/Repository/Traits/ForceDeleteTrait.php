<?php

namespace App\Base\Repository\Traits;

/**
 * （物理）削除処理
 * 物理削除する際の関数を定義する
 *
 * 当Traitを利用する場合はExclusionTraitを
 * useする必要あり
 *
 * @package App\Base\Repository\Traits
 * @author yanahiro
 * @version 1.0.0
 */
trait ForceDeleteTrait
{
    /**
     * オブジェクトの削除
     * （物理削除）
     *
     * @param  int|string  $id
     * @return static
     */
    public function forceDelete($id = null, $lockedAt = null)
    {
        $obj = $this->getObj($id);

        // 楽観的排他チェック
        if (isset($lockedAt)) {
            $this->checkExclusion($obj, [$this->getLockedAtColumn() => $lockedAt]);
        }
        // 論理削除を行う
        $obj->forceDelete();

        return $obj;
    }
}