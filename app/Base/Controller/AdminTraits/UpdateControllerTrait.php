<?php

namespace App\Base\Controller\AdminTraits;

/**
 * 更新用Trait
 *
 * @package App\Base\Controller\AdminTraits
 * @author yanahiro
 * @version 1.0.0
 */
trait UpdateControllerTrait
{
    /**
     * 更新の認可
     *
     * @param  bool $bool
     * @return bool
     */
    protected function update_permit($bool=false)
    {
        // 権限判定の処理が必要であれば処理を追加
        return true;
    }

    /**
     * 更新共通
     *
     * @return \Illuminate\View\View
     */
    public function update_common($id)
    {
        // プロパティセット
        if (is_null($this->action)) {
            $this->action = 'update';
            $this->action_ja = '更新';
        }
        if (!isset($this->view) || is_null($this->view)) {
            $this->view = view('pages.general.form');
        }

        // Formの作成
        $this->form = \FormView::setElement($this->form)
            ->setController($this->controller)
            ->setAction($this->action)
            ->setID($id)
            ->build()
            ->toArray();
        return $this->view;
    }

    /**
     * 更新
     *
     * @param  App\Services\RenderUtil\Form\FormRenderInterface $form
     * @param  int|string $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function update_base($form, $id)
    {
        // 存在チェック
        $data = $this->repo->getRecord($id);
        if (is_null($data)) {
            abort(404);
        }

        // 認可
        $this->update_permit();

        // idがセットされていない場合セット
        if (is_null($this->id)) {
            $this->id = $id;
        }

        // フォームの基礎作成
        $this->form = $form;
        if (\UnitSession::has('search_qs')) {
            $back = \UnitSession::get('search_qs');
        } else {
            $back = $this->link;
        }
        \FormView::setData($data)
            ->setPrefix($this->prefix)
            ->setBack($back);

        // 前段階のフック
        $this->intercept('update_before_hook');

        // 共通処理
        $this->view = $this->update_common($id);
        \Breadcrumb::push($this->action, $this->action_ja);
        $this->return = $this->renderer();

        // 後段階のフック
        $this->intercept('update_after_hook');

        return $this->return;
    }

    /**
     * 更新のポスト時共通
     *
     * @param  App\Services\RenderUtil\Form\FormRenderInterface $form
     * @param  Illuminate\Foundation\Http\FormRequest $request
     * @param  int|string   $id
     * @param  string       $method
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function update_post_base($form, $request, $id, $method = 'update')
    {
        // idがセットされていない場合セット
        if (is_null($this->id)) {
            $this->id = $id;
        }

        $this->form = $form;
        $this->input = $request->all();

        $this->intercept('update_post_hook');

        if (!isset($this->input['conf'])) {
            $this->update_conf($id);
        } else {
            $this->update_comp($id, $method);
        }

        return $this->return;
    }

    /**
     * 更新のポスト時確認
     *
     * @param  int|string   $id
     * @return void
     */
    protected function update_conf($id)
    {
        // 存在チェック
        $data = $this->repo->getRecord($id);

        // 認可
        $this->update_permit();

        // 戻り先作成
        if (\UnitSession::has('search_qs')) {
            $this->return = redirect()->to(\UnitSession::get('search_qs'));
        } else {
            $this->return = redirect()->action($this->controller.'lists');
        }

        if (is_null($data)) {
            \Flash::error('更新対象は既に削除されています。');
            return false;
        }
        // hidden値書き換え対応
        if ($id != $this->input[$this->repo->eloquent->getKeyName()]) {
            \Flash::error('不正なパラメータが入力されました。');
            return false;
        }

        $link_action = 'update';
        if (!is_null($this->action)) {
            // アクションが設定されている場合
            $link_action = $this->action;
        }

        \FormView::setData($this->input)->setConf()
            ->setPrefix($this->prefix)
//            ->setBack($this->link.'/update/'.$this->id);
            ->setBack($this->link.'/'.$link_action.'/'.$this->id);

        $this->intercept('update_conf_before_hook');

        $this->view = $this->update_common($id);
//        \Breadcrumb::push($this->action, $this->action_ja, $this->link.'/update/'.$this->id);
        \Breadcrumb::push($this->action, $this->action_ja, $this->link.'/'.$link_action.'/'.$this->id);
        \Breadcrumb::push('conf', '確認');

        $this->intercept('update_conf_after_hook');

        $this->return = $this->renderer();
    }

    /**
     * 更新のポスト時完了
     *
     * @param  int|string   $id
     * @param  string       $method
     * @return void
     */
    protected function update_comp($id, $method)
    {
        $this->input = \Once::get('input');
        $space = \Once::get('space');

        //$this->action = 'update';
        if(is_null($this->action)) {
            $this->action = 'update';
        }

        $this->intercept('update_comp_before_hook');

        // ブラウザバックの対応
        if(is_null($this->input) || $space != $this->prefix.$this->action.$this->id)
        {
            \Flash::error('ブラウザの戻るや複数タブでの登録は出来ません。');
            $this->return = redirect()->action($this->controller.'lists');
            return false;
        }

        // 戻り先の作成
        if (\UnitSession::has('search_qs')) {
            $this->return = redirect()->to(\UnitSession::get('search_qs'));
        } else {
            $this->return = redirect()->action($this->controller.'lists');
        }

        // 存在チェック
        $data = $this->repo->getRecord($id);
        if (is_null($data)) {
            \Flash::error('更新対象は既に削除されています。');
            return false;
        }

        // 認可
        $this->update_permit();

        // モデル更新
        $update = $this->repo->$method($this->input, $this->id);

        \Globality::set('update', $update);
        \Flash::success('更新が完了しました。');
        \Once::set('before_key_'.$this->prefix, $this->id);

        $this->intercept('update_comp_after_hook');
    }

    /**
     * Eloquentのnullableに設定されている項目でinput値がnullの場合
     * 空文字に置き換える
     *
     * @param Eloquent $eloq
     */
    public function convEmptyAtNullable($eloq)
    {
        $nullable = $eloq->nullable;
        if (!is_null($nullable)) {
            foreach ($this->input as $k => $v) {
                if (in_array($k, $nullable) && is_null($v)) {
                    $this->input[$k] = '';
                }
            }
        }
    }

    /**
     * 更新時の最初に処理を加える
     *
     * @return void
     */
    protected function update_before_hook(){}

    /**
     * 更新時の最後に処理を加える
     *
     * @return void
     */
    protected function update_after_hook(){}

    /**
     * 新規登録ポスト時共通で処理を加える
     *
     * @return void
     */
    protected function update_post_hook(){}

    /**
     * 更新確認時の最初に処理を加える
     *
     * @return void
     */
    protected function update_conf_before_hook(){}

    /**
     * 更新確認時の最後に処理を加える
     *
     * @return void
     */
    protected function update_conf_after_hook(){}

    /**
     * 更新完了時の最初に処理を加える
     *
     * @return void
     */
    protected function update_comp_before_hook(){}

    /**
     * 更新完了時の最後に処理を加える
     *
     * @return void
     */
    protected function update_comp_after_hook(){}
}
