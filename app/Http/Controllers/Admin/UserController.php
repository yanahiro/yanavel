<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Router;
use App\Base\Controller\BaseController as Controller;
use App\Models\User\UserRepository;
use App\Models\User\UserList;
use App\Models\User\UserSearch;
use App\Models\User\UserForm;

use App\Http\Request\Admin\UserFormRequest;

use App\Base\Controller\AdminTraits\CreateControllerTrait;
use App\Base\Controller\AdminTraits\DeleteControllerTrait;
use App\Base\Controller\AdminTraits\ListControllerTrait;
use App\Base\Controller\AdminTraits\UpdateControllerTrait;


/**
 * Class UserController
 * ユーザー管理コントローラクラス
 *
 * @package App\Http\Controllers\Admin
 * @author yanahiro
 * @version 1.0.0
 */
class UserController extends Controller
{

    //
    use ListControllerTrait, CreateControllerTrait,
        UpdateControllerTrait, DeleteControllerTrait;

    /**
     * ベースファンクション
     * システムメニューマスタのURLで起動するファンクション名
     *
     * @var string
     */
    protected $base_function = 'lists';

    /**
     * コンストラクタ
     * @param Router $router
     * @param BaseRepositoryInterface|null $repo
     */
    public function __construct(Router $router, UserRepository $repo = null)
    {
        parent::__construct($router, $repo);
    }

    /**
     * 一覧
     *
     * @param UserList $list
     * @param UserSearch $search
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function lists(UserList $list, UserSearch $search)
    {
        return $this->lists_base($list, $search);
    }

    /**
     * 表示件数
     *
     * @param UserList $list
     * @param type $count
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function display(UserList $list, $count)
    {
        return $this->display_base($list, $count);
    }

    /**
     * 新規登録
     *
     * @param UserForm $form
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create(UserForm $form)
    {
        return $this->create_base($form);
    }

    /**
     * 新規登録のポスト時
     *
     * @param UserForm $form
     * @param UserFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create_post(UserForm $form, UserFormRequest $request)
    {
        return $this->create_post_base($form, $request);
    }

    /**
     * 更新
     *
     * @param UserForm $form
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function update(UserForm $form, $id)
    {
        return $this->update_base($form, $id);
    }

    /**
     * 更新のポスト時
     *
     * @param UserForm $form
     * @param UserFormRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update_post(UserForm $form, UserFormRequest $request, $id)
    {
        return $this->update_post_base($form, $request, $id);
    }

    /**
     * 削除
     *
     * @param UserForm $form
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function delete(UserForm $form, $id)
    {
        return $this->delete_base($form, $id);
    }

    /**
     * 削除のポスト時
     *
     * @param UserForm $form
     * @param UserFormRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete_post(UserForm $form, UserFormRequest $request, $id)
    {
        return $this->delete_post_base($form, $request, $id);
    }
}