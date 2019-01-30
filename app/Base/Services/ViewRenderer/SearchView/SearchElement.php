<?php

namespace App\Base\Services\ViewRenderer\SearchView;

/**
 * Class SearchElement
 * 検索条件 項目定義 基底クラス
 *
 * @package App\Services\ViewRenderer\SearchView
 * @author yanahiro
 * @version 1.0.0
 */
abstract class SearchElement implements SearchElementInterface
{
	/**
	 * 並び順
	 *
	 * @var string
	 */
	protected $order_init = 'id';

	/**
	 * 並び順
	 *
	 * @var array
	 */
	protected $order_permit = ['id'];

	/**
	 * 権限
	 *
	 * @var string
	 */
	protected $permission;

	/**
	 * 結合用
	 *
	 * @var string|array
	 */
    protected $join;

    /**
     * 権限のセット
     *
     * @param  string  $permission
     * @return this
     */
	public function setPropPremission($permission)
	{
		$this->permission = $permission;
		return $this;
	}

    /**
     * 並び順の作成
     *
     * @return array
     */
	public function getOrderInit()
	{
		return $this->order_init;
	}

    /**
     * 並び順の作成
     *
     * @return array
     */
	public function getOrderPermit()
	{
		return $this->order_permit;
	}

    /**
     * 隠しwhere句
     *
     * @return array
     */
    public function getHideWhere()
    {
        return [];
    }

    /**
     * 結合の作成
     *
     * @return array
     */
    public function makeJoin($builder)
    {
        $model = $builder->getModel();
        $joins = $this->join;
        if (!is_array($joins)) {
            $joins = [$joins];
        }
        $res = [];
        foreach ($joins as $has) {
            $has = $model->$has();
            $my_table = $model->getTable();
            $other_table = $has->getRelated()->getTable();
            if ($has instanceof \Illuminate\Database\Eloquent\Relations\BelongsTo) {
                $pk = $my_table.'.'.$has->getForeignKey();
                $fk = $other_table.'.'.$has->getOtherKey();
            } else {
                $pk = $has->getForeignKey();
                $fk = $has->getQualifiedParentKeyName();
            }
            $res[] = [$other_table, $fk, $pk, $other_table, $my_table];
        }
        return $res;
    }

    /**
     * 結合が有るか
     *
     * @return bool
     */
    public function hasJoin()
    {
        if (is_null($this->join)) {
            return false;
        }
        return true;
    }
}
