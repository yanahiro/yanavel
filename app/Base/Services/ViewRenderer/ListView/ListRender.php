<?php

namespace App\Base\Services\ViewRenderer\ListView;

use App\Base\Services\ViewRenderer\Traits\Parser;
use App\Base\Services\ViewRenderer\RenderInterface;

/**
 * Class ListRender
 * 一覧表示項目レンダリングクラス
 *
 * @package App\Services\ViewRenderer\ListView
 * @author yanahiro
 * @version 1.0.0
 */
class ListRender implements RenderInterface
{
    use Parser;

    // リスト要素クラス
    protected $elem;

    // カラム
    protected $columns;

    // 操作種別
    protected $operations;

    // 検索 SearchRender
    protected $search;

    // データ
    protected $data;

    // 表示件数
    protected $count;

    // 論理削除
    protected $is_trash = false;

    /**
     * データ用
     *
     * @var \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected $paginate;

    /**
     * リストビルド用
     *
     * @var \Illuminate\Database\Eloquent\Collection|static[]
     */
    protected $builder;

    /**
     * 権限絞込み条件
     *
     * @var array
     */
    protected $permission_where;

    /**
     * コンストラクタ
     *
     * @return  void
     */
    public function __construct(ListElementInterface $elem = null)
    {
        $this->elem = $elem;
    }

    /**
     * List要素のセット
     *
     * @param  ListElementInterface  $elem
     * @return this
     */
    public function setElement(ListElementInterface $elem)
    {
        $this->elem = $elem;
        $this->is_trash = $elem->is_trash;
        return $this;
    }

    /**
     * 検索項目レンダリングクラス
     *
     * @param  SearchRender  $search
     * @return this
     */
    public function setSearch($search)
    {
        $this->search = $search;
        return $this;
    }

    /**
     * カラムの取得
     *
     * @return array
     */
    public function getColumns()
    {
        $this->columns = $this->elem->makeBaseColomns();
        return $this->columns;
    }

    /**
     * 表示件数のセット
     *
     * @param  int  $count
     * @return this
     */
    public function setCount($count)
    {
        $this->count = $count;
        return $this;
    }

    /**
     * 論理削除済み取得のセット
     *
     * @return this
     */
    public function setWithTrashed()
    {
        $this->is_trash = true;
        return $this;
    }

    /**
     * 操作の取得
     *
     * @return array
     */
    public function getOperations()
    {
        $operations = $this->elem->makeBaseOperations();
        foreach ($operations as $key => $operation) {
            $k = $operation['type'];
            $spl = explode('-', $k);
            foreach ($spl as $s) {
                $this->operations[$s][$key] = $operation;
            }
        }
        return $this->operations;
    }

    /**
     * モデルの主キーを返す
     *
     * @return array
     */
    public function getPrimaryKey(){
		$this->pk = $this->elem->eloquent->getKeyName();
        return $this->pk;
    }

    /**
     * ペジネーションを返す
     *
     * @return array
     */
    public function getPaginate(){
        $builder = $this->elem->eloquent;

        // Eagerのセット
        foreach ($this->elem->with as $with) {
            $builder = $builder->with($with);
        }

        // 削除済み取得
        if ($this->is_trash) {
            $builder = $builder->withTrashed();
        }

        // 検索ドライバがセットされている場合
        if (!is_null($this->search)) {
            $builder = $this->search->execSearch($builder);
        }

        // 表示件数のセットがない場合は初期値を取得
        if (is_null($this->count)) {
            $this->count = $this->elem->count;
        }

        if ($this->count == -1) {
            $page = 1;
            $total = $builder->paginate(1)->total();
            $builder = $builder->paginate($total, ['*'], 'page', $page);
        } else {
            $builder = $builder->paginate($this->count);
            $page = $builder->currentPage();
        }

        $paginate = [
            'current' => $page,
            'last' => $builder->lastPage(),
            'total' => $builder->total(),
            'page' => $builder->appends(\Request::all()),
        ];
        $this->builder = $builder;
        return $paginate;
    }

    /**
     * データを返す
     *
     * @return array
     */
    public function getData(){
        $data = [];
        foreach ($this->builder as $d) {
            $set = [$this->pk => $d[$this->pk]];
            $data[] = $this->parseData($this->columns, $d, $set);
        }
        return $data;
    }

    /**
     * リストのビルド
     *
     * @return this
     */
    public function build()
    {
        $this->columns = $this->getColumns();
        $this->operations = $this->getOperations();
        $this->pk = $this->getPrimaryKey();
        $this->paginate = $this->getPaginate();
        $this->data = $this->getData();
        return $this;
    }

    /**
     * view用に配列の作成
     *
     * @return array
     */
    public function toArray()
    {
        $list = [
            'columns' => $this->columns,
            'operations' => $this->operations,
            'pk' => $this->pk,
            'data' => $this->data,
            'paginate' => $this->paginate,
            'display' => $this->elem->display,
            'count' => $this->count,
            'raw' => $this->builder,
        ];
        return $list;
    }

    /**
     * viewにレンダリングする
     *
     * @return string
     */
    public function render()
    {
        // 未実装
    }
}
