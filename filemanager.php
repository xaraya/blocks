<?php
/**
 * FileManager Block
 *
 * @package blocks
 * @subpackage filemanager block
 * @category Third Party Xaraya Block
 * @version 1.0.0
 * @copyright (C) 2011 Netspan AG
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @author Marc Lutolf <mfl@netspan.ch>
 */

sys::import('xaraya.structures.containers.blocks.basicblock');
class FileManagerBlock extends BasicBlock implements iBlock
{
    protected $type = 'filemanager';
    protected $text_type = 'File Manager';
    protected $text_type_long = 'Upload/Manage Server Files';
    protected $xarversion = '1.0.0';
    protected $author = 'Marc Lutolf';
    protected $contact = 'mfl@netspan.ch';
    protected $credits = 'Core Five Labs (http://labs.corefive.com)';
    
    protected $show_preview = true; // set false to disable previewing
    protected $show_help = false;   // set true if a help method and help-type.xt template are supplied

    public $width       = '100%';
    public $height      = '400px';

}
?>