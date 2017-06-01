<?php
namespace app\api\controller;
use app\api\model\User as UserModel;
use think\Request;

class User
{
    public function login(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: GET, POST, PUT');
        $user = UserModel::getByUserAccount($request->param('account'));
        if($user == NULL){
                $data = ['success' => false,'msg' => '用户名不存在！'];
                return json($data);
        }else{
            if($user -> user_psw == $request->param('psw')){
                $token = setToken($user); 
                $data = ['success' => true,'token'  => $token,'msg' => '验证信息成功！'];         
                return json($data);
            }else{
                $data = ['success' => false,'msg' => '验证信息失败！'];
                return json($data);
            }
        }
    }

     public function regist(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: GET, POST, PUT');
        $user = UserModel::getByUserAccount($request->param('account'));
        if($user == NULL){
            $user = new UserModel;
            $user->user_account = $request->param('account');
            $user->user_psw    = $request->param('psw');
            if ($user->save()) {
                $data = ['success' => true,'data'  => null,'msg' => '新增成功！'];  
                return json($data);
            } else {
                return $user->getError();
            }
        }else{
            $data = ['success' =>false,'data' => null,'msg' => '已存在该账户'];
            return json($data);
        }
    }
}
