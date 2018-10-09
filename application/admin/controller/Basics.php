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
        return $this->fetch('Basics/auxiliar');
    }

    public function folding_panel(){
        return $this->fetch('Basics/folding-panel');
    }

    public function form(){
        return $this->fetch('Basics/form');
    }

    public function progress_bar(){
        return $this->fetch('Basics/progress-bar');
    }

    public function tab_card(){
        return $this->fetch('Basics/tab-card');
    }

    public function table(){
        return $this->fetch('Basics/table');
    }

}