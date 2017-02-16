<?php

namespace Biz\Course\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

/**
 * Interface CourseMemberDao
 * TODO course2.0 所有的api 需要重构，很多的api可以合并，还有名字不规范
 * @package Biz\Course\Dao
 */
interface CourseMemberDao extends GeneralDaoInterface
{
    /**
     * @before getMemberByCourseIdAndUserId
     * @param  $courseId
     * @param  $userId
     * @return mixed
     */
    public function getByCourseIdAndUserId($courseId, $userId);

    public function countLearningMembers($conditions);

    public function findLearningMembers($conditions, $start, $limit);

    public function countLearnedMembers($conditions);

    public function findLearnedMembers($conditions, $start, $limit);

    public function findLearnedByCourseIdAndUserId($courseId, $userId);

    public function searchMemberCountGroupByFields($conditions, $groupBy, $start, $limit);

    /**
     * @before getMembersByCourseIds
     * @before findMembersByCourseIds
     * @param  $courseIds
     * @return mixed
     */
    public function findByCourseIds($courseIds);

    /**
     * @before findMembersByUserIdAndRole
     * @param  $userId
     * @param  $role
     * @return mixed
     */
    public function findByUserIdAndRole($userId, $role);

    /**
     * @param $userId
     * @param $courseSetId
     * @param $role
     *
     * @return array
     */
    public function findByUserIdAndCourseSetIdAndRole($userId, $courseSetId, $role);

    /**
     * @before findMembersByUserIdAndRole
     * @param  $userId
     * @param  $role
     * @param  $start
     * @param  $limit
     * @param  bool $onlyPublished
     * @return mixed
     */
    public function findMembersNotInClassroomByUserIdAndRole($userId, $role, $start, $limit, $onlyPublished = true); //

    public function findByCourseIdAndRole($courseId, $role);

    public function findByUserIdAndJoinType($userId, $joinedType);

    public function searchMemberIds($conditions, $orderBy, $start, $limit);

    public function updateMembers($conditions, $updateFields);

    public function deleteByCourseIdAndRole($courseId, $role);

    public function deleteByCourseId($courseId);

    public function findByUserIdAndCourseIds($userId, $courseIds);

    public function findByCourseId($courseId);

    public function findByUserId($userId);

    public function countThreadsByCourseIdAndUserId($courseId, $userId, $type = 'discussion');

    public function countActivitiesByCourseIdAndUserId($courseId, $userId);

    public function countPostsByCourseIdAndUserId($courseId, $userId);
}
