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
 * Display function
 * @param $data array containing title,content
 */
    function display(Array $data=array())
    {
        $data = $this->getContent();
        $current_url = parse_url(xarServer::getBaseURL());
        $current_host = $current_url['host'];
        $past_url = parse_url($_SERVER['HTTP_REFERER']);
        $past_host = $past_url['host'];
        $data['same_host'] = $current_host == $past_host;
        
        $data['target'] = '';        
        $data['referer'] = array();        
        $found_redirect = false;
        $found_referer = false;
        foreach ($this->redirects as $redirect) {
            if (strstr($current_url,$redirect['source'])) {
                $data['target'] = $redirect['target'];
                $found_redirect = true;
            }
            if (strstr($_SERVER['HTTP_REFERER'],$redirect['source'])) {
                $data['referer'] = $redirect;
                $found_referer = true;
            }
            if ($found_redirect && $found_referer) break;
        }
        return $data;
    }
}
?>