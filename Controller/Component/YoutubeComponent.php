<?php

App::import('Vendor', 'Google_Client', array('file' => 'Google'.DS.'src'.DS.'Google_Client.php'));
App::import('Vendor', 'Google_YouTubeService', array('file' => 'Google'.DS.'src'.DS.'contrib'.DS.'Google_YouTubeService.php'));
class YoutubeComponent extends Component
{
    protected $_developerKey;

    public function initialize(Controller $controller)
    {
        $this->_developerKey = Configure::read('YouTube.developer_key');
    }

    public function search($query, $count)
    {
        $client = new Google_Client();
        $client->setDeveloperKey($this->_developerKey);
        $youtube = new Google_YoutubeService($client);

        $videos = $youtube->search->listSearch('id,snippet', array(
             'q' => $query,
             'maxResults' => $count,
             'order' => 'relevance',
             'type' => 'video',
             'videoDuration' => 'short',
             'videoEmbeddable' => 'true',
        ));

        return $videos;
    }

    public function searchByVideoId($video_id)
    {
        $client = new Google_Client();
        $client->setDeveloperKey($this->_developerKey);
        $youtube = new Google_YoutubeService($client);

        $video = $youtube->videos->listVideos('id, snippet, contentDetails, statistics, topicDetails', array(
            'id' => $video_id,
        ));

        return $video;
    }

    public function searchByVideoIds($videos)
    {
        $client = new Google_Client();
        $client->setDeveloperKey($this->_developerKey);
        $youtube = new Google_YoutubeService($client);

        $video_ids = implode(', ', $videos);
        $videos = $youtube->videos->listVideos('id, snippet, contentDetails, statistics, topicDetails', array(
            'id' => $video_ids,
        ));

        return $videos;
    }
}
