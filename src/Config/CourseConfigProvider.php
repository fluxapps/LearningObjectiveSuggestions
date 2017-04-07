<?php namespace SRAG\ILIAS\Plugins\AutoLearningObjectives\Config;

use SRAG\ILIAS\Plugins\AutoLearningObjectives\LearningObjective\LearningObjective;
use SRAG\ILIAS\Plugins\AutoLearningObjectives\LearningObjective\LearningObjectiveCourse;
use SRAG\ILIAS\Plugins\AutoLearningObjectives\User\StudyProgram;

/**
 * Class CourseConfigProvider
 *
 * Provides access to config data depending on the injected course
 *
 * @author Stefan Wanzenried <sw@studer-raimann.ch>
 * @package SRAG\ILIAS\Plugins\AutoLearningObjectives\Config
 */
class CourseConfigProvider {

	/**
	 * @var LearningObjectiveCourse
	 */
	protected $course;

	/**
	 * @param LearningObjectiveCourse $course
	 */
	public function __construct(LearningObjectiveCourse $course) {
		$this->course = $course;
	}

	/**
	 * @return LearningObjectiveCourse
	 */
	public function getCourse() {
		return $this->course;
	}

	/**
	 * @param string $key
	 * @return string
	 */
	public function get($key) {
		/** @var CourseConfig $config */
		$config = CourseConfig::where(array(
			'cfg_key' => $key,
			'course_obj_id' => $this->course->getId()
		))->first();
		return ($config) ? $config->getValue() : null;
	}

	/**
	 * @param string $key
	 * @param string $value
	 */
	public function set($key, $value) {
		$config = CourseConfig::where(array(
			'cfg_key' => $key,
			'course_obj_id' => $this->course->getId(),
			))->first();
		if ($config === null) {
			$config = new CourseConfig();
			$config->setKey($key);
			$config->setCourseObjId($this->course->getId());
		}
		$config->setValue($value);
		$config->save();
	}

	/**
	 * @param LearningObjective $learning_objective
	 * @param StudyProgram $study_program
	 * @return int
	 */
	public function getWeightRough(LearningObjective $learning_objective, StudyProgram $study_program) {
		return $this->get('weight_rough_' . $learning_objective->getId() . '_' . $study_program->getId());
	}

	/**
	 * @param LearningObjective $learning_objective
	 * @return int
	 */
	public function getWeightFine(LearningObjective $learning_objective) {
		return $this->get('weight_fine_' . $learning_objective->getId());
	}

}