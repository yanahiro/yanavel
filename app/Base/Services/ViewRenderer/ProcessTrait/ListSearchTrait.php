<?php

namespace App\Bases\Services\ViewRenderer\ProcessTrait;

use App\Bases\Services\ViewRenderer\ListView\ListElementInterface;
use App\Bases\Services\ViewRenderer\SearchView\SearchElementInterface;

/**
 * Traits ListSearchTrait
 * ※現在未使用
 *
 * @package App\Bases\Services\ViewRenderer\ProcessTrait
 */
trait ListSearchTrait
{
    protected $repo;

    public function listExecute(ListElementInterface $list, SearchElementInterface $search = null)
    {
        // ベースのリポジトリの設定
        $list->setRepository($this->repo);

        // 前処理のフック
        $this->hookcommon('listBeforeInterceptor');

        // プロパティセット
        $this->action = 'lists';
        $this->action_ja = '一覧';
        $this->view = view('admin.commons.list');

        // 中処理のフック
        $this->hookCommon('listMiddleInterceptor');

        // リストをビルドして配列型に変換
        \ListView::setElement($list);

        if (\UnitSession::has('display')) {
            \ListView::setCount(\UnitSession::get('display'));
        }

        // 検索する場合
        if (!is_null($search)) {
            \SearchView::setElement($search)
                ->setController($this->controller)
                ->setAction($this->action);

            $search = \SearchView::build();
            \ListView::setSearch($search);
            $this->search = \SearchView::toArray();
        }

        // リストをビルドして配列型に変換
        $this->list = \ListView::build()->toArray();

        // 空間に検索条件をセット
        \UnitSession::set('search_qs', current_url());

        if(\Once::has('before_key_'.$this->prefix))
        {
            $bi = \Once::get('before_key_'.$this->prefix);
            $this->view->with(['bi' => $bi]);
        }

        \Widget::page_link(constant_value('commons.list_link'));

        \Button::group('list');
        $buttons = \Button::a('home')
            ->name('ホームへ戻る')
            ->href('/')
            ->toArray('list');
        $this->view->with(['buttons' => $buttons]);

        $this->return = $this->render();

        // 後処理のフック
        $this->hookCommon('listAfterInterceptor');

        return $this->return;
    }

    /**
     * 一覧表示の前処理
     */
    protected function listBeforeInterceptor(){}

    protected function listMiddleInterceptor(){}

    protected function listAfterInterceptor(){}

    /**
     * 表示件数変更用
     * Spaceを使って表示件数をセッションに保存
     *
     * @param  \App\Services\RenderUtil\Listy\ListElementInterface
     * @param  int $count
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function display_base($list, $count)
    {
        if(in_array($count, $list->display))
        {
            // 表示件数を保存
            \Space::set('display', $count);
        }
        // 前のページにリダイレクト
        $url = preg_replace('/page=(\d+)/', 'page=1', \URL::previous());
        return redirect($url);
    }

}