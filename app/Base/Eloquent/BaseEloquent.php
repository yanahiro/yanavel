<?php

namespace App\Base\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * ベースEloquentクラス
 * Eloquentを作成する場合には必ず継承するクラス
 *
 * @package App\Base\Model
 * @author yanahiro
 * @version 1.0.0
 */
class BaseEloquent extends Model implements BaseEloquentInterface
{

    /**
    * createメソッド実行時に、入力を禁止するカラムの指定
    *
    * @var array
    */
    protected $guarded = ['id'];

    protected $append = ['created_id', 'updated_id'];

	/**
	 * コンストラクタ
	 *
	 * @param  array $attributes
	 * @return void
	 */
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
	}

    /**
     * DBのカラムに対応するデータを生成
     *
     * @param  array  $value
     * @param  array  $with
     * @return array
     */
    public function makePost($value, $with=[])
    {
        $set = [];
        // Carbonインスタンスに変換するものを取得
        $dates = $this->getDates();

        foreach ($this->getTableColumns() as $column) {
            if (!isset($value[$column])) {
                continue;
            }

            $data = $value[$column];

            if ($data === '') {
                // NULL許可
                if (in_array($column, $this->nullable)) {
                    $set[$column] = null;
                }
                // その他は空なら変更しない
                continue;
            }

            if (in_array($column, $dates)) {
                // 配列なら文字列に変換
                if (is_array($data)) {
                    $data = $data['year'].'-'.$data['month'].'-'.$data['day'];
                }
                // Carbonインスタンスに変換
                $data = \Carbon\Carbon::parse($data);
            }
            $set[$column] = $data;
        }
        foreach ($with as $k => $v) {
            if (in_array($k, $dates)) {
                // Carbonインスタンスに変換
                $v = \Carbon\Carbon::parse($v)->setTimezone(config('app.timezone'));
            }
            $set[$k] = $v;
        }
        return $set;
    }

    /**
     * DBのカラムを返す
     *
     * @return array
     */
    public function getTableColumns()
    {
        return \Schema::getColumnListing($this->table);
    }


    /**
     * 検索スコープ
     */

    /**
     * テキスト検索のスコープ
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $key
     * @param  string  $v
     * @param  array  $like
     * @param  string  $where_type
     * @return \Illuminate\Database\Eloquent\Builder  $query
     */
    public function scopeWhereText($query, $key, $v, $like=[], $where_type='where')
    {
//        if (count($like) > 0) {
        if (is_array($like) && count($like) > 0) {
            $value = sprintf($like, $v);
            if ($value == $v)
            {
                $query = $query->$where_type($key, '=', $value);
            }
            else
            {
                $query = $query->$where_type($key, 'like', $value);
            }
        } else {
            $query = $query->$where_type($key, 'like', $v.'%');
        }

        return $query;
    }

}
