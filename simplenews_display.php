<?php
/**
 * SimpleNews Block
 *
 * @package blocks
 * @subpackage simplenews block
 * @category Third Party Xaraya Block
 * @version 1.0.0
 * @copyright (C) 2012 Netspan AG
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @author Marc Lutolf <mfl@netspan.ch>
 */

sys::import('blocks.simplenews.simplenews');

class SimplenewsBlockDisplay extends SimplenewsBlock implements iBlock
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
            $publications->dataquery->in('id',$featuredids);
            $items = $publications->getItems();
            if (empty($items)) return '';
            $data['publications'] = $publications;
        }
        return $data;
    }
}
?>