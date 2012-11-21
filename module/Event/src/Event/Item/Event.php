<?php

namespace Event\Item;

use Eva\Mvc\Item\AbstractItem;

class Event extends AbstractItem
{
    protected $dataSourceClass = 'Event\DbTable\Events';

    protected $relationships = array(
        'Text' => array(
            'targetEntity' => 'Event\Item\Text',
            'relationship' => 'OneToOne',
            'joinColumn' => 'event_id',
            'referencedColumn' => 'id',
        ),
        'File' => array(
            'targetEntity' => 'File\Item\File',
            'relationship' => 'ManyToMany',
            'mappedBy' => 'File',
            'joinColumns' => array(
                'joinColumn' => 'event_id',
                'referencedColumn' => 'id',
            ),
            'inversedBy' => 'Event\Item\EventFile',
            'inversedMappedBy' => 'EventFile',
            'inverseJoinColumns' => array(
                'joinColumn' => 'file_id',
                'referencedColumn' => 'id',
            ),
        ),
        'EventFile' => array(
            'targetEntity' => 'Event\Item\EventFile',
            'relationship' => 'OneToMany',
            'joinColumn' => 'event_id',
            'referencedColumn' => 'id',
            'joinParameters' => array(
            ),
        ),
        'User' => array(
            'targetEntity' => 'User\Item\User',
            'relationship' => 'ManyToMany',
            'mappedBy' => 'User',
            'joinColumns' => array(
                'joinColumn' => 'event_id',
                'referencedColumn' => 'id',
            ),
            'inversedBy' => 'Event\Item\EventUser',
            'inversedMappedBy' => 'EventUser',
            'inverseJoinColumns' => array(
                'joinColumn' => 'user_id',
                'referencedColumn' => 'id',
            ),
        ),
        'EventUser' => array(
            'targetEntity' => 'Event\Item\EventUser',
            'relationship' => 'OneToMany',
            'joinColumn' => 'event_id',
            'referencedColumn' => 'id',
            'joinParameters' => array(
            ),
        ),
    );

    protected $map = array(
        'create' => array(
            'getUrlName()',
            'getCreateTime()',
            'getUserId()',
            'getUserName()',
            'getStartDatetimeUtc()',
            'getEndDatetimeUtc()',
        ),
        'save' => array(
            'getUrlName()',
        ),
    );

    public function getUrlName()
    {
        if(!$this->urlName) {
            return $this->urlName = \Eva\Stdlib\String\Hash::uniqueHash();
        }
    }

    public function getCreateTime()
    {
        if(!$this->createTime) {
            return $this->createTime = \Eva\Date\Date::getNow();
        }
    }

    public function getUserId()
    {
        if(!$this->user_id){
            $user = \Core\Auth::getLoginUser();
            $this->user_id = $user['id'];
        }
    }

    public function getUserName()
    {
        if(!$this->user_name){
            $user = \Core\Auth::getLoginUser();
            $this->user_name = $user['userName'];
        }
    }

    public function getStartDatetimeUtc()
    {
        return $this->startDatetimeUtc = $this->startTime;
    }

    public function getEndDatetimeUtc()
    {
        return $this->endDatetimeUtc = $this->endTime;
    }
}
