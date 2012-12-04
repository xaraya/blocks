<?php
/**
 * JQCarousel Block
 *
 * @package blocks
 * @subpackage jqcarousel block
 * @category Third Party Xaraya Block
 * @version 1.0.0
 * @copyright (C) 2012 Netspan AG
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @author Marc Lutolf <mfl@netspan.ch>
 */

sys::import('xaraya.structures.containers.blocks.basicblock');
class JqcarouselBlock extends BasicBlock implements iBlock
{
    protected $type = 'jqcarousel';
    protected $text_type = 'JQuery Carousel';
    protected $text_type_long = 'Simple Sliding Image Gallery';
    protected $xarversion = '1.0.0';
    protected $author = 'Marc Lutolf';
    protected $contact = 'mfl@netspan.ch';
    
    protected $show_preview = true; // set false to disable previewing
    protected $show_help = false;   // set true if a help method and help-type.xt template are supplied

    public $imagedir            = 'var/uploads';
    public $speed               = 'slow';
    public $lzoom               = 'zoomFunc';
    public $pzoom               = 'zoomFunc';
    public $lshrink             = 'shrinkFunc';
    public $pshrink             = 'shrinkFunc';
    public $usecaptions         = false;

    public function init()
    {
    }
}
?>