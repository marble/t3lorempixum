<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Oliver Tempel <info@olivertempel.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'LoremPixum' for the 'lorempixum' extension.
 *
 * @author	Oliver Tempel <info@olivertempel.de>
 * @package	TYPO3
 * @subpackage	tx_lorempixum
 */
class tx_lorempixum_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_lorempixum_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_lorempixum_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'lorempixum';	// The extension key.
	var $pi_checkCHash = true;
	var $flexConf=array(); 
     
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		$this->init();
        $content = '';
	    $cat = explode(',',$this->flexConf['sDEF']['category']);
        if(is_array($cat)){
          $count   = intval($this->flexConf['sDEF']['imagecount']);
          if($count < 1){$count = 1;}
          
          $grey    = intval($this->flexConf['sDEF']['grey']);
          $width   = intval($this->flexConf['sDEF']['width']);
          $height  = intval($this->flexConf['sDEF']['height']);
          $inr     = str_replace("\n", " ",nl2br($this->flexConf['sDEF']['imagenr']));
          $expl    = explode( "<br />", $inr); 
          if($grey == 1){$grey = 'g/';}
          $a=0;
          foreach($cat as $category){
                 $e = intval($expl[$a]);
                 $imagenr = $e > 0?'/'.$e:'';
                 for($z=1;$z<=$count;$z++){
                    $url = 'http://lorempixum.com/'.$grey.$width.'/'.$height.'/'.$category.$imagenr.'?t='.microtime();
                    $image = '<img src="'.$url.'" width="'.$width.'" height="'.$height.'" alt="'.$category.$imagenr.$a.'" />';
                    $image = !empty($this->flexConf['WRAP']['single'])?str_replace('|',$image,$this->flexConf['WRAP']['single']):$image;
                    $content.=$image; 
                    } 
                 $a++;
                 }  
          }
        
	    if($this->flexConf['WRAP']['default']==1){
          $content = $this->pi_wrapInBaseClass($content);
          }
		return $content;
	}
    function init(){
        $this->pi_initPIflexForm(); // Init and get the flexform data of the plugin
         $piFlexForm = $this->cObj->data['pi_flexform'];
          foreach ( $piFlexForm['data'] as $sheet => $data ){
              foreach ( $data as $lang => $value ) {
                   foreach ( $value as $key => $val ){
                    $this->flexConf[$sheet][$key] = $this->pi_getFFvalue($piFlexForm, $key, $sheet);
                  }
              }
        }
        
        $this->formName = $this->flexConf['sDEF']['code'].'.';

    }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lorempixum/pi1/class.tx_lorempixum_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lorempixum/pi1/class.tx_lorempixum_pi1.php']);
}

?>