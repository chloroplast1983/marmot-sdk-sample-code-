<?php
namespace News\Utils;

use News\Model\News;

class ObjectGenerate
{
    public static function generateNews(int $id = 0, int $seed = 0, array $value = array()) : News
    {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $news = new News($id);

        //title
        $title = isset($value['title']) ? $value['title'] : $faker->word;
        $news->setTitle($title);

        //source
        $source = isset($value['source']) ? $value['source'] : $faker->word;
        $news->setSource($source);

        //content
        $content = isset($value['content']) ? $value['content'] : $faker->sentence;
        $news->setContent($content);

        //image
        $image = isset($value['image']) ? $value['image'] : array($faker->md5);
        $news->setImage($image);

        //attachments
        $attachments = isset($value['attachments']) ? $value['attachments'] : array('12','2','2');
        $news->setAttachments($attachments);

        //createTime
        $createTime = isset($value['createTime']) ? $value['createTime'] : 1513737146;
        $news->setCreateTime($createTime);

        //updateTime
        $updateTime = isset($value['updateTime']) ? $value['updateTime'] : 1513737146;
        $news->setUpdateTime($updateTime);

        //statusTime
        $statusTime = isset($value['statusTime']) ? $value['statusTime'] : 1513737146;
        $news->setstatusTime($statusTime);

        //$publishUserGroup
        $publishUserGroup =
            isset($value['publishUserGroup']) ?
                $value['publishUserGroup'] : \UserGroup\Utils\ObjectGenerate::generateUserGroup(1, 1);
        $news->setPublishUserGroup($publishUserGroup);

        //status
        $status = isset($value['status']) ? $value['status'] : $faker->randomElement(
            $array = array(
                News::STATUS['ENABLED'],
                News::STATUS['DISABLED']
            )
        );
        $news->setStatus($status);

        return $news;
    }
}
