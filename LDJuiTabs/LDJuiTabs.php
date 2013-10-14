<?php
/**
 * LDJuiTabs class file
 * 
 * @author Louis DaPrato <l.daprato@gmail.com>
 */

Yii::import('zii.widgets.jui.CJuiTabs');

/**
 * This widget is exactly the same as the {@link CJuiTabs} widget except that the tabs can optionally be laid out vertically. 
 *
 * @property $vertical boolean If true tabs will be laid out vertical, if false the tabs will be horizontal (default).
 * 
 * @author Louis DaPrato <l.daprato@gmail.com>
 */
class LDJuiTabs extends CJuiTabs
{
	/**
	 * @var boolean If true tabs will be laid out vertical otherwise they will be horizontal (default).
	 */
	public $vertical = false;
	
	/**
	 * (non-PHPdoc)
	 * @see CJuiTabs::run()
	 */
	public function run()
	{
		parent::run();
		if($this->vertical)
		{
			$id = $this->getId();
			if(isset($this->htmlOptions['id']))
			{
				$id = $this->htmlOptions['id'];
			}
			else
			{
				$this->htmlOptions['id'] = $id;
			}
			$assetsDir = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
			if(is_dir($assetsDir)) 
			{
				$assetsUrl = Yii::app()->getAssetManager()->publish($assetsDir, false, 1, YII_DEBUG);
			}
			$clientScript = Yii::app()->getClientScript();
			$clientScript->registerCssFile($assetsUrl.'/jquery.ui.tabs.vertical.css');
			$clientScript->registerScript(
					__CLASS__.'#'.$id.'-vertical', 
					'jQuery("#'.$id.'").addClass("ui-tabs-vertical ui-helper-clearfix");'.
					'jQuery("#'.$id.' li").removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );'
			);
		}
	}
	
}