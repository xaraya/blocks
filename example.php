<?php
sys::import('xaraya.structures.containers.blocks.basicblock');
class ExampleBlock extends BasicBlock implements iBlock
{
    protected $type = 'example';
    protected $text_type = 'Example';
    protected $text_type_long = 'SoloBlocks Example Block';
    protected $xarversion = '2.3.0';
    protected $author = 'Chris Powis';
    protected $contact = 'crisp@xaraya.com';
    
    protected $show_preview = true;
    protected $show_help = true;
    
    public function display(Array $data=array())
    {
        return parent::display($data);
    }
}
?>