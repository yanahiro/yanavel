<?php

namespace App\Base\Controller\AdminTraits;

/**
 * 新規登録用Trait
 *
 * @package App\Base\Controller\AdminTraits
 * @author yanahiro
 * @version 1.0.0
 */
trait CreateControllerTrait
{
    /**
     * 新規登録の認可
     *
     * @return void
     */
    protected function create_permit()
    {
        // 権限判定の処理が必要であれば処理を追加
        return true;
    }

    /**
     * 新規登録共通
     *
     * @return \Illuminate\View\View
     */
    public function create_common()
    {
        // プロパティセット
        $this->action = 'create';
        $this->action_ja = '新規登録';
        $this->view = view('pages.general.form');

        // Formの作成
        $this->form = \FormView::setElement($this->form)
            ->setController($this->controller)
            ->setAction($this->action)
            ->build()
            ->toArray();
        return $this->view;
    }

    /**
     * 新規登録
     *
     * @param  App\Services\RenderUtil\Form\FormRenderInterface $form
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create_base($form)
    {
        // 認可
        $this->create_permit();

        // フォームの基礎作成
        $this->form = $form;
        if (\UnitSession::has('search_qs')) {
            $back = \UnitSession::get('search_qs');
        } else {
            $back = $this->link;
        }
        \FormView::setBack($back)
            ->setPrefix($this->prefix);

        // 前段階のフック
        $this->intercept('create_before_hook');

        // 共通処理
        $this->view = $this->create_common();
        \Breadcrumb::push($this->action, $this->action_ja);
        $this->return = $this->renderer();

        // 後段階のフック
        $this->intercept('create_after_hook');

        return $this->return;
    }

    /**
     * 新規登録のポスト時共通
     *
     * @param  App\Services\RenderUtil\Form\FormRenderInterface $form
     * @param  Illuminate\Foundation\Http\FormRequest $request
     * @param  string       $method
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    protected function create_post_base($form, $request, $method = 'create')
    {
        // 認可
        $this->create_permit();

        $this->form = $form;
        $this->input = $request->all();

        $this->intercept('create_post_hook');

        if (!isset($this->input['conf'])) {
            $this->create_conf();
        } else {
            $this->create_comp($method);
        }
        return $this->return;
    }

    /**
     * 新規登録のポスト時確認
     *
     * @return void
     */
    protected function create_conf()
    {
        \FormView::setData($this->input)->setConf()
            ->setPrefix($this->prefix)
            ->setBack($this->link.'/create');

        $this->intercept('create_conf_before_hook');

        $this->view = $this->create_common();
        \Breadcrumb::push($this->action, $this->action_ja, $this->link.'/create');
        \Breadcrumb::push('conf', '確認');

        $this->intercept('create_conf_after_hook');

        $this->return = $this->renderer();
    }

    /**
     * 新規登録のポスト時完了
     *
     * @param  string       $method
     * @return void
     */
    protected function create_comp($method)
    {
        $input = \Once::get('input');
        $space = \Once::get('space');
        $this->action = 'create';

        $this->intercept('create_comp_before_hook');

        // ブラウザバックの対応
        if (is_null($input) || $space != $this->prefix.$this->action) {
            \Flash::error('ブラウザの戻るや複数タブでの登録は出来ません。');
            $this->return = redirect()->action($this->controller.'lists');
            return false;
        }

        $create = $this->repo->$method($input);
        $pk = $create->getKeyName();

        \Flash::success('新規登録が完了しました。');
        \Once::set('before_key_'.$this->prefix, $create->$pk);

        $this->intercept('create_comp_after_hook');

        if (!isset($this->return)) {
            if (\UnitSession::has('search_qs')) {
                $this->return = redirect()->to(\UnitSession::get('search_qs'));
            } else {
                $this->return = redirect()->action($this->controller.'lists');
            }
        }
    }

    /**
     * 新規登録時の最初に処理を加える
     *
     * @return void
     */
    protected function create_before_hook(){}

    /**
     * 新規登録時の最後に処理を加える
     *
     * @return void
     */
    protected function create_after_hook(){}

    /**
     * 新規登録ポスト時共通で処理を加える
     *
     * @return void
     */
    protected function create_post_hook(){}

    /**
     * 新規登録確認時の最初に処理を加える
     *
     * @return void
     */
    protected function create_conf_before_hook(){}

    /**
     * 新規登録確認時の最後に処理を加える
     *
     * @return void
     */
    protected function create_conf_after_hook(){}

    /**
     * 新規登録完了時の最初に処理を加える
     *
     * @return void
     */
    protected function create_comp_before_hook(){}

    /**
     * 新規登録完了時の最後に処理を加える
     *
     * @return void
     */
    protected function create_comp_after_hook(){}
}
