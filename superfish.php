<?php
/**
 * Superfish Block
 *
 * @package blocks
 * @subpackage superfish block
 * @category Third Party Xaraya Block
 * @version 1.0.0
 * @copyright (C) 2013 Netspan AG
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @author Marc Lutolf <mfl@netspan.ch>
 */

sys::import('xaraya.structures.containers.blocks.basicblock');
class SuperfishBlock extends BasicBlock implements iBlock
{
    public $type           = 'superfish';
    public $text_type      = 'Superfish Menu';
    public $text_type_long = 'A navmenu based on Superfish';
    public $xarversion     = '1.0.0';
    public $author         = 'Marc Lutolf';
    public $contact        = 'mfl@netspan.ch';
    
    public $allow_multiple = true;

    public $form_content   = false;
    public $form_refresh   = false;

    public $show_preview   = true;

    public $func_update    = 'menublock_update';
    public $notes          = "no notes";
    public $links          = array(); // Used to pass a menu to the block

}
?>