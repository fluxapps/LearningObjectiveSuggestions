<?php namespace SRAG\ILIAS\Plugins\LearningObjectiveSuggestions\LearningObjective;

use SRAG\ILIAS\Plugins\LearningObjectiveSuggestions\User\User;

/**
 * Class LearningObjectiveResult
 *
 * @author  Stefan Wanzenried <sw@studer-raimann.ch>
 * @package SRAG\ILIAS\Plugins\LearningObjectiveSuggestions\LearningObjective
 */
class LearningObjectiveResult {

	/**
	 * @var LearningObjective
	 */
	protected $objective;
	/**
	 * @var User
	 */
	protected $user;


	/**
	 * @param LearningObjective $objective
	 * @param User              $user
	 */
	public function __construct(LearningObjective $objective, User $user) {
		$this->objective = $objective;
		$this->user = $user;
	}


	/**
	 * @return int
	 */
	public function getPercentage() {
		$data = \ilLOUserResults::lookupResult($this->objective->getCourse()
			->getId(), $this->user->getId(), $this->objective->getId(), \ilLOUserResults::TYPE_INITIAL);

		return $data['result_perc'];
	}


	/**
	 * @return LearningObjective
	 */
	public function getLearningObjective() {
		return $this->objective;
	}


	/**
	 * @return User
	 */
	public function getUser() {
		return $this->user;
	}
}