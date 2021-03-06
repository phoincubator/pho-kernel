<?php

/*
 * This file is part of the Pho package.
 *
 * (c) Emre Sokullu <emre@phonetworks.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pho\Kernel;

class EdgeTest extends CustomFounderTestCase 
{

    public function testEdgeCounts() {
        $this->flushDBandRestart();
        $user = new \PhoNetworksAutogenerated\User($this->kernel, $this->graph, "123456");
        $content = $user->post("emre sokullu");
        $this->assertCount(0, $content->getLikers());
        $this->assertCount(0, $this->kernel->founder()->getLikes());
        $this->kernel->founder()->like($content);
        $this->assertCount(1, $this->kernel->founder()->getLikes());
        $this->assertCount(1, $content->getLikers());
        $this->assertCount(0, $user->getFollows());
        $this->assertCount(0, $this->kernel->founder()->getFollowers());
        $user->follow($this->kernel->founder());
        $this->assertCount(1, $user->getFollows());
        $this->assertCount(1, $this->kernel->founder()->getFollowers());
    }  

    public function testEdgeIds() {
        $this->flushDBandRestart();
        $user = new \PhoNetworksAutogenerated\User($this->kernel, $this->graph, "123456");
        $content = $user->post("emre sokullu");
        $this->kernel->founder()->like($content);
        $this->assertEquals($content->id(), $this->kernel->founder()->getLikes()[0]->id());
        $this->assertEquals($this->kernel->founder()->id(), $content->getLikers()[0]->id());
        $user->follow($this->kernel->founder());
        $this->assertEquals($this->kernel->founder()->id(), $user->getFollows()[0]->id());
        $this->assertEquals($user->id(), $this->kernel->founder()->getFollowers()[0]->id());
    }  

    public function testAbstractEdgeCounts() {
        $this->flushDBandRestart();
        $user = new \PhoNetworksAutogenerated\User($this->kernel, $this->graph, "123456");
        $content = $user->post("emre sokullu");
        $this->assertCount(1, $content->getSubscribers()); // $user
        $this->assertCount(0, $this->kernel->founder()->getSubscriptions());
        $this->kernel->founder()->like($content);
        $this->assertCount(1, $this->kernel->founder()->getSubscriptions());
        $this->assertCount(2, $content->getSubscribers());
        $this->assertCount(1, $user->getSubscriptions()); // $content
        $this->assertCount(0, $this->kernel->founder()->getSubscribers());
        $user->follow($this->kernel->founder());
        $this->assertCount(2, $user->getSubscriptions());
        $this->assertCount(1, $this->kernel->founder()->getSubscribers());
    } 

    public function testAbstractEdgeIds() {
        $get_id = function($obj) { return $obj->id(); };
        $this->flushDBandRestart();
        $user = new \PhoNetworksAutogenerated\User($this->kernel, $this->graph, "123456");
        $content = $user->post("emre sokullu");
        $this->kernel->founder()->like($content);
        $this->assertContains($user->id(), array_map($get_id, $content->getSubscribers()));
        $this->assertContains($this->kernel->founder()->id(), array_map($get_id, $content->getSubscribers()));
        $user->follow($this->kernel->founder());
        $this->assertContains($content->id(), array_map($get_id, $user->getSubscriptions()));
        $this->assertContains($this->kernel->founder()->id(), array_map($get_id, $user->getSubscriptions()));
    } 

    public function testEdgeAttributePersistence() {
        $this->flushDBandRestart();
        $user = new \PhoNetworksAutogenerated\User($this->kernel, $this->graph, "123456");
        $content = $this->kernel->founder()->post("emre sokullu");
        $user->like($content);
        $like = $user->edges()->out()->current();
        $like_content = "this is great!";
        $like->attributes()->content = $like_content; // a made up attribute
        $like_id = $like->id()->toString();
        $this->kernel->halt();
        $this->kernel->boot();
        $like_recreated = $this->kernel->gs()->edge($like_id);
        $this->assertEquals($like_content, $like->attributes()->content);
        $this->assertEquals($like_id, (string) $like_recreated->id());
        $this->assertEquals($like_content, $like_recreated->attributes()->content);
    }

    /*
     * @todo implement this
     * // check for permissions
    public function testEdgeProperEdit() {
        $this->flushDBandRestart();
        $user = new \PhoNetworksAutogenerated\User($this->kernel, $this->graph, "123456");
        $content = $this->kernel->founder()->post("emre sokullu");
        $edge = $content->edges()->in()->current();
        eval(\Psy\sh());
    }
    */

}