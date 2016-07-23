<?php

class VideosController extends AppController
{
    public $uses = array('Post', 'Follow', 'Channel', 'Rating', 'Tag', 'Hit', 'Comment');

    public $components = array('Youtube');

    protected $_guestAllowedURLs = array(
        'videos' => array('p'),
    );

    public function yt($video_id = null)
    {
        $video = $this->Youtube->searchByVideoId($video_id);
        $this->set('video', $video);
    }

    public function detail($post_id = null)
    {
        $post = $this->Post->find('first', array(
            'conditions' => array(
                'Post.id' => $post_id,
            ),
        ));

        if (!$post) {
            $this->redirect('/');
        }

        $this->set('post', $post);
        $this->set('title_for_layout', $post['Post']['title']);

        $user = $this->_getSessionUser();
        $follow = $this->Follow->find('count', array(
            'conditions' => array(
                'Follow.user_id' => $post['User']['id'],
                'Follow.follower_id' => $user['User']['id'],
            ),
        ));
        $this->set('follow', $follow);

        $rating = $this->Rating->find('first', array(
            'fields' => array(
                'count(*) as votes',
                'sum(rating) as total',
            ),
            'conditions' => array(
                'Rating.post_id' => $post['Post']['id'],
            ),
        ));
        if ($rating[0]['votes'] == 0) {
            $rating[0]['votes'] = 0;
            $rating[0]['total'] = 0;
        }
        $this->set('rating', $rating);

        $tags = $this->Tag->find('list', array(
            'conditions' => array(
                'Tag.post_id' => $post['Post']['id'],
            ),
        ));
        $this->set('tags', implode(',', $tags));

        $this->Hit->unbindModel(array(
            'belongsTo' => array('Post'),
        ));
        $viewers = $this->Hit->find('all', array(
            'conditions' => array(
                'Hit.post_id' => $post['Post']['id'],
                'Hit.user_id <>' => $user['User']['id'],
            ),
            'order' => array(
                'Hit.last_ts' => 'DESC',
            ),
            'limit' => 15,
        ));
        $this->set('viewers', $viewers);

        $this->Comment->unbindModel(array(
            'belongsTo' => array('Post'),
        ));
        $comments = $this->Comment->find('all', array(
            'conditions' => array(
                'Comment.post_id' => $post['Post']['id'],
            ),
            'order' => array(
                'Comment.post_ts' => 'DESC',
            ),
        ));
        $this->set('comments', $comments);
    }

    public function p($post_id = null)
    {
        if ($this->_getSessionUser()) {
            $this->redirect(array('action' => 'detail', $post_id));
        }

        $post = $this->Post->find('first', array(
            'conditions' => array(
                'Post.id' => $post_id,
            ),
        ));

        if (!$post) {
            $this->redirect('/');
        }

        $this->set('post', $post);
        $this->set('title_for_layout', $post['Post']['title']);

        $rating = $this->Rating->find('first', array(
            'fields' => array(
                'count(*) as votes',
                'sum(rating) as total',
            ),
            'conditions' => array(
                'Rating.post_id' => $post['Post']['id'],
            ),
        ));
        if ($rating[0]['votes'] == 0) {
            $rating[0]['votes'] = 0;
            $rating[0]['total'] = 0;
        }
        $this->set('rating', $rating);

        $tags = $this->Tag->find('list', array(
            'conditions' => array(
                'Tag.post_id' => $post['Post']['id'],
            ),
        ));
        $this->set('tags', implode(',', $tags));
    }

    public function search($query = '')
    {
        $this->set('query', urldecode($query));
    }

    public function post($video_id = null)
    {
        if ($video_id) {
            $user = $this->_getSessionUser();

            // Make sure active post doesn't aready exists
            $post = $this->Post->find('first', array(
                'conditions' => array(
                    'Post.user_id' => $user['User']['id'],
                    'Post.video_id' => $video_id,
                    'Post.active' => true,
                ),
            ));
            if ($post) {
                $this->_setFlashMessage('Video has already been posted.', 'alert');
                $this->redirect($this->request->referer());
            }

            $video = $this->Youtube->searchByVideoId($video_id);

            $duration = $this->_parseDuration($video['items'][0]['contentDetails']['duration']);
            $seconds = 0;
            if (isset($duration['seconds'])) {
                $seconds += $duration['seconds'];
            }
            if (isset($duration['minutes'])) {
                $seconds += $duration['minutes'] * 60;
            }
            if (isset($duration['hours'])) {
                $seconds += $duration['hours'] * 360;
            }

            $post = array(
                'user_id' => $user['User']['id'],
                'video_id' => $video['items'][0]['id'],
                'title' => $video['items'][0]['snippet']['title'],
                'description' => $video['items'][0]['snippet']['description'],
                'thumbnail_url' => $video['items'][0]['snippet']['thumbnails']['medium']['url'],
                'channel_title' => $video['items'][0]['snippet']['channelTitle'],
                'channel_id' => $video['items'][0]['snippet']['channelId'],
                'duration' => $seconds,
                'published_ts' => date('Y-m-d H:i:s', strtotime($video['items'][0]['snippet']['publishedAt'])),
                'create_ts' => date('Y-m-d H:i:s', time()),
            );

            $this->Post->create();
            if ($this->Post->save($post)) {
                $this->_setFlashMessage('Video post successful.', 'success');
                $this->redirect(array('action' => 'detail', $this->Post->getLastInsertId()));
            }
        } else {
            $this->autoRender = false;
            $this->layout = 'ajax';

            $url = $this->request->data['url'];
            $site_channel_id = $this->request->data['site_channel_id'];
            if (!$site_channel_id) {
                $site_channel_id = 0;
            }
            $user_channel_id = $this->request->data['user_channel_id'];
            if (!$user_channel_id) {
                $user_channel_id = 0;
            }

            if (!empty($url)) {
                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
                    $video_id = $match[1];
                    if (!empty($video_id)) {
                        $user = $this->_getSessionUser();

                        // Make sure video hasn't been posted
                        $post = $this->Post->find('first', array(
                            'conditions' => array(
                                'Post.user_id' => $user['User']['id'],
                                'Post.video_id' => $video_id,
                            ),
                        ));
                        if ($post) {
                            return json_encode(array('success' => false));
                        }

                        $video = $this->Youtube->searchByVideoId($video_id);

                        $duration = $this->_parseDuration($video['items'][0]['contentDetails']['duration']);
                        $seconds = 0;
                        if (isset($duration['seconds'])) {
                            $seconds += $duration['seconds'];
                        }
                        if (isset($duration['minutes'])) {
                            $seconds += $duration['minutes'] * 60;
                        }
                        if (isset($duration['hours'])) {
                            $seconds += $duration['hours'] * 360;
                        }

                        $post = array(
                            'user_id' => $user['User']['id'],
                            'video_id' => $video['items'][0]['id'],
                            'title' => $video['items'][0]['snippet']['title'],
                            'description' => $video['items'][0]['snippet']['description'],
                            'thumbnail_url' => $video['items'][0]['snippet']['thumbnails']['medium']['url'],
                            'channel_title' => $video['items'][0]['snippet']['channelTitle'],
                            'channel_id' => $video['items'][0]['snippet']['channelId'],
                            'site_channel_id' => $site_channel_id,
                            'user_channel_id' => $user_channel_id,
                            'duration' => $seconds,
                            'published_ts' => date('Y-m-d H:i:s', strtotime($video['items'][0]['snippet']['publishedAt'])),
                            'create_ts' => date('Y-m-d H:i:s', time()),
                        );

                        $this->Post->create();
                        if ($this->Post->save($post)) {
                            return json_encode(array('success' => true));
                        }
                    }
                }
            }

            return json_encode(array('success' => false));
        }
    }

    public function delete($post_id = null)
    {
        $user = $this->_getSessionUser();
        $post = $this->Post->find('first', array(
            'conditions' => array(
                'Post.id' => $post_id,
                'Post.user_id' => $user['User']['id'],
            ),
        ));
        if ($post) {
            $post['Post']['active'] = false;
            if ($this->Post->save($post)) {
                $this->_setFlashMessage('Video deleted successfully.', 'success');
                $this->redirect(array('action' => 'me'));
            }
        }

        $this->_setFlashMessage('Video cannot be deleted.', 'alert');
        $this->redirect($this->request->referer());
    }

    public function me()
    {
        if (isset($this->request->query['channel_id'])) {
            $channel = $this->Channel->find('first', array(
                'conditions' => array(
                    'Channel.id' => $this->request->query['channel_id'],
                ),
                'recursive' => -1,
            ));
            $this->set('channel', $channel);
        }

        $user = $this->_getSessionUser();
        $channels = $this->Channel->find('all', array(
            'conditions' => array(
                'Channel.user_id' => $user['User']['id'],
                'Channel.active' => true,
            ),
            'order' => array('Channel.name' => 'ASC'),
        ));
        $this->set('channels', $channels);
    }

    public function meAjax()
    {
        $this->autoRender = false;
        $this->layout = 'ajax';

        $channel_id = $this->request->data['channel_id'];
        $limit = $this->request->data['limit'];
        $page = $this->request->data['page'];

        $user = $this->_getSessionUser();

        $conditions = array(
            'Post.user_id' => $user['User']['id'],
            'Post.active' => true,
        );
        if ($channel_id) {
            $conditions = array_merge(array('Post.user_channel_id' => $channel_id), $conditions);
        }

        $posts = $this->Post->find('all', array(
            'conditions' => $conditions,
            'order' => array(
                'Post.create_ts' => 'DESC',
            ),
            'limit' => $limit,
            'page' => $page,
        ));

        return json_encode($posts);
    }

    public function user($user_id = null)
    {
        $post_user = $this->User->find('first', array(
            'conditions' => array('User.id' => $user_id),
        ));
        $this->set('post_user', $post_user);

        if (!$post_user) {
            $this->redirect($this->request->referer());
        }

        if (isset($this->request->query['channel_id'])) {
            $channel = $this->Channel->find('first', array(
                'conditions' => array(
                    'Channel.id' => $this->request->query['channel_id'],
                    'Channel.user_id' => $post_user['User']['id'],
                ),
                'recursive' => -1,
            ));
            $this->set('channel', $channel);
        }

        $channels = $this->Channel->find('all', array(
            'conditions' => array(
                'Channel.user_id' => $post_user['User']['id'],
                'Channel.active' => true,
            ),
            'order' => array('Channel.name' => 'ASC'),
        ));
        $this->set('channels', $channels);

        $user = $this->_getSessionUser();
        $follow = $this->Follow->find('count', array(
            'conditions' => array(
                'Follow.user_id' => $post_user['User']['id'],
                'Follow.follower_id' => $user['User']['id'],
            ),
        ));
        $this->set('follow', $follow);
    }

    public function userAjax()
    {
        $this->autoRender = false;
        $this->layout = 'ajax';

        $user_id = $this->request->data['user_id'];
        $channel_id = $this->request->data['channel_id'];
        $limit = $this->request->data['limit'];
        $page = $this->request->data['page'];

        $conditions = array(
            'Post.user_id' => $user_id,
            'Post.active' => true,
        );
        if ($channel_id) {
            $conditions = array_merge(array('Post.user_channel_id' => $channel_id), $conditions);
        }

        $posts = $this->Post->find('all', array(
            'conditions' => $conditions,
            'order' => array(
                'Post.create_ts' => 'DESC',
            ),
            'limit' => $limit,
            'page' => $page,
        ));

        return json_encode($posts);
    }

    public function addChannel()
    {
        $this->autoRender = false;
        $this->layout = 'ajax';

        $name = $this->request->data['name'];

        $user = $this->_getSessionUser();
        $channel = $this->Channel->find('count', array(
            'conditions' => array(
                'Channel.user_id' => $user['User']['id'],
                'Channel.name' => trim($name),
            ),
        ));
        if ($channel) {
            return json_encode(array('success' => false));
        }

        $channel = array(
            'user_id' => $user['User']['id'],
            'name' => trim($name),
            'create_ts' => date('Y-m-d H:i:s', time()),
        );

        $this->Channel->create();
        if ($this->Channel->save($channel)) {
            return json_encode(array('success' => true));
        }

        return json_encode(array('success' => false));
    }

    public function updateSiteChannelId()
    {
        $this->autoRender = false;
        $this->layout = 'ajax';

        $post_id = $this->request->data['post_id'];
        $site_channel_id = $this->request->data['site_channel_id'];

        $user = $this->_getSessionUser();
        $post = $this->Post->find('first', array(
            'conditions' => array(
                'Post.id' => $post_id,
                'Post.user_id' => $user['User']['id'],
            ),
        ));
        if ($post) {
            $post['Post']['site_channel_id'] = $site_channel_id;
            if ($this->Post->save($post)) {
                return json_encode(array('success' => true));
            }
        }

        return json_encode(array('success' => false));
    }

    public function updateUserChannelId()
    {
        $this->autoRender = false;
        $this->layout = 'ajax';

        $post_id = $this->request->data['post_id'];
        $user_channel_id = $this->request->data['user_channel_id'];

        $user = $this->_getSessionUser();
        $post = $this->Post->find('first', array(
            'conditions' => array(
                'Post.id' => $post_id,
                'Post.user_id' => $user['User']['id'],
            ),
        ));
        if ($post) {
            $post['Post']['user_channel_id'] = $user_channel_id;
            if ($this->Post->save($post)) {
                return json_encode(array('success' => true));
            }
        }

        return json_encode(array('success' => false));
    }

    public function newest()
    {
    }

    public function newestAjax()
    {
        $this->autoRender = false;
        $this->layout = 'ajax';

        $limit = $this->request->data['limit'];
        $page = $this->request->data['page'];

        $posts = $this->Post->find('all', array(
            'conditions' => array(
                'Post.active' => true,
            ),
            'order' => array(
                'Post.create_ts' => 'DESC',
            ),
            'limit' => $limit,
            'page' => $page,
        ));

        return json_encode($posts);
    }

    public function channel($channel_id = null)
    {
        $channel = $this->Channel->find('first', array(
            'conditions' => array(
                'Channel.id' => $channel_id,
            ),
            'recursive' => -1,
        ));
        $this->set('channel', $channel);
    }

    public function channelAjax()
    {
        $this->autoRender = false;
        $this->layout = 'ajax';

        $channel_id = $this->request->data['channel_id'];
        $limit = $this->request->data['limit'];
        $page = $this->request->data['page'];

        $user = $this->_getSessionUser();

        $conditions = array(
            'Post.site_channel_id' => $channel_id,
            'Post.active' => true,
        );
        $posts = $this->Post->find('all', array(
            'conditions' => $conditions,
            'order' => array(
                'Post.create_ts' => 'DESC',
            ),
            'limit' => $limit,
            'page' => $page,
        ));

        return json_encode($posts);
    }

    public function rate()
    {
        $this->autoRender = false;
        $this->layout = 'ajax';

        $post_id = $this->request->data['post_id'];
        $rating = $this->request->data['rating'];

        $user = $this->_getSessionUser();

        $post = $this->Post->find('count', array(
            'conditions' => array('Post.id' => $post_id),
        ));
        if ($post) {
            $rate = $this->Rating->find('first', array(
                'conditions' => array(
                    'Rating.post_id' => $post_id,
                    'Rating.user_id' => $user['User']['id'],
                ),
            ));
            if ($rate) {
                $rate['Rating']['rating'] = $rating;
            } else {
                $rate = array();
                $rate['Rating']['post_id'] = $post_id;
                $rate['Rating']['user_id'] = $user['User']['id'];
                $rate['Rating']['rating'] = $rating;
            }
            if ($this->Rating->save($rate)) {
                // Compute and save average
                $rating_avg = $this->Rating->find('first', array(
                    'fields' => array(
                        'SUM(Rating.rating)/COUNT(*) as rating_avg',
                    ),
                    'conditions' => array(
                        'Rating.post_id' => $post_id,
                    ),
                    'recursive' => -1,
                ));
                $this->Post->id = $post_id;
                $this->Post->saveField('rating_avg', $rating_avg[0]['rating_avg']);

                return json_encode(array('success' => true));
            }
        }

        return json_encode(array('success' => false));
    }

    public function updateTagAjax()
    {
        $this->autoRender = false;
        $this->layout = 'ajax';

        $post_id = $this->request->data['post_id'];
        $tags = $this->request->data['tags'];

        $user = $this->_getSessionUser();

        $post = $this->Post->find('count', array(
            'conditions' => array(
                'Post.id' => $post_id,
                'Post.user_id' => $user['User']['id'],
            ),
        ));
        if ($post) {
            $this->Tag->deleteAll(array('Tag.post_id' => $post_id));

            $tag_arr = explode(',', $tags);
            foreach ($tag_arr as $tag_name) {
                $new_tag = array();
                $new_tag['Tag']['post_id'] = $post_id;
                $new_tag['Tag']['user_id'] = $user['User']['id'];
                $new_tag['Tag']['name'] = $tag_name;
                $this->Tag->create();
                $this->Tag->save($new_tag);
            }
        }
    }

    public function addUserHit()
    {
        $this->autoRender = false;
        $this->layout = 'ajax';

        $post_id = $this->request->data['post_id'];

        $user = $this->_getSessionUser();

        $hit = $this->Hit->find('first', array(
            'conditions' => array(
                'Hit.post_id' => $post_id,
                'Hit.user_id' => $user['User']['id'],
            ),
        ));
        if ($hit) {
            $hit['Hit']['count'] += 1;
        } else {
            $hit = array();
            $hit['Hit']['post_id'] = $post_id;
            $hit['Hit']['user_id'] = $user['User']['id'];
            $hit['Hit']['count'] = 1;
            $this->Hit->create();
        }

        $hit['Hit']['last_ts'] = date('Y-m-d H:i:s', time());
        if ($this->Hit->save($hit)) {
            return json_encode(array('success' => true));
        }

        return json_encode(array('success' => false));
    }

    public function addComment()
    {
        $this->autoRender = false;
        $this->layout = 'ajax';

        $post_id = $this->request->data['post_id'];
        $message = $this->request->data['message'];

        $user = $this->_getSessionUser();

        $comment = array();
        $comment['Comment']['post_id'] = $post_id;
        $comment['Comment']['user_id'] = $user['User']['id'];
        $comment['Comment']['message'] = $message;
        $comment['Comment']['post_ts'] = date('Y-m-d H:i:s', time());

        $this->Comment->create();
        if ($this->Comment->save($comment)) {
            $comment = $this->Comment->find('first', array(
                'conditions' => array('Comment.id' => $this->Comment->getLastInsertID()),
            ));

            return json_encode($comment);
        }

        return json_encode(array('success' => false));
    }
}
