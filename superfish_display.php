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

sys::import('blocks.superfish.superfish');

class SuperfishBlockDisplay extends SuperfishBlock implements iBlock
{
    public function display()
    {
        $data = $this->getContent();

        return $data;
    }
}
?>