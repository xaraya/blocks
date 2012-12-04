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

sys::import('blocks.jqcarousel.jqcarousel');

class JqcarouselBlockConfig extends JqcarouselBlock implements iBlock
{
    protected $invalid = array();
/**
 * Validation helpers
 *
 * These methods are called by this class during modify, check and update phases
**/
/**
 * setInvalid
 * @param string $key an identifier for the invalid message 
 * @param string $msg the error message to display (a null msg deletes the key if present)
 * @return bool true on success
 * @throws none
**/
    protected function setInvalid($key, $msg=null) 
    {
        if ($msg == null) {
            if (isset($this->invalid[$key]))
                unset($this->invalid[$key]);
            return true;
        }
        $this->invalid[$key] = $msg;
        return true;
    }
/**
 * getInvalid
 * @param string $key an identifier for the invalid message (a null key returns all messages)
 * @return mixed array of messages, or if $key supplied string message, false if not found
 * @throws none
**/    
    public function getInvalid($key=null) 
    {
        if ($key != null) {
            if (isset($this->invalid[$key]))
                return $this->invalid[$key];
            return false;
        }
        return $this->invalid;
    }
/**
 * isValid
 * @param string $key an identifier to check if message is present (a null key evaluates all messages)
 * @return bool true if no message(s) found
 * @throws none
**/    
    public function isValid($key=null)
    {
        return (bool) $this->getInvalid($key) ? false : true;
    }
/**
 * clearInvalid
 * @param none
 * @return void
 * @throws none
**/    
    protected function clearInvalid()
    {
        $this->invalid = array();
    }

    public function configmodify()
    {
        $data = $this->getContent();
    
        return $data;
    }

    public function configUpdate(Array $data=array())
    {
        // Get the simple values
        xarVarFetch('imagedir',         'str',       $args['imagedir'],        $this->imagedir, XARVAR_NOT_REQUIRED);
        xarVarFetch('speed',            'str',       $args['speed'],           $this->pubtype_id, XARVAR_NOT_REQUIRED);
        xarVarFetch('usecaptions',      'checkbox',  $args['usecaptions'],     $this->nocatlimit, XARVAR_NOT_REQUIRED);

        $this->setContent($args);
        return true;        
    }
}
?>