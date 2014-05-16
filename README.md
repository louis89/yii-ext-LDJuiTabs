LDJuiTabs provides optionally vertical tabs and runtime dynamic templates for the header and content areas.
===========================================================================================================

This widget is exactly the same as the CJuiTabs widget provided by Yii, but adds a few new features.

1. The tabs can be laided out vertically or horizontally, see LDJuiTabs::$vertical property. If true tabs will be laid out vertical otherwise they will be horizontal (default).
	
2. The header and content templates can be replaced by an evaluated PHP expression, see LDJuiTabs::$headerTemplateExpression and LDJuiTabs::$contentTemplateExpression. 3 variables are provided in the evaluated expression. $title (the title of the tab), $content (an array containing the content configuration), $template (string the header template). If null the expression is ignored and its respective template property value is used instead.
