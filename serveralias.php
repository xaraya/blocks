<?php
/**
 * ServerAlias Block
 *
 * @package blocks
 * @subpackage serveralias block
 * @category Third Party Xaraya Block
 * @version 1.0.0
 * @copyright (C) 2011 Netspan AG
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @author Marc Lutolf <mfl@netspan.ch>
 */

sys::import('xaraya.structures.containers.blocks.basicblock');

class ServerAliasBlock extends BasicBlock
{
    protected $name                = 'ServerAliasBlock';
    protected $text_type           = 'Server Alias';
    protected $text_type_long      = 'Redirect a server alias';
    protected $xarversion          = '1.0.0';
    protected $show_preview        = true;
    protected $usershared          = true;
    protected $pageshared          = false;
    
    public $redirects              = false;
    
/**
 * Display func.
 * @param $data array containing title,content
 */
    function display(Array $data=array())
    {
        $data = $this->getContent();
        return $data;
    }
}
?>