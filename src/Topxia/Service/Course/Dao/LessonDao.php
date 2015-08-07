<?php

namespace Topxia\Service\Course\Dao;

interface LessonDao
{

    public function getLesson($id);

    public function getLessonByCourseIdAndNumber($courseId, $number);

    public function findLessonsByCourseId($courseId);

    public function findLessonsByTypeAndMediaId($type, $mediaId);

    public function findMinStartTimeByCourseId($courseId);

    public function findLessonIdsByCourseId($courseId);

    public function searchLessons($condition, $orderBy, $start, $limit);

    public function searchLessonCount($conditions);

    public function getLessonCountByCourseId($courseId);

    public function getLessonMaxSeqByCourseId($courseId);

    public function findTimeSlotOccupiedLessonsByCourseId($courseId,$startTime,$endTime,$excludeLessonId=0);

    public function findTimeSlotOccupiedLessons($startTime,$endTime,$excludeLessonId=0);

    public function findLessonsByChapterId($chapterId);

    public function addLesson($course);

    public function updateLesson($id, $fields);

    public function updateLessonByCourseId($courseId,$fields);

    public function updateLessonByParentId($parentId,$fields);

    public function deleteLesson($id);

    public function deleteLessonByParentId($parentId);

    public function deleteLessonsByCourseId($courseId);

    public function findLessonsByIds(array $ids);

    public function findLessonsByParentId($parentId);

    public function sumLessonGiveCreditByCourseId($courseId);

    public function sumLessonGiveCreditByLessonIds(array $lesonIds);

    public function analysisLessonDataByTime($startTime,$endTime);   
}