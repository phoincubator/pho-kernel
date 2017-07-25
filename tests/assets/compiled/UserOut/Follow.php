<?php

namespace PhoNetworksAutogenerated\UserOut 
{

use Pho\Kernel\Traits\Edge\PersistentTrait;
use Pho\Lib\Graph\NodeInterface;
use Pho\Lib\Graph\PredicateInterface;
use Pho\Framework;



/*****************************************************
 * This file was auto-generated by pho-compiler
 * For more information, visit http://phonetworks.org
 ******************************************************/

class Follow extends Framework\ActorOut\Subscribe {

    
    use PersistentTrait;
    

    const HEAD_LABEL = "follow";
    const HEAD_LABELS = "follows";
    const TAIL_LABEL = "follower";
    const TAIL_LABELS = "followers";
    

    const SETTABLES_EXTRA = [\PhoNetworksAutogenerated\User::class];
    

    public function __construct(NodeInterface $tail, NodeInterface $head, ?PredicateInterface $predicate = null) 
    {
        parent::__construct($tail, $head, $predicate);
        $this->kernel = $GLOBALS["kernel"];
    }

}

/* Predicate to load as a partial */
class FollowPredicate extends Framework\ActorOut\SubscribePredicate
{
    protected $binding = false;
    
    const T_CONSUMER = true;
    const T_NOTIFIER = false;
    const T_SUBSCRIBER = false;
    const T_FORMATIVE = false;
    const T_PERSISTENT = true;
}
/* Notification to load if it's a subtype of write or mention. */

}

/*****************************************************
 * Timestamp: 
 * Size (in bytes): 1521
 * Compilation Time: 15584
 * fcec609c2204ff066671d018b6216a91
 ******************************************************/