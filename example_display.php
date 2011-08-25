<?php
sys::import('blocks.example.example');
class ExampleBlockDisplay extends ExampleBlock implements iBlock
{
/**
 * Display
 * @param none
 * @return mixed array of template data or false if nothing to display
 * @throws none
 *
 * This method is called by the blocks subsystem when displaying or previewing the block
**/  
    public function display()
    {
        // the getContent method returns an array of all the blocks public properties
        $data = $this->getContent();
        // we could have alternatively used the property values directly...
        //$data['example_text'] = $this->example_text;

        // we return an array of template data which will be rendered to
        // the blocks {type}.xt template (in this case example.xt)
        return $data;
    }
/**
 * Optional display methods
**/
/**
 * Preview
 * @params none
 * @return mixed array of template data or false if nothing to display
 * @throws none
 *
 * If present this method will be called when previewing the block (instead of display)
 * NOTE: you must also supply a preview-{type}.xt template and set $show_preview = true;
**/
    /*
    public function preview()
    {
        return $this->getContent();
    }
    */

/**
 * Help
 * @params none
 * @return mixed array of template data or false if nothing to display
 * @throws none
 *
 * If present this method will be called when showing help for the block
 * NOTE: you must also supply a help-{type}.xt template and set $show_help = true;
**/
    /*
    public function help()
    {
        return $this->getContent();
    }
    */

}
?>