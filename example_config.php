<?php
sys::import('blocks.example.example');
class ExampleBlockConfig extends ExampleBlock implements iBlock
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
/**
 * configmodify
 * This method is called by the block subsystem when displaying the blocks config form
 * NOTE: this method is also called after configcheck if the block failed to validate
 *
 * @params none
 * @return array of template data to render or empty if nothing to display
 * @throws none
**/
    public function configmodify()
    {
        $data = $this->getContent();
        
        // if the form was submitted and failed to validate, pass back messages
        if (!$this->isValid())
            $data['invalid'] = $this->getInvalid();
        return $data;
    }
/**
 * configcheck
 * If present, this method is called by the block subsystem when data is submitted by the blocks config form
 *
 * @params none
 * @return bool true if valid
 * @throws none
**/    
    public function configcheck()
    {
        // make sure we clear messages
        $this->clearInvalid();
        // fetch input
        if (!xarVarFetch('example_text', 'pre:trim:str:1:',
            $example_text, '', XARVAR_NOT_REQUIRED)) return;
        // validate
        if (empty($example_text)) {
            $this->setInvalid('example_text', xarML('Example text cannot be empty'));
        } elseif (strlen($example_text) > 255) {
            $this->setInvalid('example_text', xarML('Example text cannot exceed 255 characters'));
        }
        // it's ok to update the value here, if it failed validation
        // we still want to display what failed in the form
        $this->example_text = $example_text;
        // finally return the response, if it's not valid configmodify will be called again
        return $this->isValid();
    }
/**
 * configcheck
 * If present, this method is called by the block subsystem when data is submitted by the blocks config form
 *
 * @params none
 * @return bool true if valid
 * @throws none
**/     
    public function configupdate()
    {
        // call configcheck once more, just to be sure it wasn't by-passed
        if (!$this->configcheck()) return false;
        // valid input, configcheck already set the values, 
        // just let the subsystem know it's ok to store them 
        return true;
    }
}
?>