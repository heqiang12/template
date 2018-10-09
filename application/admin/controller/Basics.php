<?php
/**
 * Created by PhpStorm.
 * User: heqiang
 * Date: 2018/10/8 0008
 * Time: 上午 10:03
 * 展示各个部件样式
 */

namespace app\admin\controller;

use app\admin\controller\Base;

class basics extends Base{
    public function btn(){
        return $this->fetch('basics/btn');
    }

    public function auxiliar(){
        return $this->fetch('basics/auxiliar');
    }

    public function folding_panel(){
        return $this->fetch('basics/folding-panel');
    }

    public function form(){
        return $this->fetch('basics/form');
    }

    public function progress_bar(){
        return $this->fetch('basics/progress-bar');
    }

    public function tab_card(){
        return $this->fetch('basics/tab-card');
    }

    public function table(){
        return $this->fetch('basics/table');
    }

}