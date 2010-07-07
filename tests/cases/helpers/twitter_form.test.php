<?php
App::import('Helper', 'TwitterKit.TwitterForm');

class TwitterFormTestCase extends CakeTestCase
{

    /**
     *
     * @var TwitterForm
     */
    var $TwitterForm;

    function startTest()
    {
        $this->TwitterForm = new TwitterFormHelper();
    }

    function endTest()
    {
        unset($this->TwitterForm);
        ClassRegistry::flush();
    }


    function testLinkify()
    {

        $value = '@username';
        $result = '<a href="http://twitter.com/username">@username</a>';
        $this->assertEqual($this->TwitterForm->linkify($value), $result);
        $this->assertEqual($this->TwitterForm->linkify($value, array('username' => false)), $value);

        $value = '#hashtag';
        $result = '<a href="http://search.twitter.com/search?q=#hashtag">#hashtag</a>';
        $this->assertEqual($this->TwitterForm->linkify($value), $result);
        $this->assertEqual($this->TwitterForm->linkify($value, array('hashtag' => false)), $value);

        $value = 'http://example.com';
        $result = '<a href="http://example.com">http://example.com</a>';
        $this->assertEqual($this->TwitterForm->linkify($value), $result);
        $this->assertEqual($this->TwitterForm->linkify($value, array('url' => false)), $value);

        $value = '@username #hashtag';
        $result = '<a href="http://twitter.com/username">@username</a> <a href="http://search.twitter.com/search?q=#hashtag">#hashtag</a>';
        $this->assertEqual($this->TwitterForm->linkify($value), $result);
        
        $value = '@username#hashtag';
        $result = '<a href="http://twitter.com/username">@username</a><a href="http://search.twitter.com/search?q=#hashtag">#hashtag</a>';
        $this->assertEqual($this->TwitterForm->linkify($value), $result);
        
        $value = '@username http://example.com';
        $result = '<a href="http://twitter.com/username">@username</a> <a href="http://example.com">http://example.com</a>';
        $this->assertEqual($this->TwitterForm->linkify($value), $result);

        $value = 'http://example.com #hashtag';
        $result = '<a href="http://example.com">http://example.com</a> <a href="http://search.twitter.com/search?q=#hashtag">#hashtag</a>';
        $this->assertEqual($this->TwitterForm->linkify($value), $result);

        $value = 'http://example.com/#hashtag';
        $result = '<a href="http://example.com/#hashtag">http://example.com/#hashtag</a>';
        $this->assertEqual($this->TwitterForm->linkify($value), $result);

        $value = '@user_name';
        $result = '<a href="http://twitter.com/user_name">@user_name</a>';
        $this->assertEqual($this->TwitterForm->linkify($value), $result);

        $value = '#hash_tag';
        $result = '<a href="http://search.twitter.com/search?q=#hash_tag">#hash_tag</a>';
        $this->assertEqual($this->TwitterForm->linkify($value), $result);

        $value = '@user%name';
        $result = '<a href="http://twitter.com/user">@user</a>%name';
        $this->assertEqual($this->TwitterForm->linkify($value), $result);
        
        $value = 'http://example.com:8080/path?query=search&order=asc#hashtag';
        $result = '<a href="http://example.com:8080/path?query=search&order=asc#hashtag">http://example.com:8080/path?query=search&order=asc#hashtag</a>';
        $this->assertEqual($this->TwitterForm->linkify($value), $result);
        
        $value = 'http://subdomain.example.com:8080/?query=search&order=asc#hashtag';
        $result = '<a href="http://subdomain.example.com:8080/?query=search&order=asc#hashtag">http://subdomain.example.com:8080/?query=search&order=asc#hashtag</a>';
        $this->assertEqual($this->TwitterForm->linkify($value), $result);
    }


}