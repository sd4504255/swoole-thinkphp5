<?php
namespace app\controller;


class Index extends Base
{
    public function hellWord($param)
    {
        $data = $param;
        return json_encode($data);
    }
}
