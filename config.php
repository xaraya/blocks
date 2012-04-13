<?php
/**
 * ServerAlias Block
 *
 * @package blocks
 * @subpackage serveralias block
 * @category Third Party Xaraya Block
 * @version 1.0.0
 * @copyright (C) 2012 Netspan AG
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @author Marc Lutolf <mfl@netspan.ch>
 */

sys::import('blocks.serveralias.serveralias');
class ServeraliasBlockConfig extends ServeraliasBlock
{
/**
 * Modify Function to the Blocks Admin
 * @param $data array containing title,content
 */
    public function configmodify(Array $data=array())
    {
        $data = $this->getContent();
        return $data;
    }

/**
 * Updates the Block config from the Blocks Admin
 * @param $data array containing title,content
 */
    public function update(Array $data=array())
    {
        $vars = array();
        
        // fetch the array of redirects from input
        if (!xarVarFetch('redirects', 'array', $redirects, array(), XARVAR_NOT_REQUIRED)) return;
        $newredirects = array();
        foreach ($redirects as $redirect) {
            // delete if flag is set not empty
            if (isset($redirect['delete']) && !empty($redirect['delete'])) continue;
            $newredirects[] = $redirect;
        }

        // fetch the value of the new redirect
        if (!xarVarFetch('redirectsource', 'pre:trim:str:1:', $redirectsource, '', XARVAR_NOT_REQUIRED)) return;
        // only fetch other params if source isn't empty
        if (!empty($redirectsource)) {
            if (!xarVarFetch('redirecttarget', 'pre:trim:str:1:', $redirecttarget, '', XARVAR_NOT_REQUIRED)) return;
            if (!xarVarFetch('redirectlang', 'pre:trim:str:1:', $redirectlang, '', XARVAR_NOT_REQUIRED)) return;
            $newredirects[] = array(
                'source' => $redirectsource,
                'target' => $redirecttarget,
                'lang' => $redirectlang,
            );
        }
        $vars['redirects'] = $newredirects;
        $this->setContent($vars);
        return true;
    }
}
?>