<?php

namespace Uwe\CMFBundle\Services;

interface SlotFactoryInterface
{
    public function createSlot();
    public function createForm();
    public function getCreateTemplate();

}
