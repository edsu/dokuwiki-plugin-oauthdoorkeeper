<?php

use dokuwiki\plugin\oauth\Adapter;
use dokuwiki\plugin\oauthdoorkeeper\DoorKeeper;

/**
 * Service Implementation for oAuth Doorkeeper authentication
 */
class action_plugin_oauthdoorkeeper extends Adapter
{

    /** @inheritdoc */
    public function registerServiceClass()
    {
        return DoorKeeper::class;
    }

    /** * @inheritDoc */
    public function getUser()
    {
        $oauth = $this->getOAuthService();
        $data = array();

        $url = $this->getConf('baseurl') . '/api/v1/accounts/verify_credentials';
        $hostname = parse_url($this->getConf('baseurl'), PHP_URL_HOST);

        $raw = $oauth->request($url);
        $result = json_decode($raw, true);

        $data['user'] = $result['username'];
        $data['name'] = $result['display_name'];
        $data['mail'] = $result['username'] . '@'. $hostname;

        return $data;
    }

    /** @inheritDoc */
    public function getLabel()
    {
        return 'Mastodon';
    }

    /** @inheritDoc */
    public function getColor()
    {
        return '#b64145';
    }

}
