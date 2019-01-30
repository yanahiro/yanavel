<?php

namespace App\Base\Services\ViewRenderer\SearchView;

use App\Base\Services\ViewRenderer\RenderInterface;

/**
 * Class SearchRender
 * 検索項目レンダリングクラス
 *
 * @package App\Services\ViewRenderer\SearchView
 * @author yanahiro
 * @version 1.0.0
 */
class SearchRender implements RenderInterface
{
    /**
     * 並び順のキー
     *
     * @var string
     */
    const ORDER = 'o';

    /**
     * フィールド
     *
     * @var array
     */
    protected $fields;

    /**
     * グルーピングされてないフィールド
     *
     * @var array
     */
    protected $fields_raw;

    /**
     * 検索するかどうか
     *
     * @var bool
     */
    protected $is_search = true;

    /**
     * 検索したかどうか
     *
     * @var bool
     */
    protected $is_run = true;

    /**
     * 昇順降順
     *
     * @var string
     */
    protected $ad;

    /**
     * 並び順条件
     *
     * @var array
     */
    protected $order = null;

    /**
     * 初期並び順条件
     *
     * @var array
     */
    protected $order_init = [];

    /**
     * 許可済み並び順
     *
     * @var array
     */
    protected $order_permit;

    /**
     * 並び順のURL文字列
     *
     * @var string
     */
    protected $order_string = '';

    /**
     * データ
     *
     * @var array
     */
    protected $data;

    /**
     * 検索条件
     *
     * @var array
     */
    protected $where = [];

    /**
     * 辞書
     * widgetタイプに適したクエリを返す
     *
     * @var Dictionary
     */
    protected $dictionary;

    /**
     * コンストラクタ
     *
     * @return void
     */
    public function __construct(Dictionary $dictionary)
    {
        $this->dictionary = $dictionary;
    }

    /**
     * 検索要素のセット
     *
     * @param  SearchElementInterface  $elem
     * @return this
     */
    public function setElement(SearchElementInterface $elem)
    {
        // 検索要素のセット
        $this->elem = $elem;

        // 並び順の許可データ取得
        $this->order_permit = $this->elem->getOrderPermit();

        // 初期並び順取得
        $this->makeOrder($this->elem->getOrderInit(), true);

        return $this;
    }

    /**
     * 隠し検索条件セット
     *
     * @return void
     */
    protected function getHideWhere()
    {
        $hide = $this->elem->getHideWhere();

        foreach ($hide as $k => $v) {
            $this->where[$k] = $v;
        }
    }

    /**
     * 検索条件セット
     *
     * @return this
     */
    public function setWhere($key, $value)
    {
        $this->where[$key] = [
            'value' => $value
        ];
        return $this;
    }

    /**
     * データの取得
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * データのセット
     *
     * @param  array|EloquentInterface $data
     * @return this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * コントローラのセット
     *
     * @param  string  $controller
     * @return this
     */
    public function setController($controller)
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * アクションのセット
     *
     * @param  string  $action
     * @return this
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * 検索をさせないようにセット
     *
     * @return this
     */
    public function setNoSearch()
    {
        $this->is_search = false;
        return $this;
    }

    /**
     * 検索条件のデータを作る
     *
     * @return void
     */
    protected function makeData(){
        // get値からデータの生成
        if (!is_null($this->data) && $this->is_search) {
            foreach ($this->data as $k => $v) {
                // キーが並び順の時
                if ($k == self::ORDER) {
                    $this->makeOrder($v);
                    $this->order_string = $v;
                } else {
                    $this->is_run = true;
                    $this->makeWhere($k, $v);
                }
            }
        }
    }

    /**
     * 並び順のデータを作る
     *
     * @param  string   $order
     * @return void
     */
    protected function makeOrder($order, $init = false){
        // 並び順の許可がある場合
        if (!is_null($this->order_permit)) {
            $ad = 'ASC';
            // 頭に-がある場合は降順
            if (substr($order, 0, 1) == '-') {
                $order = substr($order, 1);
                $ad = 'DESC';
            }
            // キーの妥当性チェック
            if (in_array($order, $this->order_permit)) {
                if ($init) {
                    $this->order_init[$order] = $ad;
                } else {
                    $this->order[$order] = $ad;
                }
            }
        }
    }

    /**
     * where句のデータを作る
     *
     * @param  string $k
     * @param  string|array $v
     * @return void
     */
    protected function makeWhere($k, $v){
        if ($v != '' && isset($this->fields_raw[$k])) {
            $this->where[$k] = $this->fields_raw[$k];
            $this->where[$k]['value'] = $v;
        }
    }

    /**
     * フォームのフィールドを取得
     *
     * @return array
     */
    public function getFields()
    {
        // フィールド作成を実行
        $this->elem->fields();

        // データの作成
        if (is_null($this->data)) {
            $this->data = \Input::all();
        }

        // フィールドがあるかどうか
        $this->is_show = \Widget::existFields();

        // アクションやメソッドを設定
        \Widget::action($this->controller.$this->action)
            ->method('GET')
            ->classes('form-horizontal')
            ->data($this->data);

        // フィールドの作成
        $fields = \Widget::render();

        return $fields;
    }

    /**
     * 必要な情報を作る
     *
     * @return void
     */
    public function build()
    {
        // フィールドの作成
        $this->fields = $this->getFields();

        $this->fields_raw = \Widget::getFields();

        // 隠し検索条件取得
        $this->getHideWhere();

        $this->makeData();

        return $this;
    }

    /**
     * Formのオープン
     *
     * @return string
     */
    public function open()
    {
        return \Widget::open();
    }

    /**
     * Formのクローズ
     *
     * @return string
     */
    public function close()
    {
        return \Widget::close();
    }

    /**
     * viewで使いやすいように配列に変換する
     *
     * @return array
     */
    public function toArray()
    {
        $search = [
            'fields' => $this->fields,
            'order' => [
                'string' => $this->order_string,
                'permit' => $this->order_permit,
            ],
        ];
        return $search;
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

    /**
     * 検索の実行
     *
     * @param Illuminate\Database\Query\Builder
     * @return Illuminate\Database\Query\Builder
     */
    public function execSearch($builder)
    {
        $res = $builder;

        // 結合する場合
		if ($this->elem->hasJoin()) {
			$joins = $this->elem->makeJoin($res);
            foreach ($joins as $join) {
			    $res = $res->join($join[0], $join[1], '=', $join[2])->select($join[4].'.*');
            }
		}

        // where句の実行
        $res = $this->execWhere($res);

        // 並び順
        $res = $this->execOrder($res);

        return $res;
    }

    /**
     * where句の実行
     *
     * @param Illuminate\Database\Query\Builder
     * @return Illuminate\Database\Query\Builder
     */
    public function execWhere($builder)
    {
        $res = $builder;

        foreach ($this->where as $k => $v) {
            $k = \Widget::removeUniquePrefix($k);

            if (isset($v['scope'])) {
                $res = $res->$v['scope'](array_merge($v, ['key' => $k]));
                continue;
            }

            if (!isset($v['parent'])) {
                $res = $this->createWhere($res, $k, $v);
            } else {
                $res = $this->createParentWhere($res, $k, $v);
            }
        }
        return $res;
    }

    /**
     * orderByの実行
     *
     * @param Illuminate\Database\Query\Builder
     * @return Illuminate\Database\Query\Builder
     */
    public function execOrder($builder){
        $res = $builder;
        if (!is_null($this->order)) {
            foreach ($this->order as $order => $ad) {
                $res = $res->orderBy($order, $ad);
            }
        } else {
            foreach ($this->order_init as $order => $ad) {
                $res = $res->orderBy($order, $ad);
            }
        }
        return $res;
    }

    /**
     * where句の作成(parent)
     *
     * @param Illuminate\Database\Query\Builder
     * @param string $k
     * @param array $v
     * @return Illuminate\Database\Query\Builder
     */
    private function createParentWhere($res, $k, $v)
    {
        if (is_array($v['value'])) {
            if (empty(array_filter($v['value']))) {
                // 配列が空の場合は親テーブルと結合しない
                return $res;
            }
        }

        $res = $res->whereHas($v['parent'], function($q) use($k, $v)
        {
            $q = $this->createWhere($q, $k, $v);
        });
        return $res;
    }

    /**
     * where句の作成
     *
     * @param Illuminate\Database\Query\Builder
     * @param string $k
     * @param array $v
     * @return Illuminate\Database\Query\Builder
     */
    private function createWhere($res, $k, $v)
    {
        $this->dictionary->flush()
            ->setBuilder($res)
            ->setWidget(@$v['widget'])
            ->setValue($v['value'])
            ->setKey($k);

        if (isset($v['multiple'])) {
            $this->dictionary->setMulti($v['multiple']);
        }

        if (isset($v['like'])) {
            $this->dictionary->setLike($v['like']);
        }

        return $this->dictionary->build();
    }
}
