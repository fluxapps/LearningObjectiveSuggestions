<#1>
<?php
	require_once('./Customizing/global/plugins/Services/Cron/CronHook/LearningObjectiveSuggestions/vendor/autoload.php');
	\SRAG\ILIAS\Plugins\LearningObjectiveSuggestions\Score\LearningObjectiveScore::installDB();
	\SRAG\ILIAS\Plugins\LearningObjectiveSuggestions\Suggestion\LearningObjectiveSuggestion::installDB();
	\SRAG\ILIAS\Plugins\LearningObjectiveSuggestions\Config\CourseConfig::installDB();
	\SRAG\ILIAS\Plugins\LearningObjectiveSuggestions\Config\Config::installDB();
	\SRAG\ILIAS\Plugins\LearningObjectiveSuggestions\Notification\Notification::installDB();
?>
<#2>
<?php
\SRAG\ILIAS\Plugins\LearningObjectiveSuggestions\Score\LearningObjectiveScore::updateDB();
?>