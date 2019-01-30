<?php

namespace App\Base\Repository\Traits;

use App\Base\Exception\ExclusiveLockException;

/**
 * 排他トレイト
 * 排他に関する共通処理機能を保持するクラス
 *
 * UpdateTrait, DeleteTrait, ForceDeleteTtaitを利用する際には
 * 必ずuseすること
 *
 * @package App\Base\Repository\Traits
 * @author yanahiro
 * @version 1.0.0
 */
trait ExclusionTrait
{
    /**
     * 楽観的排他チェック
     * @param  array  $obj 現在の行情報
     * @param  array  $data 更新行情報
     */
    protected function checkExclusion($obj, $data)
    {
        if (!isset($data[$this->getLockedAtColumn()])) {
            // 排他キーが設定されていない場合は何もしない
            return;
        }

        if ($obj->updated_at != $data[$this->getLockedAtColumn()]) {
            // 更新日付が変わっている場合はExceptionを発生
            throw new ExclusiveLockException;
        }
    }
}