<?php
/**
 * PubSlider Block
 *
 * @package blocks
 * @subpackage pubslider block
 * @category Third Party Xaraya Block
 * @version 1.0.0
 * @copyright (C) 2011 Netspan AG
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @author Marc Lutolf <mfl@netspan.ch>
 */

sys::import('xaraya.structures.containers.blocks.basicblock');
class PubsliderBlock extends BasicBlock implements iBlock
{
    protected $type = 'pubslider';
    protected $text_type = 'Publication Slider';
    protected $text_type_long = 'Simple Content Slider for Publications module';
    protected $xarversion = '1.0.0';
    protected $author = 'Marc Lutolf';
    protected $contact = 'mfl@netspan.ch';
    
    protected $show_preview = true; // set false to disable previewing
    protected $show_help = false;   // set true if a help method and help-type.xt template are supplied

    public $numitems            = 5;
    public $pubtype_id          = 0;
    public $linkpubtype         = true;
    public $itemlimit           = 0;
    public $featuredids         = array();
    public $catfilter           = 0;
    public $linkcat             = false;
    public $includechildren     = false;
    public $nocatlimit          = true;
    public $alttitle            = '';
    public $altsummary          = '';
    public $showvalue           = true;
    public $moreitems           = array();
    public $showfeaturedsum     = false;
    public $showfeaturedbod     = false;
    public $showsummary         = false;
    // chris: state is a reserved property name used by blocks
    //public $state               = '2,3';
    public $pubstate            = '2,3';
    public $toptype             = 'ratings'; 

    public function init()
    {
        // Bail if the publications module is not loaded
        if (!xarModIsAvailable('publications')) return true;
        
        sys::import('modules.dynamicdata.class.objects.master');
        try {
            $publications = DataObjectMaster::getObjectList(array('name' => 'publications_publications'));
        } catch (Exception $e) {
            $publications = null;
        }
        if (empty($publications)) {
            $module = 'publications';
            $objects = array(
                             'publications_publications',
                             );
            if(!xarModAPIFunc('modules','admin','standardinstall',array('module' => $module, 'objects' => $objects))) 
                throw new Exception(xarML('The publications_publications object cannot be loaded'));            
        }
    }
}
?>