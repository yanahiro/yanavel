<?php

namespace App\Base\Repository\Traits;

/**
 * （論理）削除処理
 * 論理削除する際の関数を定義する
 *
 * 当Traitを利用する場合はExclusionTraitを
 * useする必要あり
 *
 * @package App\Base\Repository\Traits
 * @author yanahiro
 * @version 1.0.0
 */
trait DeleteTrait
{
    /**
     * データ削除処理
     * （論理削除）
     *
     * @param $data
     * @param array $with
     * @return mixed
     */
    public function delete($id = null, $lockedAt = null)
    {
        $obj = $this->getRecord($id);
        // 楽観的排他チェック
        if (isset($lockedAt)) {
            $this->checkDeleted($obj, [$this->getLockedAtColumn() => $lockedAt]);
        }
        // 論理削除を行う
        $obj->delete();

        return $obj;
    }
}