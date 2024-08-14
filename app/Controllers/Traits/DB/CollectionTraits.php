<?php

namespace App\Controllers\Traits\DB;

use App\Models\Database\Common;

trait CollectionTraits{
    // the traits structure is in a format that even though the feild names change we access these traits from the frontend the same way so we would never have to make changes for frontend when we change table feild names or any data accessing method we use data changes the data type
       
    # 'FrontEndValues'[Not changed unless UI structures change] => 'BackEndFeilds'[Could change when table feild names or any data accessing method changes the data type]

    # Collection Plan Table Structure assigned
    public function collectionplanStructure()
    {
        $this->table = 'collectionplan';
        
        $this->primaryKeys = [
            'CollectionPlanID'          => 'id',
            'CollectionPlanSessionID'   => 'sessionid'
        ];
        
        $this->allKeys = [
            'CollectionPlanID'              => 'id',
            'CollectionPlanSessionID'       => 'sessionid',
            'CollectionPlanCollectedAmount' => 'collectedamount',
            'CollectionPlanTotalAmount'     => 'totalamount',
            'CollectionPlanReason'          => 'reason',
            'CollectionPlanIsPlanned'       => 'is_planned',
            'CollectionPlanIsIndividual'    => 'is_individual',
            'CollectionPlanType'            => 'type',
            'CollectionPlanPeriod'          => 'period'
        ];
        
        // TODO: Update with with user information
        $this->foreignKeys = [
        ];
    }

    # Group Collection Table Structure assigned
    public function groupcollectionStructure()
    {
        $this->table = 'groupcollection';
        
        $this->primaryKeys = [
            'GroupCollectionID'         => 'id',
            'GroupCollectionSessionID'  => 'sessionid'
        ];
        
        $this->allKeys = [
            'GroupCollectionID'                 => 'id',
            'GroupCollectionSessionID'          => 'sessionid',
            'CollectionPlanSessionID'           => 'collectionplansessionid',
            'GroupCollectionIsCollector'        => 'is_collector',
            'GroupCollectionParticipentCount'   => 'participentcount'
        ];
        
        $this->foreignKeys = [
            'CollectionPlanSessionID' => 'collectionplan',
        ];
    }

    # Collection Paid Table Structure assigned
    public function collectionpaidStructure()
    {
        $this->table = 'collectionpaid';
        
        $this->primaryKeys = [
            'CollectionPaidID'  => 'id',
            'CollectionPaidSessionID'   => 'sessionid'
        ];
        
        $this->allKeys = [
            'CollectionPaidID'          => 'id',
            'CollectionPaidSessionID'   => 'sessionid',
            'CollectionDueSessionID'    => 'collectionduesessionid',
            'StackholderSessionID'      => 'stackholdersessionid',
            'CollectionPlanPayable'     => 'payable',
            'CollectionPlanDate'        => 'date'
        ];
        
        $this->foreignKeys = [
            'CollectionDueSessionID'    => 'collectionplan',
            'StackholderSessionID'      => 'stackholder'
        ];
    }

    # Collection Due Table Structure assigned
    public function collectiondueStructure()
    {
        $this->table = 'participent';
        
        $this->primaryKeys = [
            'CollectionDueID' => 'id',
        ];
        
        $this->allKeys = [
            'CollectionDueID'           => 'id',
            'CollectionDueSessionID'    => 'sessionid',
            'CollectionPlanSessionID'   => 'collectionplansessionid',
            'StackholderSessionID'      => 'stackholdersessionid',
            'CollectionDuePayable'      => 'payable',
            'CollectionDueDate'         => 'date'
        ];
        
        // TODO: Update with with user information
        $this->foreignKeys = [
            'CollectionPlanSessionID'   => 'collectionplansessionid',
            'StackholderSessionID'      => 'stackholdersessionid'
        ];
    }

    # Participent Table Structure assigned
    public function participentStructure()
    {
        $this->table = 'participent';
        
        $this->primaryKeys = [
            'ParticipentID' => 'id',
        ];
        
        $this->allKeys = [
            'ParticipentID'             => 'id',
            'ParticipentSessionID'      => 'sessionid',
            'GroupCollectionSessionID'  => 'groupcollectionsessionid',
            'StackholderSessionID'      => 'stackholdersessionid',
            // 'ParticipentDate'           => 'date',
            'ParticipentPayable'        => 'payable',
            'ParticipentPaid'           => 'paid'
        ];
        
        // TODO: Update with with user information
        $this->foreignKeys = [
            'GroupCollectionSessionID'  => 'groupcollectionsessionid',
            'StackholderSessionID'      => 'stackholdersessionid'
        ];
    }

}