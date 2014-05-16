<?php
/**
 * LDJuiTabs class file.
 *
 * @author Louis A. DaPrato <l.daprato@gmail.com>
 * @link https://lou-d.com
 * @copyright 2014 Louis A. DaPrato
 * @license The MIT License (MIT)
 * @since 1.0
 */

Yii::import('zii.widgets.jui.CJuiTabs');

/**
 * This widget is exactly the same as the {@link CJuiTabs} widget, but adds a few new features.
 * 
 * 1. The tabs can be laided out vertically or horizontally {@see LDJuiTabs::$vertical}
 * 	If true tabs will be laid out vertical otherwise they will be horizontal (default).
 * 2. The header and content templates can be replaced by an evaluated PHP expression {@see LDJuiTabs::$headerTemplateExpression}
 * 	3 variables are provided in the evaluated expression. $title (the title of the tab), $content (an array containing the content configuration), $template (string the header template).
 * 	If null the expression is ignored and its respective template property value is used instead.
 *
 * @property boolean $vertical If true tabs will be laid out vertical, if false the tabs will be horizontal (default).
 * @property string $headerTemplateExpression A php expression that is evaluated for each tab header the result of which is used in place of the header template.
 * @property string $contentTemplateExpression A php expression that is evaluated for each tab's content the result of which is used in place of the content template.
 * 
 * @author Louis A. DaPrato <l.daprato@gmail.com>
 */
class LDJuiTabs extends CJuiTabs
{
	/**
	 * @var boolean If true tabs will be laid out vertical otherwise they will be horizontal (default).
	 */
	public $vertical = false;
	
	/**
	 * @var string A php expression that is evaluated for each tab header the result of which is used in place of the header template. 
	 * 3 variables are provided in the eval'd expression $title (the title of the tab), $content (an array containing the content configuration), $template (string the standard template).
	 * If null this expression is ignored and the "headerTemplate" property's value is used instead.
	 * Defaults to null.
	 */
	public $headerTemplateExpression;
	
	/**
	 * @var string A php expression that is evaluated for each tab's content the result of which is used in place of the content template. 
	 * 3 variables are provided in the eval'd expression $title (the title of the tab), $content (an array containing the content configuration), $template (string the standard template).
	 * If null this expression is ignored and the "contentTemplate" property's value is used instead.
	 * Defaults to null.
	 */
	public $contentTemplateExpression;
	
	/**
	 * Run this widget.
	 * This method registers necessary javascript and renders the needed HTML code.
	 */
	public function run()
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
	
		echo CHtml::openTag($this->tagName, $this->htmlOptions)."\n";
		
		$this->renderTabs($id);
		
		echo CHtml::closeTag($this->tagName)."\n";
	
		$options = CJavaScript::encode($this->options);
		$clientScript = Yii::app()->getClientScript();
		$clientScript->registerScript(__CLASS__.'#'.$id, "jQuery('#{$id}').tabs($options);");
		
		if($this->vertical)
		{
			$assetsDir = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
			if(is_dir($assetsDir))
			{
				$assetsUrl = Yii::app()->getAssetManager()->publish($assetsDir, false, 1, defined('YII_DEBUG') && YII_DEBUG);
				$clientScript->registerCssFile($assetsUrl.'/jquery.ui.tabs.vertical.css');
				$clientScript->registerScript(
						__CLASS__.'#'.$id.'-vertical',
						'jQuery("#'.$id.'").addClass("ui-tabs-vertical ui-helper-clearfix");'.
						'jQuery("#'.$id.' li").removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );'
				);
			}
		}
	}
	
	/**
	 * Renders the tabs for this widget
	 * 
	 * @param string $id The ID of the JuiTabs widget
	 */
	public function renderTabs($id)
	{	
		$tabsOut = "";
		$contentOut = "";
		$tabCount = 0;
		
		foreach($this->tabs as $title => $content)
		{
			if(!is_array($content))
			{
				$content = array('content' => $content);
			}
			
			if(!isset($content['id']))
			{
				$content['id'] = $id.'_tab_'.$tabCount++;
			}

			$headerTemplate = $this->headerTemplateExpression !== null ? $this->evaluateExpression($this->headerTemplateExpression, array('template' => $this->headerTemplate, 'title' => $title, 'content' => $content)) : $this->headerTemplate;
		
			if(isset($content['ajax']))
			{
				$tabsOut .= strtr($headerTemplate, array('{title}' => $title, '{url}' => CHtml::normalizeUrl($content['ajax']), '{id}' => $content['id']))."\n";
			}
			else
			{
				$tabsOut .= strtr($headerTemplate, array('{title}' => $title, '{url}' => '#'.$content['id'], '{id}' => $content['id']))."\n";
				if(isset($content['content']))
				{
					$contentTemplate = $this->contentTemplateExpression !== null ? $this->evaluateExpression($this->contentTemplateExpression, array('template' => $this->contentTemplate, 'title' => $title, 'content' => $content)) : $this->contentTemplate;
					$contentOut .= strtr($contentTemplate, array('{content}' => $content['content'], '{id}' => $content['id']))."\n";
				}
			}
		}
		
		echo "<ul>\n".$tabsOut."</ul>\n";
		echo $contentOut;
	}
	
}