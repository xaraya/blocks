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

sys::import('blocks.pubslider.pubslider');

class PubsliderBlockDisplay extends PubsliderBlock implements iBlock
{
    public function display()
    {
        $data = $this->getContent();

        // defaults
        $multiselect = DataPropertyMaster::getProperty(array('name' => 'multiselect'));
        $multiselect->value = $data['featuredids'];
        $featuredids = $multiselect->getValue();

        // Setup featured item
        if (count($featuredids) > 0) {        
            $publications = DataObjectMaster::getObjectList(array('name' => 'publications_publications'));            
            $itemids = $publications->getItems(array('itemids' => $featuredids));
            if (empty($itemids)) return '';
            $data['publications'] = $publications;
        }
        return $data;
    }
}
?>