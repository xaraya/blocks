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
    public $send_info              = false;
    
/**
 * Display function
 * @param $data array containing title,content
 */
    function display(Array $data=array())
    {
        // Set up the redirect
        foreach ($this->redirects as $redirect) {
            $source = trim($redirect['source']);
            $target = trim($redirect['target']);
            if (strpos(xarServer::getCurrentURL(),$source) === 0) {
                // Poor man's sanity check
                if ((strpos($target,$source) === 0) || (strpos($source,$target) === 0) ) break;
                $data['source'] = $source;
                $data['language'] = $redirect['lang'];
                
                // If send_info flag is sent, send the redirect information along with the redirect reauest
                if ($this->send_info) {
                    $info = array('redirect_s' => $source, 'redirect_l' => $redirect['lang']);
                    $data['target'] = preg_replace("%".$source."%",$target,xarServer::getCurrentURL($info),1);
                } else {
                    $data['target'] = preg_replace("%".$source."%",$target,xarServer::getCurrentURL());
                }
                break;
            }
        }

        // If we already redirected and sent the redirect info, then grab it here
        if(!xarVarFetch('redirect_s',  'str',   $redirect_s,     '',       XARVAR_NOT_REQUIRED)) {return;}
        if(!xarVarFetch('redirect_l',  'str',   $redirect_l,     '',       XARVAR_NOT_REQUIRED)) {return;}
        if (!empty($redirect_s)) {
            try {
                $data['source'] = $redirect_s;
                $data['language'] = $redirect_l;
                $data['postredirect'] = 1;
            } catch (Exception $e) {}
        }

        return $data;

        /*
        if (isset($_COOKIE['Xaraya_redirect'])) {
        
            // We already performed a redirect
            $redirect = unserialize($_COOKIE['Xaraya_redirect']);
            $data['redirect_target'] = $redirect['target'];
            $data['redirect_source'] = $redirect['source'];
            $data['redirect_language'] = $redirect['lang'];
            
            // Delete the cookie for good order
            setcookie('Xaraya_redirect', '', time()-3600);
        } else {
        
            // Set up the redirect
            foreach ($this->redirects as $redirect) {
                $source = trim($redirect['source']);
                $target = trim($redirect['target']);
                if (strpos(xarServer::getCurrentURL(),$source) === 0) {
                    // Poor man's sanity check
                    if ((strpos($target,$source) === 0) || (strpos($source,$target) === 0) ) break;
                    $data['target'] = str_replace($source,$target,xarServer::getCurrentURL());
                    $data['source'] = $redirect['source'];
                    $data['language'] = $redirect['lang'];
                    
                    // Save a cookie with the redirect information
                    setcookie('Xaraya_redirect', serialize($redirect), time()+3600);                
                    break;
                }
            }
        }

        // If we already redirected and sent the redirect info, then grab it here
        if(!xarVarFetch('redirect_s',  'str',   $redirect_s,     '',       XARVAR_NOT_REQUIRED)) {return;}
        if(!xarVarFetch('redirect_l',  'str',   $redirect_l,     '',       XARVAR_NOT_REQUIRED)) {return;}
        if (!empty($redirect_s)) {
            try {
                $data['source'] = $redirect_s;
                $data['language'] = $redirect_l;
                $data['postredirect'] = 1;
            } catch (Exception $e) {}
        }

        return $data;
        */
    }
}
?>
