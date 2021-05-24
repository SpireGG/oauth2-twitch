<?php namespace SpireGG\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Tool\ArrayAccessorTrait;

class TwitchResourceOwner implements ResourceOwnerInterface
{
    use ArrayAccessorTrait;

    /** @var array */
    protected $response;
    /** @var  int */
    protected $id;
    /** @var string */
    protected $username;
    /** @var  string */
    protected $email;
    /** @var  string */
    protected $display_name;
    /** @var  string */
    protected $type;
    /** @var  string */
    protected $broadcaster_type;
    /** @var  string */
    protected $description;
    /** @var  string */
    protected $profile_image_url;
    /** @var  string */
    protected $offline_image_url;
    /** @var  int */
    protected $view_count;
    /** @var string */
    protected $created_at;

    /** @param array $response */
    public function __construct(array $response = array())
    {
        $this->response = $response;
        $this->id = $this->getValueByKey($response, 'id');
        $this->username = $this->getValueByKey($response, 'username');
        $this->email = $this->getValueByKey($response, 'email');
        $this->display_name = $this->getValueByKey($response, 'display_name');
        $this->type = $this->getValueByKey($response, 'type');
        $this->broadcaster_type = $this->getValueByKey($response, 'broadcaster_type');
        $this->description = $this->getValueByKey($response, 'description');
        $this->profile_image_url = $this->getValueByKey($response, 'profile_image_url');
        $this->offline_image_url = $this->getValueByKey($response, 'offline_image_url');
        $this->view_count = $this->getValueByKey($response, 'view_count');
        $this->created_at = $this->getValueByKey($response, 'created_at');
    }

    /** @return array */
    public function toArray()
    {
        return $this->response;
    }

    /** @return int */
    public function getId()
    {
        return $this->id;
    }

    /** @return string */
    public function getUsername()
    {
        return $this->username;
    }

    /** @return string */
    public function getEmail()
    {
        return $this->email;
    }

    /** @return string */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /** @return string */
    public function getType()
    {
        return $this->type;
    }

    /** @return string */
    public function getBroadcasterType()
    {
        return $this->broadcaster_type;
    }

    /** @return string */
    public function getDescription()
    {
        return $this->description;
    }

    /** @return string */
    public function getProfileImageUrl()
    {
        return $this->profile_image_url;
    }

    /** @return string */
    public function getOfflineImageUrl()
    {
        return $this->offline_image_url;
    }

    /** @return int */
    public function getViewCount()
    {
        return $this->view_count;
    }

    /** @return string */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
}
