<?php
/**
 * @link https://github.com/zhuravljov/yii2-queue
 * @copyright Copyright (c) 2017 Roman Zhuravlev
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace zhuravljov\yii\queue;

use Yii;
use yii\base\Behavior;

/**
 * Class LogBehavior
 *
 * @author Roman Zhuravlev <zhuravljov@gmail.com>
 */
class LogBehavior extends Behavior
{
    /**
     * @var Queue
     */
    public $owner;
    /**
     * @var bool
     */
    public $autoFlush = true;

    /**
     * Returns the fully qualified name of this class.
     * @return string the fully qualified name of this class.
     */
    public static function className()
    {
        return get_called_class();
    }

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            Queue::EVENT_AFTER_PUSH => 'afterPush',
            Queue::EVENT_BEFORE_EXEC => 'beforeExec',
            Queue::EVENT_AFTER_EXEC => 'afterExec',
            Queue::EVENT_AFTER_EXEC_ERROR => 'afterExecError',
        ];
    }

    public function afterPush(PushEvent $event)
    {
        Yii::info($this->getEventTitle($event) . ' pushed.', Queue::className());
    }

    public function beforeExec(JobEvent $event)
    {
        Yii::info($this->getEventTitle($event) . ' started.', Queue::className());
        Yii::beginProfile($this->getEventTitle($event), Queue::className());
    }

    public function afterExec(JobEvent $event)
    {
        Yii::endProfile($this->getEventTitle($event), Queue::className());
        Yii::info($this->getEventTitle($event) . ' finished.', Queue::className());
        if ($this->autoFlush) {
            Yii::getLogger()->flush(true);
        }
    }

    public function afterExecError(ErrorEvent $event)
    {
        Yii::endProfile($this->getEventTitle($event), Queue::className());
        Yii::error($this->getEventTitle($event) . ' error ' . $event->error, Queue::className());
        if ($this->autoFlush) {
            Yii::getLogger()->flush(true);
        }
    }

    protected function getEventTitle(JobEvent $event)
    {
        return strtr('[id] name', [
            'id' => $event->id,
            'name' => $event->job instanceof Job ? get_class($event->job) : 'mixed data',
        ]);
    }
}