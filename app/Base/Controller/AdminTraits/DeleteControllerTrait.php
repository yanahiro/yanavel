<?php

namespace App\Base\Controller\AdminTraits;

/**
 * 削除用Trait
 *
 * @package App\Base\Controller\AdminTraits
 * @author yanahiro
 * @version 1.0.0
 */
trait DeleteControllerTrait
{
    /**
     * 削除の認可
     *
     * @param  bool $bool
     * @return bool
     */
    protected function delete_permit($bool = false)
    {
        // 権限判定の処理が必要であれば処理を追加
        return true;
    }

    /**
     * 削除
     *
     * @param  App\Services\RenderUtil\Form\FormRenderInterface $form
     * @param  int|string   $id
     * @return \Illuminate\View\View
     */
    public function delete_base($form, $id)
    {
        // 存在チェック
        $data = $this->repo->getRecord($id);
        if (is_null($data)) {
            abort(404);
        }

        // 認可
        $this->delete_permit();

        $this->form = $form;
        $this->action = 'delete';
        $this->action_ja = '削除';
        $this->view = view('pages.general.form');
        \Breadcrumb::push($this->action, $this->action_ja);

        // 前段階のフック
        $this->intercept('delete_before_hook');

        if (\UnitSession::has('search_qs')) {
            $back = \UnitSession::get('search_qs');
        } else {
            $back = $this->link;
        }

        // Formの作成
        $this->form = \FormView::setElement($this->form)
            ->setData($data)
            ->setBack($back)
            ->setPrefix($this->prefix)
            ->setConf()
            ->setController($this->controller)
            ->setAction($this->action)
            ->setID($id)
            ->build()
            ->toArray();

        $this->return = $this->renderer();

        // 後段階のフック
        $this->intercept('delete_after_hook');

        return $this->return;
    }

    /**
     * 削除のポスト時共通
     *
     * @param  App\Services\RenderUtil\Form\FormRenderInterface $form
     * @param  Illuminate\Foundation\Http\FormRequest $request
     * @param  int|string   $id
     * @param  string       $method
     * @return \Illuminate\View\View
     */
    public function delete_post_base($form, $request, $id, $method = 'delete')
    {
        // 存在チェック
        $data = $this->repo->getRecord($id);

        // 認可
        $this->delete_permit($id);

        if (is_null($data)) {
            \Flash::error('削除済みのデータです。');
            return redirect()->action($this->controller.'lists');
        }

        $this->intercept('delete_comp_before_hook');

        $this->repo->$method($id);
        \Flash::success('削除が完了しました。');

        $this->intercept('delete_comp_after_hook');

        if (!isset($this->return)) {
            if (\UnitSession::has('search_qs')) {
                $this->return = redirect()->to(\UnitSession::get('search_qs'));
            } else {
                $this->return = redirect()->action($this->controller.'lists');
            }
        }
        return $this->return;
    }

    /**
     * 削除時の最初に処理を加える
     *
     * @return void
     */
    protected function delete_before_hook(){}

    /**
     * 削除時の最後に処理を加える
     *
     * @return void
     */
    protected function delete_after_hook(){}

    /**
     * 削除完了時の最初に処理を加える
     *
     * @return void
     */
    protected function delete_comp_before_hook(){}

    /**
     * 削除完了時の最後に処理を加える
     *
     * @return void
     */
    protected function delete_comp_after_hook(){}
}
