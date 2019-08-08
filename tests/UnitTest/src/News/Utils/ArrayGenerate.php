<?php
namespace News\Utils;

use News\Model\News;

class ArrayGenerate
{
    public static function generateNews(int $seed = 0, $value = array()) : array
    {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $news = array();

        $news = array(
            'data'=>array(
                'type'=>'news',
                'id'=>$faker->randomNumber(2)
            )
        );

        $attributes = array();

        //title
        $title = isset($value['title']) ? $value['title'] : $faker->word;
        $attributes['title'] = $title;

        //source
        $source = isset($value['source']) ? $value['source'] : $faker->word;
        $attributes['source'] = $source;

        //content
        $content = isset($value['content']) ? $value['content'] : $faker->sentence;
        $attributes['content'] = $content;

        //image
        $image = isset($value['image']) ? $value['image'] : array($faker->md5);
        $attributes['image'] = $image;

        //attachments
        $attachments = isset($value['attachments']) ? $value['attachments'] : array('12','2','2');
        $attributes['attachments'] = $attachments;

        //createTime
        $createTime = isset($value['createTime']) ? $value['createTime'] : 1513737146;
        $attributes['createTime'] = $createTime;

        //updateTime
        $updateTime = isset($value['updateTime']) ? $value['updateTime'] : 1513737146;
        $attributes['updateTime'] = $updateTime;

        //statusTime
        $statusTime = isset($value['statusTime']) ? $value['statusTime'] : 1513737146;
        $attributes['statusTime'] = $statusTime;

        //status
        $status = isset($value['status']) ? $value['status'] : $faker->randomElement(
            $array = array(
                News::STATUS['ENABLED'],
                News::STATUS['DISABLED']
            )
        );
        $attributes['status'] = $status;

        $news['data']['attributes'] = $attributes;

        //publishUserGroup
        $news['data']['relationships']['publishUserGroup']['data'] = array(
                'type' => 'userGroups',
                'id' => $faker->randomNumber(1)
        );

        return $news;
    }
}
