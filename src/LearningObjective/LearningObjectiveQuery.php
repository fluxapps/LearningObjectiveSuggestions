<?php namespace SRAG\ILIAS\Plugins\LearningObjectiveSuggestions\LearningObjective;

use SRAG\ILIAS\Plugins\LearningObjectiveSuggestions\Config\CourseConfigProvider;

/**
 * Class LearningObjectiveQuery
 *
 * @author  Stefan Wanzenried <sw@studer-raimann.ch>
 * @package SRAG\ILIAS\Plugins\LearningObjectiveSuggestions\LearningObjective
 */
class LearningObjectiveQuery {

	/**
	 * @var CourseConfigProvider
	 */
	protected $config;


	/**
	 * @param CourseConfigProvider $config
	 */
	public function __construct(CourseConfigProvider $config) {
		$this->config = $config;
	}


	/**
	 * Get all learning objectives
	 *
	 * @return LearningObjective[]
	 */
	public function getAll() {
		static $cache = array();
		$ref_id = $this->config->getCourse()->getRefId();
		if (isset($cache[$ref_id])) {
			return $cache[$ref_id];
		}
		$objectives = array();
		$course = $this->config->getCourse()->getILIASCourse();
		$ids = \ilCourseObjective::_getObjectiveIds($course->getId());
		foreach ($ids as $id) {
			$objectives[] = new LearningObjective(new \ilCourseObjective($course, $id));
		}

		$cache[$ref_id] = $objectives;

		return $objectives;
	}


	/**
	 * @param int $objective_id
	 *
	 * @return LearningObjective
	 */
	public function getByObjectiveId($objective_id) {
		$filtered = array_filter($this->getAll(), function ($objective) use ($objective_id) {
			/** @var $objective LearningObjective */
			return ($objective->getId() == $objective_id);
		});

		return array_pop($filtered);
	}


	/**
	 * Get the learning objectives belonging to the main section
	 *
	 * @return LearningObjective[]
	 */
	public function getMain() {
		$main = json_decode($this->config->get('learning_objectives_main'), true);

		return array_filter($this->getAll(), function ($objective) use ($main) {
			/** @var $objective LearningObjective */
			return (in_array($objective->getId(), $main));
		});
	}


	/**
	 * Get the learning objectives belonging to the extended section
	 *
	 * @return LearningObjective[]
	 */
	public function getExtended() {
		$extended = json_decode($this->config->get('learning_objectives_extended'), true);

		return array_filter($this->getAll(), function ($objective) use ($extended) {
			/** @var $objective LearningObjective */
			return (in_array($objective->getId(), $extended));
		});
	}
}