<?php
sys::import('blocks.timer.timer');
class TimerBlockModify extends TimerBlock implements iBlockModify
{
    public function modify()
    {
        return $this->getContent();
    }

/*
    public function checkModify(Array $data=array())
    {

    }
*/

    public function update()
    {
        if (!xarVarFetch('timer_time', 'pre:trim:str:1:',
            $timer_time, null, XARVAR_NOT_REQUIRED)) return;

        $this->timer_time = $timer_time;
        return true;
    }
}
?>