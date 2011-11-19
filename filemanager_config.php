<?php
/**
 * FileManager Block
 *
 * @package blocks
 * @subpackage filemanager block
 * @category Third Party Xaraya Block
 * @version 1.0.0
 * @copyright (C) 2011 Netspan AG
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @author Marc Lutolf <mfl@netspan.ch>
 */

sys::import('blocks.filemanager.filemanager');

class FileManagerBlockConfig extends FileManagerBlock implements iBlock
{
    public function configmodify()
    {
        $data = $this->getContent();  
        $file = sys::code() . "blocks/filemanager/filemanager/scripts/filemanager.config.js";
        $data['configuration'] = trim($this->read_file($file));
        return $data;
    }

    public function configUpdate(Array $data=array())
    {
        xarVarFetch('width',         'str',       $args['width'],      $this->width, XARVAR_NOT_REQUIRED);
        xarVarFetch('height',        'str',       $args['height'],     $this->height, XARVAR_NOT_REQUIRED);
        xarVarFetch('configuration', 'str',       $configuration,      '', XARVAR_NOT_REQUIRED);
        $file = sys::code() . "blocks/filemanager/filemanager/scripts/filemanager.config.js";
        $this->write_file($file, $configuration);
        $this->setContent($args);
        return true;        
    }

    private function read_file($file)
    {
        if (empty($file)) return false;
        try {
            $data = "";
            if (file_exists($file)) {
                $fp = fopen($file, "rb");
                while (!feof($fp)) {
                    $filestring = fread($fp, 4096);
                    $data .=  $filestring;
                }
                fclose ($fp);
            }
            return $data ;
        } catch (Exception $e) {
            return '';
        }
    }
    
    private function write_file($file, $data)
    {
        if (empty($file)) return false;
        try {
            $fp = fopen($file, "wb");
        
            if (get_magic_quotes_gpc()) {
                $data = stripslashes($data);
            }
            fwrite($fp, $data);
            fclose ($fp);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>