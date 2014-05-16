LDJuiTabs provides optionally vertical tabs and runtime dynamic templates for the header and content areas.
===========================================================================================================

Overview
--------

This widget is exactly the same as the CJuiTabs widget provided by Yii, but adds a few new features.

1. The tabs can be laided out vertically or horizontally, see LDJuiTabs::$vertical property. If true tabs will be laid out vertical otherwise they will be horizontal (default).
	
2. The header and content templates can be replaced by an evaluated PHP expression, see LDJuiTabs::$headerTemplateExpression and LDJuiTabs::$contentTemplateExpression. 3 variables are provided in the evaluated expression. $title (the title of the tab), $content (an array containing the content configuration), $template (string the standard template). If null the expression is ignored and its respective template property value is used instead.

Requirements
------------

Yii 1.1 or above.

Example
-------

Note that none of the effects below are possible with the current implementation of CJuiTabs and yet are quite simple. If used properly these features add a significant amount of functionality to CJuiTabs.

The following example will create tabs with the following properties:

1. Vertical layout
2. Headers contain a span with a class equal to the content and value equal to the title.
3. Content prefixed the tab title

```php
$this->widget(
		'ext.LDJuiTabs.LDJuiTabs',
		array(
			'tabs' => $tabs,
			'vertical' => true,
			'headerTemplate' => '<li><a href="{url}" title="{title}">{text}</a></li>',
			'headerTemplateExpression' => 'strtr($template, array("{text}" => "<span class=\'".$content."\'>$title</span>"))',
			'contentTemplate' => '<div id="{id}">{title}:{content}</div>',
			'contentTemplateExpression' => 'strtr($template, array("{title}" => "$title"))',
		)
);
```