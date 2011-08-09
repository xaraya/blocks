<?php
sys::import('xaraya.structures.containers.blocks.basicblock');
class TimerBlock extends BasicBlock implements iBlock
{
    protected $type = 'timer';
    protected $text_type = 'Timer';
    protected $text_type_long = 'Timer Block';
    protected $xarversion = '2.3.0';
    protected $author = 'Chris Powis';
    protected $contact = 'crisp@xaraya.com';

    protected $show_preview = true;
    protected $show_help = false;

    public $timer_time;
    public $timer_direction;
    public $timer_message;

    public function display(Array $data=array())
    {
        $data = $this->getContent();
        if (!empty($this->timer_time))
            $timer_unix_time = strtotime($this->timer_time);
        if (!empty($timer_unix_time)) {
            $now = time();
            if ($timer_unix_time > $now) {
                $data['timer_direction'] = 'until';
            } else {
                $data['timer_direction'] = 'since';
            }
            $data['timer_locale_time'] = xarLocaleFormatDate("%B %d, %Y %H:%M:%S", $timer_unix_time);
            $data['timer_unix_time'] = $timer_unix_time;
        }

        return $data;
    }
}
?>