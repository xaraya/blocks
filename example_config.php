<?php
sys::import('blocks.example.example');
class ExampleBlockConfig extends ExampleBlock implements iBlock
{
    protected $invalid = array();
    
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
    
    public function getInvalid($key=null) 
    {
        if ($key != null) {
            if (isset($this->invalid[$key]))
                return $this->invalid[$key];
            return false;
        }
        return $this->invalid;
    }
    
    public function isValid($key=null)
    {
        return (bool) $this->getInvalid($key) ? false : true;
    }
    
    protected function clearInvalid()
    {
        $this->invalid = array();
    }

    public function configmodify()
    {
        $data = $this->getContent();
        
        if (!$this->isValid())
            $data['invalid'] = $this->getInvalid();
        return $data;
    }
    
    public function configcheck()
    {
        $this->clearInvalid();
        if (!xarVarFetch('example_text', 'pre:trim:str:1:',
            $example_text, '', XARVAR_NOT_REQUIRED)) return;
        if (empty($example_text)) {
            $this->setInvalid('example_text', xarML('Example text cannot be empty'));
        } elseif (strlen($example_text) > 255) {
            $this->setInvalid('example_text', xarML('Example text cannot exceed 255 characters'));
        }
        $this->example_text = $example_text;
        return $this->isValid();
    }
    
    public function configupdate()
    {
        if (!$this->configcheck()) return false;
        return true;
    }
}
?>