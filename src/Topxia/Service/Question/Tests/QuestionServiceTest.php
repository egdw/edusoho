<?php

namespace Topxia\Service\Question\Tests;

use Topxia\Service\Common\BaseTestCase;
use Topxia\Common\ArrayToolkit;

class QuestionServiceTest extends BaseTestCase
{

    public function testSingleJudgeChoiceQuestions()
    {
        $question = array(
            'type' => 'single_choice',
            'stem' => 'test single choice question 1.',
            'choices' => array(
                'question 1 -> choice 1',
                'question 1 -> choice 2',
                'question 1 -> choice 3',
                'question 1 -> choice 4',
            ),
            'answer' => array(1),
            'target' => 'course-1',
        );
        $question = $this->getQuestionService()->createQuestion($question);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array(),
        ));
        $this->assertEquals('noAnswer', $result[$question['id']]['status']);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array(1),
        ));
        $this->assertEquals('right', $result[$question['id']]['status']);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array(0),
        ));
        $this->assertEquals('wrong', $result[$question['id']]['status']);


        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array(2),
        ));
        $this->assertEquals('wrong', $result[$question['id']]['status']);
    }


    public function testJudgeChoiceQuestions()
    {
        $question = array(
            'type' => 'choice',
            'stem' => 'test choice question 1.',
            'choices' => array(
                'question 1 -> choice 1',
                'question 1 -> choice 2',
                'question 1 -> choice 3',
                'question 1 -> choice 4',
            ),
            'answer' => array(0, 1),
            'target' => 'course-1',
        );
        $question = $this->getQuestionService()->createQuestion($question);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array(),
        ));
        $this->assertEquals('noAnswer', $result[$question['id']]['status']);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array(0, 1),
        ));
        $this->assertEquals('right', $result[$question['id']]['status']);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array(0),
        ));
        $this->assertEquals('partRight', $result[$question['id']]['status']);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array(1),
        ));
        $this->assertEquals('partRight', $result[$question['id']]['status']);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array(0, 1, 2),
        ));
        $this->assertEquals('wrong', $result[$question['id']]['status']);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array(2),
        ));
        $this->assertEquals('wrong', $result[$question['id']]['status']);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array(0, 2),
        ));
        $this->assertEquals('wrong', $result[$question['id']]['status']);
    }

    public function testJudgeChoiceQuestionsWithPartRightPercentage()
    {
        $question = array(
            'type' => 'choice',
            'stem' => 'test choice question 1.',
            'choices' => array(
                'question 1 -> choice 1',
                'question 1 -> choice 2',
                'question 1 -> choice 3',
                'question 1 -> choice 4',
            ),
            'answer' => array(0, 1, 2, 3),
            'target' => 'course-1',
        );
        $question = $this->getQuestionService()->createQuestion($question);
        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array(0),
        ));
        $this->assertEquals('partRight', $result[$question['id']]['status']);
        $this->assertEquals(25, $result[$question['id']]['percentage']);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array(0, 1),
        ));
        $this->assertEquals('partRight', $result[$question['id']]['status']);
        $this->assertEquals(50, $result[$question['id']]['percentage']);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array(0, 1, 2),
        ));
        $this->assertEquals('partRight', $result[$question['id']]['status']);
        $this->assertEquals(75, $result[$question['id']]['percentage']);
    }

    public function testJudgeDetermineQuestions()
    {
        $question = array(
            'type' => 'determine',
            'stem' => 'test determine question 1.',
            'answer' => array(1),
            'target' => 'course-1',
        );
        $question = $this->getQuestionService()->createQuestion($question);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array(1),
        ));
        $this->assertEquals('right', $result[$question['id']]['status']);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array(0),
        ));
        $this->assertEquals('wrong', $result[$question['id']]['status']);

        $question['answer'] = array(0);
        $question = $this->getQuestionService()->createQuestion($question);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array(1),
        ));
        $this->assertEquals('wrong', $result[$question['id']]['status']);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array(0),
        ));
        $this->assertEquals('right', $result[$question['id']]['status']);
    }

    public function testJudgeFillQuestions()
    {
        $question = array(
            'type' => 'fill',
            'stem' => 'fill 1 [[aaa|bbb|ccc]], fill 2 [[ddd|eee|fff]].',
            'target' => 'course-1',
        );
        $question = $this->getQuestionService()->createQuestion($question);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array('aaa', 'eee'),
        ));
        $this->assertEquals('right', $result[$question['id']]['status']);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array('ddd', 'eee'),
        ));
        $this->assertEquals('partRight', $result[$question['id']]['status']);
        $this->assertEquals(50, $result[$question['id']]['percentage']);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array('aaa', 'qqq'),
        ));
        $this->assertEquals('partRight', $result[$question['id']]['status']);
        $this->assertEquals(50, $result[$question['id']]['percentage']);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array('qqq', 'www'),
        ));
        $this->assertEquals('wrong', $result[$question['id']]['status']);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array('aaa', 'eee', 'qqq'),
        ));
        $this->assertEquals('wrong', $result[$question['id']]['status']);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array('aaa'),
        ));
        $this->assertEquals('wrong', $result[$question['id']]['status']);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array(),
        ));
        $this->assertEquals('noAnswer', $result[$question['id']]['status']);
    }

    /**
     * @group current
     */
    public function testJudgeEssayQuestions()
    {
        $question = array(
            'type' => 'essay',
            'stem' => 'question.',
            'answer' => array('answer'),
            'target' => 'course-1',
        );
        $question = $this->getQuestionService()->createQuestion($question);

        $result = $this->getQuestionService()->judgeQuestions(array(
            $question['id'] => array('answer'),
        ));
        $this->assertEquals('none', $result[$question['id']]['status']);
    }

    /*
        问题数据同步
    */

    public function testAddQuestion()
    {
        $question = array(
            'type' => 'essay',
            'stem' => 'question.',
            'answer' => array('answer'),
            'target' => 'course-1',
            'parentId' =>1,
            'pId' => 1
        );
        $question = $this->getQuestionService()->addQuestion($question);
        $this->assertEquals('question.',$question['stem']); 

    }

    public function testFindQuestionsByPId()
    {
        $question = array(
            'type' => 'essay',
            'stem' => 'question.',
            'answer' => array('answer'),
            'target' => 'course-1',
            'pId' => 1
        );
        $question = $this->getQuestionService()->addQuestion($question);
        $this->assertEquals('question.',$question['stem']);
        $question = $this->getQuestionService()->findQuestionsByPId(1);
        $this->assertEquals('question.',$question[0]['stem']);
    }

    public function testFindQuestionsCountByParentId()
    {
       $question = array(
            'type' => 'essay',
            'stem' => 'question.',
            'answer' => array('answer'),
            'target' => 'course-1',
            'parentId' =>1,
            'pId' => 1
        );
        $question = $this->getQuestionService()->addQuestion($question);
        $this->assertEquals('question.',$question['stem']); 
        $count = $this->getQuestionService()->findQuestionsCountByParentId(1);
        $this->assertEquals(1,$count); 
    }

    public function testEditQuestion()
    {
        $question = array(
            'type' => 'essay',
            'stem' => 'question.',
            'answer' => array('answer'),
            'target' => 'course-1',
            'parentId' =>1,
            'pId' => 1
        );
        $question = $this->getQuestionService()->addQuestion($question);
        $this->assertEquals('question.',$question['stem']);
        $question = $this->getQuestionService()->editQuestion($question['id'],array('target' => 'course-2'));
        $this->assertEquals('course-2',$question['target']);
    }

    public function testUpdateQuestionByPId()
    {
        $question = array(
            'type' => 'essay',
            'stem' => 'question.',
            'answer' => array('answer'),
            'target' => 'course-1',
            'parentId' =>1,
            'pId' => 1
        );
        $question = $this->getQuestionService()->addQuestion($question);
        $this->assertEquals('question.',$question['stem']);
        $count = $this->getQuestionService()->updateQuestionByPId(1,array('target' => 'course-3'));
        $this->assertEquals(1,$count);
    }

    public function testDeleteQuestionsByPId()
    {
        $question = array(
            'type' => 'essay',
            'stem' => 'question.',
            'answer' => array('answer'),
            'target' => 'course-1',
            'parentId' =>1,
            'pId' => 1
        );
        $question = $this->getQuestionService()->addQuestion($question);
        $this->assertEquals('question.',$question['stem']);
        $count = $this->getQuestionService()->deleteQuestionsByPId(1);
        $this->assertEquals(1,$count);
    }

    public function testDeleteQuestionsByParentId()
    {
        $question = array(
            'type' => 'essay',
            'stem' => 'question.',
            'answer' => array('answer'),
            'target' => 'course-1',
            'parentId' =>1,
            'pId' => 1
        );
        $question = $this->getQuestionService()->addQuestion($question);
        $this->assertEquals('question.',$question['stem']);
        $count = $this->getQuestionService()->deleteQuestionsByParentId(1);
        $this->assertEquals(1,$count);
    }

    public function testUpdateQuestionByTarget()
    {
        $question = array(
            'type' => 'essay',
            'stem' => 'question.',
            'answer' => array('answer'),
            'target' => 'course-1',
            'parentId' =>1,
            'pId' => 1
        );
        $question = $this->getQuestionService()->addQuestion($question);
        $this->assertEquals('question.',$question['stem']);
        $count = $this->getQuestionService()->updateQuestionByTarget('course-1',array('type'=>'eassy'));
        $this->assertEquals(1,$count);
    }


    protected function getQuestionService()
    {
        return $this->getServiceKernel()->createService('Question.QuestionService');
    }

}