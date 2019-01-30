<?php

namespace App\Base\Controller\AdminTraits;

/**
 * 一覧表示用Trait
 *
 * @package App\Base\Controller\AdminTraits
 * @author yanahiro
 * @version 1.0.0
 */
trait ListControllerTrait
{

    public function lists_base($list, $search = null)
    {
        // リポジトリのセット
        $list->setRepository($this->repo);

        // 前処理のフック
        $this->intercept('list_before_hook');

        // プロパティセット
        $this->action = 'lists';
        $this->action_ja = '一覧';
        $this->view = view('pages.general.list');

        // 中処理のフック
        $this->intercept('list_middle_hook');

        // リストをビルドして配列型に変換
        \ListView::setElement($list);

        if (\UnitSession::has('display')) {
            \ListView::setCount(\UnitSession::get('display'));
        }
        // 検索あり
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

        \Widget::page_link(constant_value('common.list_link'));

        \Button::group('list');
        $buttons = \Button::a('home')
            ->name('ホームへ戻る')
            ->href('/')
            ->toArray('list');
        $this->view->with(['buttons' => $buttons]);

        $this->return = $this->renderer();

        // 後処理のフック
        $this->intercept('list_after_hook');
//dd($this->search['fields']);
        return $this->return;
    }

    /**^
     * 一覧表示の最初に処理を加える
     *
     * @return void
     */
    protected function list_before_hook(){}

    /**
     * 一覧表示の中間に処理を加える
     *
     * @return void
     */
    protected function list_middle_hook(){}

    /**
     * 一覧表示の最後に処理を加える
     *
     * @return void
     */
    protected function list_after_hook(){}

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
            \UnitSession::set('display', $count);
        }
        // 前のページにリダイレクト
        $url = preg_replace('/page=(\d+)/', 'page=1', \URL::previous());
        return redirect($url);
    }

}