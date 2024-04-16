<?php

class Alert extends Eloquent {

    protected $table = "alert";

    public static $rules = [
        'description' => 'required|max:255',
    ];

    protected $fillable = ['description','severety'];

    public static $SEVERETIES = [
       '0' => 'None',
       '1' => 'Bad',
       '2' => 'Very bad',
       '3' => 'Severe'
    ];

    public static $COLORS = [
       '0' => 'text-success',
       '1' => '',
       '2' => 'text-warning',
       '3' => 'text-danger'
    ];

    /**
     * Get the comment's content.
     *
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    public static function getContentGroups(){
        return [
            'Titles &amp; Descriptions' => [101,102,105,106,107,301,302,305,306,307],
            'Body Content' => [601,602,603,201,202],
            'Social Tagging' => [1001,1002,1003,1004,1005,1006],
            'Pagination' => [1101,1102]
        ];
    }

    public static function getContentIds(){
        $ids = array();
        $groups = self::getContentGroups();
        foreach($groups as $group){
            $ids = array_merge($ids, $group);
        }
        return $ids;
    }

}