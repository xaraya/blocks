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

sys::import('xaraya.structures.relativedirectoryiterator');
sys::import('blocks.jqcarousel.jqcarousel');

class JqcarouselBlockDisplay extends JqcarouselBlock implements iBlock
{
    public function display()
    {
        $data = $this->getContent();

        if (empty($this->imagedir)) return array();
        $dir = new RelativeDirectoryIterator($this->imagedir);
        if ($dir == false) return array();
        
        $data['items'] = array();
        for($dir->rewind();$dir->valid();$dir->next()) {
            if($dir->isDir()) continue; // no dirs
            if($dir->isDot()) continue; // temp for emacs insanity and skip hidden files while we're at it
            $data['items'][] = array(
                'image'   => $this->imagedir . "/" . $dir->getFileName(),
                'alt'     => 'dork',
                'caption' => 'doofus',
            );
        }
        return $data;
    }
}
?>